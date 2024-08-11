<?php


use Illuminate\Support\Facades\Route;

Route::prefix('bids')->group(function () {
    Route::post('index', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'index']);

    Route::post('store', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'store']);

    Route::post('show', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'showUserBids']);

    Route::delete('delete', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'delete']);
});


