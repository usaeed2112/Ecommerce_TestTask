<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Laptop',
                'price' => 1200,
                'stock_quantity' => 15,
            ],
            [
                'name' => 'Smartphone',
                'price' => 800,
                'stock_quantity' => 25,
            ],
            [
                'name' => 'Keyboard',
                'price' => 45,
                'stock_quantity' => 40,
            ],
            [
                'name' => 'Mouse',
                'price' => 25,
                'stock_quantity' => 60,
            ],
            [
                'name' => 'Monitor',
                'price' => 300,
                'stock_quantity' => 20,
            ],
            [
                'name' => 'Headphones',
                'price' => 90,
                'stock_quantity' => 35,
            ],
            [
                'name' => 'Webcam',
                'price' => 70,
                'stock_quantity' => 18,
            ],
            [
                'name' => 'USB Cable',
                'price' => 10,
                'stock_quantity' => 100,
            ],
            [
                'name' => 'External Hard Drive',
                'price' => 150,
                'stock_quantity' => 22,
            ],
            [
                'name' => 'Gaming Chair',
                'price' => 250,
                'stock_quantity' => 12,
            ],
        ]);
    }
}
