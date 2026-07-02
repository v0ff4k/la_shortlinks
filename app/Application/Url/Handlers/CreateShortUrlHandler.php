<?php

namespace App\Application\Url\Handlers;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Domains\Url\Models\Url;

class CreateShortUrlHandler
{
    public function handle(CreateShortUrlCommand $command): Url
    {
        $dto = $command->dto;

        // Если алиас занят, выбрасываем ошибку или генерируем новый код
        if ($dto->customAlias && Url::where('custom_alias', $dto->customAlias)->exists()) {
            throw new \InvalidArgumentException("Custom alias '{$dto->customAlias}' is already taken.");
        }

        $url = new Url([
            'user_id' => $dto->userId,
            'original_url' => $dto->originalUrl,
            'short_code' => $dto->customAlias ?? \Illuminate\Support\Str::random(6),
            'custom_alias' => $dto->customAlias,
            'expires_at' => $dto->expiresAt,
        ]);
        $url->save();

        return $url;
    }
}