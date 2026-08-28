<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Notifications\StockStatusChanged;

function ensureRole(): int
{
    DB::table('roles')->updateOrInsert(
        ['id' => 3],
        ['name' => 'Wholeseller', 'slug' => 'wholeseller', 'created_at' => now(), 'updated_at' => now()]
    );

    return 3;
}

function createProduct(int $quantity = 10): Product
{
    $category = Category::factory()->create();

    return Product::create([
        'category_id' => $category->id,
        'title' => fake()->words(3, true),
        'slug' => fake()->unique()->slug(),
        'unit_price' => 100,
        'sale_price' => 100,
        'quantity' => $quantity,
        'status' => 'active',
    ]);
}

function createWholeseller(): User
{
    return User::factory()->create([
        'role_id' => ensureRole(),
        'user_type' => 'wholeseller',
        'status' => true,
    ]);
}

it('creates in stock notification when quantity goes from 0 to positive', function () {
    $product = createProduct(quantity: 0);
    $user = createWholeseller();

    $product->update(['quantity' => 10]);

    $notification = $user->notifications()->first();

    expect($notification)->not->toBeNull()
        ->and($notification->type)->toBe(StockStatusChanged::class)
        ->and($notification->data['status'])->toBe('in_stock')
        ->and($notification->data['product_id'])->toBe($product->id);
});

it('creates out of stock notification when quantity goes from positive to 0', function () {
    $product = createProduct(quantity: 10);
    $user = createWholeseller();

    $product->update(['quantity' => 0]);

    $notification = $user->notifications()->first();

    expect($notification)->not->toBeNull()
        ->and($notification->type)->toBe(StockStatusChanged::class)
        ->and($notification->data['status'])->toBe('out_of_stock')
        ->and($notification->data['product_id'])->toBe($product->id);
});

it('does not create notification when quantity stays positive', function () {
    $user = createWholeseller();
    $product = createProduct(quantity: 10);

    $product->update(['quantity' => 5]);

    expect($user->notifications()->count())->toBe(0);
});

it('does not create notification when quantity stays zero', function () {
    $user = createWholeseller();
    $product = createProduct(quantity: 0);

    $product->update(['quantity' => 0]);

    expect($user->notifications()->count())->toBe(0);
});

it('notifies all wholesalers when product goes out of stock', function () {
    $product = createProduct(quantity: 5);

    $wholesellers = collect();
    for ($i = 0; $i < 3; $i++) {
        $wholesellers->push(
            User::factory()->create([
                'role_id' => ensureRole(),
                'user_type' => 'wholeseller',
                'status' => true,
            ])
        );
    }

    $product->update(['quantity' => 0]);

    foreach ($wholesellers as $wholeseller) {
        $wholeseller->refresh();
        expect($wholeseller->notifications()->count())->toBe(1);
    }
});

it('returns notifications via index endpoint', function () {
    $user = createWholeseller();

    $product = createProduct(quantity: 0);
    $product->update(['quantity' => 10]);

    $this->actingAs($user)
        ->getJson(route('notifications.index'))
        ->assertOk()
        ->assertJsonStructure([
            'notifications' => [
                '*' => ['id', 'data', 'read_at', 'created_at'],
            ],
            'unread_count',
        ])
        ->assertJsonPath('unread_count', 1)
        ->assertJsonCount(1, 'notifications');
});

it('marks all notifications as read', function () {
    $user = createWholeseller();

    $product = createProduct(quantity: 0);
    $product->update(['quantity' => 10]);

    $this->actingAs($user)
        ->postJson(route('notifications.markRead'))
        ->assertOk();

    $this->actingAs($user)
        ->getJson(route('notifications.index'))
        ->assertJsonPath('unread_count', 0);
});

it('requires authentication to access notifications', function () {
    $this->getJson(route('notifications.index'))
        ->assertStatus(401);

    $this->postJson(route('notifications.markRead'))
        ->assertStatus(401);
});

it('returns latest 10 notifications only', function () {
    $user = createWholeseller();

    for ($i = 0; $i < 15; $i++) {
        $product = createProduct(quantity: 0);
        $product->update(['quantity' => 10]);
    }

    $this->actingAs($user)
        ->getJson(route('notifications.index'))
        ->assertOk()
        ->assertJsonCount(10, 'notifications');
});
