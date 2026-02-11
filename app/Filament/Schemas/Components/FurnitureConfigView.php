<?php

namespace App\Filament\Schemas\Components;

use Closure;
use Filament\Schemas\Components\Component;

class FurnitureConfigView extends Component
{
    protected string $view = 'filament.schemas.components.furniture-config-view';

    public static function make(string|Closure|null $statePath = null): static
    {
        $component = app(static::class);
        $component->statePath($statePath ?? 'furniture_config');

        return $component;
    }
}
