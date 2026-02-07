@extends('layouts.app')

@section('title', 'Books - PageTurner')

@section('header')
    <h1 class="text-4xl font-bold">📚 All Books</h1>
    <p class="mt-2" style="color: var(--light-text);">Explore our complete collection</p>
@endsection

@section('content')
    <!-- Search & Filter -->
    <div class="card mb-8">
        <form action="{{ route('books.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Search by title or author..."
                    class="w-full"
                >
            </div>
            
            <div class="w-full md:w-48">
                <select name="category" class="w-full">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn-primary">
                🔍 Search
            </button>
        </form>
    </div>
    
    <!-- Books Grid -->
    @if($books->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @foreach($books as $book)
                <x-book-card :book="$book" />
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            {{ $books->withQueryString()->links() }}
        </div>
    @else
        <div class="card text-center py-16">
            <p class="text-xl mb-4" style="color: var(--light-text);">
                No books found matching your search criteria.
            </p>
            <a href="{{ route('books.index') }}" class="btn-primary">
                Reset Search
            </a>
        </div>
    @endif
@endsection