<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use App\Models\Car;
use App\Models\Sale;

class EditSale extends EditRecord
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Sale
    {
        return DB::transaction(function () use ($record, $data) {
            $existingSale = Sale::find($record->id);
            $car = Car::with('price')->find($data['car_id']);

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
                if ($existingSale->coupon_id && $existingSale->coupon_id != $data['coupon_id']) {
                    $oldCoupon = Coupon::find($existingSale->coupon_id);
                    $oldCoupon->update(['is_used' => false]);
                }
                 $coupon = Coupon::find($data['coupon_id']);
                    $price = $price * (1 - $coupon->discount_amount / 100);
                    $coupon->update(['is_used' => true]);
            } else {
                if ($existingSale->coupon_id) {
                    $oldCoupon = Coupon::find($existingSale->coupon_id);
                    $oldCoupon->update(['is_used' => false]);
                }
            }

            $data['contract_details'] = preg_replace('/, Price: \d+(,\d{3})*(\.\d{2})?/', '', $data['contract_details']);

            $data['contract_details'] = 'Price: ' . number_format($price, 2) . ', ' . $data['contract_details'];

            $existingSale->update($data);

            if ($existingSale->car_id != $data['car_id']) {
                $oldCar = Car::find($existingSale->car_id);
                $oldCar->increment('quantity');
                $car->decrement('quantity');
            }

            return $existingSale;
        });
    }
}
