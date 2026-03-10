<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with('category'); //Book::with('category') loads the related category data for each book to avoid N+1 query problem when displaying category information in the view
        //n+1 problem is when you have a relationship and you loop through the parent model and access the related model, it will execute a query for each parent model to get the related model, which can be very inefficient. By using with('category'), it will load all the related categories in one query, and then you can access the category information without executing additional queries for each book.
        //Filter by categroy if provided
        if ($request->has('category')) { 
            $query->where('category_id', $request->category); //filters the books by the selected category, it checks if the request has a 'category' parameter and if it does, it adds a where clause to the query to filter the books by the selected category ID
        }

        //Search by title pr author
        if ($request->has('search')) { //filters the books by a search term, it checks if the request has a 'search' parameter and if it does, it adds a where clause to the query to filter the books by title or author that contains the search term. The where clause uses a closure to group the conditions for title and author together, allowing for an OR condition between them.
            $search = $request->search;
            $query->where(function ($q) use ($search) { //function ($q) use ($search) is a closure that allows us to group the where conditions for title and author together. The use ($search) syntax allows us to access the $search variable from the outer scope within the closure.
                $q->where('title', 'like', "%{$search}%")->orWhere('author', 'like', "%{$search}%"); 
            });
        }

        $books = $query->paginate(12);  
        $categories = Category::all(); 

        return view('books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['category', 'reviews.user']);

        /** @var \App\Models\User|null $user */
        $user = Auth::guard('web')->user();

        $canReview = $user ? $user->hasOrderedBook($book->id) : false;

        return view('books.show', compact('book', 'canReview'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.show', $book)->with('sucess', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete(); //actually

        return redirect()->route('books.index')->with('sucess', 'Book deleted successfully');
    }
}
