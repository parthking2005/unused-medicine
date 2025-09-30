<?php

namespace App\Http\Controllers\Api;

use App\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PickupmanController extends ApiController
{
    /**
     * List donations assigned to the pickupman
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listDonations(Request $request): JsonResponse
    {
        try {
            $donations = Donation::where('pickupman_id', auth()->id())
                ->when($request->status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->with(['donator', 'ngo', 'medicines'])
                ->orderBy('created_at', 'desc')
                ->get();

            return $this->sendResponse($donations);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch donations', [], 500);
        }
    }

    /**
     * Update donation status
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateDonationStatus(Request $request, int $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:collected,failed',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            $donation = Donation::where('id', $id)
                ->where('pickupman_id', auth()->id())
                ->firstOrFail();

            $donation->update([
                'status' => $request->status,
                'pickup_notes' => $request->notes,
                'collected_at' => $request->status === 'collected' ? now() : null,
            ]);

            return $this->sendResponse($donation, 'Donation status updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update donation status', [], 500);
        }
    }
}
