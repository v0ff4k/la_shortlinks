<?php

namespace App\Application\Analytics\DTOs;

use App\Domains\Analytics\ValueObjects\IpAddress;

readonly class TrackVisitDTO
{
    public function __construct(
        public int $urlId,
        public IpAddress $ip,
        public \DateTimeInterface $visitedAt
    ) {}
}
