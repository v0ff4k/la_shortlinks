<?php

namespace App\Infrastructure\Events\Listeners;

use App\Domains\Url\Events\UrlVisited;
use App\Jobs\TrackVisitJob;

class LogVisitListener
{
    public function handle(UrlVisited $event): void
    {
        dispatch(new TrackVisitJob($event->urlId, $event->ip));
    }
}
