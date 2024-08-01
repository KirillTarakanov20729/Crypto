<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admins')->middleware(['jwt.auth'])->group(function () {
    Route::post('index', [\App\Http\Controllers\API_Client\Admin\AdminController::class, 'index']);

    Route::post('store', [\App\Http\Controllers\API_Client\Admin\AdminController::class, 'store']);

    Route::get('show/{id}', [\App\Http\Controllers\API_Client\Admin\AdminController::class, 'show']);

    Route::put('update', [\App\Http\Controllers\API_Client\Admin\AdminController::class, 'update']);

    Route::delete('delete/{id}', [\App\Http\Controllers\API_Client\Admin\AdminController::class, 'delete']);
});
