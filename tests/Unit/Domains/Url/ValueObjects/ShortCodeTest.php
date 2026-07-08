<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\Url\ValueObjects;

use App\Domains\Url\ValueObjects\ShortCode;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ShortCodeTest extends TestCase
{
    public function test_valid_short_code_is_accepted(): void
    {
        $validCode = 'abc123';
        $vo = new ShortCode($validCode);

        $this->assertSame($validCode, $vo->value);
    }

    public function test_invalid_short_code_throws_exception(): void
    {
        $invalidCode = 'ab!@#$%';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid short code format');

        new ShortCode($invalidCode);
    }
}
