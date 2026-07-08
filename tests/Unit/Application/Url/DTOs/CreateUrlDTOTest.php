<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Url\DTOs;

use App\Application\Url\DTOs\CreateUrlDTO;
use App\Infrastructure\Http\Requests\CreateUrlRequest;
use PHPUnit\Framework\TestCase;

class CreateUrlDTOTest extends TestCase
{
    public function test_from_request_creates_dto_correctly(): void
    {
        $request = CreateUrlRequest::create('/api/urls', 'POST', [
            'original_url' => 'https://example.com',
            'custom_alias' => 'mylink',
            'expires_at' => '2026-08-01 12:00:00',
        ]);
        $request->setUserResolver(fn() => null);

        $dto = CreateUrlDTO::fromRequest($request);

        $this->assertInstanceOf(CreateUrlDTO::class, $dto);
        $this->assertSame('https://example.com', $dto->originalUrl);
        $this->assertSame('mylink', $dto->customAlias);
        $this->assertNotNull($dto->expiresAt);
    }
}
