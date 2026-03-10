@extends('layouts.app')

@section('title', isset($book) ? 'Edit Book - PageTurner' : 'Add New Book - PageTurner')

@section('header')
    <h1 class="text-4xl font-bold">
        {{ isset($book) ? '✏️ Edit Book' : '📚 Add New Book' }}
    </h1>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="card">
            <form action="{{ isset($book) ? route('admin.books.update', $book) : route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($book))
                    @method('PUT')
                @endif
                
                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block font-bold mb-2" style="color: var(--dark-text);">
                        Book Title *
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title', isset($book) ? $book->title : '') }}"
                        placeholder="Enter book title"
                        required
                        class="w-full"
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Author -->
                <div class="mb-6">
                    <label for="author" class="block font-bold mb-2" style="color: var(--dark-text);">
                        Author *
                    </label>
                    <input 
                        type="text" 
                        name="author" 
                        id="author" 
                        value="{{ old('author', isset($book) ? $book->author : '') }}"
                        placeholder="Enter author name"
                        required
                        class="w-full"
                    >
                    @error('author')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Category -->
                <div class="mb-6">
                    <label for="category_id" class="block font-bold mb-2" style="color: var(--dark-text);">
                        Category *
                    </label>
                    <select name="category_id" id="category_id" required class="w-full">
                        <option value="">Select a category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', isset($book) ? $book->category_id : '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- ISBN & Price -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="isbn" class="block font-bold mb-2" style="color: var(--dark-text);">
                            ISBN *
                        </label>
                        <input 
                            type="text" 
                            name="isbn" 
                            id="isbn" 
                            value="{{ old('isbn', isset($book) ? $book->isbn : '') }}"
                            placeholder="e.g., 978-3-16-148410-0"
                            required
                            class="w-full"
                        >
                        @error('isbn')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="price" class="block font-bold mb-2" style="color: var(--dark-text);">
                            Price (₱) *
                        </label>
                        <input 
                            type="number" 
                            step="0.01" 
                            name="price" 
                            id="price" 
                            value="{{ old('price', isset($book) ? $book->price : '') }}"
                            placeholder="0.00"
                            required
                            class="w-full"
                        >
                        @error('price')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Stock Quantity -->
                <div class="mb-6">
                    <label for="stock_quantity" class="block font-bold mb-2" style="color: var(--dark-text);">
                        Stock Quantity *
                    </label>
                    <input 
                        type="number" 
                        name="stock_quantity" 
                        id="stock_quantity" 
                        value="{{ old('stock_quantity', isset($book) ? $book->stock_quantity : 0) }}"
                        min="0"
                        required
                        class="w-full"
                    >
                    @error('stock_quantity')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block font-bold mb-2" style="color: var(--dark-text);">
                        Description
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="6"
                        placeholder="Enter book description..."
                        class="w-full"
                    >{{ old('description', isset($book) ? $book->description : '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Cover Image -->
                <div class="mb-8">
                    <label for="cover_image" class="block font-bold mb-2" style="color: var(--dark-text);">
                        Cover Image
                    </label>
                    <input 
                        type="file" 
                        name="cover_image" 
                        id="cover_image" 
                        accept="image/*"
                        class="w-full"
                    >
                    <p class="text-sm" style="color: var(--light-text); margin-top: 8px;">
                        Accepted formats: JPG, PNG, GIF, WebP (Max 2MB)
                    </p>
                    @if(isset($book) && $book->cover_image)
                        <div class="mt-4">
                            <p class="text-sm" style="color: var(--light-text); margin-bottom: 8px;">Current cover:</p>
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-32 rounded-lg">
                        </div>
                    @endif
                    @error('cover_image')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Actions -->
                <div class="flex gap-4">
                    <a href="{{ isset($book) ? route('books.show', $book) : route('books.index') }}" class="btn-secondary flex-1 text-center">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary flex-1">
                        {{ isset($book) ? '✓ Update Book' : '✓ Add Book' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection