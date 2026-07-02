<?php

namespace App\Application\Url\Commands;

use App\Application\Url\DTOs\CreateUrlDTO;

readonly class CreateShortUrlCommand
{
    public function __construct(public CreateUrlDTO $dto) {}
}
