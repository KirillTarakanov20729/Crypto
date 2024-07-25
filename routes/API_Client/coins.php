<?php

use Illuminate\Support\Facades\Route;

Route::prefix('coins')->group(function () {
    Route::post('index', [\App\Http\Controllers\API_Client\Coin\CoinController::class, 'index']);
});
