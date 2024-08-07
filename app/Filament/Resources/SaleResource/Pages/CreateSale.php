<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Models\Coupon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use App\Models\Car;
use App\Models\Sale;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;
    protected function handleRecordCreation(array $data): Sale
    {
        return DB::transaction(function () use ($data) {
            $car = Car::find($data['car_id']);

            if ($car->quantity == 0) {
                Notification::make()
                    ->title('Car not available')
                    ->body('The selected car is out of stock.')
                    ->warning()
                    ->send();

                $this->halt();
            }

            $price = $car->price->price;

            if (isset($data['coupon_id'])) {
                $coupon = Coupon::find($data['coupon_id']);
                $price = $price * (1 - $coupon->discount_amount / 100);
                $coupon->update(['is_used' => true]);
            }

            $data['contract_details'] = 'Price: ' . number_format($price, 2) . ', ' . $data['contract_details'];

            $sale = Sale::create($data);

            $car->decrement('quantity');

            return $sale;
        });
    }
}
