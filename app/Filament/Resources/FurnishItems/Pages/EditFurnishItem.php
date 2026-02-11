<?php

namespace App\Filament\Resources\FurnishItems\Pages;

use App\Filament\Resources\FurnishItems\FurnishItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFurnishItem extends EditRecord
{
    protected static string $resource = FurnishItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
