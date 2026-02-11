<?php

namespace App\Filament\Resources\FurnishItems\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FurnishItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Base')
                    ->schema([
                        Select::make('room_id')
                            ->relationship('room', 'name')
                            ->required()
                            ->label('Stanza')
                            ->searchable()
                            ->preload(),
                        TextInput::make('name')
                            ->required()
                            ->label('Nome')
                            ->maxLength(255),
                        FileUpload::make('image')
                            ->label('Immagine')
                            ->image()
                            ->directory('images')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml'])
                            ->maxSize(2048),
                        TextInput::make('label')
                            ->label('Etichetta')
                            ->maxLength(255)
                            ->helperText('Etichetta mostrata quando si seleziona questo mobile (es. "Forma del divano")'),
                        TextInput::make('min_properties')
                            ->label('Proprietà Minime Richieste')
                            ->numeric()
                            ->default(0)
                            ->helperText('Numero minimo di proprietà che devono essere selezionate per questo mobile'),
                    ])
                    ->columns(2),

                Section::make('Prezzi e Tempi Base')
                    ->schema([
                        TextInput::make('base_price')
                            ->label('Prezzo Base')
                            ->numeric()
                            ->prefix('€')
                            ->step(0.01),
                        TextInput::make('base_m3')
                            ->label('Metri Cubi Base')
                            ->numeric()
                            ->step(0.01),
                        TextInput::make('base_tempo_carico')
                            ->label('Tempo Carico (minuti)')
                            ->numeric()
                            ->default(0),
                        TextInput::make('base_tempo_scarico')
                            ->label('Tempo Scarico (minuti)')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),

                Section::make('Proprietà Annidate')
                    ->schema([
                        Repeater::make('properties')
                            ->label('Proprietà')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nome')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('label')
                                    ->label('Etichetta')
                                    ->maxLength(255)
                                    ->helperText('Etichetta mostrata quando si seleziona questa proprietà'),
                                TextInput::make('price')
                                    ->label('Prezzo')
                                    ->numeric()
                                    ->prefix('€')
                                    ->step(0.01)
                                    ->default(0),
                                TextInput::make('m3')
                                    ->label('Metri Cubi')
                                    ->numeric()
                                    ->step(0.01)
                                    ->default(0),
                                TextInput::make('tempo_carico')
                                    ->label('Tempo Carico (minuti)')
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('tempo_scarico')
                                    ->label('Tempo Scarico (minuti)')
                                    ->numeric()
                                    ->default(0),
                                Repeater::make('properties')
                                    ->label('Sotto-proprietà')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nome')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('price')
                                            ->label('Prezzo')
                                            ->numeric()
                                            ->prefix('€')
                                            ->step(0.01)
                                            ->default(0),
                                        TextInput::make('m3')
                                            ->label('Metri Cubi')
                                            ->numeric()
                                            ->step(0.01)
                                            ->default(0),
                                        TextInput::make('tempo_carico')
                                            ->label('Tempo Carico (minuti)')
                                            ->numeric()
                                            ->default(0),
                                        TextInput::make('tempo_scarico')
                                            ->label('Tempo Scarico (minuti)')
                                            ->numeric()
                                            ->default(0),
                                    ])
                                    ->columns(3)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),
                            ])
                            ->columns(3)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->defaultItems(0)
                            ->addActionLabel('Aggiungi Proprietà'),
                    ])
                    ->collapsible(),
            ]);
    }
}
