<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $products = Product::all();

        if ($orders->isEmpty()) {
            $this->call(OrderSeeder::class);
            $orders = Order::all();
        }
        if ($products->isEmpty()) {
            $this->call(ProductSeeder::class);
            $products = Product::all();
        }

        // Ensure there are orders and products
        if ($orders->isEmpty() || $products->isEmpty()) {
            echo "No orders or products found or created. Cannot seed order items.\n";
            return;
        }

        foreach ($orders as $order) {
            // Add 1 to 3 items per order
            $numItems = rand(1, 3);
            for ($i = 0; $i < $numItems; $i++) {
                $product = $products->random();
                $quantity = rand(1, 5);
                OrderItem::firstOrCreate([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'specifications' => json_encode(['ukuran' => 'A3', 'bahan' => 'Vinyl', 'finishing' => 'Glossy']), // Dummy specifications
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $quantity * $product->price,
                ]);
            }
        }
    }
}