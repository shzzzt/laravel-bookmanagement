@extends('layouts.app')

@section('title', $category->name . ' - PageTurner')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold">{{ $category->name }}</h1>
            <p class="mt-2" style="color: var(--light-text);">
                @if($category->description)
                    {{ $category->description }}
                @else
                    Explore our {{ $category->name }} collection
                @endif
            </p>
        </div>
        
        @auth
            @if(auth()->user()->isAdmin())
                <div class="space-y-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn-secondary block text-center">
                        Edit Category
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary w-full" onclick="return confirm('Are you sure?')">
                            Delete Category
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
@endsection

@section('content')
    <div class="mb-8">
        <div class="badge-blue mb-4">{{ $books->total() }} {{ $books->total() === 1 ? 'book' : 'books' }}</div>
    </div>
    
    @if($books->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @foreach($books as $book)
                <x-book-card :book="$book" />
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $books->links() }}
        </div>
    @else
        <div class="card text-center py-16">
            <p class="text-xl mb-4" style="color: var(--light-text);">
                No books in this category yet.
            </p>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.books.create') }}" class="btn-primary">
                        Add a Book
                    </a>
                @endif
            @endauth
        </div>
    @endif
@endsection