<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'name' => 'Flexi China 280gsm',
                'description' => 'Bahan banner flexi standar',
                'unit' => 'meter persegi',
                'current_stock' => 500.00,
                'minimum_stock' => 50.00,
                'price' => 15000.00, // Price per square meter
            ],
            [
                'name' => 'Vinyl Ritrama',
                'description' => 'Bahan stiker vinyl berkualitas tinggi',
                'unit' => 'meter persegi',
                'current_stock' => 300.00,
                'minimum_stock' => 30.00,
                'price' => 25000.00,
            ],
            [
                'name' => 'Art Paper 150gsm',
                'description' => 'Kertas glossy untuk brosur dan kartu nama',
                'unit' => 'lembar',
                'current_stock' => 1000.00,
                'minimum_stock' => 100.00,
                'price' => 500.00, // Price per sheet
            ],
            [
                'name' => 'Tinta Solvent CMYK',
                'description' => 'Set tinta solvent untuk printer outdoor',
                'unit' => 'liter',
                'current_stock' => 20.00,
                'minimum_stock' => 5.00,
                'price' => 250000.00, // Price per liter
            ],
        ];

        foreach ($materials as $material) {
            Material::firstOrCreate(['name' => $material['name']], $material);
        }
    }
}