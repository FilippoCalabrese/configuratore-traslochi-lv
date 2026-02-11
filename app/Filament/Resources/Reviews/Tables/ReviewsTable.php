<?php

namespace App\Filament\Resources\Reviews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome Cliente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('rating')
                    ->label('Valutazione')
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        5 => 'success',
                        4 => 'success',
                        3 => 'warning',
                        2 => 'danger',
                        1 => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (int $state): string => str_repeat('★', $state).' ('.$state.'/5)')
                    ->sortable(),
                TextColumn::make('text')
                    ->label('Testo')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->text)
                    ->searchable(),
                TextColumn::make('review_date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('order')
                    ->label('Ordine')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Attiva')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creata il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Stato')
                    ->options([
                        true => 'Attive',
                        false => 'Non Attive',
                    ]),
                SelectFilter::make('rating')
                    ->label('Valutazione')
                    ->options([
                        5 => '5 stelle',
                        4 => '4 stelle',
                        3 => '3 stelle',
                        2 => '2 stelle',
                        1 => '1 stella',
                    ]),
            ])
            ->defaultSort('order')
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
