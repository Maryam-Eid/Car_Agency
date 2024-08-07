<?php

namespace App\Filament\Resources\SalespersonResource\Pages;

use App\Filament\Resources\SalespersonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSalesperson extends CreateRecord
{
    protected static string $resource = SalespersonResource::class;
}
