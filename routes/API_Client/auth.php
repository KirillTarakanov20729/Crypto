<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', [\App\Http\Controllers\API_Client\Auth\AuthController::class, 'login']);
    Route::post('refresh', [\App\Http\Controllers\API_Client\Auth\AuthController::class, 'refresh']);

    Route::middleware(['jwt.auth'])->group(function () {
        Route::post('me', [\App\Http\Controllers\API_Client\Auth\AuthController::class, 'me']);
        Route::post('logout', [\App\Http\Controllers\API_Client\Auth\AuthController::class, 'logout']);
    });
});
