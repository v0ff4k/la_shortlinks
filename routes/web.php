<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\UrlStoreController;

Route::view('/', 'welcome');

Route::get('/test', fn() => 'Hurray, Laravel 12 + DDD is working! ' . date('m/d/Y'));

Route::get('/{code}', [RedirectController::class, '__invoke'])
    ->where('code', '^(?!admin|filament|livewire|sanctum|api|urls).*$')
    ->middleware('throttle:10,1');

Route::post('/urls', [UrlStoreController::class, 'store'])
    ->middleware('auth'); // needs  ID-ed user
