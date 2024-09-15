<?php

namespace App\Filament\Resources\OrderResouceResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySaleChart extends ChartWidget
{
    protected static ?string $heading = 'Sales by Category';

    protected function getData(): array
    {
        $categorySales = Category::select('categories.name', DB::raw('SUM(order_product.quantity * order_product.price) as total_sales'))
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $categorySales->pluck('total_sales')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $categorySales->count()),
                ],
            ],
            'labels' => $categorySales->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
