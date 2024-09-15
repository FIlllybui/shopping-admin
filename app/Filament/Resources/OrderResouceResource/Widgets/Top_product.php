<?php

namespace App\Filament\Resources\OrderResouceResource\Widgets;

use Filament\Widgets\ChartWidget;

class Top_product extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Top Products',
                    'data' => [10, 20, 30, 40, 50],
                ],
            ],
            'labels' => ['Product 1', 'Product 2', 'Product 3', 'Product 4', 'Product 5'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
