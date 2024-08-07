<?php

namespace App\Filament\Resources\ShareholderResource\Pages;

use App\Filament\Resources\ShareholderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShareholder extends EditRecord
{
    protected static string $resource = ShareholderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
