<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // For admin to view all reviews
        /** @var \App\Models\User|null $user */
        $user = Auth::guard('web')->user();

        if (!$user || !$user->isAdmin()) {
            abort(403);
        }
        
        $reviews = Review::with(['user', 'book'])
            ->latest()
            ->paginate(20);
            
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $user = $request->user();

        if (!$user || !$user->hasOrderedBook($book->id)) {
            return redirect()->route('books.show', $book)
                ->with('error', 'You can only review books that you have ordered.');
        }

         $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        $validated['user_id'] = $user->id;
        $validated['book_id'] = $book->id;
        
        // Check if user already reviewed this book
        $existingReview = Review::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();
        
        if ($existingReview) {
            $existingReview->update($validated);
            $message = 'Review updated successfully!';
        } else {
            Review::create($validated);
            $message = 'Review submitted successfully!';
        }
        
        return redirect()->route('books.show', $book)
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load(['user', 'book']);
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        // Only allow owner or admin to delete
        /** @var \App\Models\User|null $user */
        $user = Auth::guard('web')->user();

        if (!$user || ($user->id !== $review->user_id && !$user->isAdmin())) {
            abort(403);
        }
        
        $book = $review->book;
        $review->delete();
        
        return redirect()->route('books.show', $book)
            ->with('success', 'Review deleted successfully!');
    }
}
