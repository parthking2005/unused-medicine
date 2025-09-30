<?php

namespace App\Http\Controllers\Api;

use App\NGO;
use App\Pickupman;
use App\Verifier;
use App\MedicineStock;
use App\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManagerController extends ApiController
{
    /**
     * Get NGO statistics
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getNgoStats(int $id): JsonResponse
    {
        try {
            $ngo = NGO::findOrFail($id);
            
            $stats = [
                'donations_today' => Donation::where('ngo_id', $id)
                    ->whereDate('created_at', today())
                    ->count(),
                'total_stock' => MedicineStock::where('ngo_id', $id)
                    ->sum('quantity'),
                'active_pickupmen' => Pickupman::where('ngo_id', $id)
                    ->where('is_active', true)
                    ->count(),
                'pending_donations' => Donation::where('ngo_id', $id)
                    ->where('status', 'pending')
                    ->count(),
            ];

            return $this->sendResponse($stats);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch NGO stats', [], 500);
        }
    }

    /**
     * List all pickupmen
     *
     * @return JsonResponse
     */
    public function listPickupmen(): JsonResponse
    {
        try {
            $pickupmen = Pickupman::where('ngo_id', auth()->user()->ngo_id)->get();
            return $this->sendResponse($pickupmen);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch pickupmen', [], 500);
        }
    }

    /**
     * Create a new pickupman
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createPickupman(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:pickupmen',
                'phone' => 'required|string',
                'password' => 'required|min:8',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            $data = $request->all();
            $data['ngo_id'] = auth()->user()->ngo_id;
            $data['password'] = Hash::make($request->password);

            $pickupman = Pickupman::create($data);
            return $this->sendResponse($pickupman, 'Pickupman created successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create pickupman', [], 500);
        }
    }

    /**
     * List all verifiers
     *
     * @return JsonResponse
     */
    public function listVerifiers(): JsonResponse
    {
        try {
            $verifiers = Verifier::where('ngo_id', auth()->user()->ngo_id)->get();
            return $this->sendResponse($verifiers);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch verifiers', [], 500);
        }
    }

    /**
     * Update medicine stock
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateMedicineStock(Request $request, int $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'quantity' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            $stock = MedicineStock::findOrFail($id);
            
            if ($stock->ngo_id !== auth()->user()->ngo_id) {
                return $this->sendError('Unauthorized access to medicine stock', [], 403);
            }

            $stock->update(['quantity' => $request->quantity]);
            return $this->sendResponse($stock, 'Stock updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update stock', [], 500);
        }
    }

    /**
     * Assign donation to pickupman and verifier
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function assignDonation(Request $request, int $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'pickupman_id' => 'required|exists:pickupmen,id',
                'verifier_id' => 'required|exists:verifiers,id',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            $donation = Donation::findOrFail($id);
            
            if ($donation->ngo_id !== auth()->user()->ngo_id) {
                return $this->sendError('Unauthorized access to donation', [], 403);
            }

            $donation->update([
                'pickupman_id' => $request->pickupman_id,
                'verifier_id' => $request->verifier_id,
                'status' => 'assigned'
            ]);

            return $this->sendResponse($donation, 'Donation assigned successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to assign donation', [], 500);
        }
    }
}
