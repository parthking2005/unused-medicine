<?php

namespace App\Http\Controllers\Api;

use App\NGO;
use App\Manager;
use App\Donator;
use App\Medicine;
use App\MedicineCategory;
use App\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends ApiController
{
    /**
     * List all NGOs
     *
     * @return JsonResponse
     */
    public function listNgos(): JsonResponse
    {
        try {
            $ngos = NGO::with('manager')->get();
            return $this->sendResponse($ngos);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch NGOs', [], 500);
        }
    }

    /**
     * Create a new NGO
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createNgo(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email|unique:ngos',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            $ngo = NGO::create($request->all());
            return $this->sendResponse($ngo, 'NGO created successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create NGO', [], 500);
        }
    }

    /**
     * List all managers
     *
     * @return JsonResponse
     */
    public function listManagers(): JsonResponse
    {
        try {
            $managers = Manager::with('ngo')->get();
            return $this->sendResponse($managers);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch managers', [], 500);
        }
    }

    /**
     * Block/Unblock a donator
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function blockDonator(Request $request, int $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'blocked' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            $donator = Donator::findOrFail($id);
            $donator->update(['blocked' => $request->blocked]);

            return $this->sendResponse($donator, 'Donator status updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update donator status', [], 500);
        }
    }

    /**
     * List all medicine categories
     *
     * @return JsonResponse
     */
    public function listMedicineCategories(): JsonResponse
    {
        try {
            $categories = MedicineCategory::with('medicines')->get();
            return $this->sendResponse($categories);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch medicine categories', [], 500);
        }
    }

    /**
     * Create a new medicine
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createMedicine(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'medicine_category_id' => 'required|exists:medicine_categories,id',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            $medicine = Medicine::create($request->all());
            return $this->sendResponse($medicine, 'Medicine created successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create medicine', [], 500);
        }
    }

    /**
     * List all messages
     *
     * @return JsonResponse
     */
    public function listMessages(): JsonResponse
    {
        try {
            $messages = Message::orderBy('created_at', 'desc')->get();
            return $this->sendResponse($messages);
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch messages', [], 500);
        }
    }
}
