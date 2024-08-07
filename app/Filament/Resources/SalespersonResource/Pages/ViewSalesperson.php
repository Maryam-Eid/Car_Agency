<?php

namespace App\Filament\Resources\SalespersonResource\Pages;

use App\Filament\Resources\SalespersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSalesperson extends ViewRecord
{
    protected static string $resource = SalespersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
