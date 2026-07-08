<?php

declare(strict_types=1);

namespace App\Application\Url\Handlers;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Domains\Url\Models\Url;
use Illuminate\Support\Str;

class CreateShortUrlHandler
{
    public function handle(CreateShortUrlCommand $command): Url
    {
        $dto = $command->dto;

        if ($dto->customAlias && Url::where('custom_alias', $dto->customAlias)->exists()) {
            throw new \InvalidArgumentException("Custom alias '{$dto->customAlias}' is already taken.");
        }

        $url = new Url([
            'user_id' => $dto->userId,
            'original_url' => $dto->originalUrl,
            'short_code' => $dto->customAlias ?? Str::random(6),
            'custom_alias' => $dto->customAlias,
            'expires_at' => $dto->expiresAt,
        ]);

        $url->save();

        return $url->refresh();
    }
}
