<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{

    use RefreshDatabase; // run migrations on the temporary sqlite database from phpunit.xml

    public function test_homepage_contains_empty_table()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
        $response->assertSee(__('No products found') );
    }

    public function test_homepage_contains_non_empty_table()
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Product 1',
            'price' => 123
        ]);
        $response = $this->get('/products');
        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee(__('No products found') );
        $response->assertSee(__('Product 1') );
        $response->assertViewHas('products', function($collection) use ($product) {
            return $collection->contains($product);
        });
    }

    public function test_paginated_products_table_doesnt_contain_11th_record()
    {
        $user = User::factory()->create();
        $products = Product::factory(11)->create();
        $lastProduct = $products->last();

        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($collection) use ($lastProduct) {
            return !$collection->contains($lastProduct);
        });
    }
}
