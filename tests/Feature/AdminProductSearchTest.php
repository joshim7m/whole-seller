<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Inertia\Testing\AssertableInertia as Assert;

it('filters admin products by product sku', function () {
    $admin = catalogAdminUser();

    $category = Category::factory()->create();

    Product::create([
        'category_id' => $category->id,
        'title' => 'Cotton T-Shirt',
        'slug' => 'cotton-t-shirt',
        'sku' => 'TSH-100',
        'unit_price' => 500,
        'sale_price' => 400,
        'status' => 'active',
    ]);

    Product::create([
        'category_id' => $category->id,
        'title' => 'Denim Jeans',
        'slug' => 'denim-jeans',
        'sku' => 'JNS-200',
        'unit_price' => 1200,
        'sale_price' => 1000,
        'status' => 'active',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.products.index', ['search' => 'TSH-100']))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $inertia) => $inertia
            ->has('products.data', 1)
            ->where('products.data.0.sku', 'TSH-100'));
});

it('filters admin products by variant sku', function () {
    $admin = catalogAdminUser();

    $category = Category::factory()->create();

    $product = Product::create([
        'category_id' => $category->id,
        'title' => 'Polo Shirt',
        'slug' => 'polo-shirt',
        'unit_price' => 800,
        'sale_price' => 700,
        'status' => 'active',
    ]);

    ProductVariant::create([
        'product_id' => $product->id,
        'sku' => 'POLO-RED-L',
        'size' => 'L',
        'color' => 'Red',
        'quantity' => 5,
        'unit_price' => 800,
        'sale_price' => 700,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.products.index', ['search' => 'POLO-RED-L']))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $inertia) => $inertia
            ->has('products.data', 1)
            ->where('products.data.0.id', $product->id));
});
