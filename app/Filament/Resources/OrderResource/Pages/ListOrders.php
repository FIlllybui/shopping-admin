<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResouceResource\Widgets\CategorySaleChart;
use App\Filament\Resources\OrderResouceResource\Widgets\Top_product;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\OrderOverview;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderOverview::class,
            CategorySaleChart::class,
            Top_product::class,
        ];
    }
}
