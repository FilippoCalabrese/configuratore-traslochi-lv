<?php

namespace App\Filament\Resources\Configurations\Schemas;

use App\Filament\Schemas\Components\FurnitureConfigView;
use App\Models\Room;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConfigurationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Cliente')
                    ->schema([
                        TextInput::make('config_id')
                            ->label('ID Configurazione')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('nome')
                            ->label('Nome e Cognome')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Telefono')
                            ->tel()
                            ->required()
                            ->maxLength(50),
                    ])
                    ->columns(2),

                Section::make('Dettagli Trasloco')
                    ->schema([
                        TextInput::make('luogo_carico')
                            ->label('Indirizzo di Carico')
                            ->required()
                            ->maxLength(500),
                        TextInput::make('luogo_scarico')
                            ->label('Indirizzo di Scarico')
                            ->required()
                            ->maxLength(500),
                        TextInput::make('distanza_totale')
                            ->label('Distanza Totale (km)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('km'),
                        TextInput::make('tempo_totale')
                            ->label('Tempo Totale (minuti)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('min'),
                        Select::make('tipo_trasporto')
                            ->label('Tipo Trasporto')
                            ->options([
                                'solo_trasporto' => 'Solo Trasporto',
                                'trasporto_parziale' => 'Trasporto + Montaggio o Smontaggio',
                                'trasporto_totale' => 'Trasporto + Montaggio + Smontaggio',
                            ])
                            ->required()
                            ->default('solo_trasporto'),
                        TextInput::make('piano_carico')
                            ->label('Piano Carico')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('piano_scarico')
                            ->label('Piano Scarico')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Opzioni')
                    ->schema([
                        Toggle::make('imballaggio')
                            ->label('Imballaggio')
                            ->default(false),
                        Toggle::make('ztl')
                            ->label('ZTL')
                            ->default(false),
                        Toggle::make('ascensore')
                            ->label('Ascensore')
                            ->default(false),
                    ])
                    ->columns(3),

                Section::make('Stanze Selezionate')
                    ->schema([
                        CheckboxList::make('stanze_selezionate')
                            ->label('Stanze')
                            ->options(function () {
                                return Room::query()
                                    ->orderBy('name')
                                    ->pluck('name', 'name')
                                    ->toArray();
                            })
                            ->columns(2)
                            ->gridDirection('row')
                            ->descriptions(function () {
                                $rooms = Room::query()
                                    ->withCount('furnishItems')
                                    ->orderBy('name')
                                    ->get();

                                $descriptions = [];
                                foreach ($rooms as $room) {
                                    $descriptions[$room->name] = "{$room->furnish_items_count} mobili disponibili";
                                }

                                return $descriptions;
                            }),
                    ])
                    ->collapsible(),

                Section::make('Configurazione Mobili')
                    ->schema([
                        FurnitureConfigView::make('furniture_config'),
                    ])
                    ->collapsible(),

                Section::make('Dettagli Prenotazione')
                    ->schema([
                        KeyValue::make('booking_details')
                            ->label('Dettagli'),
                    ])
                    ->collapsible(),

                Section::make('Prezzi e Tempi')
                    ->schema([
                        TextInput::make('total_price')
                            ->label('Prezzo Totale')
                            ->numeric()
                            ->prefix('€')
                            ->step(0.01)
                            ->default(0),
                        TextInput::make('transport_cost')
                            ->label('Costo Trasporto')
                            ->numeric()
                            ->prefix('€')
                            ->step(0.01)
                            ->default(0),
                        TextInput::make('total_carico_time')
                            ->label('Tempo Carico (minuti)')
                            ->numeric()
                            ->default(0),
                        TextInput::make('total_scarico_time')
                            ->label('Tempo Scarico (minuti)')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),

                Section::make('Stato')
                    ->schema([
                        Select::make('status')
                            ->label('Stato')
                            ->options([
                                'in_progress' => 'In Corso',
                                'completed' => 'Completata',
                            ])
                            ->required()
                            ->default('in_progress'),
                        TextInput::make('current_step')
                            ->label('Step Corrente')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(1)
                            ->maxValue(7),
                    ])
                    ->columns(2),
            ]);
    }
}
