@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600 mt-2">Manage your library activities and resources from your dashboard.</p>
    </div>

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Search Books Card -->
        <div class="rounded-lg border bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold ml-3 text-red-600">Search Books</h3>
                </div>
                <p class="text-gray-600 mb-4">Find and discover books in our library collections.</p>
                <a href="{{ route('books.search') }}"
                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-red-600 text-white hover:bg-red-700 h-10 px-4 py-2 w-full transition duration-200">
                    Search Collection
                </a>
            </div>
        </div>

        <!-- All Books Card -->
        <div class="rounded-lg border bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="text-xl font-semibold ml-3 text-orange-600">All Books</h3>
                </div>
                <p class="text-gray-600 mb-4">Browse our complete catalog of available books.</p>
                <a href="{{ route('books.index') }}"
                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-orange-600 text-white hover:bg-orange-700 h-10 px-4 py-2 w-full transition duration-200">
                    View Catalog
                </a>
            </div>
        </div>

        <!-- Borrowed Books Card -->
        <div class="rounded-lg border bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-xl font-semibold ml-3 text-blue-600">Borrowed Books</h3>
                </div>
                <p class="text-gray-600 mb-4">View and manage your currently borrowed books.</p>
                <a href="{{ route('borrowed.books') }}"
                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 h-10 px-4 py-2 w-full transition duration-200">
                    View Borrowed
                </a>
            </div>
        </div>

        <!-- Discussion Room Card -->
        <div class="rounded-lg border bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold ml-3 text-red-600">Discussion Room</h3>
                </div>
                <p class="text-gray-600 mb-4">Reserve a room for group discussions and study sessions.</p>
                <a href="{{ route('reservations.index') }}"
                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-red-600 text-white hover:bg-red-700 h-10 px-4 py-2 w-full transition duration-200">
                    Reserve Room
                </a>
            </div>
        </div>

        <!-- PC Room Card -->
        <div class="rounded-lg border bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-xl font-semibold ml-3 text-orange-600">PC Room</h3>
                </div>
                <p class="text-gray-600 mb-4">Book a computer station for your research or study.</p>
                <a href="{{ route('pc-room.index') }}"
                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-orange-600 text-white hover:bg-orange-700 h-10 px-4 py-2 w-full transition duration-200">
                    Book PC
                </a>
            </div>
        </div>

        <!-- Lost Items Card -->
        <div class="rounded-lg border bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945" />
                    </svg>
                    <h3 class="text-xl font-semibold ml-3 text-blue-600">Lost Items</h3>
                </div>
                <p class="text-gray-600 mb-4">Report or search for lost items in the library.</p>
                <a href="{{ route('lost_items.index') }}"
                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 h-10 px-4 py-2 w-full transition duration-200">
                    View Lost Items
                </a>
            </div>
        </div>
    </div>

    <!-- Borrowed Books Section -->
    <div class="rounded-lg border bg-white shadow-sm">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Currently Borrowed Books</h2>
                <a href="{{ route('borrowed.books') }}"
                    class="text-blue-600 hover:text-blue-700 text-sm font-medium transition duration-200">
                    View All →
                </a>
            </div>
            <div class="space-y-4">
                @forelse($borrowedBooks as $borrow)
                <div class="p-4 rounded-lg bg-gray-50 border hover:border-red-200 transition-colors duration-200">
                    <div class="grid gap-2">
                        <div class="flex justify-between items-start">
                            <h3 class="font-semibold text-red-600">{{ $borrow->book->title }}</h3>
                            <span class="text-sm px-3 py-1 rounded-full {{ \Carbon\Carbon::parse($borrow->due_date)->isPast() ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600' }}">
                                Due: {{ \Carbon\Carbon::parse($borrow->due_date)->format('M d, Y') }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">By {{ $borrow->book->author }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">
                                Borrowed on {{ \Carbon\Carbon::parse($borrow->borrowed_date)->format('M d, Y') }}
                            </span>
                            @if(\Carbon\Carbon::parse($borrow->due_date)->isPast())
                            <span class="text-sm text-red-600 font-medium">Overdue</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <p class="mt-4 text-gray-500">No borrowed books found.</p>
                    <a href="{{ route('books.search') }}"
                        class="inline-flex items-center justify-center mt-4 text-sm text-blue-600 hover:text-blue-700">
                        Browse Available Books →
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection