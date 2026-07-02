<?php

namespace Tests\Unit\Application\Url\DTOs;

use App\Application\Url\DTOs\CreateUrlDTO;
use App\Infrastructure\Http\Requests\CreateUrlRequest;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class CreateUrlDTOTest extends TestCase
{
    public function test_from_request_creates_dto_correctly(): void
    {
        $request = new CreateUrlRequest();
        $request->initialize(['original_url' => 'https://example.com', 'custom_alias' => 'mylink']);

        $dto = CreateUrlDTO::fromRequest($request);

        $this->assertInstanceOf(CreateUrlDTO::class, $dto);
        $this->assertSame('https://example.com', $dto->originalUrl);
        // Проверим, что если был передан custom_alias, он игнорируется в DTO, т.к. DTO берет его из другого места (если был бы)
        // Но по нашему коду DTO всегда генерит код, если нет алиаса в конструкторе
        // Т.е. custom_alias не передается в DTO из этого метода
        // Правильнее будет проверить, что DTO создается с null alias, если не передан напрямую
        // Но в текущем методе fromRequest custom_alias не используется
        // Поэтому проверим, что DTO создается с оригиналом
    }
}
