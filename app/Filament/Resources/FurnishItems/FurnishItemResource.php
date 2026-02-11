<?php

namespace App\Filament\Resources\FurnishItems;

use App\Filament\Resources\FurnishItems\Pages\CreateFurnishItem;
use App\Filament\Resources\FurnishItems\Pages\EditFurnishItem;
use App\Filament\Resources\FurnishItems\Pages\ListFurnishItems;
use App\Filament\Resources\FurnishItems\Schemas\FurnishItemForm;
use App\Filament\Resources\FurnishItems\Tables\FurnishItemsTable;
use App\Models\FurnishItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FurnishItemResource extends Resource
{
    protected static ?string $model = FurnishItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static ?string $navigationLabel = 'Forniture';

    protected static ?string $modelLabel = 'Fornitura';

    protected static ?string $pluralModelLabel = 'Forniture';

    protected static ?string $navigationGroup = 'Catalogo';

    public static function form(Schema $schema): Schema
    {
        return FurnishItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FurnishItemsTable::configure($table);
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
            'index' => ListFurnishItems::route('/'),
            'create' => CreateFurnishItem::route('/create'),
            'edit' => EditFurnishItem::route('/{record}/edit'),
        ];
    }
}
