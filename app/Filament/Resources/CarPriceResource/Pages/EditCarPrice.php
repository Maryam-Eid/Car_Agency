<?php

namespace App\Filament\Resources\CarPriceResource\Pages;

use App\Filament\Resources\CarPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarPrice extends EditRecord
{
    protected static string $resource = CarPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
