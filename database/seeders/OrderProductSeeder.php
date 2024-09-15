<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 orders
        for ($i = 0; $i < 10; $i++) {
            $order = Order::create([
                'status' => 'pending',
                'total_price' => 0, // We'll update this later
            ]);

            // Add 1-5 random products to each order
            $numProducts = rand(1, 5);
            $totalPrice = 0;

            for ($j = 0; $j < $numProducts; $j++) {
                $product = Product::inRandomOrder()->first();
                $quantity = rand(1, 5);
                $price = $product->price;

                DB::table('order_product')->insert([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $totalPrice += $price * $quantity;
            }

            // Update the order's total price
            $order->update(['total_price' => $totalPrice]);
        }
    }
}
