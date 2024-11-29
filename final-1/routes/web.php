<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\PCRoomController;
use App\Http\Controllers\DiscussionRoomController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLostItemController;
use App\Http\Controllers\Admin\AdminPCRoomController;
use App\Http\Controllers\Admin\AdminDiscussionRoomController;
use App\Http\Controllers\Admin\AdminBorrowController;
use App\Http\Controllers\SuperAdmin\SuperAdminBookController;
use App\Http\Controllers\SuperAdmin\SuperadminmainnaniController;


// Public Routes
Route::get('/', function () {
    return view('landing');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Guest Routes (for non-authenticated users)
Route::middleware('guest')->group(function () {
    // The reCAPTCHA validation will work through auth.php routes
});

// Super Admin Routes
Route::middleware(['auth', SuperAdminMiddleware::class])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperadminmainnaniController::class, 'dashboard'])->name('dashboard');
    Route::get('/manage-admins', [SuperadminmainnaniController::class, 'manageAdmins'])->name('manage-admins');
    Route::get('/create-admin', [SuperadminmainnaniController::class, 'createAdmin'])->name('create-admin');
    Route::post('/store-admin', [SuperadminmainnaniController::class, 'storeAdmin'])->name('store-admin');
    Route::get('/system-logs', [SuperadminmainnaniController::class, 'systemLogs'])->name('system-logs');
    Route::get('pc-room/session-logs', [SuperadminmainnaniController::class, 'sessionLogs'])
        ->name('session-logs');
    Route::get('/lost-item-logs', [SuperadminmainnaniController::class, 'lostItemLogs'])
        ->name('lost-item-logs');
    Route::get('returned-book-logs', [SuperadminmainnaniController::class, 'returnedBookLogs'])
        ->name('returned-book-logs');
        Route::get('/report-logs', [SuperadminmainnaniController::class, 'reportLogs'])->name('report-logs');
        Route::get('/history', [SuperadminmainnaniController::class, 'discussionRoomHistory'])
    ->name('history');

    // Book routes
    Route::get('/books', [SuperAdminBookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [SuperAdminBookController::class, 'show'])->name('books.show');

});

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Book routes
    Route::resource('books', AdminBookController::class);
    Route::get('/returned_books', [AdminController::class, 'returnedBooks'])->name('returnedBooks');

    // Books Borrow routes
    Route::prefix('borrows')->name('borrows.')->group(function () {
        Route::get('/pending', [AdminBorrowController::class, 'pending'])->name('pending');
        Route::get('/', [AdminBorrowController::class, 'index'])->name('index');
        Route::post('/{id}/approve', [AdminBorrowController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminBorrowController::class, 'reject'])->name('reject');
        Route::get('/borrowed', [AdminBorrowController::class, 'borrowedBooks'])->name('borrowed');
    });


    Route::prefix('discussion-rooms')->name('discussion_rooms.')->group(function () {
        Route::get('/', [AdminDiscussionRoomController::class, 'index'])
            ->name('index');
        Route::get('/create', [AdminDiscussionRoomController::class, 'create'])
            ->name('create');
        Route::post('/', [AdminDiscussionRoomController::class, 'store'])
            ->name('store');
        Route::patch('/{room}/room-status', [AdminDiscussionRoomController::class, 'updateRoomStatus'])
            ->name('update-status');
        Route::patch('/reservations/{reservation}/reservation-status', [AdminDiscussionRoomController::class, 'updateReservationStatus'])
            ->name('reservation-status');
        Route::get('/expired', [AdminDiscussionRoomController::class, 'expired'])
            ->name('expired');
        Route::post('/{room}/end-session', [AdminDiscussionRoomController::class, 'endSession'])
            ->name('end-session');
        Route::get('/active-sessions', [AdminDiscussionRoomController::class, 'getActiveSessions'])
            ->name('active-sessions');
        Route::get('/check-expired', [AdminDiscussionRoomController::class, 'checkExpiredSessions'])
            ->name('check-expired');
        Route::get('/history', [AdminDiscussionRoomController::class, 'history'])
            ->name('history');
            Route::patch('/{room}/room-status', [AdminDiscussionRoomController::class, 'updateRoomStatus'])
            ->name('room-status');
            Route::patch('/{room}/update-status', [AdminDiscussionRoomController::class, 'updateStatus'])
            ->name('update-status');
        
        Route::post('/{room}/end-session', [AdminDiscussionRoomController::class, 'endSession'])
            ->name('end-session');
            
    });
    // PC Room admin routes
    Route::prefix('pc-room')->name('pc-room.')->group(function () {
        Route::get('/dashboard', [AdminPcRoomController::class, 'dashboard'])->name('dashboard');
        Route::post('/approve/{id}', [AdminPcRoomController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [AdminPcRoomController::class, 'reject'])->name('reject');
        Route::post('/end-session/{id}', [AdminPcRoomController::class, 'endSession'])->name('end-session');
    });

    // Lost Items Report
    Route::get('/lost_items', [AdminLostItemController::class, 'index'])->name('lost_items.index');
    Route::get('/lost_items/create', [AdminLostItemController::class, 'create'])->name('lost_items.create');
    Route::post('/lost_items', [AdminLostItemController::class, 'store'])->name('lost_items.store');
    Route::get('/lost_items/{lostItem}', [AdminLostItemController::class, 'show'])->name('lost_items.show');
    Route::patch('/lost_items/{lostItem}/status', [AdminLostItemController::class, 'updateStatus'])->name('lost_items.update-status');
    Route::delete('/lost_items/{lostItem}', [AdminLostItemController::class, 'destroy'])->name('lost_items.destroy');
});


// User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Single dashboard route
    Route::get('/dashboard', [BookController::class, 'dashboard'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Book routes
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::post('/books/borrow/{book}', [BookController::class, 'borrow'])->name('books.borrow');
    Route::get('/borrowed_books', [BookController::class, 'borrowedBooks'])->name('borrowed.books');
    Route::post('/books/return/{borrowId}', [BookController::class, 'returnBook'])->name('books.return');
    Route::get('/books/category/{category}', [BookController::class, 'booksByCategory'])->name('books.category')->where('category', '[0-9]+');
    Route::get('/books/history', [BookController::class, 'borrowingHistory'])->name('books.history');

    // Lost items routes
    Route::get('/lost-items', [LostItemController::class, 'index'])->name('lost_items.index');
    Route::get('/lost-items/{lostItem}', [LostItemController::class, 'show'])->name('lost_items.show');

    // PC Room routes
    Route::prefix('pc-room')->name('pc-room.')->group(function () {
        Route::get('/', [PcRoomController::class, 'index'])->name('index');
        Route::post('/pc-room/request-access', [PcRoomController::class, 'requestAccess'])->name('pc-room.request-access');
        Route::post('/request-access', [PcRoomController::class, 'requestAccess'])->name('request');
        Route::post('/end-session', [PcRoomController::class, 'endSession'])->name('end-session');
    });

    // Discussion Room routes
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [DiscussionRoomController::class, 'index'])->name('index');
        Route::get('/create', [DiscussionRoomController::class, 'create'])->name('create');
        Route::post('/', [DiscussionRoomController::class, 'store'])->name('store');
        Route::post('/check-availability', [DiscussionRoomController::class, 'checkRoomAvailability'])->name('check-availability');
        Route::patch('/{reservations}', [DiscussionRoomController::class, 'update'])->name('update');
    });
    
});

// Include auth.php routes (which handle login/registration)
require __DIR__ . '/auth.php';
