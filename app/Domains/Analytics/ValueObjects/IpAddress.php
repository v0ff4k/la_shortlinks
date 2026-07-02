<?php

namespace App\Domains\Analytics\ValueObjects;

use InvalidArgumentException;

readonly class IpAddress
{
    public function __construct(public string $value)
    {
        if (!filter_var($this->value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException('Invalid IP address');
        }
    }
}