<?php

use Illuminate\Support\Facades\Route;

Route::prefix('telegram')->group(function () {
    require __DIR__ . '/auth.php';
    require __DIR__ . '/coins.php';
    require __DIR__ . '/balance.php';
    require __DIR__ . '/bids.php';
    require __DIR__ . '/payments.php';
});
