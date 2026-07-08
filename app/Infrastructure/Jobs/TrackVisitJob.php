<?php

declare(strict_types=1);

namespace App\Infrastructure\Jobs;

use App\Domains\Analytics\Models\UrlVisit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackVisitJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;
    public array $backoff = [1, 5, 10];

    public function __construct(
        private readonly int $urlId,
        private readonly string $ip
    ) {}

    public function handle(): void
    {
        $anonIp = $this->anonymizeIp($this->ip);

        UrlVisit::create([
            'url_id' => $this->urlId,
            'ip_address' => $anonIp,
            'visited_at' => now(),
        ]);
    }

    private function anonymizeIp(string $ip): string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return preg_replace('/\.\d+$/', '.0', $ip);
        }

        return $ip;
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('TrackVisitJob failed.', [
            'url_id' => $this->urlId,
            'ip' => $this->ip,
            'error' => $exception->getMessage(),
        ]);
    }
}
