<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Filament\Resources\CarResource\RelationManagers;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('model')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('available_color')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('capacity')
                    ->placeholder('Use this format x.xL')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('additional_features')
                    ->columnSpanFull(),
                Forms\Components\Select::make('branch_id')
                    ->label('Branch')
                    ->options(function () {
                        return \App\Models\Branch::pluck('name', 'id')->toArray();
                    })
                    ->placeholder('Select branch')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('manufacturer_id')
                    ->label('Manufacturer')
                    ->searchable()
                    ->options(function () {
                        return \App\Models\Manufacturer::pluck('name', 'id')->unique()->toArray();
                    })
                    ->placeholder('Select manufacturer')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('available_color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('branch.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('manufacturer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('branch_id')
                    ->label('Branch')
                    ->options(function () {
                        return \App\Models\Branch::pluck('name', 'id')->toArray();
                    })
                    ->searchable(),
                SelectFilter::make('manufacturer_id')
                    ->label('Manufacturer')
                    ->options(function () {
                        return \App\Models\Manufacturer::pluck('name', 'id')->unique()->toArray();
                    })
                    ->searchable(),
                SelectFilter::make('available_color')
                    ->options(function () {
                        return \App\Models\Car::query()
                            ->pluck('available_color', 'available_color')
                            ->unique()
                            ->sort()
                            ->toArray();
                    })
                    ->label('Color')
                    ->searchable(),
                SelectFilter::make('capacity')
                    ->options(function () {
                        return \App\Models\Car::query()
                            ->pluck('capacity', 'capacity')
                            ->unique()
                            ->sort()
                            ->toArray();
                    })
                    ->label('Capacity')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'view' => Pages\ViewCar::route('/{record}'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
