<?php

namespace App\Filament\Resources\CarPriceResource\Pages;

use App\Filament\Resources\CarPriceResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCarPrices extends ListRecords
{
    protected static string $resource = CarPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'low' => Tab::make()
                ->label('Low Prices')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('price', '<', 20000)),
            'medium' => Tab::make()
                ->label('Medium Prices')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereBetween('price', [20000, 50000])),
            'high' => Tab::make()
                ->label('High Prices')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('price', '>', 50000)),
        ];
    }
}
