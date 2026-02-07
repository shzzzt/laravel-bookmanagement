@extends('layouts.app')

@section('title', isset($category) ? 'Edit Category - PageTurner' : 'Add New Category - PageTurner')

@section('header')
    <h1 class="text-4xl font-bold">
        {{ isset($category) ? '✏️ Edit Category' : '📂 Add New Category' }}
    </h1>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="card">
            <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif
                
                <!-- Category Name -->
                <div class="mb-6">
                    <label for="name" class="block font-bold mb-2" style="color: var(--dark-text);">
                        Category Name *
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', isset($category) ? $category->name : '') }}"
                        placeholder="e.g., Fantasy, Science Fiction, Mystery..."
                        required
                        class="w-full"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Description -->
                <div class="mb-8">
                    <label for="description" class="block font-bold mb-2" style="color: var(--dark-text);">
                        Description
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="6"
                        placeholder="Enter a description for this category..."
                        class="w-full"
                    >{{ old('description', isset($category) ? $category->description : '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Actions -->
                <div class="flex gap-4">
                    <a href="{{ route('categories.index') }}" class="btn-secondary flex-1 text-center">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary flex-1">
                        {{ isset($category) ? '✓ Update Category' : '✓ Add Category' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection