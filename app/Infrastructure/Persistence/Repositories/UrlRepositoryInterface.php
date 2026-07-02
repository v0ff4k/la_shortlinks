<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domains\Url\Models\Url;

interface UrlRepositoryInterface
{
    public function findByShortCode(string $code): ?Url;
    public function create(array $data): Url;
}
