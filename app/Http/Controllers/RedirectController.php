<?php

declare(strict_types=1);

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

        // anonymizing IP (GDPR)
        $anonIp = $this->anonymizeIp((string) $request->ip());

        event(new UrlVisited($url->id, $anonIp));

        return redirect($url->original_url);
    }

    private function anonymizeIp(string $ip): string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $result = preg_replace('/\.\d+$/', '.0', $ip);
            return is_string($result) ? $result : $ip;
        }

        return $ip;
    }
}
