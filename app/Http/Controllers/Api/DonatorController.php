<?php

namespace App\Http\Controllers\Api;

use App\Donation;
use App\DonationMedicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DonatorController extends ApiController
{
    /**
     * Create a new donation
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createDonation(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'ngo_id' => 'required|exists:ngos,id',
                'pickup_date' => 'required|date|after:today',
                'pickup_address' => 'required|string',
                'medicines' => 'required|array|min:1',
                'medicines.*.medicine_id' => 'required|exists:medicines,id',
                'medicines.*.quantity' => 'required|integer|min:1',
                'medicines.*.expiry_date' => 'required|date|after:today',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            DB::beginTransaction();

            $donation = Donation::create([
                'donator_id' => auth()->id(),
                'ngo_id' => $request->ngo_id,
                'pickup_date' => $request->pickup_date,
                'pickup_address' => $request->pickup_address,
                'status' => 'pending',
            ]);

            foreach ($request->medicines as $medicine) {
                DonationMedicine::create([
                    'donation_id' => $donation->id,
                    'medicine_id' => $medicine['medicine_id'],
                    'quantity' => $medicine['quantity'],
                    'expiry_date' => $medicine['expiry_date'],
                ]);
            }

            DB::commit();

            return $this->sendResponse($donation->load('medicines'), 'Donation created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to create donation', [], 500);
        }
    }

    /**
     * List donations by the donator
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listDonations(Request $request): JsonResponse
    {
        try {
            $donations = Donation::where('donator_id', auth()->id())
                ->when($request->status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->with(['ngo', 'medicines', 'feedback'])
                ->orderBy('created_at', 'desc')
                ->get();

            return $this->sendResponse($donations);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch donations', [], 500);
        }
    }

    /**
     * List feedback for the donator's donations
     *
     * @return JsonResponse
     */
    public function listFeedback(): JsonResponse
    {
        try {
            $feedback = Donation::where('donator_id', auth()->id())
                ->with(['feedback.category', 'feedback.verifier'])
                ->has('feedback')
                ->get()
                ->pluck('feedback')
                ->flatten();

            return $this->sendResponse($feedback);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch feedback', [], 500);
        }
    }

    /**
     * Update donator profile
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'address' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            $donator = auth()->user();
            $donator->update($request->only(['name', 'phone', 'address']));

            return $this->sendResponse($donator, 'Profile updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update profile', [], 500);
        }
    }
}
