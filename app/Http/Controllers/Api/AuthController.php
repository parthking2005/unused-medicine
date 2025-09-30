<?php

namespace App\Http\Controllers\Api;

use App\Admin;
use App\Donator;
use App\Manager;
use App\Pickupman;
use App\Verifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    /**
     * Login user and create token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required|in:admin,manager,pickupman,verifier,donator',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            // Get the model based on role
            $model = $this->getModelByRole($request->role);
            $user = $model::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->sendError('Invalid credentials', [], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->sendResponse([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return $this->sendError('Login failed', [], 500);
        }
    }

    /**
     * Register a new user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:donators',
                'password' => 'required|string|min:8',
                'role' => 'required|in:donator', // Only donators can register through API
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->toArray(), 422);
            }

            $user = Donator::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->sendResponse([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'User registered successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Registration failed', [], 500);
        }
    }

    /**
     * Get the model class based on role
     *
     * @param string $role
     * @return string
     */
    private function getModelByRole(string $role): string
    {
        return match ($role) {
            'admin' => Admin::class,
            'manager' => Manager::class,
            'pickupman' => Pickupman::class,
            'verifier' => Verifier::class,
            'donator' => Donator::class,
            default => throw new \InvalidArgumentException('Invalid role'),
        };
    }
}
