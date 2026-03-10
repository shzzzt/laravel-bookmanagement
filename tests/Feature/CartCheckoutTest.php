<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_book_to_cart(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock_quantity' => 5]);

        $response = $this
            ->actingAs($user)
            ->post(route('cart.add', $book), [
                'quantity' => 2,
            ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('success', 'Book added to cart.');

        $this->assertSame(2, session('cart')[$book->id]);
    }

    public function test_user_can_checkout_from_cart(): void
    {
        $user = User::factory()->create([
            'address' => '123 Main St, Springfield',
        ]);

        $book = Book::factory()->create([
            'price' => 25.50,
            'stock_quantity' => 8,
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession([
                'cart' => [$book->id => 3],
            ])
            ->post(route('orders.store'), [
                'address' => '456 Checkout St, Springfield',
            ]);

        $order = Order::first();

        $response->assertRedirect(route('orders.show', $order));

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 1);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $user->id,
            'status' => 'pending',
            'total_amount' => 76.50,
            'shipping_address' => '456 Checkout St, Springfield',
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => 3,
            'unit_price' => 25.50,
        ]);

        $this->assertNull(session('cart'));
        $this->assertSame(5, $book->fresh()->stock_quantity);
    }

    public function test_checkout_fails_when_cart_is_empty(): void
    {
        $user = User::factory()->create([
            'address' => '123 Main St, Springfield',
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('orders.store'), [
                'address' => '789 Empty Cart Ave, Springfield',
            ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error', 'Your cart is empty.');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
    }

    public function test_checkout_fails_when_checkout_address_is_missing(): void
    {
        $user = User::factory()->create(['address' => null]);

        $book = Book::factory()->create([
            'price' => 19.99,
            'stock_quantity' => 5,
        ]);

        $response = $this
            ->actingAs($user)
            ->withSession([
                'cart' => [$book->id => 1],
            ])
            ->post(route('orders.store'));

        $response->assertSessionHasErrors('address');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
    }
}
