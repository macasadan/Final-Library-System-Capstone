<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Category;

class AdminBookController extends Controller
{
    // Display a listing of the books with pagination
    public function index()
    {
        $books = Book::paginate(10); // Adjust the number of items per page as needed
        return view('admin.books.index', compact('books'));
    }


    // Show the form for creating a new book
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    // Store a newly created book in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'description' => 'nullable|string',
            'isbn' => 'required|string|unique:books,isbn',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully.');
    }

    // Show the form for editing a book
    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    // Update a book in the database
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'description' => 'nullable|string',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book->update($request->all());
        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    // Remove a book from the database
    public function destroy(Book $book)
    {
        // Check if book can be deleted (no active borrows)
        if ($book->borrows()->whereNull('returned_at')->exists()) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Cannot delete book. It has active borrowers.');
        }

        $book->delete();
        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully.');
    }
}
