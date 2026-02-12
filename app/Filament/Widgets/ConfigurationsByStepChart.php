<?php

namespace App\Filament\Widgets;

use App\Models\Configuration;
use Filament\Widgets\ChartWidget;

class ConfigurationsByStepChart extends ChartWidget
{
    protected ?string $heading = 'Distribuzione per Step Corrente';

    protected function getData(): array
    {
        $steps = [
            1 => 'Step 1',
            2 => 'Step 2',
            3 => 'Step 3',
            4 => 'Step 4',
            5 => 'Step 5',
            6 => 'Step 6',
        ];

        $data = Configuration::all()
            ->groupBy('current_step')
            ->map(fn ($group) => $group->count());

        $labels = [];
        $counts = [];
        $colors = [
            'rgba(239, 68, 68, 0.8)',   // Step 1 - Rosso
            'rgba(245, 158, 11, 0.8)',  // Step 2 - Arancione
            'rgba(234, 179, 8, 0.8)',   // Step 3 - Giallo
            'rgba(34, 197, 94, 0.8)',   // Step 4 - Verde
            'rgba(59, 130, 246, 0.8)',  // Step 5 - Blu
            'rgba(139, 92, 246, 0.8)',  // Step 6 - Viola
        ];

        foreach ($steps as $stepNum => $stepLabel) {
            $labels[] = $stepLabel;
            $counts[] = $data->get($stepNum) ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Richieste',
                    'data' => $counts,
                    'backgroundColor' => array_slice($colors, 0, count($counts)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
