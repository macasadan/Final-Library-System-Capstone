@extends('layouts.app')

@section('content')
<div class="flex-1 min-h-screen bg-gray-50">
    <!-- Main Content Area -->
    <div class="p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Search Books</h1>
            <p class="mt-2 text-gray-600">Find and borrow books from our library collection</p>
        </div>

        <!-- Search Form -->
        <div class="mb-8">
            <form action="{{ route('books.search') }}" method="GET" class="max-w-3xl">
                <div class="flex gap-3">
                    <input
                        type="text"
                        name="query"
                        class="flex-1 px-4 py-2.5 text-black bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search by title, author, or category..."
                        value="{{ request('query') }}"
                        required>
                    <button type="submit" class="px-6 py-2.5 text-black bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="mb-6">
            <div class="px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6">
            <div class="px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded-lg">
                {{ session('error') }}
            </div>
        </div>
        @endif

        <!-- Search Results -->
        @if(isset($books) && $books->count() > 0)
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($books as $book)
            <div class="overflow-hidden transition-all duration-200 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md hover:border-blue-200">
                <div class="p-6">
                    <h3 class="mb-2 text-xl font-semibold text-gray-900">{{ $book->title }}</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p class="flex items-center gap-2">
                            <span class="font-medium">Author:</span>
                            {{ $book->author }}
                        </p>
                        @if($book->categories->isNotEmpty())
                        <p class="flex items-center gap-2">
                            <span class="font-medium">Categories:</span>
                            @foreach($book->categories as $category)
                            <a href="{{ route('books.category', ['category' => $category->id]) }}"
                                class="text-blue-600 hover:underline">
                                {{ $category->name }}
                            </a>
                            @if(!$loop->last), @endif
                            @endforeach
                        </p>
                        @endif
                        <p class="flex items-center gap-2">
                            <span class="font-medium">Available Copies:</span>
                            <span class="px-2 py-1 text-sm text-blue-700 bg-blue-100 rounded-full">
                                {{ $book->quantity }}
                            </span>
                        </p>
                    </div>

                    @if($book->quantity > 0)
                    <button type="button"
                        class="w-full px-4 py-2 mt-4 text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        data-bs-toggle="modal"
                        data-bs-target="#borrowModal{{ $book->id }}">
                        Borrow Book
                    </button>
                    @else
                    <button class="w-full px-4 py-2 mt-4 text-gray-500 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed" disabled>
                        Out of Stock
                    </button>
                    @endif
                </div>
            </div>

            <!-- Borrow Modal -->
            <!-- Borrow Modal -->
            <div class="modal fade" id="borrowModal{{ $book->id }}" tabindex="-1" aria-labelledby="borrowModalLabel{{ $book->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-white rounded-lg shadow-xl">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-semibold text-gray-900" id="borrowModalLabel{{ $book->id }}">Borrow "{{ $book->title }}"</h3>
                                <button type="button" class="text-gray-400 hover:text-gray-500" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <form action="{{ route('books.borrow', $book->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="id_number{{ $book->id }}" class="block mb-1 text-sm font-medium text-gray-700">
                                        ID Number
                                    </label>
                                    <input type="text"
                                        id="id_number{{ $book->id }}"
                                        name="id_number"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <div>
                                    <label for="course{{ $book->id }}" class="block mb-1 text-sm font-medium text-gray-700">
                                        Course
                                    </label>
                                    <input type="text"
                                        id="course{{ $book->id }}"
                                        name="course"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <div>
                                    <label for="department{{ $book->id }}" class="block mb-1 text-sm font-medium text-gray-700">
                                        Department
                                    </label>
                                    <select id="department{{ $book->id }}"
                                        name="department"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="">Select Department</option>
                                        <option value="COT">College of Technology (COT)</option>
                                        <option value="COE">College of Engineering (COE)</option>
                                        <option value="CEAS">College of Education, Arts and Sciences (CEAS)</option>
                                        <option value="CME">College of Management and Economics (CME)</option>
                                    </select>
                                </div>

                                <div class="flex justify-end gap-3 mt-6">
                                    <button type="button"
                                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                                        data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Confirm Borrow
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @elseif(isset($books))
        <div class="p-4 text-blue-700 bg-blue-100 border border-blue-200 rounded-lg">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>No books found matching your search criteria.</span>
            </div>
        </div>
        @endif
    </div>
</div>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookId = document.querySelector('input[name="book_id"]')?.value;
        if (bookId) {
            const modal = new bootstrap.Modal(document.querySelector('#borrowModal' + bookId));
            modal.show();
        }
    });
</script>
@endif
@endsection