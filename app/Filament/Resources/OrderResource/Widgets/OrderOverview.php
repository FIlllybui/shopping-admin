<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('รายการสั่งซื้อทั้งหมด', Order::count())
                ->description('รายการสั่งซื้อทั้งหมดในระบบ')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }
}
