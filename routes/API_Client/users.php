<?php

use Illuminate\Support\Facades\Route;

Route::prefix('users')->middleware('jwt.auth')->group(function () {
    Route::post('index', [\App\Http\Controllers\API_Client\User\UserController::class, 'index']);
});
