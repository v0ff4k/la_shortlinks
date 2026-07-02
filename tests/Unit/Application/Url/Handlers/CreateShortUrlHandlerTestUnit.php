<?php

namespace Tests\Unit\Application\Url\Handlers;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Application\Url\DTOs\CreateUrlDTO;
use App\Application\Url\Handlers\CreateShortUrlHandler;
use App\Domains\Url\Models\Url;
use Illuminate\Support\Str;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateShortUrlHandlerTestUnit extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_handler_creates_url_model_with_mock(): void
    {
        $dto = new CreateUrlDTO(userId: 1, originalUrl: 'https://example.com', customAlias: null, expiresAt: null);
        $command = new CreateShortUrlCommand($dto);

        $mockUrl = Mockery::mock(Url::class);
        $mockUrl->shouldReceive('setAttribute')->with('user_id', 1)->andReturnSelf();
        $mockUrl->shouldReceive('setAttribute')->with('original_url', 'https://example.com')->andReturnSelf();
        $mockUrl->shouldReceive('setAttribute')->with('short_code', Mockery::any())->andReturnSelf();
        $mockUrl->shouldReceive('save')->once();

        $handler = Mockery::mock(CreateShortUrlHandler::class)->makePartial();
        $handler->shouldAllowMockingProtectedMethods();
        $handler->shouldReceive('createNewUrlInstance')->andReturn($mockUrl);

        $result = $handler->handle($command);

        $this->assertSame($mockUrl, $result);
    }
}