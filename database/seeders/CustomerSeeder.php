<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone_number' => '081234567890',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'phone_number' => '081345678901',
                'address' => 'Jl. Raya Bogor No. 25, Bogor',
            ],
            [
                'name' => 'Joko Susilo',
                'email' => 'joko@example.com',
                'phone_number' => '081456789012',
                'address' => 'Jl. Diponegoro No. 45, Surabaya',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'phone_number' => '081567890123',
                'address' => 'Jl. Asia Afrika No. 8, Bandung',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(['email' => $customer['email']], $customer);
        }
    }
}