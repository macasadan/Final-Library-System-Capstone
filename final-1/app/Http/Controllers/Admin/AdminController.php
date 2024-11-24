<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use App\Models\DiscussionRoomReservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Method for displaying the admin dashboard
    public function dashboard()
    {
        try {
            // Fetch basic statistics
            $totalBooks = Book::count();
            $totalBorrowedBooks = Borrow::whereNull('returned_at')->count();
            $pendingCount = Borrow::where('status', 'pending')->count();

            // Fetch expired reservations
            $expiredReservations = DiscussionRoomReservation::where('end_time', '<', now())
                ->where('status', '!=', 'completed')
                ->get();

            return view('admin.dashboard', compact(
                'totalBooks',
                'totalBorrowedBooks',
                'pendingCount',
                'expiredReservations'
            ));
        } catch (\Exception $e) {
            Log::error('Error in dashboard: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the dashboard.');
        }
    }

    // Method for displaying the list of returned books
    public function returnedBooks(Request $request)
    {
        try {
            $query = Borrow::query()
                ->with(['book', 'user'])
                ->whereNotNull('returned_at');

            // Handle search
            if ($request->filled('search')) {
                $searchTerm = trim($request->input('search'));

                $query->where(function ($q) use ($searchTerm) {
                    $q->whereHas('book', function ($bookQuery) use ($searchTerm) {
                        $bookQuery->where('title', 'like', '%' . $searchTerm . '%')
                            ->orWhere('author', 'like', '%' . $searchTerm . '%')
                            ->orWhere('isbn', 'like', '%' . $searchTerm . '%');
                    })
                        ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                            $userQuery->where('name', 'like', '%' . $searchTerm . '%')
                                ->orWhere('email', 'like', '%' . $searchTerm . '%');
                        })
                        ->orWhere('id_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('course', 'like', '%' . $searchTerm . '%')
                        ->orWhere('department', 'like', '%' . $searchTerm . '%');
                });
            }

            // Handle date range filtering
            if ($request->filled('date_from')) {
                $dateFrom = Carbon::parse($request->input('date_from'))->startOfDay();
                $query->where('returned_at', '>=', $dateFrom);
            }

            if ($request->filled('date_to')) {
                $dateTo = Carbon::parse($request->input('date_to'))->endOfDay();
                $query->where('returned_at', '<=', $dateTo);
            }

            // Get statistics
            $statsQuery = clone $query;
            $stats = [
                'today' => $statsQuery->clone()->where('returned_at', '>=', Carbon::today())->count(),
                'month' => $statsQuery->clone()->where('returned_at', '>=', Carbon::now()->startOfMonth())->count(),
                'total' => $statsQuery->clone()->count()
            ];

            $returnedBooks = $query->latest('returned_at')->paginate(10)->withQueryString();

            return view('admin.returned_books', [
                'returnedBooks' => $returnedBooks,
                'stats' => $stats,
                'search' => $request->input('search'),
                'dateFrom' => $request->input('date_from'),
                'dateTo' => $request->input('date_to')
            ]);
        } catch (\Exception $e) {
            Log::error('Error in returnedBooks: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching returned books.');
        }
    }
}
