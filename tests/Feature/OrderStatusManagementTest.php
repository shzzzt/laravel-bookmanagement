<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderStatusManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_cancel_order_and_stock_is_restored(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $customer = User::factory()->create();

        $book = Book::factory()->create([
            'stock_quantity' => 3,
            'price' => 10.00,
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'total_amount' => 20.00,
            'shipping_address' => 'Test Address',
            'status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => 2,
            'unit_price' => 10.00,
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('orders.updateStatus', $order), [
                'status' => 'cancelled',
            ]);

        $response->assertRedirect(route('orders.index'));

        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertSame(5, $book->fresh()->stock_quantity);
    }

    public function test_admin_can_reactivate_cancelled_order_when_stock_is_sufficient(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $customer = User::factory()->create();

        $book = Book::factory()->create([
            'stock_quantity' => 6,
            'price' => 12.00,
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'total_amount' => 24.00,
            'shipping_address' => 'Test Address',
            'status' => 'cancelled',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => 2,
            'unit_price' => 12.00,
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('orders.updateStatus', $order), [
                'status' => 'pending',
            ]);

        $response->assertRedirect(route('orders.index'));

        $this->assertSame('pending', $order->fresh()->status);
        $this->assertSame(4, $book->fresh()->stock_quantity);
    }

    public function test_reactivation_fails_when_stock_is_insufficient(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $customer = User::factory()->create();

        $book = Book::factory()->create([
            'stock_quantity' => 1,
            'price' => 15.00,
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'total_amount' => 45.00,
            'shipping_address' => 'Test Address',
            'status' => 'cancelled',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => 3,
            'unit_price' => 15.00,
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('orders.updateStatus', $order), [
                'status' => 'pending',
            ]);

        $response->assertRedirect(route('orders.index'));
        $response->assertSessionHas('error', 'Cannot set this order to an active status because stock is no longer sufficient.');

        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertSame(1, $book->fresh()->stock_quantity);
    }
}
