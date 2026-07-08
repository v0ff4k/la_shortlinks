<?php

declare(strict_types=1);

namespace App\Application\Url\DTOs;

use App\Infrastructure\Http\Requests\CreateUrlRequest;

readonly class CreateUrlDTO
{
    public function __construct(
        public ?int $userId,
        public string $originalUrl,
        public ?string $customAlias,
        public ?\DateTimeInterface $expiresAt
    ) {}

    public static function fromRequest(CreateUrlRequest $request): self
    {
        $alias = $request->input('custom_alias');

        return new self(
            $request->user()?->id,
            $request->input('original_url'),
            $alias,
            $request->filled('expires_at') ? new \DateTime($request->input('expires_at')) : null
        );
    }
}
