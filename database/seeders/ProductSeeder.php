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
                'img' => '/nike.png',
                'brand' => 'Nike',
                'title' => 'Air Max Running Shoes',
                'rating' => 4.5,
                'reviews' => 120,
                'sellPrice' => 4999.00,
                'orders' => '150',
                'mrp' => '6999.00',
                'discount' => 28,
                'category' => 'men',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'img' => '/puma.avif',
                'brand' => 'Puma',
                'title' => 'Suede Classic Sneakers',
                'rating' => 4.2,
                'reviews' => 85,
                'sellPrice' => 3499.00,
                'orders' => '95',
                'mrp' => '4999.00',
                'discount' => 30,
                'category' => 'women',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}