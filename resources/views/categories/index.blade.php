@extends('layouts.app')

@section('title', 'Categories - PageTurner')

@section('content')
    <!-- Page Header -->
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            <i class="fas fa-tags mr-2"></i>All Categories
        </h1>
        <p class="text-gray-600 text-lg">
            Explore our collection organized by genre and topic
        </p>
    </div>

    <!-- Categories Grid -->
    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}" 
                   class="group">
                    <div class="bg-white rounded-xl border border-gray-100 hover:border-pastel-blue/50 hover:shadow-lg transition-all duration-200 overflow-hidden h-full">
                        <!-- Category Header with Icon -->
                        <div class="bg-gradient-to-r from-pastel-blue/20 to-pastel-yellow/20 p-8 flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 group-hover:text-accent-blue transition-colors duration-200 mb-2">
                                    {{ $category->name }}
                                </h3>
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 bg-pastel-blue/30 text-accent-blue text-sm font-bold rounded-full">
                                        {{ $category->books_count }} 
                                        {{ $category->books_count === 1 ? 'Book' : 'Books' }}
                                    </span>
                                </div>
                            </div>
                            <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-pastel-yellow to-pastel-blue flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-book text-2xl text-accent-blue"></i>
                            </div>
                        </div>

                        <!-- Category Description -->
                        @if($category->description)
                            <div class="p-6">
                                <p class="text-gray-600 line-clamp-3">
                                    {{ $category->description }}
                                </p>
                            </div>
                        @else
                            <div class="p-6">
                                <p class="text-gray-500 italic">
                                    No description available
                                </p>
                            </div>
                        @endif

                        <!-- View More Link -->
                        <div class="px-6 pb-6 pt-0">
                            <div class="inline-flex items-center text-accent-blue font-medium group-hover:gap-2 transition-all duration-200">
                                Browse Books <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $categories->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-100 p-12 text-center">
            <div class="flex flex-col items-center">
                <i class="fas fa-inbox text-5xl text-pastel-blue/40 mb-4"></i>
                <p class="text-xl text-gray-600 mb-6">
                    No categories available yet
                </p>
                <a href="{{ route('books.index') }}" class="px-6 py-3 bg-gradient-to-r from-pastel-blue to-pastel-yellow text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 hover:scale-[1.02]">
                    <i class="fas fa-book-open mr-2"></i>Browse All Books
                </a>
            </div>
        </div>
    @endif
@endsection