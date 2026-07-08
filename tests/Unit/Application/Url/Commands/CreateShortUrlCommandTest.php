<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Url\Commands;

use App\Application\Url\Commands\CreateShortUrlCommand;
use App\Application\Url\DTOs\CreateUrlDTO;
use PHPUnit\Framework\TestCase;

class CreateShortUrlCommandTest extends TestCase
{
    public function test_command_stores_dto(): void
    {
        $dto = new CreateUrlDTO(userId: 1, originalUrl: 'https://example.com', customAlias: null, expiresAt: null);
        $command = new CreateShortUrlCommand($dto);

        $this->assertSame($dto, $command->dto);
    }
}
