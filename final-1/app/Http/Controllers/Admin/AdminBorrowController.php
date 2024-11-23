<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBorrowController extends Controller
{
    public function index()
    {
        $allBorrows = Borrow::where('status', Borrow::STATUS_PENDING)
            ->with(['user', 'book'])
            ->latest()
            ->paginate(10);

        return view('admin.borrows.index', compact('allBorrows'));
    }

    public function pending()
    {
        $pendingBorrows = Borrow::where('status', Borrow::STATUS_PENDING)
            ->with(['user', 'book'])
            ->latest()
            ->paginate(10);

        return view('admin.borrows.pending', compact('pendingBorrows'));
    }

    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $borrow = Borrow::findOrFail($id);

            if ($borrow->status !== Borrow::STATUS_PENDING) {
                return response()->json(['message' => 'This request has already been processed.'], 400);
            }

            $book = Book::findOrFail($borrow->book_id);

            if ($book->quantity <= 0) {
                return response()->json(['message' => 'Book is no longer available.'], 400);
            }

            $book->decrement('quantity');

            $borrow->update([
                'status' => Borrow::STATUS_APPROVED,
                'borrow_date' => now(),
                'due_date' => now()->addDays(14)
            ]);

            DB::commit();
            return response()->json(['message' => 'Borrowing request approved successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        }
    }
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $borrow = Borrow::findOrFail($id);

        if ($borrow->status !== Borrow::STATUS_PENDING) {
            return back()->with('error', 'This request has already been processed.');
        }

        $borrow->update([
            'status' => Borrow::STATUS_REJECTED,
            'rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('success', 'Borrowing request rejected successfully.');
    }
}
