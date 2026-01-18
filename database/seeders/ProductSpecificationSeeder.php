<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Database\Seeder;

class ProductSpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spanduk = Product::where('name', 'Spanduk Flexi Standar')->first();
        $stiker = Product::where('name', 'Stiker Vinyl Glossy')->first();
        $banner = Product::where('name', 'Banner X-Banner')->first();

        if ($spanduk) {
            ProductSpecification::firstOrCreate([
                'product_id' => $spanduk->id,
                'name' => 'Ukuran',
                'value' => '1x1 meter'
            ]);
            ProductSpecification::firstOrCreate([
                'product_id' => $spanduk->id,
                'name' => 'Bahan',
                'value' => 'Flexi 280gsm'
            ]);
        }

        if ($stiker) {
            ProductSpecification::firstOrCreate([
                'product_id' => $stiker->id,
                'name' => 'Ukuran',
                'value' => 'A3'
            ]);
            ProductSpecification::firstOrCreate([
                'product_id' => $stiker->id,
                'name' => 'Finishing',
                'value' => 'Laminasi Glossy'
            ]);
        }

        if ($banner) {
            ProductSpecification::firstOrCreate([
                'product_id' => $banner->id,
                'name' => 'Ukuran',
                'value' => '60x160 cm'
            ]);
            ProductSpecification::firstOrCreate([
                'product_id' => $banner->id,
                'name' => 'Tipe Rangka',
                'value' => 'X-Banner Stand'
            ]);
        }
    }
}