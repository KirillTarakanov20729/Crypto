<?php


use Illuminate\Support\Facades\Route;

Route::prefix('coins')->group(function () {
    Route::get('all', [\App\Http\Controllers\API_Telegram\Coin\CoinController::class, 'all']);
});


