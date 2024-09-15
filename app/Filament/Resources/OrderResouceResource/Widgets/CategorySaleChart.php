<?php

namespace App\Filament\Resources\OrderResouceResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Category;
use App\Models\Order;
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

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $categorySales->pluck('total_sales')->toArray(),
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
