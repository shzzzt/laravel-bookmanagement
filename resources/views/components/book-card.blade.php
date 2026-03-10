@props(['book'])

<div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 hover:border-pastel-blue/50 group">
    <!-- Cover Image -->
    <div class="h-48 bg-gradient-to-br from-pastel-yellow/30 to-pastel-blue/30 flex items-center justify-center relative overflow-hidden">
        @if($book->cover_image)
        <img src="{{ asset('storage/' . $book->cover_image) }}"
            alt="{{ $book->title }}"
            class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
        <div class="text-center p-4">
            <i class="fas fa-book-open text-5xl text-accent-blue/50 mb-3"></i>
            <p class="text-gray-400 text-sm font-medium">{{ $book->title }}</p>
        </div>
        @endif
        <!-- Category Badge -->
        <div class="absolute top-3 left-3">
            <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-xs font-bold rounded-full text-accent-blue border border-pastel-blue/30">
                {{ $book->category->name }}
            </span>
        </div>
    </div>

    <!-- Content -->
    <div class="p-4">
        <!-- Title & Author -->
        <h3 class="font-bold text-gray-800 text-lg mb-1 truncate group-hover:text-accent-blue transition-colors duration-200">
            {{ $book->title }}
        </h3>
        <p class="text-gray-600 text-sm mb-3">by {{ $book->author }}</p>

        <!-- Rating -->
        <div class="flex items-center mb-3">
            <div class="flex">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <=round($book->average_rating))
                    <i class="fas fa-star text-accent-yellow mr-1 text-sm"></i>
                    @else
                    <i class="far fa-star text-gray-300 mr-1 text-sm"></i>
                    @endif
                    @endfor
            </div>
            <span class="text-gray-500 text-xs ml-2">
                ({{ number_format($book->average_rating, 1) }})
            </span>
        </div>

        <!-- Price & Stock -->
        <div class="flex justify-between items-center mb-4">
            <span class="text-xl font-bold text-accent-blue">
                ₱{{ number_format($book->price, 2) }}
            </span>
            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $book->stock_quantity > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $book->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
            </span>
        </div>

        <!-- Action Button -->
        <a href="{{ route('books.show', $book) }}"
            class="block w-full text-center py-2 bg-yellow text-white font-medium rounded-lg hover:shadow-md transition-all duration-200 hover:scale-[1.02]">
            <i class="fas fa-eye mr-2"></i>View Details
        </a>
    </div>
</div>