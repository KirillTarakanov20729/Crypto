<?php

use Illuminate\Support\Facades\Route;

Route::prefix('coins')->middleware(['jwt.auth'])->group(function () {
    Route::post('index', [\App\Http\Controllers\API_Client\Coin\CoinController::class, 'index']);
});
