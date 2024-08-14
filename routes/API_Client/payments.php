<?php

use Illuminate\Support\Facades\Route;

Route::prefix('payments')->middleware(['jwt.auth'])->group(function() {
   Route::post('index', [\App\Http\Controllers\API_Client\Payment\PaymentController::class, 'index']);

   Route::delete('delete/{id}', [\App\Http\Controllers\API_Client\Payment\PaymentController::class, 'delete']);
});
