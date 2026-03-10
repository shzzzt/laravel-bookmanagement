@extends('layouts.app')

@section('title', (auth()->user()->isAdmin() ? 'All Orders' : 'My Orders') . ' - PageTurner')

@section('header')
<h1 class="text-4xl font-bold">📋 {{ auth()->user()->isAdmin() ? 'All Orders' : 'My Orders' }}</h1>
<p class="mt-2" style="color: var(--light-text);">
    {{ auth()->user()->isAdmin() ? 'View and manage customer orders' : 'View and manage your orders' }}
</p>
@endsection

@section('content')
@if($orders->count() > 0)
<div class="space-y-4 mb-8">
    @foreach($orders as $order)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-start mb-4">
            <!-- Order ID -->
            <div>
                <p class="text-sm" style="color: var(--light-text);">Order #</p>
                <p class="text-2xl font-bold" style="color: var(--dark-text);">
                    #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                </p>
            </div>

            <!-- Date -->
            <div>
                <p class="text-sm" style="color: var(--light-text);">Date</p>
                <p class="font-bold" style="color: var(--dark-text);">
                    {{ $order->created_at->format('M d, Y') }}
                </p>
                <p class="text-xs" style="color: var(--light-text);">
                    {{ $order->created_at->format('h:i A') }}
                </p>
            </div>

            <!-- Amount -->
            <div>
                <p class="text-sm" style="color: var(--light-text);">Total</p>
                <p class="text-2xl font-bold" style="color: var(--pastel-blue-dark);">
                    ₱{{ number_format($order->total_amount, 2) }}
                </p>
            </div>

            <!-- Status -->
            <div>
                <p class="text-sm" style="color: var(--light-text);">Status</p>
                @php
                $statusColors = [
                'pending' => 'bg-yellow-100 text-yellow-700',
                'completed' => 'bg-green-100 text-green-700',
                'cancelled' => 'bg-red-100 text-red-700',
                ];
                @endphp
                <div class="{{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }} inline-block capitalize mt-1 px-3 py-1 rounded-full text-xs font-semibold">
                    {{ ucfirst($order->status) }}
                </div>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="mb-4">
            <p class="text-sm" style="color: var(--light-text);">Customer</p>
            <p class="font-bold" style="color: var(--dark-text);">{{ $order->user->name }}</p>
            <p class="text-xs" style="color: var(--light-text);">{{ $order->user->email }}</p>
        </div>

        <div class="mb-4">
            <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="flex flex-col sm:flex-row gap-3 sm:items-end">
                @csrf
                @method('PATCH')

                <div>
                    <label for="status-{{ $order->id }}" class="block text-sm" style="color: var(--light-text);">Update Status</label>
                    <select id="status-{{ $order->id }}" name="status" class="w-full sm:w-52 px-3 py-2 border border-gray-300 rounded-lg mt-1 focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue outline-none">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-pastel-blue to-pastel-yellow text-white font-medium rounded-lg hover:shadow-md transition-all duration-200">
                    Save Status
                </button>
            </form>
        </div>
        @endif

        <!-- Items Preview -->
        <div class="border-t pt-4 mb-4" style="border-color: var(--pastel-blue);">
            <p class="text-sm font-bold mb-2" style="color: var(--dark-text);">Items ({{ $order->orderItems->count() }})</p>
            <div class="space-y-2">
                @foreach($order->orderItems->take(2) as $item)
                <p class="text-sm" style="color: var(--light-text);">
                    {{ $item->book->title }}
                    <span style="color: var(--dark-text); font-weight: 600;">
                        × {{ $item->quantity }}
                    </span>
                </p>
                @endforeach
                @if($order->orderItems->count() > 2)
                <p class="text-sm" style="color: var(--light-text);">
                    ... and {{ $order->orderItems->count() - 2 }} more
                </p>
                @endif
            </div>
        </div>

        <!-- View Details Button -->
        <a href="{{ route('orders.show', $order) }}" class="inline-block px-4 py-2 bg-gradient-to-r from-pastel-blue to-pastel-yellow text-white font-medium rounded-lg hover:shadow-md transition-all duration-200">
            View Details
        </a>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="flex justify-center">
    {{ $orders->links() }}
</div>
@else
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-10 text-center">
    <p class="text-xl mb-4" style="color: var(--light-text);">
        {{ auth()->user()->isAdmin() ? 'No orders have been placed yet.' : "You haven't placed any orders yet." }}
    </p>
    <a href="{{ route('books.index') }}" class="inline-block px-4 py-2 bg-gradient-to-r from-pastel-blue to-pastel-yellow text-white font-medium rounded-lg hover:shadow-md transition-all duration-200">
        Start Shopping
    </a>
</div>
@endif
@endsection