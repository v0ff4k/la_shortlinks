<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Url\Handlers;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Application\Url\DTOs\CreateUrlDTO;
use App\Application\Url\Handlers\CreateShortUrlHandler;
use App\Domains\Url\Models\Url;
use App\Domains\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateShortUrlHandlerTestUnit extends TestCase
{
    use RefreshDatabase;

    public function test_handler_rejects_duplicate_custom_alias(): void
    {
        $user = User::factory()->create();
        Url::factory()->create([
            'user_id' => $user->id,
            'custom_alias' => 'dup-link',
            'short_code' => 'dup-link',
        ]);

        $dto = new CreateUrlDTO(
            userId: $user->id,
            originalUrl: 'https://example.com',
            customAlias: 'dup-link',
            expiresAt: null
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Custom alias 'dup-link' is already taken.");

        (new CreateShortUrlHandler())->handle(new CreateShortUrlCommand($dto));
    }
}
