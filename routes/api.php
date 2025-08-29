<?php

use App\Http\Controllers\Api\AppStoreAssetController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\LeasingController;
use App\Http\Controllers\Api\MobileSettingController;
use App\Http\Controllers\Api\TermsAndConditionController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\SuccessPageController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PaymentController;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use YieldStudio\LaravelExpoNotifier\Models\ExpoToken;




Route::get("/drivers", [DriverController::class, "index"])->name("drivers.index");
Route::get("/vehicles", [VehicleController::class, "index"])->name("vehicles.index");
Route::get("/mobile-settings", [MobileSettingController::class, "index"])->name("mobileSettings.index");
Route::get("/success-page", [SuccessPageController::class, "index"])->name("successPage.index");


Route::post('/driver/login', [AuthController::class, 'login']);
Route::post('/driver/refresh-token', [AuthController::class, 'refreshToken']);
Route::get('/app-store-assets', [AppStoreAssetController::class, 'index']);
Route::middleware('auth:api')->post('/user', [AuthController::class, 'user']);




Route::group(['middleware' => 'auth:driver'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/driver/leasing', [LeasingController::class, 'getLeasing'])->name('driver.vehicles.index');
    Route::get('/driver/notifications', [NotificationController::class, 'index'])->name('driver.notifications.index');
    Route::get('/driver/payments', [PaymentController::class, 'payments'])->name('driver.payments.index');
    Route::get('/leasing-payments-old', [PaymentController::class, 'index_old']);
    Route::get('/leasing-payments', [PaymentController::class, 'index']);
    Route::get('/payments', [PaymentController::class, 'payments']);
    Route::get('/payment-types', [DriverController::class, 'paymentTypes']);
    Route::get('/user-details', [DriverController::class, 'userDetails']);

    Route::get('/terms-and-conditions', [TermsAndConditionController::class, 'index']);

    Route::post('/expo-token', function (Request $request) {
        $request->validate([
            "token" => "required"
        ]);
        $customer = auth()->guard('driver')->user();
        $customer->expo_token = $request->token;
        $customer->save();
        return response()->json(['status' => 'ok']);
    });
});


Route::post('/payment/create', [\App\Http\Controllers\Api\KapitalPaymentController::class, 'createStripeCheckout'])->name('stripe.post');









