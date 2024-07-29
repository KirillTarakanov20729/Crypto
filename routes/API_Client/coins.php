<?php

use Illuminate\Support\Facades\Route;

Route::prefix('coins')->middleware(['jwt.auth'])->group(function () {
    Route::post('index', [\App\Http\Controllers\API_Client\Coin\CoinController::class, 'index']);

    Route::post('store', [\App\Http\Controllers\API_Client\Coin\CoinController::class, 'store']);

    Route::post('show', [\App\Http\Controllers\API_Client\Coin\CoinController::class, 'show']);

    Route::put('update', [\App\Http\Controllers\API_Client\Coin\CoinController::class, 'update']);

    Route::delete('delete', [\App\Http\Controllers\API_Client\Coin\CoinController::class, 'delete']);
});
