<?php

namespace App\Application\Analytics\Handlers;

use App\Application\Analytics\DTOs\TrackVisitDTO;
use App\Domains\Analytics\Models\UrlVisit;

class TrackVisitHandler
{
    public function handle(TrackVisitDTO $dto): void
    {
        UrlVisit::create([
            'url_id' => $dto->urlId,
            'ip_address' => $dto->ip->value,
            'visited_at' => $dto->visitedAt,
        ]);
    }
}
