<?php

namespace Tests\Unit\Domains\Url\ValueObjects;

use App\Domains\Url\ValueObjects\OriginalUrl;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class OriginalUrlTest extends TestCase
{
    public function test_valid_url_is_accepted(): void
    {
        $validUrl = 'https://example.com';
        $vo = new OriginalUrl($validUrl);

        $this->assertSame($validUrl, $vo->value);
    }

    public function test_invalid_url_throws_exception(): void
    {
        $invalidUrl = 'not-a-url';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid URL');

        new OriginalUrl($invalidUrl);
    }
}
