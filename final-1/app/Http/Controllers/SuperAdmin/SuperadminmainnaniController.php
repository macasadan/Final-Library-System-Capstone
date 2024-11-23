<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\PcSession;
use App\Models\DiscussionRoom;
use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SuperadminmainnaniController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalBooks = Book::count();
        $totalAdmins = User::where('is_admin', true)->count(); // Add this line
        $totalDiscussionRooms = DiscussionRoom::count();

        return view('super-admin.dashboard', compact(
            'totalUsers',
            'totalBooks',
            'totalAdmins',
            'totalDiscussionRooms'
        ));
    }

    public function manageAdmins()
    {
        $admins = User::where('is_admin', true)->get();
        return view('super-admin.manage-admins', compact('admins'));
    }

    public function createAdmin()
    {
        return view('super-admin.create-admin');
    }

    public function storeAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $admin = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'is_admin' => true,
        ]);

        Log::info('New admin created', ['admin_id' => $admin->id, 'admin_name' => $admin->name]);

        return redirect()->route('super-admin.manage-admins')
            ->with('success', 'Admin created successfully');
    }

    public function systemLogs()
    {
        // Implement system logs view
        return view('super-admin.system-logs');
    }

    public function userManagement()
    {
        $users = User::where('is_admin', false)->get();
        return view('super-admin.user-management', compact('users'));
    }
    public function books()
    {
        $books = Book::with('category')->paginate(10);
        return view('super-admin.books.index', compact('books'));
    }
    public function sessionLogs()
    {
        $completedSessions = PcSession::with('user')
            ->where('status', 'completed')
            ->orderBy('end_time', 'desc')
            ->get();

        return view('super-admin.session-logs', [
            'completedSessions' => $completedSessions
        ]);
    }
    public function lostItemLogs()
    {
        $lostItemLogs = LostItem::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('super-admin.lost-item-logs', [
            'lostItemLogs' => $lostItemLogs
        ]);
    }
    public function returnedBookLogs()
    {
        $returnedBooks = Borrow::with(['user', 'book'])
            ->whereNotNull('returned_at')
            ->orderBy('returned_at', 'desc')
            ->paginate(10);

        return view('super-admin.returned-book-logs', compact('returnedBooks'));
    }
}
