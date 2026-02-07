@extends('layouts.app')

@section('title', 'Categories - PageTurner')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold">📂 All Categories</h1>
            <p class="mt-2" style="color: var(--light-text);">Browse books by genre</p>
        </div>
        
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.categories.create') }}" class="btn-secondary">
                    + New Category
                </a>
            @endif
        @endauth
    </div>
@endsection

@section('content')
    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($categories as $category)
                <div class="card group hover:shadow-xl transition">
                    <!-- Category Header -->
                    <div class="mb-4 pb-4 border-b" style="border-color: var(--pastel-blue);">
                        <h3 class="text-2xl font-bold" style="color: var(--dark-text);">
                            {{ $category->name }}
                        </h3>
                        <div class="badge-blue mt-2 inline-block">
                            {{ $category->books_count }} {{ $category->books_count === 1 ? 'book' : 'books' }}
                        </div>
                    </div>
                    
                    <!-- Description -->
                    @if($category->description)
                        <p style="color: var(--light-text); margin-bottom: 16px; line-height: 1.6;">
                            {{ Str::limit($category->description, 100) }}
                        </p>
                    @endif
                    
                    <!-- Actions -->
                    <div class="flex gap-3">
                        <a href="{{ route('categories.show', $category) }}" class="btn-primary flex-1 text-center">
                            Browse Books
                        </a>
                        
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn-secondary flex-1 text-center">
                                    Edit
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $categories->links() }}
        </div>
    @else
        <div class="card text-center py-16">
            <p class="text-xl mb-4" style="color: var(--light-text);">
                No categories found.
            </p>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                        Create First Category
                    </a>
                @endif
            @endauth
        </div>
    @endif
@endsection