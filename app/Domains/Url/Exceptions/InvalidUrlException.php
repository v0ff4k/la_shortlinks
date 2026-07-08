<?php

declare(strict_types=1);

namespace App\Domains\Url\Exceptions;

use Exception;

class InvalidUrlException extends Exception
{
    public static function fromUrl(string $url): self
    {
        return new self("The URL '{$url}' is invalid.");
    }
}
