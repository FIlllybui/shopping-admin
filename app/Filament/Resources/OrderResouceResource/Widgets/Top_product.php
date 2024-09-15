<?php

namespace App\Filament\Resources\OrderResouceResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Top_product extends ChartWidget
{
    protected static ?string $heading = 'Top 10 Best-Selling Products by Category';

    protected function getData(): array
    {
        $categories = Category::all();
        $datasets = [];
        $labels = [];
        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
        ];

        foreach ($categories as $index => $category) {
            $topProducts = Product::where('category_id', $category->id)
                ->join('order_product', 'products.id', '=', 'order_product.product_id')
                ->select('products.name', DB::raw('SUM(order_product.quantity) as total_sold'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->limit(10)
                ->get();

            $datasets[] = [
                'label' => $category->name,
                'data' => $topProducts->pluck('total_sold')->toArray(),
                'backgroundColor' => $colors[$index % count($colors)],
            ];

            $labels = array_merge($labels, $topProducts->pluck('name')->map(function ($name, $key) use ($topProducts) {
                return $name . ' (' . $topProducts[$key]->total_sold . ')';
            })->toArray());
        }

        return [
            'datasets' => $datasets,
            'labels' => array_unique($labels),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Number of Products Sold',
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Products',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => "function(context) {
                            return context.dataset.label + ': ' + context.parsed.y;
                        }",
                    ],
                ],
            ],
        ];
    }
}
