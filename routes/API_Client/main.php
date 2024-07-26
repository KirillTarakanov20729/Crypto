<?php

use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function () {
    require __DIR__ . '/coins.php';
    require __DIR__ . '/users.php';
    require __DIR__ . '/auth.php';
});
