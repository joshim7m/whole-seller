<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $customer = User::where('user_type', 'customer')->first();
        if (! $customer) {
            return;
        }

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => '000001',
            'payment_status' => 'paid',
            'status' => 'completed',
            'total_amount' => 160000,
            'delivery_charge' => 6000,
            'shipping_address' => '12 Dhanmondi, Dhaka 1209',
            'payment_method' => 'cash_on_delivery',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'item_name' => 'Classic T-Shirt',
            'quantity' => 2,
            'price_at_purchase' => 65000,
            'total' => 130000,
            'size' => 'M',
            'color' => 'Black',
        ]);

        Invoice::create([
            'user_id' => $customer->id,
            'order_id' => $order->id,
            'invoice_number' => 'INV-001',
            'invoice_date' => now(),
            'payment_method' => 'cash_on_delivery',
            'payment_status' => 'paid',
            'total_amount' => 160000,
            'due_amount' => 0,
            'paid_amount' => 160000,
        ]);
    }
}
