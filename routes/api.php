<?php

use App\Http\Controllers\API\AssessmentController;
use App\Http\Controllers\API\Auth\RegisterController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('register', [RegisterController::class, 'register'])->name('register');
        Route::post('resend-otp', [RegisterController::class, 'resendOtp'])->name('resendOtp');
    });


    Route::get('assessment-questions', [AssessmentController::class, 'index']);
    Route::get('daily-assessment-questions', [AssessmentController::class, 'dailyIndex']);
});
