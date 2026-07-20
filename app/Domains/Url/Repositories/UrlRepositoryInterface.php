<?php

declare(strict_types=1);

namespace App\Domains\Url\Repositories;

use App\Domains\Url\Models\Url;

interface UrlRepositoryInterface
{
    public function findByShortCode(string $code): ?Url;

    /**
     * @param array<string, mixed> $data
     * @return \App\Domains\Url\Models\Url
     */
    public function create(array $data): Url;
}
