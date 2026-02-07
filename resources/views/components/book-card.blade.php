@props(['book'])

<div class="card h-full flex flex-col">
    <!-- Cover Image -->
    <div class="h-48 bg-gradient-to-br mb-4 rounded-lg overflow-hidden flex items-center justify-center" style="background: linear-gradient(135deg, var(--pastel-blue) 0%, var(--pastel-yellow) 100%);">
        @if($book->cover_image)
            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-full w-full object-cover">
        @else
            <svg class="h-20 w-20 opacity-50" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        @endif
    </div>
    
    <!-- Content -->
    <div class="flex-grow">
        <div class="badge-blue mb-2">{{ $book->category->name }}</div>
        
        <h3 class="font-bold text-lg mb-1 line-clamp-2" style="color: var(--dark-text);">
            {{ $book->title }}
        </h3>
        
        <p class="text-sm mb-3" style="color: var(--light-text);">
            by {{ $book->author }}
        </p>
        
        <!-- Rating -->
        <div class="flex items-center mb-3">
            <div class="flex">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($book->average_rating))
                        <svg class="w-4 h-4 star-yellow" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @else
                        <svg class="w-4 h-4 star-empty" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @endif
                @endfor
            </div>
            <span class="text-xs ml-2" style="color: var(--light-text);">
                {{ number_format($book->average_rating, 1) }} ({{ $book->reviews->count() }})
            </span>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="border-t pt-3" style="border-color: var(--pastel-blue);">
        <p class="text-lg font-bold mb-3" style="color: var(--pastel-blue-dark);">
            ${{ number_format($book->price, 2) }}
        </p>
        
        @if($book->stock_quantity > 0)
            <div class="badge-blue mb-3">{{ $book->stock_quantity }} in stock</div>
        @else
            <div class="badge-yellow mb-3">Out of Stock</div>
        @endif
        
        <a href="{{ route('books.show', $book) }}" class="btn-primary w-full text-center block text-sm">
            View Details
        </a>
    </div>
</div>