<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Order;
use App\Models\StockLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StockLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = Material::all();
        $users = User::all();
        $orders = Order::all();

        if ($materials->isEmpty()) {
            $this->call(MaterialSeeder::class);
            $materials = Material::all();
        }
        if ($users->isEmpty()) {
            $this->call(UserSeeder::class);
            $users = User::all();
        }
        if ($orders->isEmpty()) {
            $this->call(OrderSeeder::class);
            $orders = Order::all();
        }

        if ($materials->isEmpty() || $users->isEmpty() || $orders->isEmpty()) {
            echo "Missing dependencies for StockLogSeeder. Ensure Materials, Users, and Orders are seeded.\n";
            return;
        }

        foreach ($materials as $material) {
            $currentStock = $material->current_stock;

            // Add some 'in' logs
            for ($i = 0; $i < rand(1, 3); $i++) {
                $quantityIn = rand(10, 100);
                $previousStock = $currentStock;
                $currentStock += $quantityIn;
                StockLog::firstOrCreate([
                    'material_id' => $material->id,
                    'type' => 'in',
                    'quantity' => $quantityIn,
                    'previous_stock' => $previousStock,
                    'new_stock' => $currentStock,
                    'description' => 'Pembelian stok rutin.',
                    'reference_type' => 'App\Models\User', // Or another relevant model
                    'reference_id' => $users->random()->id,
                    'created_by' => $users->random()->id,
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }

            // Add some 'out' logs (usage)
            for ($i = 0; $i < rand(1, 5); $i++) {
                $quantityOut = rand(1, 20);
                $previousStock = $currentStock;
                $currentStock -= $quantityOut;
                if ($currentStock < 0) $currentStock = 0; // Prevent negative stock for seeding purposes
                StockLog::firstOrCreate([
                    'material_id' => $material->id,
                    'type' => 'out',
                    'quantity' => $quantityOut,
                    'previous_stock' => $previousStock,
                    'new_stock' => $currentStock,
                    'description' => 'Penggunaan untuk pesanan.',
                    'reference_type' => 'App\Models\Order', // Or another relevant model
                    'reference_id' => $orders->random()->id,
                    'created_by' => $users->random()->id,
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }
            // Update the material's current stock
            $material->current_stock = $currentStock;
            $material->save();
        }
    }
}
