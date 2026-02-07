<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = auth()->user()->orders()->paginate(10);

        return view('orders.index', compact('orders'));
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
        $validated = $request->validate([
            'total_amount'=> 'required|numeric|min:0',
            'status' => 'nullable|in:pending,processing,completed,cancelled',
        ]);

        $validated['user_id'] = auth()->id();
        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
        $validated = $request->validate([
            'status' => 'nullable|in:pending,processing,completed,cancelled',
        ]);

        if (!auth()->user()->isAdmin()) abort(403);

        $order->update(['status' => $validated['status']]);

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
