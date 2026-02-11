<?php

namespace App\Filament\Resources\FurnishItems\Pages;

use App\Filament\Resources\FurnishItems\FurnishItemResource;
use App\Models\FurnishItem;
use App\Models\Room;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListFurnishItems extends ListRecords
{
    protected static string $resource = FurnishItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('Tutte')
                ->badge(fn () => FurnishItem::count()),
        ];

        $rooms = Room::orderBy('name')->get();

        foreach ($rooms as $room) {
            $tabs['room_'.$room->id] = Tab::make($room->name)
                ->badge(fn () => FurnishItem::where('room_id', $room->id)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('room_id', $room->id));
        }

        return $tabs;
    }
}
