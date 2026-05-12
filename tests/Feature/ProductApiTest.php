<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Product::factory()->createMany([
            [
                'img' => 'https://example.com/image1.jpg',
                'brand' => 'Brand A',
                'title' => 'Product One',
                'rating' => 4.5,
                'reviews' => 100,
                'sellPrice' => 99.99,
                'orders' => '500',
                'mrp' => '129.99',
                'discount' => 23,
                'category' => 'electronics',
            ],
            [
                'img' => 'https://example.com/image2.jpg',
                'brand' => 'Brand B',
                'title' => 'Product Two',
                'rating' => 3.8,
                'reviews' => 50,
                'sellPrice' => 49.99,
                'orders' => '1000',
                'mrp' => '79.99',
                'discount' => 37,
                'category' => 'clothing',
            ],
            [
                'img' => 'https://example.com/image3.jpg',
                'brand' => 'Brand A',
                'title' => 'Product Three',
                'rating' => 4.9,
                'reviews' => 200,
                'sellPrice' => 149.99,
                'orders' => '200',
                'mrp' => '199.99',
                'discount' => 25,
                'category' => 'electronics',
            ],
        ]);
    }

    public function test_get_products_returns_all_products(): void
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_get_product_returns_specific_product(): void
    {
        $product = Product::first();

        $response = $this->getJson("/api/product/{$product->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $product->id,
            'brand' => $product->brand,
            'title' => $product->title,
        ]);
    }

    public function test_get_product_returns_404_for_nonexistent_product(): void
    {
        $response = $this->getJson('/api/product/999');

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Product not found']);
    }

    public function test_add_product_creates_new_product(): void
    {
        $productData = [
            'img' => 'https://example.com/new.jpg',
            'brand' => 'New Brand',
            'title' => 'New Product',
            'rating' => 4.0,
            'reviews' => 10,
            'sellPrice' => 79.99,
            'orders' => '50',
            'mrp' => '99.99',
            'discount' => 20,
            'category' => 'home',
        ];

        $response = $this->postJson('/api/product', $productData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'brand' => 'New Brand',
            'title' => 'New Product',
            'category' => 'home',
        ]);
    }

    public function test_add_product_validates_required_fields(): void
    {
        $response = $this->postJson('/api/product', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['img', 'brand', 'title', 'sellPrice', 'category']);
    }

    public function test_get_by_category_returns_products_in_category(): void
    {
        $response = $this->getJson('/api/category/electronics');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment(['category' => 'electronics']);
    }

    public function test_get_by_category_returns_empty_for_nonexistent_category(): void
    {
        $response = $this->getJson('/api/category/nonexistent');

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    public function test_get_top_rated_returns_products_with_rating_4_and_above(): void
    {
        $response = $this->getJson('/api/filter/topRated');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonStructure([
            '*' => ['id', 'rating', 'title', 'brand']
        ]);
    }

    public function test_get_best_sellers_returns_products_ordered_by_orders(): void
    {
        $response = $this->getJson('/api/filter/bestSellers');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_search_products_by_title(): void
    {
        $response = $this->getJson('/api/products/search?q=One');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['title' => 'Product One']);
    }

    public function test_search_products_by_brand(): void
    {
        $response = $this->getJson('/api/products/search?q=Brand A');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_search_products_returns_empty_for_no_matches(): void
    {
        $response = $this->getJson('/api/products/search?q=nonexistent');

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    public function test_filter_products_by_min_price(): void
    {
        $response = $this->getJson('/api/products/filterBy?minPrice=100');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_filter_products_by_max_price(): void
    {
        $response = $this->getJson('/api/products/filterBy?maxPrice=50');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_filter_products_by_brand(): void
    {
        $response = $this->getJson('/api/products/filterBy?brand=Brand A');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_filter_products_by_rating(): void
    {
        $response = $this->getJson('/api/products/filterBy?rating=4.5');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_filter_products_with_multiple_filters(): void
    {
        $response = $this->getJson('/api/products/filterBy?minPrice=50&maxPrice=150&brand=Brand A');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_list_of_products_new_returns_recent_products(): void
    {
        $response = $this->getJson('/api/products/new');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_list_of_products_default_returns_products(): void
    {
        $response = $this->getJson('/api/products/default');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
}