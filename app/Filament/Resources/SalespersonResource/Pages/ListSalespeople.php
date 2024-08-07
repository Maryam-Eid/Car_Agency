<?php

namespace App\Filament\Resources\SalespersonResource\Pages;

use App\Filament\Resources\SalespersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;

class ListSalespeople extends ListRecords
{
    protected static string $resource = SalespersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->label('All Sales'),
            '0+' => Tab::make()
                ->label('0+ Sales')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('sales', fn($q) => $q->havingRaw('COUNT(*) >= ?', [0]))),
            '5+' =>Tab::make()
                ->label('5+ Sales')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('sales', fn($q) => $q->havingRaw('COUNT(*) >= ?', [5]))),
            '10+' => Tab::make()
                ->label('10+ Sales')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('sales', fn($q) => $q->havingRaw('COUNT(*) >= ?', [10]))),
            '20+' => Tab::make()
                ->label('20+ Sales')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('sales', fn($q) => $q->havingRaw('COUNT(*) >= ?', [20]))),
        ];
    }

}
