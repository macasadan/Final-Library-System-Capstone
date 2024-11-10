<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Borrow;

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
        return view('admin.books.create');
    }

    // Store a newly created book in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'description' => 'nullable|string',
            'isbn' => 'required|string|unique:books,isbn',
            'quantity' => 'required|integer|min:1',
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully.');
    }

    // Show the form for editing a book
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }



    // Update a book in the database
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'description' => 'nullable|string',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'quantity' => 'required|integer|min:1',
        ]);

        $book->update($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    // Remove a book from the database
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }
}
