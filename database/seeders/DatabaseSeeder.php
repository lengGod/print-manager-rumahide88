<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class, // Assuming RoleSeeder sets up roles first
            UserSeeder::class, // Users might depend on roles
            // CustomerSeeder::class,
            // CategorySeeder::class,
            // ProductTypeSeeder::class,
            // MaterialSeeder::class,
            // ProductSeeder::class, // Products depend on categories and product types
            // ProductSpecificationSeeder::class, // Product specifications depend on products
            // OrderSeeder::class, // Orders depend on customers
            // OrderItemSeeder::class, // Order items depend on orders and products
            // DesignFileSeeder::class, // Design files depend on order items and users
            // ProductionLogSeeder::class, // Production logs depend on order items and users
            // StockLogSeeder::class, // Stock logs depend on materials
        ]);
    }
}
