<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
   Route::post('sign-in', [AuthController::class, 'sign_in']);
   Route::post('refresh', [AuthController::class, 'refresh'])->middleware('throttle:10,1');
   Route::post('sign-out', [AuthController::class, 'sign_out'])->middleware('auth:api');
   Route::post('sign-up', [AuthController::class, 'sign_up']);
   Route::post('send-email-verification', [AuthController::class, 'send_email_verification']);
   Route::post('send-reset-password', [AuthController::class, 'send_reset_password_email']);
   Route::post('reset-password', [AuthController::class, 'reset_password']);
});
