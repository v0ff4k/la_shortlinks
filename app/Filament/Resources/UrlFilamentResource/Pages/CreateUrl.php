<?php

declare(strict_types=1);

namespace App\Filament\Resources\UrlFilamentResource\Pages;

use App\Filament\Resources\UrlFilamentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUrl extends CreateRecord
{
    protected static string $resource = UrlFilamentResource::class;
}
