<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domains\Url\Repositories\UrlRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\UrlRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UrlRepositoryInterface::class, UrlRepository::class);
    }
}
