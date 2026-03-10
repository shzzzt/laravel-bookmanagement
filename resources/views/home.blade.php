@extends('layouts.app')

@section('title', 'PageTurner - Online Bookstore')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden rounded-2xl mb-12">
    <div class="absolute inset-0 bg-gradient-to-r from-pastel-blue to-pastel-yellow opacity-20"></div>
    <div class="relative bg-white/90 backdrop-blur-sm p-8 md:p-12 rounded-2xl border border-pastel-blue/30">
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4 leading-tight">
                Discover Your Next
                <span class="text-yellow">
                    Favorite Book
                </span>
            </h1>
            <p class="text-gray-600 text-lg mb-8">
                Dive into magical worlds with our curated collection of books.
                From thrilling adventures to heartwarming stories, find your perfect read today.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('books.index') }}"
                    class="px-6 py-3 bg-accent-blue  text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 hover:scale-[1.02]">
                    <i class="fas fa-book-open mr-2"></i>Browse Collection
                </a>
                <a href="{{ route('categories.index') }}"
                    class="px-6 py-3 bg-white border-2 border-pastel-blue text-accent-blue font-medium rounded-lg hover:bg-pastel-blue/10 transition-colors duration-200">
                    <i class="fas fa-tags mr-2"></i>Explore Categories
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<section class="mb-12">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Browse by Category</h2>
        <a href="{{ route('categories.index') }}" class="text-accent-blue hover:text-accent-blue/80 transition-colors duration-200 font-medium">
            View All <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($categories as $category)
        <a href="{{ route('categories.show', $category) }}"
            class="bg-white p-6 rounded-xl border border-gray-100 hover:border-pastel-blue/50 hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-pastel-yellow/30 to-pastel-blue/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-tag text-accent-blue"></i>
                </div>
                <span class="px-2 py-1 bg-pastel-blue/10 text-accent-blue text-xs font-bold rounded-full">
                    {{ $category->books_count }}
                </span>
            </div>
            <h3 class="font-bold text-gray-800 group-hover:text-accent-blue transition-colors duration-200">
                {{ $category->name }}
            </h3>
            @if($category->description)
            <p class="text-gray-600 text-sm mt-2 line-clamp-2">
                {{ $category->description }}
            </p>
            @endif
        </a>
        @endforeach
    </div>
</section>

<!-- Featured Books Section -->
<section>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Featured Books</h2>
        <a href="{{ route('books.index') }}" class="text-accent-blue hover:text-accent-blue/80 transition-colors duration-200 font-medium">
            View All <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    @if($featuredBooks->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($featuredBooks as $book)
        <x-book-card :book="$book" />
        @endforeach
    </div>
    @else
    <x-alert type="info">
        <div class="flex items-center">
            <i class="fas fa-book-open mr-3 text-2xl"></i>
            <div>
                <p class="font-bold">No books available yet!</p>
                <p class="text-sm mt-1">Check back soon for new arrivals.</p>
            </div>
        </div>
    </x-alert>
    @endif
</section>
@endsection