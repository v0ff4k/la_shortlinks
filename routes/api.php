<?php

declare(strict_types=1);

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:60,1'])
    ->group(function (): void { // 60 запросов в минуту
        Route::post('/urls', UrlController::class);
    });
