<?php

use Illuminate\Support\Facades\Route;

Route::prefix('users')->middleware('jwt.auth')->group(function () {
    Route::post('index', [\App\Http\Controllers\API_Client\User\UserController::class, 'index']);

    Route::post('store', [\App\Http\Controllers\API_Client\User\UserController::class, 'store']);

    Route::get('show/{id}', [\App\Http\Controllers\API_Client\User\UserController::class, 'show']);

    Route::put('update', [\App\Http\Controllers\API_Client\User\UserController::class, 'update']);

    Route::delete('delete/{id}', [\App\Http\Controllers\API_Client\User\UserController::class, 'delete']);
});
