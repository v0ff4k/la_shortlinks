<?php

namespace Tests\Unit;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Application\Url\DTOs\CreateUrlDTO;
use App\Application\Url\Handlers\CreateShortUrlHandler;
use App\Domains\Url\Models\Url;
use Tests\TestCase;

class CreateShortUrlHandlerTest extends TestCase
{
    public function test_it_creates_url(): void
    {
        $dto = new CreateUrlDTO(1, 'https://example.com', 'abc123');
        $command = new CreateShortUrlCommand($dto);

        $handler = new CreateShortUrlHandler();
        $url = $handler->handle($command);

        $this->assertInstanceOf(Url::class, $url);
        $this->assertEquals('https://example.com', $url->original_url);
    }
}

