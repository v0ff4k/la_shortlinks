<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);
$d = [App\Infrastructure\Http\Controllers\RedirectController::class, '__invoke'];

// Защищенный редирект
Route::get('/{code}', $d)->middleware('throttle:10,1'); // 10 запросов в минуту на IP
