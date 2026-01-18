<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Full access to all system features'],
            ['name' => 'cashier', 'display_name' => 'Kasir', 'description' => 'Manage customers and orders'],
            ['name' => 'designer', 'display_name' => 'Desainer', 'description' => 'Manage design files and revisions'],
            ['name' => 'operator', 'display_name' => 'Operator Produksi', 'description' => 'Update production status'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
