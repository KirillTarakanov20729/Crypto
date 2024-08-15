<?php


use Illuminate\Support\Facades\Route;

Route::prefix('bids')->group(function () {
    Route::post('index', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'index']);

    Route::post('store', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'store']);

    Route::post('showUserBids', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'showUserBids']);

    Route::post('ask', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'askBid']);

    Route::post('response', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'responseBid']);

    Route::post('pay', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'payBid']);

    Route::post('cancel', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'cancelBid']);

    Route::post('show', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'showBid']);

    Route::delete('delete', [\App\Http\Controllers\API_Telegram\Bids\BidController::class, 'delete']);
});


