<?php

declare(strict_types=1);

namespace App\Domains\Url\ValueObjects;

use InvalidArgumentException;

readonly class ShortCode
{
    public function __construct(public string $value)
    {
        if (!preg_match('/^[a-zA-Z0-9-_]+$/', $this->value)) {
            throw new InvalidArgumentException('Invalid short code format');
        }
    }
}
