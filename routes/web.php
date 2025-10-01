<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

// dd(Hash::make('admin@123'));
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// All routes with admin prefix and uses by admin only

Route::group(['prefix' => 'admin'], function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('register', 'Auth\RegisterController@showAdminRegisterForm')->name('admin-register');
        Route::post('register', 'Auth\RegisterController@createAdmin')->name('admin-register');
        Route::get('login', 'Auth\LoginController@showAdminLoginForm')->name('admin-login');
        Route::post('login', 'Auth\LoginController@adminLogin')->name('admin-login');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', 'AdminController@index')->name('admin-dashboard');
        Route::get('/dashboard', 'AdminController@index')->name('admin-dashboard');
        Route::get('profile', 'AdminController@showProfile')->name('Profile-Admin');
        Route::get('changepassword', 'AdminController@showChangePasswordForm')->name('ChangePassword-Admin');
        Route::post('changepassword', 'AdminController@updatePassword')->name('ChangePassword-Admin');
        Route::get('donationhistory', 'AdminController@viewDonationHistory')->name('ViewDonationHistory-Admin');
        Route::get('medicinestock', 'AdminController@viewMedicineStock')->name('ViewMedicineStock-Admin');
        Route::post('selectmedicinecategory', 'AdminController@selectMedicineCategory')->name('SelectMedicineCategory-Admin');
        Route::get('managedonators', 'AdminController@showBlockDonatorsForm')->name('ManageDonators-Admin');
        Route::get('blockdonator/{id}', 'AdminController@blockDonator')->name('BlockDonator-Admin');
        Route::get('warndonator/{id}', 'AdminController@warnDonator')->name('WarnDonator-Admin');
        Route::get('logout', 'Auth\LogoutController@adminLogout')->name('admin-logout');
        
        // NGO Management
        Route::get('registerngo', 'Auth\RegisterController@showNgoRegisterForm')->name('admin-registerngo');
        Route::post('registerngo', 'Auth\RegisterController@createNgo')->name('admin-registerngo');
        Route::get('displayngos', 'NgosController@index')->name('admin-displayngos');
        Route::get('ngos/{id}/edit', 'NgosController@edit');
        Route::put('ngos/{id}', 'NgosController@update');
        Route::delete('ngos/{id}', 'NgosController@destroy');

        // Manager Management
        Route::get('registermanager', 'Auth\RegisterController@showManagerRegisterForm')->name('admin-registermanager');
        Route::post('registermanager', 'Auth\RegisterController@createManager')->name('admin-registermanager');
        Route::get('displaymanagers', 'ManagerController@index')->name('admin-displaymanagers');
        Route::get('managers/{id}/edit', 'ManagerController@edit');
        Route::put('managers/{id}', 'ManagerController@update');
        Route::delete('managers/{id}', 'ManagerController@destroy');

        // Message Management
        Route::get('messages', 'AdminController@viewMessages')->name('admin.messages');
        Route::put('messages/{id}/visibility', 'AdminController@updateMessageVisibility')->name('admin.messages.visibility');
    });
});


