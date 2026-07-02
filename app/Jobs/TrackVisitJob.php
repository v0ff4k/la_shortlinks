<?php

namespace App\Jobs;

use App\Domains\Analytics\Models\UrlVisit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackVisitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly int $urlId,
        private readonly string $ip
    ) {}

public function handle(): void
{
    UrlVisit::create([
        'url_id' => $this->urlId,
        'ip_address' => $this->ip, // Теперь анонимизированный IP
        'visited_at' => now(),
    ]);
}
}