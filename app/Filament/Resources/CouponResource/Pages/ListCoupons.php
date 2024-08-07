<?php

namespace App\Filament\Resources\CouponResource\Pages;

use App\Filament\Resources\CouponResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCoupons extends ListRecords
{
    protected static string $resource = CouponResource::class;

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
            'used' => Tab::make()
                ->label('Used')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_used', '!=', 0)),
            'not_used' => Tab::make()
                ->label('Not Used')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_used',  0)),
        ];
    }

}
