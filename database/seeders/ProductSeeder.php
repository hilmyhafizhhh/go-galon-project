<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            "name" => "Aqua",
            "volume_l" => "19",
            'price' => 8000.00,
            'stock' => 100,
            'image' => "aqua.png",
        ]);

        Product::create([
            "name" => "Le Minerale",
            "volume_l" => "15",
            'price' => 6000.00,
            'stock' => 90,
            'image' => "minerale.png",
        ]);

        Product::create([
            "name" => "Vite",
            "volume_l" => "19",
            'price' => 7000.00,
            'stock' => 90,
            'image' => "vit.png",
        ]);

        Product::create([
            "name" => "Cleo",
            "volume_l" => "19",
            'price' => 7000.00,
            'stock' => 20,
            'image' => "cleo.png",
        ]);

        Product::create([
            "name" => "Crystalline",
            "volume_l" => "19",
            'price' => 8000.00,
            'stock' => 20,
            'image' => "crystalline.png",
        ]);
    }
}
