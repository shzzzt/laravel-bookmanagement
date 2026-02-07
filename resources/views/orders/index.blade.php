@extends('layouts.app')

@section('title', 'My Orders - PageTurner')

@section('header')
    <h1 class="text-4xl font-bold">📋 My Orders</h1>
    <p class="mt-2" style="color: var(--light-text);">View and manage your orders</p>
@endsection

@section('content')
    @if($orders->count() > 0)
        <div class="space-y-4 mb-8">
            @foreach($orders as $order)
                <div class="card">
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
                                ${{ number_format($order->total_amount, 2) }}
                            </p>
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <p class="text-sm" style="color: var(--light-text);">Status</p>
                            @php
                                $statusColors = [
                                    'pending' => 'badge-yellow',
                                    'processing' => 'badge-blue',
                                    'completed' => 'badge-blue',
                                    'cancelled' => 'badge-yellow',
                                ];
                            @endphp
                            <div class="{{ $statusColors[$order->status] ?? 'badge-blue' }} inline-block capitalize mt-1">
                                {{ ucfirst($order->status) }}
                            </div>
                        </div>
                    </div>
                    
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
                    <a href="{{ route('orders.show', $order) }}" class="btn-primary inline-block">
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
        <div class="card text-center py-16">
            <p class="text-xl mb-4" style="color: var(--light-text);">
                You haven't placed any orders yet.
            </p>
            <a href="{{ route('books.index') }}" class="btn-primary">
                Start Shopping
            </a>
        </div>
    @endif
@endsection