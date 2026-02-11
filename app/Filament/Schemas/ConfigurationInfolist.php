<?php

namespace App\Filament\Schemas;

use App\Filament\Schemas\Components\FurnitureConfigView;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConfigurationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Cliente')
                    ->schema([
                        TextEntry::make('config_id')
                            ->label('ID Configurazione'),
                        TextEntry::make('nome')
                            ->label('Nome e Cognome'),
                        TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),
                        TextEntry::make('phone')
                            ->label('Telefono')
                            ->copyable(),
                        TextEntry::make('contact_consent')
                            ->label('Consenso Ricontatto')
                            ->badge()
                            ->color(fn ($state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn ($state): string => $state ? 'Sì' : 'No'),
                    ])
                    ->columns(2),

                Section::make('Dettagli Trasloco')
                    ->schema([
                        TextEntry::make('luogo_carico')
                            ->label('Indirizzo di Carico'),
                        TextEntry::make('luogo_scarico')
                            ->label('Indirizzo di Scarico'),
                        TextEntry::make('distanza_totale')
                            ->label('Distanza Totale')
                            ->formatStateUsing(fn ($state): string => $state ? number_format($state, 2).' km' : 'N/A'),
                        TextEntry::make('tempo_totale')
                            ->label('Tempo Totale')
                            ->formatStateUsing(fn ($state): string => $state ? number_format($state, 0).' minuti' : 'N/A'),
                        TextEntry::make('tipo_trasporto')
                            ->label('Tipo Trasporto')
                            ->formatStateUsing(fn ($state): string => match ($state) {
                                'solo_trasporto' => 'Solo Trasporto',
                                'trasporto_parziale' => 'Trasporto + Montaggio o Smontaggio',
                                'trasporto_totale' => 'Trasporto + Montaggio + Smontaggio',
                                default => $state,
                            }),
                        TextEntry::make('piano_carico')
                            ->label('Piano Carico')
                            ->formatStateUsing(fn ($state): string => $state == 0 ? 'Piano terra' : $state.'° Piano'),
                        TextEntry::make('piano_scarico')
                            ->label('Piano Scarico')
                            ->formatStateUsing(fn ($state): string => $state == 0 ? 'Piano terra' : $state.'° Piano'),
                    ])
                    ->columns(2),

                Section::make('Opzioni')
                    ->schema([
                        TextEntry::make('imballaggio')
                            ->label('Imballaggio')
                            ->badge()
                            ->color(fn ($state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn ($state): string => $state ? 'Sì' : 'No'),
                        TextEntry::make('ztl')
                            ->label('ZTL')
                            ->badge()
                            ->color(fn ($state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn ($state): string => $state ? 'Sì' : 'No'),
                        TextEntry::make('ascensore')
                            ->label('Ascensore')
                            ->badge()
                            ->color(fn ($state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn ($state): string => $state ? 'Sì' : 'No'),
                    ])
                    ->columns(3),

                Section::make('Stanze Selezionate')
                    ->schema([
                        TextEntry::make('stanze_selezionate')
                            ->label('Stanze')
                            ->formatStateUsing(function ($state): string {
                                if (is_array($state)) {
                                    return implode(', ', $state);
                                }

                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    if (is_array($decoded)) {
                                        return implode(', ', $decoded);
                                    }

                                    return $state;
                                }

                                return 'Nessuna stanza selezionata';
                            })
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Configurazione Mobili')
                    ->schema([
                        FurnitureConfigView::make('furniture_config'),
                    ])
                    ->collapsible(),

                Section::make('Prezzi e Tempi')
                    ->schema([
                        TextEntry::make('total_price')
                            ->label('Prezzo Totale')
                            ->money('EUR', locale: 'it'),
                        TextEntry::make('transport_cost')
                            ->label('Costo Trasporto')
                            ->money('EUR', locale: 'it'),
                        TextEntry::make('total_carico_time')
                            ->label('Tempo Carico')
                            ->formatStateUsing(fn ($state): string => $state ? number_format($state, 0).' minuti' : 'N/A'),
                        TextEntry::make('total_scarico_time')
                            ->label('Tempo Scarico')
                            ->formatStateUsing(fn ($state): string => $state ? number_format($state, 0).' minuti' : 'N/A'),
                    ])
                    ->columns(2),

                Section::make('Dettagli Prenotazione')
                    ->schema([
                        TextEntry::make('booking_details')
                            ->label('Dettagli')
                            ->formatStateUsing(function ($state): string {
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    if (is_array($decoded)) {
                                        $state = $decoded;
                                    } else {
                                        return $state ?: 'N/A';
                                    }
                                }

                                if (! is_array($state) || empty($state)) {
                                    return 'N/A';
                                }

                                $details = [];
                                if (isset($state['start'])) {
                                    $details[] = 'Inizio: '.date('d/m/Y H:i', strtotime($state['start']));
                                }
                                if (isset($state['end'])) {
                                    $details[] = 'Fine: '.date('d/m/Y H:i', strtotime($state['end']));
                                }
                                if (isset($state['summary'])) {
                                    $details[] = 'Riepilogo: '.$state['summary'];
                                }
                                if (isset($state['payment_method'])) {
                                    $details[] = 'Metodo di pagamento: '.$state['payment_method'];
                                }

                                return empty($details) ? 'N/A' : implode("\n", $details);
                            })
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Stato')
                    ->schema([
                        TextEntry::make('status')
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
                            }),
                        TextEntry::make('current_step')
                            ->label('Step Corrente')
                            ->badge()
                            ->color('info'),
                        TextEntry::make('created_at')
                            ->label('Data Creazione')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Ultimo Aggiornamento')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}
