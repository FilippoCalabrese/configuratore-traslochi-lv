<?php

namespace App\Filament\Widgets;

use App\Models\Configuration;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ConfigurationsStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = Configuration::count();
        $inProgress = Configuration::where('status', 'in_progress')->count();
        $completed = Configuration::where('status', 'completed')->count();
        $totalValue = Configuration::whereNotNull('total_price')->sum('total_price');

        $completionRate = $total > 0 ? round(($completed / $total) * 100, 1) : 0;

        return [
            Stat::make('Totale Richieste', $total)
                ->description('Tutte le richieste di trasloco')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),
            Stat::make('In Corso', $inProgress)
                ->description('Richieste in elaborazione')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),
            Stat::make('Completate', $completed)
                ->description("Tasso di completamento: {$completionRate}%")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Valore Totale', '€ '.number_format($totalValue, 2, ',', '.'))
                ->description('Valore complessivo delle richieste')
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('info'),
        ];
    }
}
