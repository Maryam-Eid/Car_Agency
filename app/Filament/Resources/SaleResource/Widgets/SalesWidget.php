<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesWidget extends ChartWidget
{
    protected static ?string $heading = 'Daily Sales';

    protected function getData(): array
    {
        $salesData = Sale::query()
            ->join('cars', 'sales.car_id',  'cars.id')
            ->join('car_prices', 'cars.model', 'car_prices.car_model')
            ->selectRaw('DATE(sales.date) as day, SUM(car_prices.price) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $days = $salesData->pluck('day')->toArray();
        $totals = $salesData->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Daily Sales',
                    'data' => $totals,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $days,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
