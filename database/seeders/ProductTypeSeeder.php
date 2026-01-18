<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure categories exist or create them
        $categorySpanduk = Category::firstOrCreate(['name' => 'Spanduk'], ['description' => 'Spanduk dan banner']);
        $categoryStiker = Category::firstOrCreate(['name' => 'Stiker'], ['description' => 'Stiker dan label']);
        $categoryKartuNama = Category::firstOrCreate(['name' => 'Kartu Nama'], ['description' => 'Kartu nama profesional']);
        $categoryBrosur = Category::firstOrCreate(['name' => 'Brosur'], ['description' => 'Brosur dan flyer']);

        $productTypes = [
            ['name' => 'Spanduk', 'description' => 'Jenis produk spanduk', 'category_id' => $categorySpanduk->id],
            ['name' => 'Banner', 'description' => 'Jenis produk banner', 'category_id' => $categorySpanduk->id],
            ['name' => 'Stiker', 'description' => 'Jenis produk stiker', 'category_id' => $categoryStiker->id],
            ['name' => 'Kartu Nama', 'description' => 'Jenis produk kartu nama', 'category_id' => $categoryKartuNama->id],
            ['name' => 'Brosur', 'description' => 'Jenis produk brosur', 'category_id' => $categoryBrosur->id],
        ];

        foreach ($productTypes as $type) {
            ProductType::firstOrCreate(['name' => $type['name']], $type);
        }
    }
}