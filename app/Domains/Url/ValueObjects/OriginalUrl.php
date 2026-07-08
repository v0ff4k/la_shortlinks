<?php

declare(strict_types=1);

namespace App\Domains\Url\ValueObjects;

use InvalidArgumentException;

readonly class OriginalUrl
{
    public function __construct(public string $value)
    {
        if (!filter_var($this->value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL');
        }
    }
}
