<?php

namespace App\Filament\Resources\Configurations\Pages;

use App\Filament\Resources\Configurations\ConfigurationResource;
use App\Models\Configuration;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListConfigurations extends ListRecords
{
    protected static string $resource = ConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tutte')
                ->badge(fn () => Configuration::count()),
            'in_progress' => Tab::make('In Corso')
                ->badge(fn () => Configuration::where('status', 'in_progress')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'in_progress')),
            'completed' => Tab::make('Completate')
                ->badge(fn () => Configuration::where('status', 'completed')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')),
        ];
    }
}
