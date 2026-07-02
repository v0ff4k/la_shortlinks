<?php

namespace App\Infrastructure\Jobs;

use App\Domains\Analytics\Models\UrlVisit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackVisitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3; // Количество попыток
    public array $backoff = [1, 5, 10]; // Интервалы между попытками

    public function __construct(
        private readonly int $urlId,
        private readonly string $ip // Raw IP
    ) {}

public function handle(): void
{
    // Анонимизация IP (GDPR)
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
    // Для IPv6 можно использовать более сложную логику
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