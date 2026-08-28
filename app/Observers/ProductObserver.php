<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\User;
use App\Notifications\StockStatusChanged;
use Illuminate\Support\Facades\Notification;

class ProductObserver
{
    public function updated(Product $product): void
    {
        $oldQuantity = (int) $product->getOriginal('quantity');
        $newQuantity = (int) $product->quantity;

        if ($oldQuantity === $newQuantity) {
            return;
        }

        $status = match (true) {
            $oldQuantity === 0 && $newQuantity > 0 => 'in_stock',
            $oldQuantity > 0 && $newQuantity === 0 => 'out_of_stock',
            default => null,
        };

        if ($status === null) {
            return;
        }

        $wholesellers = User::where('user_type', 'wholeseller')->get();

        Notification::send($wholesellers, new StockStatusChanged($product, $status));
    }
}
