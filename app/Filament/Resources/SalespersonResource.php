<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalespersonResource\Pages;
use App\Filament\Resources\SalespersonResource\RelationManagers;
use App\Models\Salesperson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalespersonResource extends Resource
{
    protected static ?string $model = Salesperson::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_information')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('branch_id')
                    ->label('Branch')
                    ->options(function () {
                        return \App\Models\Branch::pluck('name', 'id')->toArray();
                    })
                    ->placeholder('Select branch')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_information')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales_count')
                    ->label('Sales Count')
                    ->formatStateUsing(fn($record) => $record->salesCount),
                Tables\Columns\TextColumn::make('branch.name')
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
            'index' => Pages\ListSalespeople::route('/'),
            'create' => Pages\CreateSalesperson::route('/create'),
            'view' => Pages\ViewSalesperson::route('/{record}'),
            'edit' => Pages\EditSalesperson::route('/{record}/edit'),
        ];
    }
}
