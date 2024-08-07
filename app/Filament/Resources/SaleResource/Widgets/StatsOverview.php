<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Client;
use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Sale::query()
            ->join('cars', 'cars.id', 'sales.car_id')
            ->join('car_prices', 'car_prices.car_model', 'cars.model')
            ->sum('car_prices.price');

        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->color('success')
                ->icon('heroicon-o-arrow-trending-up')
                ->description('Total revenue from all sales'),
            Stat::make('Total Sales', Sale::query()->count())
                ->color('primary')
                ->icon('heroicon-o-document-currency-dollar')
                ->description('Number of sales made'),
            Stat::make('Clients', Client::query()->count())
                ->color('info')
                ->icon('heroicon-o-user-group')
                ->description('Number of clients')
        ];
    }
}
