<?php

declare(strict_types=1);

namespace App\Filament\Resources\UrlFilamentResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('visited_at')
            ->columns([
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable(),

                TextColumn::make('visited_at')
                    ->label('Visited At')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('visited_at', 'desc')
            ->paginated([10, 25, 50])
            // NO headerActions, recordActions, toolbarActions we are on READONLY !
            ->emptyStateHeading('No visits yet')
            ->emptyStateDescription('This link has not been visited yet.');
    }
}
