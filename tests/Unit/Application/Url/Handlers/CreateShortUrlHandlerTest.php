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

class CreateShortUrlHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_handler_creates_url_model(): void
    {
        $user = User::factory()->create();
        $dto = new CreateUrlDTO(userId: $user->id, originalUrl: 'https://example.com', customAlias: null, expiresAt: null);
        $command = new CreateShortUrlCommand($dto);

        $handler = new CreateShortUrlHandler();
        $url = $handler->handle($command);

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('https://example.com', $url->original_url);
        $this->assertSame($user->id, $url->user_id);
        $this->assertDatabaseHas('urls', [
            'user_id' => $user->id,
            'original_url' => 'https://example.com',
        ]);
    }
}
