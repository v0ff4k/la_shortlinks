<?php

declare(strict_types=1);

namespace Tests\Unit;

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

    public function test_it_creates_url(): void
    {
        $user = User::factory()->create();
        $dto = new CreateUrlDTO($user->id, 'https://example.com', 'abc123', null);
        $command = new CreateShortUrlCommand($dto);

        $handler = new CreateShortUrlHandler();
        $url = $handler->handle($command);

        $this->assertInstanceOf(Url::class, $url);
        $this->assertEquals('https://example.com', $url->original_url);
        $this->assertSame('abc123', $url->short_code);
        $this->assertSame($user->id, $url->user_id);
        $this->assertDatabaseHas('urls', [
            'short_code' => 'abc123',
            'original_url' => 'https://example.com',
        ]);
    }
}
