@extends('layouts.app')

@section('title', $book->title . ' - PageTurner')

@section('content')
<!-- Breadcrumb -->
<nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
        <li>
            <a href="{{ route('home') }}" class="hover:text-accent-blue transition-colors duration-200">
                <i class="fas fa-home mr-1"></i>Home
            </a>
        </li>
        <li><i class="fas fa-chevron-right text-xs"></i></li>
        <li>
            <a href="{{ route('books.index') }}" class="hover:text-accent-blue transition-colors duration-200">
                Books
            </a>
        </li>
        <li><i class="fas fa-chevron-right text-xs"></i></li>
        <li class="text-accent-blue font-medium">{{ $book->title }}</li>
    </ol>
</nav>

<!-- Book Details -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="md:flex">
        <!-- Left Column - Cover Image -->
        <div class="md:w-1/3 bg-gradient-to-br from-pastel-yellow/20 to-pastel-blue/20 p-8 flex items-center justify-center">
            @if($book->cover_image)
            <img src="{{ asset('storage/' . $book->cover_image) }}"
                alt="{{ $book->title }}"
                class="max-h-96 object-contain rounded-lg shadow-lg">
            @else
            <div class="text-center">
                <i class="fas fa-book-open text-8xl text-accent-blue/30 mb-4"></i>
                <p class="text-gray-400 font-medium">{{ $book->title }}</p>
            </div>
            @endif
        </div>

        <!-- Right Column - Details -->
        <div class="md:w-2/3 p-8">
            <!-- Category & Rating -->
            <div class="flex justify-between items-start mb-4">
                <span class="px-3 py-1 bg-pastel-blue/20 text-accent-blue text-sm font-bold rounded-full">
                    {{ $book->category->name }}
                </span>
                <div class="flex items-center">
                    <div class="flex mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <=round($book->average_rating))
                            <i class="fas fa-star text-accent-yellow mx-0.5"></i>
                            @else
                            <i class="far fa-star text-gray-300 mx-0.5"></i>
                            @endif
                            @endfor
                    </div>
                    <span class="text-gray-600 text-sm">
                        {{ number_format($book->average_rating, 1) }} ({{ $book->reviews->count() }} reviews)
                    </span>
                </div>
            </div>

            <!-- Title & Author -->
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $book->title }}</h1>
            <p class="text-xl text-gray-600 mb-6">by {{ $book->author }}</p>

            <!-- ISBN -->
            <div class="mb-6">
                <span class="text-gray-500 text-sm">ISBN:</span>
                <span class="ml-2 font-mono bg-gray-100 px-3 py-1 rounded text-gray-700">
                    {{ $book->isbn }}
                </span>
            </div>

            <!-- Price & Stock -->
            <div class="flex items-center justify-between mb-8 p-4 bg-gradient-to-r from-pastel-yellow/10 to-pastel-blue/10 rounded-lg">
                <div>
                    <span class="text-3xl font-bold text-accent-blue">
                        ₱{{ number_format($book->price, 2) }}
                    </span>
                </div>
                <div>
                    <span class="px-4 py-2 rounded-full font-medium {{ $book->stock_quantity > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <i class="fas {{ $book->stock_quantity > 0 ? 'fa-check' : 'fa-times' }} mr-2"></i>
                        {{ $book->stock_quantity > 0 ? 'In Stock (' . $book->stock_quantity . ' available)' : 'Out of Stock' }}
                    </span>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Description</h3>
                <div class="text-gray-600 leading-relaxed prose max-w-none">
                    {{ $book->description ?? 'No description available for this book.' }}
                </div>
            </div>

            <!-- Cart Section -->
            @auth
            @if(!auth()->user()->isAdmin()) <!-- checks user session-->
            <div class="mb-8 p-4 rounded-lg bg-gradient-to-r from-pastel-yellow/10 to-pastel-blue/10 border border-pastel-blue/30">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Add to Cart</h3>

                @if($book->stock_quantity > 0)
                <form action="{{ route('cart.add', $book) }}" method="POST" class="flex flex-col sm:flex-row sm:items-end gap-3">
                    @csrf

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input
                            id="quantity"
                            name="quantity"
                            type="number"
                            min="1"
                            max="{{ $book->stock_quantity }}"
                            value="1"
                            class="w-28 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue outline-none"
                            required>
                    </div>

                    <button
                        type="submit"
                        class="px-6 py-2 bg-yellow text-gray-800 font-bold rounded-lg hover:shadow-md transition-all duration-200">
                        <i class="fas fa-shopping-bag mr-2"></i> Add to Cart
                    </button>
                </form>
                @else
                <p class="text-sm text-red-600 font-medium">This book is currently out of stock.</p>
                @endif
            </div>
            @endif
            @else
            <div class="mb-8 p-4 rounded-lg bg-white border border-pastel-blue/30">
                <p class="text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="text-accent-blue font-medium hover:underline">Log in</a>
                    to order this book.
                </p>
            </div>
            @endauth

            <!-- Admin Actions -->
            @auth
            @if(auth()->user()->isAdmin())
            <div class="flex space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.books.edit', $book) }}"
                    class="px-6 py-2 bg-accent-yellow text-white font-medium rounded-lg hover:shadow-md transition-all duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Book
                </a>
                <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this book?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-red-400 to-red-500 text-white font-medium rounded-lg hover:shadow-md transition-all duration-200">
                        <i class="fas fa-trash mr-2"></i>Delete Book
                    </button>
                </form>
            </div>
            @endif
            @endauth
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="mt-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        <i class="fas fa-star mr-2 text-accent-yellow"></i>
        Customer Reviews
    </h2>

    <!-- Add Review Form -->
    @auth
    @if($canReview)
    <div class="bg-white rounded-xl border border-gray-100 p-6 mb-8 shadow-sm">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Write a Review</h3>
        <form action="{{ route('reviews.store', $book) }}" method="POST">
            @csrf
            @php
            $userReview = $book->reviews->where('user_id', auth()->id())->first();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Rating -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Rating</label>
                    <div class="flex items-center space-x-2">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                            <input type="radio" name="rating" value="{{ $i }}"
                                class="hidden peer" {{ old('rating', $userReview->rating ?? null) == $i ? 'checked' : '' }} required> <!-- The old('rating', $userReview->rating ?? null) function retrieves the previously submitted rating value from the session (if the form was submitted and validation failed) or the existing rating from the user's review (if it exists). This allows the form to retain the user's selected rating if they need to correct any validation errors. -->
                            <i class="far fa-star text-2xl text-gray-300 peer-checked:text-accent-yellow peer-hover:text-accent-yellow transition-colors duration-200"></i> 
                            </label>
                            @endfor
                    </div>
                    @error('rating')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current User Review -->
                @if($userReview)
                <div class="bg-pastel-blue/10 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        You reviewed this book on {{ $userReview->created_at->format('M d, Y') }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Comment -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Your Comment</label>
                <textarea name="comment" rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue outline-none transition-all duration-200"
                    placeholder="Share your thoughts about this book...">{{ old('comment', $userReview->comment ?? '') }}</textarea>
                @error('comment')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-pastel-blue to-pastel-yellow text-white font-medium rounded-lg hover:shadow-md transition-all duration-200 hover:scale-[1.02]">
                <i class="fas fa-paper-plane mr-2"></i>
                {{ $userReview ? 'Update Review' : 'Submit Review' }}
            </button>
        </form>
    </div>
    @else
    <x-alert type="info" class="mb-8">
        <div class="flex items-center">
            <i class="fas fa-receipt mr-3 text-xl"></i>
            <div>
                <p class="font-bold">Review locked</p>
                <p class="text-sm mt-1">You can only review books that you have ordered.</p>
            </div>
        </div>
    </x-alert>
    @endif
    @else
    <x-alert type="info" class="mb-8">
        <div class="flex items-center">
            <i class="fas fa-sign-in-alt mr-3 text-xl"></i>
            <div>
                <p class="font-bold">Want to leave a review?</p>
                <p class="text-sm mt-1">
                    <a href="{{ route('login') }}" class="text-accent-blue hover:underline font-medium">Login</a>
                    or
                    <a href="{{ route('register') }}" class="text-accent-blue hover:underline font-medium">register</a>
                    to share your thoughts!
                </p>
            </div>
        </div>
    </x-alert>
    @endauth

    <!-- Reviews List -->
    @if($book->reviews->count() > 0)
    <div class="space-y-6">
        @foreach($book->reviews as $review)
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-pastel-blue to-pastel-yellow flex items-center justify-center text-white font-bold mr-3">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $review->user->name }}</p>
                        <div class="flex items-center">
                            <div class="flex mr-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <=$review->rating)
                                    <i class="fas fa-star text-accent-yellow text-xs"></i>
                                    @else
                                    <i class="far fa-star text-gray-300 text-xs"></i>
                                    @endif
                                    @endfor
                            </div>
                            <span class="text-gray-500 text-sm">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Delete Review Button -->
                @auth
                @if(auth()->id() === $review->user_id || auth()->user()->isAdmin())
                <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                    onsubmit="return confirm('Delete this review?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-red-400 hover:text-red-600 transition-colors duration-200">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                @endif
                @endauth
            </div>

            @if($review->comment)
            <div class="text-gray-600 leading-relaxed">
                {{ $review->comment }}
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <x-alert type="info">
        <div class="flex items-center">
            <i class="fas fa-comment-slash mr-3 text-2xl"></i>
            <div>
                <p class="font-bold">No reviews yet</p>
                <p class="text-sm mt-1">Be the first to share your thoughts about this book!</p>
            </div>
        </div>
    </x-alert>
    @endif
</div>
@endsection