Route::group(['prefix' => 'ngo'], function () {
    Route::get('/', function () {
        return view('ngo.home');
    })->name('NGOPanel');
    //All routes with manager prefix and uses by manager only
    Route::group(['prefix' => 'manager'], function () {
        Route::group(['middleware' => ['auth:manager']], function () {
            Route::get('/', 'ManagerController@showdashboard');
            Route::get('logout', 'Auth\LogoutController@managerLogout');
            Route::get('profile', 'ManagerController@showProfile')->name('Profile-Manager');
            Route::get('changepassword', 'ManagerController@showChangePasswordForm')->name('ChangePassword-Manager');
            Route::post('changepassword', 'ManagerController@updatePassword')->name('ChangePassword-Manager');

            Route::get('registerpickupman', 'Auth\RegisterController@showPickupmanRegisterForm')->name('RegisterPickupman');
            Route::post('registerpickupman', 'Auth\RegisterController@createPickupman')->name('RegisterPickupman');
            Route::get('displaypickupmen', 'PickupmanController@index')->name('DisplayPickupmen');
            Route::get('pickupmen/{id}/edit', 'PickupmanController@edit');
            Route::put('pickupmen/{id}', 'PickupmanController@update');
            Route::delete('pickupmen/{id}', 'PickupmanController@destroy');

            Route::get('registerverifier', 'Auth\RegisterController@showVerifierRegisterForm')->name('RegisterVerifier');
            Route::post('registerverifier', 'Auth\RegisterController@createVerifier')->name('RegisterVerifier');
            Route::get('displayverifier', 'VerifierController@index')->name('DisplayVerifier');
            Route::get('verifier/{id}/edit', 'VerifierController@edit');
            Route::put('verifier/{id}', 'VerifierController@update');
            Route::delete('verifier/{id}', 'VerifierController@destroy');


            Route::get('pickedupdonations', 'ManagerController@viewPickedUpDonations')->name('ViewPickedUpDs-Manager');
            Route::put('updatepickedupdonations/{id}', 'ManagerController@updatePickedUpDonations')->name('UpdatePickedUpDs-Manager');
            Route::get('editdpd', 'ManagerController@showDPDForm')->name('EditDPD-Manager');
            Route::put('updatedpd', 'ManagerController@updateDPD')->name('UpdateDPD-Manager');
            Route::get('donationhistory', 'ManagerController@viewDonationHistory')->name('ViewDonationHistory-Manager');

            Route::get('medicinestock', 'ManagerController@viewMedicineStock')->name('ViewMedicineStock-Manager');
            Route::get('managemedicinestock', 'ManagerController@manageMedicineStock')->name('ManageMedicineStock-Manager');
            Route::get('managemedicinestock/{id}', 'ManagerController@fetchQty')->name('FetchQty-Manager');
            Route::delete('removemedicinestock/{id}/{qtyr}', 'ManagerController@removeMedicineStock')->name('RemoveMedicineStock-Manager');

            // Medicine Expiration Management
            Route::get('medicine/expiration', 'MedicineExpirationController@index')->name('medicine.expiration.index');
            Route::post('medicine/expiration', 'MedicineExpirationController@store')->name('medicine.expiration.store');
            Route::put('medicine/expiration/{expiration}/dispose', 'MedicineExpirationController@dispose')->name('medicine.expiration.dispose');
            Route::get('medicine/expiration/report', 'MedicineExpirationController@report')->name('medicine.expiration.report');

            Route::get('expiremedicine', 'ManagerController@viewExpireMedicine')->name('ViewExpire-Medicine');
            Route::get('removemedicine', 'ManagerController@removeExpireMedicine');
        });
        Route::get('login', 'Auth\LoginController@showManagerLoginForm')->name('manager-login');
        Route::post('login', 'Auth\LoginController@managerLogin')->name('manager-login');
        Route::get('createpassword', 'Auth\LoginController@showManagerCreatePasswordForm')->name('Manager-CreatePassword');
        Route::post('createpassword', 'Auth\LoginController@managerCreatePassword')->name('Manager-CreatePassword');
        Route::get('forgotpassword', 'ManagerController@showForgotPasswordForm')->name('ForgotPassword-Manager');
        Route::post('forgotpassword', 'ManagerController@forgotPassword')->name('ForgotPassword-Manager');
    });

    //All routes with pickupman prefix and uses by pickupman only
    Route::group(['prefix' => 'pickupman'], function () {
        Route::group(['middleware' => ['auth:pickupman']], function () {
            Route::get('/', 'PickupmanController@showDashboard');
            Route::get('logout', 'Auth\LogoutController@pickupmanLogout');
            Route::get('profile', 'PickupmanController@showProfile')->name('Profile-Pickupman');
            Route::get('changepassword', 'PickupmanController@showChangePasswordForm')->name('ChangePassword-Pickupman');
            Route::post('changepassword', 'PickupmanController@updatePassword')->name('ChangePassword-Pickupman');

            Route::get('pendingdonations', 'PickupmanController@viewPendingDonations')->name('ViewPDs-Pickupman');
            Route::put('updatependingdonation/{id}', 'PickupmanController@updatePendingDonation')->name('UpdatePendingDonation-Pickupman');
            Route::get('handindonations', 'PickupmanController@viewTakenDonations')->name('ViewTDs-Pickupman');
            Route::put('updateHandindonation/{id}', 'PickupmanController@UpdateTakenDonation')->name('UpdateTakenDonation-Pickupman');
        });
        Route::get('login', 'Auth\LoginController@showPickupmanLoginForm')->name('pickupman-login');
        Route::post('login', 'Auth\LoginController@pickupmanLogin')->name('pickupman-login');
        Route::get('createpassword', 'Auth\LoginController@showPickupmanCreatePasswordForm')->name('Pickupman-CreatePassword');
        Route::post('createpassword', 'Auth\LoginController@pickupmanCreatePassword')->name('Pickupman-CreatePassword');
        Route::get('forgotpassword', 'PickupmanController@showForgotPasswordForm')->name('ForgotPassword-Pickupman');
        Route::post('forgotpassword', 'PickupmanController@forgotPassword')->name('ForgotPassword-Pickupman');
    });

    //All routes with verifier prefix and uses by pickupman only
    Route::group(['prefix' => 'verifier'], function () {
        Route::group(['middleware' => ['auth:verifier']], function () {
            Route::get('/', 'VerifierController@showDashboard');
            Route::get('profile', 'VerifierController@showProfile')->name('Profile-Verifier');
            Route::get('logout', 'Auth\LogoutController@verifierLogout')->name('Logout-Verifier');
            Route::get('changepassword', 'VerifierController@showChangePasswordForm')->name('ChangePassword-Verifier');
            Route::post('changepassword', 'VerifierController@updatePassword')->name('ChangePassword-Verifier');
            Route::get('pendingdonations', 'VerifierController@viewPendingDonations')->name('ViewPDs-Verifier');
            Route::put('takependingdonation/{id}', 'VerifierController@takePendingDonation')->name('TakePendingDonation-Verifier');
            Route::get('takendonation', 'VerifierController@viewTakenDonation')->name('ViewTD-Verifier');
            Route::post('addmedicine', 'VerifierController@addMedicine')->name('AddMedicine-Verifier');
            Route::get('addtostock/{id}', 'VerifierController@addMedicinesToStock')->name('AddMedicinesToStock-Verifier');
            Route::get('feedback', 'VerifierController@showFeedbackForm')->name('GiveFeedback-Verifier');
            Route::post('submitfeedback', 'VerifierController@submitFeedback')->name('SubmitFeedback-Verifier');
            Route::get('addmedicinecategory', 'VerifierController@showMedicineCategoryForm')->name('AddMCategory-Verifier');
            Route::post('addmedicinecategory', 'VerifierController@addMedicineCategory')->name('AddMCategory-Verifier');
        });
        Route::get('login', 'Auth\LoginController@showVerifierLoginForm')->name('verifier-login');
        Route::post('login', 'Auth\LoginController@verifierLogin')->name('verifier-login');
        Route::get('createpassword', 'Auth\LoginController@showVerifierCreatePasswordForm')->name('Verifier-CreatePassword');
        Route::post('createpassword', 'Auth\LoginController@verifierCreatePassword')->name('Verifier-CreatePassword');
        Route::get('forgotpassword', 'VerifierController@showForgotPasswordForm')->name('ForgotPassword-Verifier');
        Route::post('forgotpassword', 'VerifierController@forgotPassword')->name('ForgotPassword-Verifier');
    });
});


