<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Admin Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Books Management Section -->
        <div class="p-6 bg-green-100 rounded-lg shadow-md border border-green-300">
            <h3 class="text-xl font-semibold text-gray-700">Books Management</h3>
            <p class="text-gray-600 mt-1">Oversee library books: Add, update, or remove books from the collection.</p>
            <a href="{{ route('admin.books.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Manage Books
            </a>
        </div>

        <!-- Returned Books Section -->
        <div class="p-6 bg-yellow-100 rounded-lg shadow-md border border-yellow-300">
            <h3 class="text-xl font-semibold text-gray-700">Returned Books</h3>
            <p class="text-gray-600 mt-1">Monitor books that have been returned by users.</p>
            <a href="{{ route('admin.returnedBooks') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                View Returned Books
            </a>
        </div>

        <!-- Discussion Rooms Management Section -->
        <div class="p-6 bg-purple-100 rounded-lg shadow-md border border-purple-300">
            <h3 class="text-xl font-semibold text-gray-700">Discussion Rooms</h3>
            <p class="text-gray-600 mt-1">Manage and update the status of discussion rooms.</p>
            <a href="{{ route('admin.discussion_rooms.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Manage Rooms
            </a>
        </div>

        <!-- Reservations and Notifications Section -->
        <div class="p-6 bg-orange-100 rounded-lg shadow-md border border-orange-300">
            <h3 class="text-xl font-semibold text-gray-700">Room Reservations</h3>
            <p class="text-gray-600 mt-1">Check active room reservations and expired notifications.</p>
            <a href="{{ route('admin.discussion_rooms.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                View Reservations
            </a>
            @isset($expiredReservations)
            @if($expiredReservations->count() > 0)
            <p class="mt-4 text-red-600 font-semibold">
                {{ $expiredReservations->count() }} reservations have expired!
            </p>
            @endif
            @endisset
        </div>
    </div>
</div>
@endsection