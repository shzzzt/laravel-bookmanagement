@extends('layouts.app')

@section('title', $book->title . ' - PageTurner')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Book Cover & Details -->
        <div class="md:col-span-1">
            <div class="card sticky top-8">
                <!-- Cover Image -->
                <div class="h-64 bg-gradient-to-br rounded-lg overflow-hidden flex items-center justify-center mb-6" style="background: linear-gradient(135deg, var(--pastel-blue) 0%, var(--pastel-yellow) 100%);">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-full w-full object-cover">
                    @else
                        <svg class="h-24 w-24 opacity-50" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    @endif
                </div>
                
                <!-- Price & Stock -->
                <p class="text-3xl font-bold mb-4" style="color: var(--pastel-blue-dark);">
                    ${{ number_format($book->price, 2) }}
                </p>
                
                <div class="mb-6">
                    @if($book->stock_quantity > 0)
                        <div class="badge-blue mb-3">✓ {{ $book->stock_quantity }} in stock</div>
                    @else
                        <div class="badge-yellow mb-3">⚠ Out of Stock</div>
                    @endif
                </div>
                
                <!-- Admin Actions -->
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="space-y-2">
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn-primary w-full text-center block">
                                ✏️ Edit Book
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-secondary w-full" onclick="return confirm('Are you sure?')">
                                    🗑️ Delete Book
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
        
        <!-- Book Information -->
        <div class="md:col-span-2">
            <div class="badge-blue mb-4">{{ $book->category->name }}</div>
            
            <h1 class="text-4xl font-bold mb-2" style="color: var(--dark-text);">
                {{ $book->title }}
            </h1>
            
            <p class="text-xl mb-6" style="color: var(--light-text);">
                by <span style="color: var(--dark-text); font-weight: 600;">{{ $book->author }}</span>
            </p>
            
            <!-- Rating -->
            <div class="flex items-center mb-6">
                <div class="flex">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($book->average_rating))
                            <svg class="w-6 h-6 star-yellow" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @else
                            <svg class="w-6 h-6 star-empty" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="ml-4 text-lg" style="color: var(--light-text);">
                    {{ number_format($book->average_rating, 1) }} / 5.0 ({{ $book->reviews->count() }} {{ $book->reviews->count() === 1 ? 'review' : 'reviews' }})
                </span>
            </div>
            
            <!-- ISBN -->
            <div class="card mb-6" style="background-color: rgba(168, 216, 234, 0.05);">
                <p style="color: var(--light-text); font-size: 14px;">ISBN</p>
                <p class="font-bold" style="color: var(--dark-text);">{{ $book->isbn }}</p>
            </div>
            
            <!-- Description -->
            <div class="mb-8">
                <h3 class="text-xl font-bold mb-4" style="color: var(--dark-text);">
                    📖 Description
                </h3>
                <p style="color: var(--light-text); line-height: 1.8;">
                    {{ $book->description ?? 'No description available.' }}
                </p>
            </div>
        </div>
    </div>
    
    <!-- Reviews Section -->
    <div class="border-t pt-8" style="border-color: var(--pastel-blue);">
        <h2 class="text-3xl font-bold mb-8" style="color: var(--dark-text);">
            💬 Customer Reviews
        </h2>
        
        <!-- Review Form -->
        @auth
            <div class="card mb-8" style="background-color: rgba(255, 216, 155, 0.05);">
                <h3 class="text-xl font-bold mb-6" style="color: var(--dark-text);">
                    Write a Review
                </h3>
                
                <form action="{{ route('reviews.store', $book) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block font-bold mb-3" style="color: var(--dark-text);">
                            Your Rating ⭐
                        </label>
                        <select name="rating" class="w-full md:w-48" required>
                            <option value="">Select a rating...</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block font-bold mb-3" style="color: var(--dark-text);">
                            Your Comment
                        </label>
                        <textarea 
                            name="comment" 
                            rows="4" 
                            placeholder="Share your thoughts about this book..."
                            class="w-full"
                        ></textarea>
                    </div>
                    
                    <button type="submit" class="btn-secondary">
                        Submit Review
                    </button>
                </form>
            </div>
        @else
            <div class="card mb-8" style="background-color: rgba(168, 216, 234, 0.05); border-left: 4px solid var(--pastel-blue);">
                <p style="color: var(--light-text); margin-bottom: 12px;">
                    Want to share your thoughts? 
                    <a href="{{ route('login') }}" style="color: var(--pastel-blue-dark); font-weight: 600; text-decoration: none;">
                        Log in
                    </a>
                    to write a review.
                </p>
            </div>
        @endauth
        
        <!-- Display Reviews -->
        <div class="space-y-4">
            @forelse($book->reviews as $review)
                <div class="card">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="font-bold" style="color: var(--dark-text);">
                                {{ $review->user->name }}
                            </p>
                            <div class="flex items-center mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="w-4 h-4 star-yellow" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 star-empty" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-2 text-sm" style="color: var(--light-text);">
                                    {{ $review->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        
                        @auth
                            @if(auth()->id() === $review->user_id || auth()->user()->isAdmin())
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    
                    @if($review->comment)
                        <p style="color: var(--light-text); line-height: 1.6;">
                            {{ $review->comment }}
                        </p>
                    @endif
                </div>
            @empty
                <div class="card text-center py-8">
                    <p style="color: var(--light-text);">
                        No reviews yet. Be the first to review this book!
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection