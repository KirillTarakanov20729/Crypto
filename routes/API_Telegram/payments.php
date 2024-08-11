<?php

use Illuminate\Support\Facades\Route;

Route::prefix('payments')->group(function() {
    Route::post('show', [\App\Http\Controllers\API_Telegram\Payment\PaymentController::class, 'show']);
});
