<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domains\Url\Models\Url;
use App\Domains\Url\Repositories\UrlRepositoryInterface;

class UrlRepository implements UrlRepositoryInterface
{
    public function findByShortCode(string $code): ?Url
    {
        return Url::where('short_code', $code)->orWhere('custom_alias', $code)->first();
    }

    /**
     * @param array<string, mixed> $data
     * @return \App\Domains\Url\Models\Url
     */
    public function create(array $data): Url
    {
        return Url::create($data);
    }
}
