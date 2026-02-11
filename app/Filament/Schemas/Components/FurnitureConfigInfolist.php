<?php

namespace App\Filament\Schemas\Components;

use Filament\Schemas\Components\Component;

class FurnitureConfigInfolist extends Component
{
    protected string $view = 'filament.schemas.components.furniture-config-infolist';

    public static function make(): static
    {
        return app(static::class);
    }
}
