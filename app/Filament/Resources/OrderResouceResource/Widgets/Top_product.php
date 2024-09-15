<?php

namespace App\Filament\Resources\OrderResouceResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class Top_product extends ChartWidget
{
    protected static ?string $heading = 'Top 10 Best-Selling Products by Category';

    protected function getData(): array
    {
        $categories = Category::all();
        $datasets = [];
        $labels = [];

        foreach ($categories as $category) {
            $topProducts = Product::where('category_id', $category->id)
                ->join('order_product', 'products.id', '=', 'order_product.product_id')
                ->select('products.name', DB::raw('SUM(order_product.quantity) as total_sold'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->limit(10)
                ->get();

            $data = $topProducts->pluck('total_sold')->toArray();
            $productLabels = $topProducts->pluck('name')->toArray();

            $datasets[] = [
                'label' => $category->name,
                'data' => $data,
            ];

            $labels = array_merge($labels, $productLabels);
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
}
