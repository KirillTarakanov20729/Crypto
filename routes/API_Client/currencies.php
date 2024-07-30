<?php
use Illuminate\Support\Facades\Route;

Route::prefix('currencies')->middleware(['jwt.auth'])->group(function () {
    Route::post('index', [\App\Http\Controllers\API_Client\Currency\CurrencyController::class, 'index']);

    Route::post('store', [\App\Http\Controllers\API_Client\Currency\CurrencyController::class, 'store']);

    Route::get('show/{id}', [\App\Http\Controllers\API_Client\Currency\CurrencyController::class, 'show']);

    Route::put('update', [\App\Http\Controllers\API_Client\Currency\CurrencyController::class, 'update']);

    Route::delete('delete/{id}', [\App\Http\Controllers\API_Client\Currency\CurrencyController::class, 'delete']);
});
