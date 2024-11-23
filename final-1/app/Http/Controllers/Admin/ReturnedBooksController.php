<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReturnedBooksController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrow::with(['book', 'user'])
            ->whereNotNull('returned_at');

        // Handle search
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');

            // Sanitize search term
            $searchTerm = trim($searchTerm);

            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('book', function ($bookQuery) use ($searchTerm) {
                    $bookQuery->where('title', 'like', "%{$searchTerm}%")
                        ->orWhere('author', 'like', "%{$searchTerm}%")
                        ->orWhere('isbn', 'like', "%{$searchTerm}%");
                })
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', "%{$searchTerm}%")
                            ->orWhere('email', 'like', "%{$searchTerm}%");
                    })
                    ->orWhere('id_number', 'like', "%{$searchTerm}%")
                    ->orWhere('course', 'like', "%{$searchTerm}%")
                    ->orWhere('department', '=', $searchTerm); // Exact match for department
            });
        }

        // Handle date range filtering
        if ($request->filled('date_from')) {
            try {
                $dateFrom = Carbon::parse($request->input('date_from'));
                $query->where('returned_at', '>=', $dateFrom);
            } catch (\Exception $e) {
                Log::error('Invalid date_from value: ' . $request->input('date_from'));
            }
        }

        if ($request->filled('date_to')) {
            try {
                $dateTo = Carbon::parse($request->input('date_to'));
                $query->where('returned_at', '<=', $dateTo);
            } catch (\Exception $e) {
                Log::error('Invalid date_to value: ' . $request->input('date_to'));
            }
        }

        $returnedBooks = $query->paginate(10);

        return view('admin.returned_books.index', compact('returnedBooks'));
    }
}
