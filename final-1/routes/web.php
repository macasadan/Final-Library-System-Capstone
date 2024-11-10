<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\PCRoomController;
use App\Http\Controllers\DiscussionRoomController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLostItemController;
use App\Http\Controllers\Admin\AdminPCRoomController;
use App\Http\Controllers\Admin\AdminDiscussionRoomController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Guest Routes (for non-authenticated users)
Route::middleware('guest')->group(function () {
    // The reCAPTCHA validation will work through auth.php routes
});

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('books', AdminBookController::class);
    Route::get('/returned_books', [AdminController::class, 'returnedBooks'])->name('returnedBooks');

    // Discussion room routes
    Route::get('/discussion_rooms', [AdminDiscussionRoomController::class, 'index'])
        ->name('discussion_rooms.index');
    Route::get('/discussion_rooms/create', [AdminDiscussionRoomController::class, 'create'])
        ->name('discussion_rooms.create');
    Route::post('/discussion_rooms', [AdminDiscussionRoomController::class, 'store'])
        ->name('discussion_rooms.store');
    Route::patch('/discussion-rooms/{room}/status', [AdminDiscussionRoomController::class, 'updateStatus'])
        ->name('discussion_rooms.update-status');
    Route::patch('/discussion-rooms/reservations/{reservation}/status', [AdminDiscussionRoomController::class, 'updateReservationStatus'])
        ->name('discussion_rooms.update-status');
    Route::get('/discussion_rooms/expired', [AdminDiscussionRoomController::class, 'expired'])
        ->name('discussion_rooms.expired');
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

    // Lost items routes
    Route::get('/lost-items/report', function () {
        return view('lost_items.report');
    });
    Route::post('/lost-items/report', [LostItemController::class, 'report'])
        ->name('lost_items.report');

    // PC Room routes
    Route::post('/pc-rooms/reserve/{room}', [PCRoomController::class, 'reserve'])
        ->name('pc_rooms.reserve');

    // Discussion Room routes
    Route::get('/reservations', [DiscussionRoomController::class, 'index'])
        ->name('reservations.index');
    Route::get('/reservations/create', [DiscussionRoomController::class, 'create'])
        ->name('reservations.create');
    Route::post('/reservations', [DiscussionRoomController::class, 'store'])
        ->name('reservations.store');
});

// Include auth.php routes (which handle login/registration)
require __DIR__ . '/auth.php';
