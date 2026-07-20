<?php

declare(strict_types=1);

namespace App\Filament\Resources\UrlFilamentResource\Pages;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Application\Url\DTOs\CreateUrlDTO;
use App\Application\Url\Handlers\CreateShortUrlHandler;
use App\Filament\Resources\UrlFilamentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUrl extends CreateRecord
{
    protected static string $resource = UrlFilamentResource::class;

    /**
     * Переопределяем создание записи, чтобы использовать DDD-хендлер
     * вместо прямого Eloquent::create()
     */
    protected function handleRecordCreation(array $data): Model
    {
        /** @var CreateShortUrlHandler $handler */
        $handler = app(CreateShortUrlHandler::class);

        // Moved array<string, mixed> into predictable array-shape
        /** @var array{original_url: string, custom_alias?: string|null, expires_at?: string|null} $dtoData */
        $dtoData = [
            'original_url' => (string) ($data['original_url'] ?? ''),
            'custom_alias' => isset($data['custom_alias']) ? (string) $data['custom_alias'] : null,
            'expires_at'   => isset($data['expires_at']) ? (string) $data['expires_at'] : null,
        ];

        $userId = auth()->id();
        $dto = CreateUrlDTO::fromArray($dtoData, $userId !== null ? (int) $userId : null);

        return $handler->handle(new CreateShortUrlCommand($dto));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
