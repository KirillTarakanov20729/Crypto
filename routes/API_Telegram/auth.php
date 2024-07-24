<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [\App\Http\Controllers\API_Telegram\Auth\AuthController::class, 'register']);

    Route::post('login', [\App\Http\Controllers\API_Telegram\Auth\AuthController::class, 'login']);

    Route::post('check_auth', [\App\Http\Controllers\API_Telegram\Auth\AuthController::class, 'check_auth']);

    Route::post('logout', [\App\Http\Controllers\API_Telegram\Auth\AuthController::class, 'logout']);
});
