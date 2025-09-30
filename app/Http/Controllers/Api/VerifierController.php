<?php

namespace App\Http\Controllers\Api;

use App\Donation;
use App\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerifierController extends ApiController
{
    /**
     * List donations assigned to the verifier
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listDonations(Request $request): JsonResponse
    {
        try {
            $donations = Donation::where('verifier_id', auth()->id())
                ->when($request->status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->with(['donator', 'ngo', 'medicines', 'feedback'])
                ->orderBy('created_at', 'desc')
                ->get();

            return $this->sendResponse($donations);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch donations', [], 500);
        }
    }

    /**
     * Verify a donation
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function verifyDonation(Request $request, int $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:verified,rejected',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            $donation = Donation::where('id', $id)
                ->where('verifier_id', auth()->id())
                ->firstOrFail();

            $donation->update([
                'status' => $request->status,
                'verification_notes' => $request->notes,
                'verified_at' => now(),
            ]);

            return $this->sendResponse($donation, 'Donation verified successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to verify donation', [], 500);
        }
    }

    /**
     * Submit feedback for a donation
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function submitFeedback(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'donation_id' => 'required|exists:donations,id',
                'category_id' => 'required|exists:feedback_categories,id',
                'content' => 'required|string',
                'rating' => 'required|integer|min:1|max:5',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            // Verify that the donation is assigned to this verifier
            $donation = Donation::where('id', $request->donation_id)
                ->where('verifier_id', auth()->id())
                ->firstOrFail();

            $feedback = Feedback::create([
                'donation_id' => $request->donation_id,
                'category_id' => $request->category_id,
                'content' => $request->content,
                'rating' => $request->rating,
                'verifier_id' => auth()->id(),
            ]);

            return $this->sendResponse($feedback, 'Feedback submitted successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to submit feedback', [], 500);
        }
    }
}
