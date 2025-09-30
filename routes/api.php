<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Admin routes
    Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function () {
        Route::get('/ngos', 'Api\AdminController@listNgos');
        Route::post('/ngos', 'Api\AdminController@createNgo');
        Route::get('/managers', 'Api\AdminController@listManagers');
        Route::put('/donators/{id}/block', 'Api\AdminController@blockDonator');
        Route::get('/medicine-categories', 'Api\AdminController@listMedicineCategories');
        Route::post('/medicines', 'Api\AdminController@createMedicine');
        Route::get('/messages', 'Api\AdminController@listMessages');
    });

    // Manager routes
    Route::group(['prefix' => 'manager', 'middleware' => 'role:manager'], function () {
        Route::get('/ngo/{id}/stats', 'Api\ManagerController@getNgoStats');
        Route::get('/pickupmen', 'Api\ManagerController@listPickupmen');
        Route::post('/pickupmen', 'Api\ManagerController@createPickupman');
        Route::get('/verifiers', 'Api\ManagerController@listVerifiers');
        Route::put('/medicine-stocks/{id}', 'Api\ManagerController@updateMedicineStock');
        Route::put('/donations/{id}/assign', 'Api\ManagerController@assignDonation');
    });

    // Pickupman routes
    Route::group(['prefix' => 'pickupman', 'middleware' => 'role:pickupman'], function () {
        Route::get('/donations', 'Api\PickupmanController@listDonations');
        Route::put('/donations/{id}/status', 'Api\PickupmanController@updateDonationStatus');
    });

    // Verifier routes
    Route::group(['prefix' => 'verifier', 'middleware' => 'role:verifier'], function () {
        Route::get('/donations', 'Api\VerifierController@listDonations');
        Route::put('/donations/{id}/verify', 'Api\VerifierController@verifyDonation');
        Route::post('/feedback', 'Api\VerifierController@submitFeedback');
    });

    // Donator routes
    Route::group(['prefix' => 'donator', 'middleware' => 'role:donator'], function () {
        Route::post('/donations', 'Api\DonatorController@createDonation');
        Route::get('/donations', 'Api\DonatorController@listDonations');
        Route::get('/feedback', 'Api\DonatorController@listFeedback');
        Route::put('/profile', 'Api\DonatorController@updateProfile');
    });
});