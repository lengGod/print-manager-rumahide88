<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\ProductionLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductionLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderItems = OrderItem::all();
        $users = User::all();

        if ($orderItems->isEmpty()) {
            $this->call(OrderItemSeeder::class);
            $orderItems = OrderItem::all();
        }
        if ($users->isEmpty()) {
            $this->call(UserSeeder::class); // Assuming UserSeeder creates at least one user
            $users = User::all();
        }

        // Ensure there are order items and users
        if ($orderItems->isEmpty() || $users->isEmpty()) {
            echo "No order items or users found or created. Cannot seed production logs.\n";
            return;
        }

        foreach ($orderItems as $orderItem) {
            // Simulate production for some order items
            if (rand(0, 1)) { // 50% chance to have a production log
                $startTime = Carbon::now()->subDays(rand(1, 10))->startOfDay()->addHours(rand(8, 12));
                $endTime = (rand(0, 1)) ? $startTime->copy()->addHours(rand(2, 8)) : null; // 50% chance to be completed

                ProductionLog::firstOrCreate([
                    'order_id' => $orderItem->order_id, // Changed from order_item_id
                    'operator_id' => $users->random()->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'status' => $endTime ? 'Selesai' : 'Proses Cetak',
                    'notes' => $endTime ? 'Produksi selesai.' : 'Sedang dalam proses produksi.',
                ]);
            }
        }
    }
}