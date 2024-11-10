<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">User Dashboard</h1>

    <div class="grid grid-cols-2 gap-6 mb-8">
        <!-- Search Books -->
        <a href="{{ route('books.search') }}" class="block p-4 bg-blue-500 text-white text-center rounded-lg hover:bg-blue-700">
            Search Books
        </a>

        <!-- Borrowed Books -->
        <a href="{{ route('borrowed.books') }}" class="block p-4 bg-green-500 text-white text-center rounded-lg hover:bg-green-700">
            View Borrowed Books
        </a>

        <!-- Reserve a Book -->
        <a href="{{ route('reservations.index') }}" class="block p-4 bg-yellow-500 text-white text-center rounded-lg hover:bg-yellow-700">
            Reserve a Discussion Room
        </a>

        <!-- Reserve PC Room -->
        <a href="#" class="block p-4 bg-indigo-500 text-white text-center rounded-lg hover:bg-indigo-700">
            Reserve PC Room
        </a>

        <!-- Report Lost Items -->
        <a href="{{ route('lost_items.report') }}" class="block p-4 bg-red-500 text-white text-center rounded-lg hover:bg-red-700">
            Report Lost Items
        </a>

        <!-- View Available Books -->
        <a href="{{ route('books.index') }}" class="block p-4 bg-purple-500 text-white text-center rounded-lg hover:bg-purple-700">
            View Available Books
        </a>
    </div>



    <!-- Borrowed Books Section -->
    <h2 class="text-xl font-semibold mb-2">Borrowed Books</h2>
    <div class="bg-white p-4 rounded shadow">
        @forelse($borrowedBooks as $borrow)
        <div class="p-2 bg-green-100 border-b">
            <p><strong>Title:</strong> {{ $borrow->book->title }}</p>
            <p><strong>Author:</strong> {{ $borrow->book->author }}</p>
            <p><strong>Borrowed Date:</strong> {{ \Carbon\Carbon::parse($borrow->borrowed_date)->format('Y-m-d') }}</p>
            <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($borrow->due_date)->format('Y-m-d') }}</p>
        </div>
        @empty
        <p>No borrowed books found.</p>
        @endforelse

        <!-- Show more link if there are more borrowed books -->
        <div class="mt-2 text-right">
            <a href="{{ route('borrowed.books') }}" class="text-blue-500 hover:underline">View All Borrowed Books</a>
        </div>
    </div>
</div>
</div>
@endsection