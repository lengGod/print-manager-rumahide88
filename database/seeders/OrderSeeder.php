<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $users = User::all(); // Assuming UserSeeder runs before this and creates users

        if ($customers->isEmpty()) {
            $this->call(CustomerSeeder::class);
            $customers = Customer::all();
        }
        if ($users->isEmpty()) {
            $this->call(UserSeeder::class);
            $users = User::all();
        }

        // Ensure there are customers and users
        if ($customers->isEmpty() || $users->isEmpty()) {
            echo "No customers or users found or created. Cannot seed orders.\n";
            return;
        }

        $ordersData = [
            [
                'customer_id' => $customers->random()->id,
                'order_date' => Carbon::now()->subDays(10),
                'deadline' => Carbon::now()->subDays(5),
                'notes' => 'Catatan untuk pesanan spanduk acara.',
                'status' => 'Selesai',
                'total_amount' => 150000,
                'discount' => 15000,
                'final_amount' => 135000,
                'payment_status' => 'paid',
                'paid_amount' => 135000,
                'created_by' => $users->random()->id,
            ],
            [
                'customer_id' => $customers->random()->id,
                'order_date' => Carbon::now()->subDays(5),
                'deadline' => Carbon::now()->addDays(2),
                'notes' => 'Pesanan banner sedang diproses desain.',
                'status' => 'Proses Desain',
                'total_amount' => 200000,
                'discount' => 0,
                'final_amount' => 200000,
                'payment_status' => 'partial',
                'paid_amount' => 100000,
                'created_by' => $users->random()->id,
            ],
            [
                'customer_id' => $customers->random()->id,
                'order_date' => Carbon::now()->subDays(2),
                'deadline' => Carbon::now()->addDays(7),
                'notes' => 'Perlu konfirmasi desain stiker dari pelanggan.',
                'status' => 'Menunggu Desain',
                'total_amount' => 50000,
                'discount' => 5000,
                'final_amount' => 45000,
                'payment_status' => 'unpaid',
                'paid_amount' => 0,
                'created_by' => $users->random()->id,
            ],
            [
                'customer_id' => $customers->random()->id,
                'order_date' => Carbon::now()->subDays(15),
                'deadline' => Carbon::now()->subDays(10),
                'notes' => 'Pesanan kartu nama sudah diambil.',
                'status' => 'Selesai',
                'total_amount' => 300000,
                'discount' => 30000,
                'final_amount' => 270000,
                'payment_status' => 'paid',
                'paid_amount' => 270000,
                'created_by' => $users->random()->id,
            ],
        ];

        foreach ($ordersData as $index => $orderData) {
            // Generate unique order number
            $orderData['order_number'] = 'ORD-' . Carbon::now()->format('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            Order::firstOrCreate(['order_number' => $orderData['order_number']], $orderData);
        }
    }
}