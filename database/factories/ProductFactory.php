<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'img' => fake()->imageUrl(),
            'brand' => fake()->company(),
            'title' => fake()->sentence(3),
            'rating' => fake()->randomFloat(1, 0, 5),
            'reviews' => fake()->numberBetween(0, 1000),
            'sellPrice' => fake()->randomFloat(2, 10, 1000),
            'orders' => (string) fake()->numberBetween(0, 1000),
            'mrp' => (string) fake()->randomFloat(2, 10, 1500),
            'discount' => fake()->numberBetween(0, 50),
            'category' => fake()->randomElement(['electronics', 'clothing', 'books', 'home', 'sports']),
        ];
    }
}