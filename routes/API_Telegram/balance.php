<?php


use Illuminate\Support\Facades\Route;

Route::prefix('balance')->group(function () {
    Route::get('show/{telegram_id}', [\App\Http\Controllers\API_Telegram\Balance\BalanceController::class, 'show']);

    Route::put('update', [\App\Http\Controllers\API_Telegram\Balance\BalanceController::class, 'update']);
});


