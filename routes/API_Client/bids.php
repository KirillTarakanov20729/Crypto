<?php

use Illuminate\Support\Facades\Route;

Route::prefix('bids')->middleware(['jwt.auth'])->group(function () {
    Route::post('index', [\App\Http\Controllers\API_Client\Bid\BidController::class, 'index']);

    Route::post('store', [\App\Http\Controllers\API_Client\Bid\BidController::class, 'store']);

    Route::get('show/{id}', [\App\Http\Controllers\API_Client\Bid\BidController::class, 'show']);

    Route::put('update', [\App\Http\Controllers\API_Client\Bid\BidController::class, 'update']);

    Route::delete('delete/{id}', [\App\Http\Controllers\API_Client\Bid\BidController::class, 'delete']);
});
