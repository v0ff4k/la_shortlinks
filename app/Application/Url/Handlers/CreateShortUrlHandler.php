<?php

declare(strict_types=1);

namespace App\Application\Url\Handlers;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Domains\Url\Models\Url;
use Illuminate\Support\Str;

class CreateShortUrlHandler
{
    private const MAX_GENERATION_ATTEMPTS = 5;

    public function handle(CreateShortUrlCommand $command): Url
    {
        $dto = $command->dto;

        if ($this->detectCycle($dto->originalUrl)) {
            throw new \InvalidArgumentException('This URL would create a redirect loop.');
        }

        if ($dto->customAlias) {
            $collision = Url::query()
                ->where('short_code', $dto->customAlias)
                ->orWhere('custom_alias', $dto->customAlias)
                ->exists();

            if ($collision) {
                throw new \InvalidArgumentException(
                    "Alias '{$dto->customAlias}' conflicts with an existing short code or alias."
                );
            }

            return $this->createUrl($dto->userId, $dto->originalUrl, $dto->customAlias, $dto->customAlias, $dto->expiresAt);
        }

        for ($i = 0; $i < self::MAX_GENERATION_ATTEMPTS; $i++) {
            $shortCode = Str::random(8);

            try {
                return $this->createUrl($dto->userId, $dto->originalUrl, $shortCode, null, $dto->expiresAt);

            } catch (\Illuminate\Database\QueryException $e) {
                // 23000 = Integrity constraint violation (duplicated key)
                if ($e->getCode() === '23000') {
                    continue; // gen another code.
                }
                throw $e;
            }
        }

        throw new \RuntimeException('Failed to generate unique short code after ' . self::MAX_GENERATION_ATTEMPTS . ' attempts.');
    }

    private function createUrl(?int $userId, string $originalUrl, string $shortCode, ?string $customAlias, ?\DateTimeInterface $expiresAt): Url
    {
        $url = new Url([
            'user_id'      => $userId,
            'original_url' => $originalUrl,
            'short_code'   => $shortCode,
            'custom_alias' => $customAlias,
            'expires_at'   => $expiresAt,
            'visits_count' => 0,
        ]);

        $url->save();

        return $url->refresh();
    }

    /**
     * BFS-search in cycle of internal redirects
     * 1. fast check: ref on current domain
     * 2. get short_code from URL
     * 3. BFS by redirects
     */
    private function detectCycle(string $originalUrl): bool
    {
        $appHost = parse_url(config('app.url'), PHP_URL_HOST);
        $targetHost = parse_url($originalUrl, PHP_URL_HOST);

        if ($targetHost !== $appHost) {
            return false;
        }

        $path = parse_url($originalUrl, PHP_URL_PATH); // return: array|string|int|null|false
        $path = trim(is_string($path) ? $path : '', '/');

        $visited = [];
        $queue = [$path];

        while (!empty($queue)) {
            $code = array_shift($queue);

            if (in_array($code, $visited, true)) {
                return true;
            }

            $visited[] = $code;

            $url = Url::where('short_code', $code)
                ->orWhere('custom_alias', $code)
                ->first();

            if (!$url) {
                continue;
            }

            $nextHost = parse_url($url->original_url, PHP_URL_HOST);
            if ($nextHost === $appHost) {
                $nextPath = parse_url($url->original_url, PHP_URL_PATH);// array|string|int|null|false
                $queue[] = trim(is_string($nextPath) ? $nextPath : '', '/');
            }
        }

        return false;
    }
}
