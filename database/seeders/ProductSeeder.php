<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::firstOrCreate(['name' => 'Cetak Digital']);
        $productTypeSpanduk = ProductType::firstOrCreate(['name' => 'Spanduk']);
        $productTypeStiker = ProductType::firstOrCreate(['name' => 'Stiker']);

        $products = [
            [
                'category_id' => $category->id,
                'product_type_id' => $productTypeSpanduk->id,
                'name' => 'Spanduk Flexi Standar',
                'description' => 'Spanduk bahan flexi 280gsm dengan finishing standar.',
                'price' => 25000.00, // Harga per meter persegi
                'stock' => 100,
                'unit' => 'm2',
            ],
            [
                'category_id' => $category->id,
                'product_type_id' => $productTypeStiker->id,
                'name' => 'Stiker Vinyl Glossy',
                'description' => 'Stiker bahan vinyl glossy tahan air dan cuaca.',
                'price' => 35000.00, // Harga per meter persegi
                'stock' => 150,
                'unit' => 'm2',
            ],
            [
                'category_id' => $category->id,
                'product_type_id' => $productTypeSpanduk->id,
                'name' => 'Banner X-Banner',
                'description' => 'Banner flexi dengan rangka X-Banner, mudah dipasang.',
                'price' => 150000.00, // Harga per unit
                'stock' => 50,
                'unit' => 'unit',
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name'], 'product_type_id' => $product['product_type_id']],
                $product
            );
        }
    }
}