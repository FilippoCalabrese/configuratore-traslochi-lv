<?php

namespace App\Filament\Widgets;

use App\Models\Configuration;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ConfigurationsChart extends ChartWidget
{
    protected ?string $heading = 'Richieste per Giorno (Ultimi 30 giorni)';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $configurations = Configuration::whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($config) {
                return $config->created_at->format('Y-m-d');
            });

        $labels = [];
        $counts = [];

        // Riempiamo tutti i giorni degli ultimi 30 giorni
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $labels[] = $currentDate->format('d/m');

            $counts[] = $configurations->has($dateStr) ? $configurations->get($dateStr)->count() : 0;

            $currentDate->addDay();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Richieste',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
