<?php

namespace App\Filament\Resources\SalespersonResource\Pages;

use App\Filament\Resources\SalespersonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesperson extends EditRecord
{
    protected static string $resource = SalespersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
