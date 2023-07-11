<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Product::create([
            'name' => 'Product 1',
            'price' => 9.99,
            'description' => 'Product 1 description',
        ]);

        Product::create([
            'name' => 'Product 2',
            'price' => 19.99,
            'description' => 'Product 2 description',
        ]);

    }
}
