<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('products')->insert([
            [
                'img' => '/Products/Men/shoe1.jpg',
                'brand' => 'Nike',
                'title' => 'Air Max Running Shoes',
                'rating' => 4.5,
                'reviews' => 120,
                'sellPrice' => 4999.00,
                'orders' => '150',
                'mrp' => '6999.00',
                'discount' => 28,
                'category' => 'Men',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'img' => '/Products/Women/shoe2.jpg',
                'brand' => 'Puma',
                'title' => 'Suede Classic Sneakers',
                'rating' => 4.2,
                'reviews' => 85,
                'sellPrice' => 3499.00,
                'orders' => '95',
                'mrp' => '4999.00',
                'discount' => 30,
                'category' => 'Women',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}