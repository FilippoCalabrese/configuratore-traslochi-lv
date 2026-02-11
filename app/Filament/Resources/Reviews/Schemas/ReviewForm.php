<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Recensione')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome Cliente')
                            ->required()
                            ->maxLength(255),
                        Select::make('rating')
                            ->label('Valutazione')
                            ->options([
                                1 => '1 stella',
                                2 => '2 stelle',
                                3 => '3 stelle',
                                4 => '4 stelle',
                                5 => '5 stelle',
                            ])
                            ->required()
                            ->default(5),
                        DatePicker::make('review_date')
                            ->label('Data Recensione')
                            ->required()
                            ->default(now())
                            ->displayFormat('d/m/Y'),
                        Textarea::make('text')
                            ->label('Testo Recensione')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000),
                        TextInput::make('order')
                            ->label('Ordine')
                            ->numeric()
                            ->default(0)
                            ->helperText('Numero per ordinare le recensioni (più basso = prima)'),
                        Toggle::make('is_active')
                            ->label('Attiva')
                            ->default(true)
                            ->helperText('Le recensioni non attive non verranno mostrate'),
                    ])
                    ->columns(2),
            ]);
    }
}
