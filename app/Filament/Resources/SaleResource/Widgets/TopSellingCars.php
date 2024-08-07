<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Sale;
use App\Models\Car;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class TopSellingCars extends BaseWidget
{
    public function getTableRecordKey($record): string
    {
        return (string)$record->car_id;
    }

    public function table(Table $table): Table
    {
        $query = Sale::query()
            ->select('cars.model as model', 'manufacturers.name as car_manufacturer', DB::raw('SUM(car_prices.price) as total_revenue'))
            ->join('cars', 'cars.id', 'sales.car_id')
            ->join('car_prices', 'car_prices.car_model', 'cars.model')
            ->join('manufacturers', 'manufacturers.id', 'cars.manufacturer_id')
            ->groupBy('cars.model', 'manufacturers.name')
            ->orderBy(DB::raw('SUM(car_prices.price)'), 'desc');

        return $table
            ->query($query)
            ->paginationPageOptions([3])
            ->columns([
                Tables\Columns\TextColumn::make('car_manufacturer')
                    ->label('Car Manufacturer'),
                Tables\Columns\TextColumn::make('model')
                    ->label('Car Model'),
                Tables\Columns\TextColumn::make('total_revenue')
                    ->label('Total Revenue')
                    ->formatStateUsing(fn($state) => '$' . number_format($state, 2)),
            ]);
    }
}
