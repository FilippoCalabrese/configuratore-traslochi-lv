<?php

namespace App\Filament\Resources\Configurations;

use App\Filament\Resources\Configurations\Pages\EditConfiguration;
use App\Filament\Resources\Configurations\Pages\ListConfigurations;
use App\Filament\Resources\Configurations\Schemas\ConfigurationForm;
use App\Filament\Resources\Configurations\Tables\ConfigurationsTable;
use App\Filament\Schemas\ConfigurationInfolist;
use App\Models\Configuration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ConfigurationResource extends Resource
{
    protected static ?string $model = Configuration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Richieste di Trasloco';

    protected static ?string $modelLabel = 'Richiesta di Trasloco';

    protected static ?string $pluralModelLabel = 'Richieste di Trasloco';

    protected static ?string $navigationGroup = 'Traslochi';

    public static function form(Schema $schema): Schema
    {
        return ConfigurationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConfigurationsTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ConfigurationInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConfigurations::route('/'),
            'view' => Pages\ViewConfiguration::route('/{record}'),
            'edit' => EditConfiguration::route('/{record}/edit'),
        ];
    }
}
