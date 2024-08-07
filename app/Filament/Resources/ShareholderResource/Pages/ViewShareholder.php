<?php

namespace App\Filament\Resources\ShareholderResource\Pages;

use App\Filament\Resources\ShareholderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewShareholder extends ViewRecord
{
    protected static string $resource = ShareholderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
