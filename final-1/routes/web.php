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

// Public Routes
Route::get('/', function () {
    return view('welcome');
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
        Route::get('admin/returned-books', [ReturnedBooksController::class, 'index'])->name('admin.returnedBooks');
    });



    // Discussion room routes
    Route::get('/discussion_rooms', [AdminDiscussionRoomController::class, 'index'])
        ->name('discussion_rooms.index');
    Route::get('/discussion_rooms/create', [AdminDiscussionRoomController::class, 'create'])
        ->name('discussion_rooms.create');
    Route::post('/discussion_rooms', [AdminDiscussionRoomController::class, 'store'])
        ->name('discussion_rooms.store');
    Route::patch('/discussion-rooms/{room}/room-status', [AdminDiscussionRoomController::class, 'updateRoomStatus'])
        ->name('discussion_rooms.update-status');
    Route::patch('/discussion-rooms/reservations/{reservation}/reservation-status', [AdminDiscussionRoomController::class, 'updateReservationStatus'])
        ->name('discussion_rooms.reservation-status');
    Route::get('/discussion_rooms/expired', [AdminDiscussionRoomController::class, 'expired'])
        ->name('discussion_rooms.expired');
    Route::post('/discussion-rooms/{room}/end-session', [AdminDiscussionRoomController::class, 'endSession'])
        ->name('discussion_rooms.end-session');

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
    Route::get('/reservations', [DiscussionRoomController::class, 'index'])
        ->name('reservations.index');
    Route::get('/reservations/create', [DiscussionRoomController::class, 'create'])
        ->name('reservations.create');
    Route::post('/reservations', [DiscussionRoomController::class, 'store'])
        ->name('reservations.store');
    Route::post('/reservations/check-availability', [DiscussionRoomController::class, 'checkRoomAvailability'])
        ->name('reservations.check-availability');
});

// Include auth.php routes (which handle login/registration)
require __DIR__ . '/auth.php';
