<?php

use App\Http\Controllers\UrlController;
//use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:60,1'])
    ->group(function () { // 60 запросов в минуту
        Route::post('/urls', UrlController::class);
    });

// Route::get('/{code}', [RedirectController::class, '__invoke']);
