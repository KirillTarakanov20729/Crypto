<?php

use Illuminate\Support\Facades\Route;

Route::prefix('telegram')->group(function () {
    require __DIR__ . '/auth.php';
    require __DIR__ . '/coins.php';
});
