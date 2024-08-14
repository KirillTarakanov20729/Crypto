<?php

use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function () {
    require __DIR__ . '/coins.php';
    require __DIR__ . '/users.php';
    require __DIR__ . '/auth.php';
    require __DIR__ . '/currencies.php';
    require __DIR__ . '/bids.php';
    require __DIR__ . '/admins.php';
    require __DIR__ . '/payments.php';
});
