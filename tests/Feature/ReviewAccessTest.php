<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_review_book_without_ordering_it(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('reviews.store', $book), [
                'rating' => 5,
                'comment' => 'Great book',
            ]);

        $response->assertRedirect(route('books.show', $book));
        $response->assertSessionHas('error', 'You can only review books that you have ordered.');

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_user_can_review_book_after_ordering_it(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $book->price,
            'shipping_address' => 'Test Address',
            'status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => 1,
            'unit_price' => $book->price,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('reviews.store', $book), [
                'rating' => 4,
                'comment' => 'Worth reading',
            ]);

        $response->assertRedirect(route('books.show', $book));
        $response->assertSessionHas('success', 'Review submitted successfully!');

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'rating' => 4,
            'comment' => 'Worth reading',
        ]);
    }
}
