<?php

declare(strict_types=1);

namespace App\Application\Url\Queries;

use App\Domains\Url\Models\Url;
use Illuminate\Support\Collection;

readonly class GetUrlsQuery
{
    public function __construct(public ?int $userId) {}

    public function execute(): Collection
    {
        return Url::when($this->userId, fn($q) => $q->where('user_id', $this->userId))->get();
    }
}
