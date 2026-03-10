@extends('layouts.app')

@section('title', 'Order Details - PageTurner')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
            <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Status</p>
            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium capitalize {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                {{ $order->status }}
            </span>
        </div>
    </div>

    <div class="border-t border-gray-100 pt-4 space-y-4">
        @if($order->shipping_address)
        <div class="bg-gray-50 border border-gray-100 rounded-lg p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Delivery Address</p>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $order->shipping_address }}</p>
        </div>
        @endif

        @foreach($order->orderItems as $item)
        <div class="flex items-center justify-between">
            <div>
                <p class="font-semibold text-gray-800">{{ $item->book->title }}</p>
                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ₱{{ number_format($item->unit_price, 2) }}</p>
            </div>
            <p class="font-bold text-accent-blue">₱{{ number_format($item->subtotal, 2) }}</p>
        </div>
        @endforeach
    </div>

    <div class="border-t border-gray-100 mt-6 pt-4 flex items-center justify-between">
        <a href="{{ route('orders.index') }}" class="text-sm text-accent-blue hover:underline">← Back to My Orders</a>
        <p class="text-xl font-bold text-gray-800">Total: ₱{{ number_format($order->total_amount, 2) }}</p>
    </div>
</div>
@endsection