<?php

namespace App\Filament\Resources\Configurations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ConfigurationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('phone')
                    ->label('Telefono')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('status')
                    ->label('Stato')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'in_progress' => 'In Corso',
                        'completed' => 'Completata',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('current_step')
                    ->label('Step')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('total_price')
                    ->label('Prezzo Totale')
                    ->money('EUR', locale: 'it')
                    ->sortable(),
                TextColumn::make('luogo_carico')
                    ->label('Indirizzo Carico')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->luogo_carico),
                TextColumn::make('luogo_scarico')
                    ->label('Indirizzo Scarico')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->luogo_scarico),
                TextColumn::make('distanza_totale')
                    ->label('Distanza')
                    ->numeric(decimalPlaces: 0)
                    ->suffix(' km')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Data Creazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label('Ultimo Aggiornamento')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'in_progress' => 'In Corso',
                        'completed' => 'Completata',
                    ]),
                SelectFilter::make('current_step')
                    ->label('Step')
                    ->options([
                        1 => 'Step 1 - Informazioni Cliente',
                        2 => 'Step 2 - Informazioni Trasporto',
                        3 => 'Step 3 - Selezione Mobili',
                        4 => 'Step 4 - Riepilogo',
                        5 => 'Step 5 - Prenotazione',
                        6 => 'Step 6 - Completata',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
