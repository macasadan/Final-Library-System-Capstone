<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
 

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Books Management Section -->
        <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-green-500">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Books Management
                    </h3>
                </div>
                <p class="text-gray-600 mb-4">Oversee library books: Add, update, or remove books from the collection.</p>
                <a href="{{ route('admin.books.index') }}" class="w-full block text-center bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
                    Manage Books
                </a>
            </div>
        </div>

        <!-- Borrowed Books Management Section -->
        <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-blue-500">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h16M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        Borrowed Books
                    </h3>
                </div>
                <p class="text-gray-600 mb-4">Manage book borrowing requests and track borrowed books.</p>
                <div class="space-y-2">
                    <a href="{{ route('admin.borrows.pending') }}" class="w-full block text-center bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition-colors relative">
                        Pending Requests
                        @if(isset($pendingCount) && $pendingCount > 0)
                        <span class="absolute top-0 right-0 -mt-2 -mr-2 bg-red-500 text-white text-xs rounded-full px-2 py-1">
                            {{ $pendingCount }}
                        </span>
                        @endif
                    </a>
                    <a href="{{ route('admin.borrows.borrowed') }}" class="w-full block text-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                        All Borrowed Books
                    </a>
                </div>
            </div>
        </div>

        <!-- Discussion Rooms Management Section -->
        <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-purple-500">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Discussion Rooms
                    </h3>
                </div>
                <p class="text-gray-600 mb-4">Manage and update the status of discussion rooms.</p>
                <a href="{{ route('admin.discussion_rooms.index') }}" class="w-full block text-center bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition-colors">
                    Manage Rooms
                </a>
            </div>
        </div>

        <!-- Reservations Section -->
        <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-orange-500">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Room Reservations
                    </h3>
                </div>
                <p class="text-gray-600 mb-4">Check active room reservations and expired notifications.</p>
                <a href="{{ route('admin.discussion_rooms.index') }}" class="w-full block text-center bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 transition-colors">
                    View Reservations
                </a>
                @isset($expiredReservations)
                @if($expiredReservations->count() > 0)
                <div class="mt-4 bg-red-100 border-l-4 border-red-500 p-3 rounded">
                    <p class="text-red-700 font-semibold">
                        {{ $expiredReservations->count() }} reservations have expired!
                    </p>
                </div>
                @endif
                @endisset
            </div>
        </div>

        <!-- Lost Item Management Section -->
        <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-red-500">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Lost Item Management
                    </h3>
                </div>
                <p class="text-gray-600 mb-4">Manage reported lost items and create new reports.</p>
                <div class="space-y-2">
                    <a href="{{ route('admin.lost_items.index') }}" class="w-full block text-center bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                        View Lost Items
                    </a>
                    <a href="{{ route('admin.lost_items.create') }}" class="w-full block text-center bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
                        Report Lost Item
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection