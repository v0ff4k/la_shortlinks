<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domains\Url\Models\Url;

class UrlRepository implements UrlRepositoryInterface
{
    public function findByShortCode(string $code): ?Url
    {
        return Url::where('short_code', $code)->first();
    }

    public function create(array $data): Url
    {
        return Url::create($data);
    }
}
