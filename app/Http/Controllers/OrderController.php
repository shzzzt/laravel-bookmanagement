<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Book;
use App\Models\OrderItem;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::guard('web')->user();
        $adminMetrics = null;

        if ($user->isAdmin()) {
            $orders = Order::with(['orderItems.book', 'user'])->latest()->paginate(10);

            $adminMetrics = [
                'total' => Order::count(),
                'pending' => Order::where('status', 'pending')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count(),
            ];
        } else {
            $orders = $user->orders()->with(['orderItems.book', 'user'])->latest()->paginate(10);
        }

        return view('orders.index', compact('orders', 'adminMetrics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'Admins cannot place customer orders.');
        }

        $cart = $request->session()->get('cart', []);

        if (empty($cart) && $request->filled('book_id')) {
            $validated = $request->validate([
                'book_id' => 'required|exists:books,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $cart = [
                (int) $validated['book_id'] => (int) $validated['quantity'],
            ];
        }

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'address' => 'required|string|max:500',
        ]);

        try {
            $order = DB::transaction(function () use ($cart, $validated, $user) {
                $books = Book::whereIn('id', array_keys($cart))->lockForUpdate()->get()->keyBy('id');
                $lineItems = [];
                $totalAmount = 0;

                foreach ($cart as $bookId => $quantity) {
                    $book = $books->get((int) $bookId);

                    if (!$book) {
                        throw new \RuntimeException('One or more items in your cart are no longer available.');
                    }

                    $quantity = (int) $quantity;

                    if ($quantity < 1) {
                        throw new \RuntimeException('Invalid cart quantity detected.');
                    }

                    if ($book->stock_quantity < $quantity) {
                        throw new \RuntimeException("Not enough stock for {$book->title}.");
                    }

                    $lineItems[] = [
                        'book' => $book,
                        'quantity' => $quantity,
                        'unit_price' => $book->price,
                    ];

                    $totalAmount += $book->price * $quantity;
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => $totalAmount,
                    'shipping_address' => $validated['address'],
                    'status' => 'pending',
                ]);

                foreach ($lineItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'book_id' => $item['book']->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                    ]);

                    $item['book']->decrement('stock_quantity', $item['quantity']);
                }

                return $order;
            });
        } catch (\RuntimeException $exception) {
            return redirect()->route('cart.index')->with('error', $exception->getMessage());
        }

        $request->session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Order created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        /** @var User $user */
        $user = Auth::guard('web')->user();

        if ($order->user_id !== $user->id && !$user->isAdmin()) {
            abort(403);
        }

        $order->load('orderItems.book');

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, Order $order)
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        if (!$user->isAdmin()) abort(403);

        $newStatus = $validated['status'];
        $currentStatus = $order->status;

        if ($newStatus === $currentStatus) {
            return redirect()->route('orders.index')->with('success', 'Order status is already up to date.');
        }

        try {
            DB::transaction(function () use ($order, $currentStatus, $newStatus) {
                $order->load('orderItems');

                $bookIds = $order->orderItems->pluck('book_id')->all();
                $books = Book::whereIn('id', $bookIds)->lockForUpdate()->get()->keyBy('id');

                if ($currentStatus !== 'cancelled' && $newStatus === 'cancelled') {
                    foreach ($order->orderItems as $item) {
                        $book = $books->get($item->book_id);

                        if ($book) {
                            $book->increment('stock_quantity', $item->quantity);
                        }
                    }
                }

                if ($currentStatus === 'cancelled' && $newStatus !== 'cancelled') {
                    foreach ($order->orderItems as $item) {
                        $book = $books->get($item->book_id);

                        if (!$book || $book->stock_quantity < $item->quantity) {
                            throw new \RuntimeException('Cannot set this order to an active status because stock is no longer sufficient.');
                        }
                    }

                    foreach ($order->orderItems as $item) {
                        $books->get($item->book_id)?->decrement('stock_quantity', $item->quantity);
                    }
                }

                $order->update(['status' => $newStatus]);
            });
        } catch (\RuntimeException $exception) {
            return redirect()->route('orders.index')->with('error', $exception->getMessage());
        }

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
