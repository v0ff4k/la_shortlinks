<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;

Route::view('/', 'welcome');

Route::get('/test', fn() => 'Hurray, Laravel 12 + DDD is working!');

Route::get('/{code}', [RedirectController::class, '__invoke'])
    ->where('code', '^(?!admin|filament|livewire|sanctum|api).*$')
    ->middleware('throttle:10,1');
