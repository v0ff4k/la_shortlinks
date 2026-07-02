<?php

namespace App\Filament\Resources;

use App\Domains\Url\Models\Url;
use Filament\{Resources, Tables, Forms};
use Filament\Resources\Resource;

class UrlFilamentResource extends Resource
{
    protected static ?string $model = Url::class;
    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('original_url')->limit(50),
                Tables\Columns\TextColumn::make('short_code'),
                Tables\Columns\TextColumn::make('custom_alias'),
                Tables\Columns\TextColumn::make('expires_at')->dateTime(),
                Tables\Columns\TextColumn::make('visits_count')->counts('visits'),
            ])
            ->filters([
                Tables\Filters\Filter::make('expired')
                    ->query(fn ($query) => $query->where('expires_at', '<=', now())),
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
            ->paginated([10, 25, 50]); // Постраничный вывод
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('original_url')->required()->url()->maxLength(2048),
                Forms\Components\TextInput::make('custom_alias')->alphaDash()->minLength(3)->maxLength(50),
                Forms\Components\DateTimePicker::make('expires_at'),
            ]);
    }
}