<?php

namespace Tests\Unit\Application\Url\Handlers;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Application\Url\DTOs\CreateUrlDTO;
use App\Application\Url\Handlers\CreateShortUrlHandler;
use App\Domains\Url\Models\Url;
use Illuminate\Support\Facades\DB;
use Mockery;
use PHPUnit\Framework\TestCase;

//(Примечание: Этот тест создает запись в БД. Для изоляции, можно использовать RefreshDatabase или DatabaseMigrations, но тогда это уже будет Feature-тест. Unit-тест не должен использовать БД.)
class CreateShortUrlHandlerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_handler_creates_url_model(): void
    {
        $dto = new CreateUrlDTO(userId: 1, originalUrl: 'https://example.com', customAlias: null, expiresAt: null);
        $command = new CreateShortUrlCommand($dto);

        $handler = new CreateShortUrlHandler();
        $url = $handler->handle($command);

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('https://example.com', $url->original_url);
        $this->assertSame(1, $url->user_id);
    }
}
