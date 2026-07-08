<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Domains\Url\Models\Url;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\UrlFilamentResource\Pages;

class UrlFilamentResource extends Resource
{
    protected static ?string $model = Url::class;

    public static function getNavigationLabel(): string
    {
        return 'Short URLs';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('original_url')
                    ->label('Original URL')
                    ->required()
                    ->url()
                    ->maxLength(2048)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('custom_alias')
                    ->label('Custom Alias')
                    ->alphaDash()
                    ->minLength(3)
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->helperText('Leave empty to auto-generate'),

                Forms\Components\DateTimePicker::make('expires_at')
                    ->label('Expires At')
                    ->after('now')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('original_url')
                    ->label('Original URL')
                    ->limit(50)
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('short_code')
                    ->label('Code')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('custom_alias')
                    ->label('Alias')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Never'),

                Tables\Columns\TextColumn::make('visits_count')
                    ->label('Visits')
                    ->counts('visits')
                    ->sortable()
                    ->numeric(thousandsSeparator: ','),
            ])
            ->filters([
                Tables\Filters\Filter::make('expired')
                    ->label('Expired Only')
                    ->query(fn($query) => $query->whereNotNull('expires_at')->where('expires_at', '<=', now())),

                Tables\Filters\Filter::make('active')
                    ->label('Active Only')
                    ->query(fn($query) => $query->where(function ($q): void {
                        $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                    })),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUrls::route('/'),
            'create' => Pages\CreateUrl::route('/create'),
            'edit' => Pages\EditUrl::route('/{record}/edit'),
        ];
    }
}
