<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Spanduk', 'description' => 'Spanduk dan banner'],
            ['name' => 'Brosur', 'description' => 'Brosur dan flyer'],
            ['name' => 'Kartu Nama', 'description' => 'Kartu nama profesional'],
            ['name' => 'Stiker', 'description' => 'Stiker dan label'],
            ['name' => 'Kemasan', 'description' => 'Packaging dan kemasan produk'],
            ['name' => 'Undangan', 'description' => 'Undangan pernikahan dan acara'],
            ['name' => 'Buku', 'description' => 'Buku, majalah, dan publikasi'],
            ['name' => 'Merchandise', 'description' => 'Merchandise dan souvenir'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
