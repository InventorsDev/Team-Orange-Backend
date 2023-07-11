<?php

use App\Http\Controllers\API\AssessmentController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\SetUsernameController;
use App\Http\Controllers\API\User\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::prefix('v1')->group(function () {

    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('register', [RegisterController::class, 'register'])->name('register');
        Route::post('resend-otp', [RegisterController::class, 'resendOtp'])->name('resendOtp');
        Route::post('verify-otp', [RegisterController::class, 'verifyOtp'])->name('verifyOtp');
        Route::post('login', [LoginController::class, 'login'])->name('login');
        Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgotPassword');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('', [UserProfileController::class, 'show'])->name('show');
            Route::post('set-username', [SetUsernameController::class, 'setUsername'])->name('setUsername');
            Route::post('/update-profile', [UserProfileController::class, 'updateProfile'])->name('updateProfile');
        });
    });

    Route::get('assessment-questions', [AssessmentController::class, 'index']);
    Route::get('daily-assessment-questions', [AssessmentController::class, 'dailyIndex']);
});
