<?php

declare(strict_types=1);

namespace App\Filament\Resources\UrlFilamentResource\Pages;

use App\Filament\Resources\UrlFilamentResource;
use App\Filament\Resources\UrlFilamentResource\RelationManagers\VisitsRelationManager;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ViewUrlStats extends ViewRecord
{
    protected static string $resource = UrlFilamentResource::class;

    protected static ?string $title = 'Link Statistics';

    // ViewRecord автоматически резолвит record через getRecordRouteKeyName()
    // и проверяет права через Policy::view(). Метод mount() больше не нужен.

    public function getRelationManagers(): array
    {
        return [
            VisitsRelationManager::class,
        ];
    }

    /**
     * Filament v5 signature: accepts Schema, returns Schema
     */
    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Link Overview')
                    ->schema([
                        TextEntry::make('original_url')
                            ->label('Original URL')
                            ->copyable()
                            ->columnSpanFull(),
                        TextEntry::make('short_code')
                            ->label('Short Code')
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('custom_alias')
                            ->label('Alias')
                            ->placeholder('—'),
                        TextEntry::make('visits_count')
                            ->label('Total Visits')
                            ->numeric(thousandsSeparator: ','),
                        TextEntry::make('expires_at')
                            ->label('Expires')
                            ->dateTime('H:i:s d-m-y')
                            ->placeholder('Never'),
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime('H:i:s d-m-y'),
                    ])
                    ->columns(['default' => 2, 'md' => 4, 'xl' => 6])          // 2-4-6 cols per screen
                    ->columnSpanFull()   // set full with span element.
                ,
            ]);
    }
}
