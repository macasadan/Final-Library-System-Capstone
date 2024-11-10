<?php


namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function dashboard()
    {
        // Fetch reserved books for the authenticated user


        // Fetch borrowed books for the authenticated user - only non-returned books
        $borrowedBooks = Borrow::where('user_id', Auth::id())
            ->whereNull('returned_at') // This ensures only currently borrowed books are shown
            ->with('book')
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
        $books = Book::where('title', 'LIKE', "%{$query}%")
            ->orWhere('author', 'LIKE', "%{$query}%")
            ->get();

        return view('books.search', compact('books'));
    }

    // Users Borrow a book
    public function borrow(Book $book)
    {
        // Check if the book is available
        if ($book->quantity > 0) {
            // Reduce the quantity of the book
            $book->decrement('quantity');

            // Create a borrow record
            $borrow = Borrow::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'borrow_date' => now(), // Set the current timestamp as the borrowed date
                'due_date' => now()->addDays(14), // Example: Set the due date 14 days from now
            ]);

            return redirect()->back()->with('success', 'Book borrowed successfully!');
        } else {
            return redirect()->back()->with('error', 'Book is not available.');
        }
    }


    // Borrowing and Reservation Logic that shows in user  dashboard

    public function borrowedBooks()
    {
        // Fetch all borrowed books for the authenticated user
        $borrowedBooks = Borrow::where('user_id', Auth::id())
            ->whereNull('returned_at') // Only show books not yet returned
            ->with('book') // Include book details for easy access
            ->latest('borrow_date')
            ->get();
        return view('borrowed_books', compact('borrowedBooks'));
    }




    // Show available books
    public function index()
    {
        $books = Book::where('quantity', '>', 0)->get();
        return view('books.index', compact('books'));
    }
}
