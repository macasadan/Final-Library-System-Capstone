<?php


namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Carbon\Carbon;

class BookController extends Controller
{

    public function dashboard()
    {
        // Fetch reserved books for the authenticated user

        // Fetch borrowed books for the authenticated user - only non-returned books
        $borrowedBooks = Borrow::where('user_id', Auth::id())
            ->whereNull('returned_at') // This ensures only currently borrowed books are shown
            ->with(['book' => function ($query) {
                $query->with('categories');
            }])
            ->latest('borrow_date') // Order by most recent borrow
            ->limit(2)
            ->get();

        return view('dashboard', compact('borrowedBooks'));
    }


    // Users return a borrowed book
    public function returnBook(Request $request, $borrowId)
    {
        DB::beginTransaction();
        try {
            $borrow = Borrow::where('id', $borrowId)
                ->where('user_id', Auth::id())
                ->whereNull('returned_at')
                ->firstOrFail();

            if (!$borrow) {
                return response()->json(['error' => 'Borrow record not found.'], 404);
            }

            // Update book quantity
            $book = Book::find($borrow->book_id);
            $book->increment('quantity');

            // Update borrow record with only the returned_at timestamp
            $borrow->update([
                'returned_at' => now(),
                'return_status' => 'returned',
                'returned_condition' => $request->returned_condition ?? 'good'
            ]);

            DB::commit();
            return response()->json([
                'success' => 'Book returned successfully!',
                'borrow_id' => $borrow->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error returning book: ' . $e->getMessage()], 500);
        }
    }


    // Search for books
    public function search(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where(function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
                ->orWhere('author', 'LIKE', "%{$query}%");
        })->with('categories')->get();

        return view('books.search', compact('books'));
    }

    // Users Borrow a book
    public function borrow(Request $request, Book $book)
    {
        $request->validate([
            'id_number' => 'required|string',
            'course' => 'required|string',
            'department' => 'required|in:COT,COE,CEAS,CME'
        ]);

        if ($book->quantity <= 0) {
            return redirect()->back()
                ->with('error', 'Sorry, this book is no longer available.')
                ->withInput();
        }

        // Start transaction
        DB::beginTransaction();

        try {
            // Reduce the quantity of the book


            // Create a borrow record
            $borrow = Borrow::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'id_number' => $request->id_number,
                'course' => $request->course,
                'department' => $request->department,
                'borrow_date' => now(),
                'due_date' => Carbon::now()->addDay(1),
                'status' => Borrow::STATUS_PENDING
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Book borrowed successfully! Please return it by ' . $borrow->due_date->format('M d, Y'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while processing your request. Please try again.')
                ->withInput();
        }
    }

    // Users history of borrowed books
    public function borrowingHistory(Request $request)
    {
        $query = Borrow::where('user_id', Auth::id())
            ->with('book');

        // Handle status filter
        switch ($request->get('status')) {
            case 'current':
                $query->whereNull('returned_at')
                    ->where('status', 'approved');
                break;
            case 'returned':
                $query->whereNotNull('returned_at');
                break;
        }

        // Handle sorting
        switch ($request->get('sort')) {
            case 'oldest':
                $query->oldest('created_at');
                break;
            default: // newest
                $query->latest('created_at');
                break;
        }

        $borrowHistory = $query->paginate(10)
            ->withQueryString();

        return view('books.history', compact('borrowHistory'));
    }

    // Borrowing and Reservation Logic that shows in user  dashboard

    public function borrowedBooks()
    {
        // Fetch all borrowed books for the authenticated user
        $borrowedBooks = Borrow::where('user_id', Auth::id())
            ->whereNull('returned_at') // Only show books not yet returned
            ->with(['book' => function ($query) {
                $query->with('categories'); // Explicitly load categories
            }])                             // Include book details for easy access
            ->latest('borrow_date')
            ->get();
        return view('borrowed_books', compact('borrowedBooks'));
    }

    // Show books by category
    public function booksByCategory(Category $category)
    {
        $books = $category->books()
            ->where('quantity', '>', 0)
            ->get();

        return view('books.book-category', compact('category', 'books'));
    }

    // Show available books
    public function index()
    {
        $categories = Category::has('books')
            ->withCount('books')
            ->get();
        $books = Book::with('categories')
            ->where('quantity', '>', 0)
            ->get();
        return view('books.index', compact('books', 'categories'));
    }
}
