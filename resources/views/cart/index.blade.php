@extends('layouts.app')

@section('title', 'My Cart - PageTurner')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">My Cart</h1>
        <p class="text-gray-600">Review your selected books before checkout.</p>
    </div>

    @if($items->isEmpty())
    <div class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm text-center">
        <p class="text-lg text-gray-600 mb-4">Your cart is empty.</p>
        <a href="{{ route('books.index') }}" class="px-6 py-3 bg-gradient-to-r from-pastel-blue to-pastel-yellow text-white font-medium rounded-lg hover:shadow-md transition-all duration-200 inline-block">
            Browse Books
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            @foreach($items as $item)
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="font-bold text-gray-800">{{ $item['book']->title }}</p>
                        <p class="text-sm text-gray-500">by {{ $item['book']->author }}</p>
                        <p class="text-sm text-accent-blue mt-1">₱{{ number_format($item['book']->price, 2) }} each</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <form action="{{ route('cart.update', $item['book']) }}" method="POST" class="flex items-end gap-2">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Qty</label>
                                <input
                                    type="number"
                                    name="quantity"
                                    min="1"
                                    max="{{ $item['book']->stock_quantity }}"
                                    value="{{ $item['quantity'] }}"
                                    class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue outline-none"
                                    required>
                            </div>
                            <button type="submit" class="px-3 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                Update
                            </button>

                        </form>

                        <form action="{{ route('cart.remove', $item['book']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-3 pt-3 border-t border-gray-100 text-right">
                    <span class="text-sm text-gray-500">Subtotal:</span>
                    <span class="text-lg font-bold text-gray-800 ml-2">₱{{ number_format($item['subtotal'], 2) }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div>
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm sticky top-24">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Order Summary</h2>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600">Total</span>
                    <span class="text-2xl font-bold text-accent-blue">₱{{ number_format($total, 2) }}</span>
                </div>

                <form action="{{ route('orders.store') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="mb-3">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Delivery Address</label>
                        <textarea id="address" name="address" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue outline-none">{{ old('address', auth()->user()->address) }}</textarea>
                        @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">You can change this during checkout anytime.</p>
                    </div>

                    <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-pastel-blue to-pastel-yellow text-white font-medium rounded-lg hover:shadow-md transition-all duration-200">
                        Checkout
                    </button>
                </form>

                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Clear Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection