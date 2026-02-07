@extends('layouts.app')

@section('title', 'PageTurner - Online Bookstore')

@section('header')
    <div class="text-center">
        <h1 class="text-5xl font-bold mb-4">Welcome to PageTurner</h1>
        <p class="text-lg mb-6" style="color: var(--light-text);">
            Discover your next favorite book from our curated collection
        </p>
        <a href="{{ route('books.index') }}" class="btn-primary text-lg" style="display: inline-block; padding: 12px 32px;">
            Browse Our Collection
        </a>
    </div>
@endsection

@section('content')
    <!-- Categories Section -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8" style="color: var(--dark-text);">
            📚 Browse by Category
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="card text-center hover:shadow-lg transition p-6">
                    <div class="text-4xl mb-3">📖</div>
                    <h3 class="font-bold text-lg mb-2" style="color: var(--dark-text);">
                        {{ $category->name }}
                    </h3>
                    <p class="text-sm" style="color: var(--light-text);">
                        {{ $category->books_count }} {{ $category->books_count === 1 ? 'book' : 'books' }}
                    </p>
                </a>
            @empty
                <div class="col-span-full text-center py-8">
                    <p style="color: var(--light-text);">No categories yet.</p>
                </div>
            @endforelse
        </div>
    </section>
    
    <!-- Featured Books Section -->
    <section>
        <h2 class="text-3xl font-bold mb-8" style="color: var(--dark-text);">
            ⭐ Featured Books
        </h2>
        
        @forelse($featuredBooks as $book)
            @if($loop->first)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @endif
            
            <x-book-card :book="$book" />
            
            @if($loop->last)
                </div>
            @endif
        @empty
            <div class="card text-center py-12">
                <p style="color: var(--light-text); font-size: 18px;">
                    No books available yet. Check back soon!
                </p>
            </div>
        @endforelse
    </section>
@endsection