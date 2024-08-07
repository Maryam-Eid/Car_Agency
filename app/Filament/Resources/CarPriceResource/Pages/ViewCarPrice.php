<?php

namespace App\Filament\Resources\CarPriceResource\Pages;

use App\Filament\Resources\CarPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCarPrice extends ViewRecord
{
    protected static string $resource = CarPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
