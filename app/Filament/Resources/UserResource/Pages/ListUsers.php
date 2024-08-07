<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

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
            'admin' => Tab::make()
                ->label('Admins')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('role', 'admin')),
            'employee' => Tab::make()
                ->label('Employees')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('role', 'employee')),
        ];
    }

}
