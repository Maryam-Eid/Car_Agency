<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Car;
use App\Models\Coupon;
use App\Models\Manufacturer;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('car_id')
                    ->label('Car')
                    ->relationship('car', 'id')
                    ->options(function () {
                        return Car::with('manufacturer')
                            ->get()
                            ->mapWithKeys(function ($car) {
                                return [$car->id => $car->model . ' - ' . $car->manufacturer->name . ' - ' . $car->available_color . ' - ' . $car->capacity];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->placeholder('Select car')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $car = Car::with('price')->find($state);
                        if ($car && $car->price) {
                            $set('price', number_format($car->price->price, 2));
                        }
                    })
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->prefix('$')
                    ->label('Price')
                    ->disabled(),
                Forms\Components\Select::make('client_id')
                    ->label('Client')
                    ->placeholder('Select client')
                    ->options(function () {
                        return \App\Models\Client::pluck('name', 'id')->toArray();
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('salesperson_id')
                    ->label('Salesperson')
                    ->placeholder('Select salesperson')
                    ->options(function () {
                        return \App\Models\Salesperson::pluck('name', 'id')->toArray();
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('branch_id')
                    ->label('Branch')
                    ->placeholder('Select branch')
                    ->options(function () {
                        return \App\Models\Branch::pluck('name', 'id')->toArray();
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('coupon_id')
                    ->label('Coupon')
                    ->placeholder('Select coupon')
                    ->relationship('coupon', 'id')
                    ->options(function () {
                        $usedCoupons = Coupon::where('is_used', '0')
                            ->get()
                            ->mapWithKeys(function ($coupon) {
                                return [$coupon->id => $coupon->code . ' - ' . $coupon->discount_amount . '%'];
                            })
                            ->toArray();

                        $recordId = request()->route('record');
                        if ($recordId) {
                            $sale = Sale::find($recordId);
                            if ($sale && $sale->coupon_id) {
                                $currentCoupon = Coupon::find($sale->coupon_id);
                                $usedCoupons[$currentCoupon->id] = $currentCoupon->code . ' - ' . $currentCoupon->discount_amount . '%';
                            }
                        }

                        return $usedCoupons;
                    })
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $get, $state) {
                        $car = Car::with('price')->find($get('car_id'));
                        if ($car && $car->price && $state) {
                            $coupon = Coupon::find($state);
                            $discountedPrice = $car->price->price * (1 - $coupon->discount_amount / 100);
                            $set('price', number_format($discountedPrice, 2));
                        } else {
                            $set('price', number_format($car->price->price, 2));
                        }
                    }),
                Forms\Components\DatePicker::make('date')
                    ->default(today())
                    ->required(),
                Forms\Components\Textarea::make('contract_details')
                    ->required()
                    ->default('Payment Method: ')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('car.model')
                    ->label('Car Model')
                    ->sortable(),
                Tables\Columns\TextColumn::make('car.manufacturer.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('salesperson.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('branch.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('coupon_id')
                    ->label('Coupon Used')
                    ->icon(fn($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->default(false),
                Tables\Columns\TextColumn::make('date')
                    ->date()
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
                SelectFilter::make('car_id')
                    ->label('Car Model')
                    ->options(function () {
                        return Car::pluck('model', 'id')->unique()->toArray();
                    })
                    ->searchable(),
                SelectFilter::make('client_id')
                    ->label('Client')
                    ->options(function () {
                        return \App\Models\Client::pluck('name', 'id')->toArray();
                    })
                    ->searchable(),
                SelectFilter::make('salesperson_id')
                    ->label('Salesperson')
                    ->options(function () {
                        return \App\Models\Salesperson::pluck('name', 'id')->toArray();
                    })
                    ->searchable(),
                SelectFilter::make('branch_id')
                    ->label('Branch')
                    ->options(function () {
                        return \App\Models\Branch::pluck('name', 'id')->toArray();
                    })
                    ->searchable(),
                Filter::make('coupon_id')
                    ->label('Coupon Used')
                    ->toggle()
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('coupon_id'))
                    ->default(false),
                Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date'],
                                fn(Builder $query, $date) => $query->whereDate('date', $date),
                            );
                    }),
                SelectFilter::make('month')
                    ->label('Month')
                    ->options(self::getMonthOptions())
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['value'],
                            fn(Builder $query, $month) => $query->whereMonth('date', $month)
                        );
                    }),
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'view' => Pages\ViewSale::route('/{record}'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }

    public static function getMonthOptions(): array
    {
        return [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
    }
}