Route::get('/', 'DonatorController@index')->name('MedCharity');
Route::middleware('guest')->group(function () {
    Route::get('login', 'Auth\LoginController@showDonatorLoginForm')->name('LoginDonator');
    Route::get('register', 'Auth\RegisterController@showDonatorRegisterForm')->name('RegisterDonator');
    Route::post('register', 'Auth\RegisterController@createDonator')->name('RegisterDonator');
    Route::post('login', 'Auth\LoginController@donatorLogin')->name('LoginDonator');
});
Route::get('forgotpassword', 'DonatorController@showForgotPasswordForm')->name('ForgotPassword-Donator');
Route::post('forgotpassword', 'DonatorController@forgotPassword')->name('ForgotPassword-Donator');
Route::get('createpassword', 'DonatorController@showCreatePasswordForm')->name('CreatePassword-Donator');
Route::post('createpassword', 'DonatorController@createPassword')->name('CreatePassword-Donator');
Route::get('/about', 'DonatorController@showAbout')->name('About');
Route::get('/contact', 'DonatorController@showContact')->name('Contact');
Route::post('contactmessage', 'DonatorController@sendMessage')->name('ContactMessage');


Route::group(['middleware' => ['auth:donator']], function () {
    Route::get('donate', 'DonatorController@showDonateForm');
    Route::post('donate', 'DonatorController@donate')->name('Donate');
    Route::get('disabledates', 'DonatorController@disabledates');
    Route::get('donations', 'DonatorController@viewDonations')->name('viewDonations-Donator');
    Route::get('profile', 'DonatorController@showProfile');
    Route::get('changepassword', 'DonatorController@showChangePasswordForm')->name('ChangePassword-Donator');
    Route::post('changepassword', 'DonatorController@updatePassword')->name('ChangePassword-Donator');
    Route::get('{ngo_id}/edit', 'DonatorController@edit');
    Route::put('{id}', 'DonatorController@update');

    Route::get('logout', 'Auth\LogoutController@donatorLogout');
});
