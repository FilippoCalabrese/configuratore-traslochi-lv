<?php

namespace App\Filament\Resources\FurnishItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FurnishItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Immagine')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.svg')),
                TextColumn::make('room.name')
                    ->label('Stanza')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('label')
                    ->label('Etichetta')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('base_price')
                    ->label('Prezzo Base')
                    ->money('EUR', locale: 'it')
                    ->sortable(),
                TextColumn::make('base_m3')
                    ->label('m³')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('min_properties')
                    ->label('Prop. Min.')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('base_tempo_carico')
                    ->label('Tempo Carico')
                    ->numeric()
                    ->suffix(' min')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('base_tempo_scarico')
                    ->label('Tempo Scarico')
                    ->numeric()
                    ->suffix(' min')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Data Creazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Ultimo Aggiornamento')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('room_id')
                    ->label('Stanza')
                    ->relationship('room', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('room.name')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
