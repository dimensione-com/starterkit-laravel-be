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
});
