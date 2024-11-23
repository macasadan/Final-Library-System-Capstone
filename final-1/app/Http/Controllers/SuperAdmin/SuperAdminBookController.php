<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Category;

class SuperAdminBookController extends Controller
{
    // Display a listing of the books with pagination
    public function index()
    {
        $books = Book::with('category')->paginate(10);
        return view('super-admin.books.index', compact('books'));
    }

    // Show detailed book information
    public function show(Book $book)
    {
        $book->load('category', 'borrows');
        return view('super-admin.books.show', compact('book'));
    }
}
