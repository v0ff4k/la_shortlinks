<?php

declare(strict_types=1);

namespace App\Domains\Url\Listeners;

use App\Domains\Url\Events\UrlVisited;
use App\Domains\Url\Models\Url;
use App\Domains\Url\Models\UrlVisit;

class RecordUrlVisit
{
    public function handle(UrlVisited $event): void
    {
        // 1. store log
        UrlVisit::create([
            'url_id'     => $event->urlId,
            'ip_address' => $event->ip,
            'visited_at' => now(),
        ]);

        // 2. increment
        Url::where('id', $event->urlId)->increment('visits_count');
    }
}
