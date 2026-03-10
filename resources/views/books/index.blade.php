@extends('layouts.app')

@section('title', 'All Books - PageTurner')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Browse Our Collection</h1>
        <p class="text-gray-600">Discover amazing books from various categories</p>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-xl border border-gray-100 p-6 mb-8 shadow-sm">
        <form action="{{ route('books.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by title, author, or ISBN..."
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue outline-none transition-all duration-200">
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <select name="category" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue outline-none transition-all duration-200 appearance-none bg-white">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-pastel-blue to-pastel-yellow text-white font-medium rounded-lg hover:shadow-md transition-all duration-200 hover:scale-[1.02]">
                    <i class="fas fa-search mr-2"></i>Search Books
                </button>
            </div>
        </form>
    </div>

    <!-- Books Count -->
    @if(request()->has('search') || request()->has('category'))
        <div class="mb-4">
            <p class="text-gray-600">
                Found <span class="font-bold text-accent-blue">{{ $books->total() }}</span> 
                book{{ $books->total() !== 1 ? 's' : '' }}
                @if(request('search'))
                    matching "<span class="font-bold">{{ request('search') }}</span>"
                @endif
            </p>
        </div>
    @endif

    <!-- Books Grid -->
    @if($books->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($books as $book)
                <x-book-card :book="$book" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $books->withQueryString()->links() }}
        </div>
    @else
        <x-alert type="info" class="mt-8">
            <div class="flex items-center">
                <i class="fas fa-book-open mr-4 text-3xl"></i>
                <div>
                    <p class="font-bold">No books found</p>
                    <p class="text-sm mt-1">
                        @if(request()->has('search') || request()->has('category'))
                            Try adjusting your search filters
                        @else
                            No books are currently available in our collection
                        @endif
                    </p>
                </div>
            </div>
        </x-alert>
    @endif
@endsection

@push('styles')
<style>
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
</style>
@endpush