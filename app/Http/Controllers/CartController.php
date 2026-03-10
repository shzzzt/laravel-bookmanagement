<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        $bookIds = array_keys($cart);

        $books = empty($bookIds)
            ? collect()
            : Book::whereIn('id', $bookIds)->get()->keyBy('id');

        $items = collect($cart)
            ->map(function ($quantity, $bookId) use ($books) {
                $book = $books->get((int) $bookId);

                if (!$book) {
                    return null;
                }

                return [
                    'book' => $book,
                    'quantity' => (int) $quantity,
                    'subtotal' => $book->price * (int) $quantity,
                ];
            })
            ->filter()
            ->values();

        return view('cart.index', [
            'items' => $items,
            'total' => $items->sum('subtotal'),
        ]);
    }

    public function add(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($book->stock_quantity < 1) {
            return back()->with('error', 'This book is currently out of stock.');
        }

        $cart = $request->session()->get('cart', []);
        $currentQuantity = (int) ($cart[$book->id] ?? 0);
        $newQuantity = $currentQuantity + (int) $validated['quantity'];

        if ($newQuantity > $book->stock_quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cart[$book->id] = $newQuantity;
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Book added to cart.');
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ((int) $validated['quantity'] > $book->stock_quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cart = $request->session()->get('cart', []);

        if (!array_key_exists($book->id, $cart)) {
            return back();
        }

        $cart[$book->id] = (int) $validated['quantity'];
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request, Book $book): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if (array_key_exists($book->id, $cart)) {
            unset($cart[$book->id]);
            $request->session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');

        return back()->with('success', 'Cart cleared.');
    }
}
