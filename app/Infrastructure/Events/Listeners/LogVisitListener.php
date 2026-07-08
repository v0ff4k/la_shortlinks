<?php

declare(strict_types=1);

namespace App\Infrastructure\Events\Listeners;

use App\Domains\Url\Events\UrlVisited;
use App\Infrastructure\Jobs\TrackVisitJob;

class LogVisitListener
{
    public function handle(UrlVisited $event): void
    {
        dispatch(new TrackVisitJob($event->urlId, $event->ip));
    }
}
