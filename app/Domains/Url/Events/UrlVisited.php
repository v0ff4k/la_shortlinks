<?php

namespace App\Domains\Url\Events;

use Illuminate\Foundation\Events\Dispatchable;

class UrlVisited
{
    use Dispatchable;

    public function __construct(
        public int $urlId,
        public string $ip
    ) {}
}