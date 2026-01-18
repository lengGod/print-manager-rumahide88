<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@printmanager.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'address' => 'Jakarta, Indonesia',
        ]);
        $admin->roles()->attach(Role::where('name', 'admin')->first()->id);

        // Create sample users for each role
        $cashier = User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@printmanager.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'address' => 'Jakarta, Indonesia',
        ]);
        $cashier->roles()->attach(Role::where('name', 'cashier')->first()->id);

        $designer = User::create([
            'name' => 'Designer User',
            'email' => 'designer@printmanager.com',
            'password' => Hash::make('password'),
            'phone' => '081234567892',
            'address' => 'Jakarta, Indonesia',
        ]);
        $designer->roles()->attach(Role::where('name', 'designer')->first()->id);

        $operator = User::create([
            'name' => 'Operator User',
            'email' => 'operator@printmanager.com',
            'password' => Hash::make('password'),
            'phone' => '081234567893',
            'address' => 'Jakarta, Indonesia',
        ]);
        $operator->roles()->attach(Role::where('name', 'operator')->first()->id);
    }
}
