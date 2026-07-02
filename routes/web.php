<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;

Auth::routes(['verify' => true]);

// Защищенный редирект
Route::get('/{code}', [RedirectController::class, '__invoke'])
    ->middleware('throttle:10,1'); // 10 запросов в минуту на IP
