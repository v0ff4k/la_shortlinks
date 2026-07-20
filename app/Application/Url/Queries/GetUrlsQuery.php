<?php

declare(strict_types=1);

namespace App\Application\Url\Queries;

use App\Domains\Url\Models\Url;
use Illuminate\Database\Eloquent\Collection;

readonly class GetUrlsQuery
{
    public function __construct(public ?int $userId) {}

    /** @return Collection<int, Url> */
    public function execute(): Collection
    {
        /** @var Collection<int, Url> */
        return Url::when(
            $this->userId !== null,
            fn($q) => $q->where('user_id', $this->userId)
        )->get();
    }
}
