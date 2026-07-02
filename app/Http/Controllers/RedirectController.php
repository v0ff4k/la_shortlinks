<?php

namespace App\Http\Controllers;

use App\Domains\Url\Events\UrlVisited;
use App\Domains\Url\Repositories\UrlRepositoryInterface;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __construct(
        private readonly UrlRepositoryInterface $repository
    ) {}

    public function __invoke(string $code, Request $request): RedirectResponse
    {
        $url = $this->repository->findByShortCode($code);
        abort_if(!$url || $url->isExpired(), 404);

        // Анонимизация IP (GDPR)
        $ip = $request->ip();
        $anonIp = substr($ip, 0, strrpos($ip, '.') + 1) . '0'; // IPv4: 192.168.1.100 -> 192.168.1.0

        event(new UrlVisited($url->id, $anonIp));

        return redirect($url->original_url);
    }
}