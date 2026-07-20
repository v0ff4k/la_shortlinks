<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Domains\Url\Models\Url;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\UrlFilamentResource\Pages;
use App\Filament\Resources\UrlFilamentResource\RelationManagers\VisitsRelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class UrlFilamentResource extends Resource
{
    protected static ?string $model = Url::class;

    public static function getRecordRouteKeyName(): string
    {
        return 'short_code';
    }

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
                    ->rule(function ($attribute, $value, $fail): void {
                        if (!$value) {
                            return;
                        }

                        // Getting safe 'record' from the  Livewire context(safely)
                        $record = request()->route('record');


                        $query = Url::query()
                            ->where(function ($q) use ($value): void {
                                $q->where('short_code', $value)->orWhere('custom_alias', $value);
                            });

                        // Явная проверка типа устраняет ошибку getKey()
                        if ($record instanceof Url) {
                            $query->where('id', '!=', $record->getKey());
                        }

                        if ($query->exists()) {
                            $fail("This alias conflicts with an existing short code or custom alias.");
                        }
                    })
                    ->helperText('Must be unique across all short codes and aliases'),

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
                    ->color('primary')
                    ->copyable()
                    ->copyMessage('Short code copied!'),

                Tables\Columns\TextColumn::make('custom_alias')
                    ->label('Alias')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime('H:i:s d-m-y')
                    ->sortable()
                    ->placeholder('Never'),

                Tables\Columns\TextColumn::make('visits_count')
                    ->label('Visits')
//                    ->counts('visits')
                    ->sortable()
                    ->numeric(thousandsSeparator: ' '),
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
                Action::make('statistics')
                    ->label('Stats')
                    ->icon('heroicon-o-chart-bar')
                    ->color('info')
                    ->url(fn($record): string => UrlFilamentResource::getUrl('stats', ['record' => $record->short_code])),
                ViewAction::make()
                    ->modalHeading('Link Details')
                    ->modalWidth('3xl')
                    ->infolist([
                        Section::make('Link Information')
                            ->schema([
                                TextEntry::make('original_url')->label('Original URL')->copyable()->columnSpanFull(),
                                TextEntry::make('short_code')->label('Short Code')->badge()->color('primary'),
                                TextEntry::make('custom_alias')->label('Alias')->placeholder('—'),
                                TextEntry::make('visits_count')->label('Total Visits')->numeric(thousandsSeparator: ' '),
                                TextEntry::make('expires_at')->label('Expires')->dateTime('H:i:s d-m-y')->placeholder('Never'),
                                TextEntry::make('created_at')->label('Created')->dateTime('H:i:s d-m-y'),
                            ])
                            ->columns(2),
                    ]),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'edit' => Pages\EditUrl::route('/{record:short_code}/edit'),
            'stats' => Pages\ViewUrlStats::route('/{record:short_code}/stats'),
        ];
    }

    //    public static function getRelations(): array
    //    {
    //        return [
    //            VisitsRelationManager::class,
    //        ];
    //    }
}
