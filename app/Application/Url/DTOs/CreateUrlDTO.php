<?php

declare(strict_types=1);

namespace App\Application\Url\DTOs;

use App\Infrastructure\Http\Requests\CreateUrlRequest;
use Carbon\Carbon;

readonly class CreateUrlDTO
{
    public function __construct(
        public ?int $userId,
        public string $originalUrl,
        public ?string $customAlias,
        public ?\DateTimeInterface $expiresAt
    ) {}

    /**
     * Build from HTTP Request (web/API controllers)
     */
    public static function fromRequest(CreateUrlRequest $request): self
    {
        return new self(
            userId: $request->user()?->id,
            originalUrl: $request->input('original_url'),
            customAlias: $request->input('custom_alias'),
            expiresAt: $request->filled('expires_at')
                ? new \DateTime($request->input('expires_at'))
                : null,
        );
    }

    /**
     * Build from Array (Filament/Artisan command/, tests)
     * @param array{original_url: string, custom_alias?: string|null, expires_at?: string|null} $data
     */
    public static function fromArray(array $data, ?int $userId = null): self
    {
        return new self(
            userId: $userId,
            originalUrl: $data['original_url'],
            customAlias: $data['custom_alias'] ?? null,
            expiresAt: !empty($data['expires_at'])
                ? Carbon::parse($data['expires_at'])->toDateTime()
                : null,
        );
    }
}
