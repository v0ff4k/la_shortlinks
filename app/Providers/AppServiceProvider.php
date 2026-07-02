<?php

namespace App\Providers;

use App\Infrastructure\Persistence\Repositories\UrlRepository;
use App\Domains\Url\Repositories\UrlRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UrlRepositoryInterface::class, UrlRepository::class);
    }
}
