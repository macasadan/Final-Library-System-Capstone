@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Search Books</h2>
        <form action="{{ route('books.search') }}" method="GET" class="mb-6">
            <div class="flex gap-2">
                <input
                    type="text"
                    name="query"
                    class="flex-1 rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Search by title or author"
                    value="{{ request('query') }}"
                    required>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Search
                </button>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        {{ session('error') }}
    </div>
    @endif

    @if(isset($books) && $books->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($books as $book)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h5 class="text-xl font-semibold text-gray-900 mb-2">{{ $book->title }}</h5>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><span class="font-semibold">Author:</span> {{ $book->author }}</p>
                    @if($book->category)
                    <p>
                        <span class="font-semibold">Category:</span>
                        <a href="{{ route('books.category', ['category' => $book->category->id]) }}"
                            class="text-blue-600 hover:underline">
                            {{ $book->category->name }}
                        </a>
                    </p>
                    @endif
                    <p><span class="font-semibold">Available Copies:</span> {{ $book->quantity }}</p>
                </div>

                @if($book->quantity > 0)
                <button type="button"
                    class="w-full mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                    data-bs-toggle="modal"
                    data-bs-target="#borrowModal{{ $book->id }}">
                    Borrow
                </button>
                @else
                <button class="w-full mt-4 px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed" disabled>
                    Out of Stock
                </button>
                @endif
            </div>
        </div>

        <!-- Borrow Modal -->
        <div class="modal fade" id="borrowModal{{ $book->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="bg-white rounded-lg shadow-lg">
                    <div class="p-6">
                        <h5 class="text-xl font-semibold mb-4">Borrow "{{ $book->title }}"</h5>
                        <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500" data-bs-dismiss="modal">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <form action="{{ route('books.borrow', $book->id) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="id_number{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        ID Number
                                    </label>
                                    <input type="text"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('id_number') border-red-500 @enderror"
                                        id="id_number{{ $book->id }}"
                                        name="id_number"
                                        required>
                                    @error('id_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="course{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        Course
                                    </label>
                                    <input type="text"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('course') border-red-500 @enderror"
                                        id="course{{ $book->id }}"
                                        name="course"
                                        required>
                                    @error('course')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="department{{ $book->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        Department
                                    </label>
                                    <select class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('department') border-red-500 @enderror"
                                        id="department{{ $book->id }}"
                                        name="department"
                                        required>
                                        <option value="">Select Department</option>
                                        <option value="COT">College of Technology (COT)</option>
                                        <option value="COE">College of Engineering (COE)</option>
                                        <option value="CEAS">College of Education, Arts and Sciences (CEAS)</option>
                                        <option value="CME">College of Management and Economics (CME)</option>
                                    </select>
                                    @error('department')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button"
                                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
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
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg">
        No books found matching your search.
    </div>
    @endif
</div>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var bookId = document.querySelector('input[name="book_id"]').value;
        var errorModal = document.querySelector('[data-bs-target="#borrowModal' + bookId + '"]');
        if (errorModal) {
            new bootstrap.Modal(document.querySelector('#borrowModal' + bookId)).show();
        }
    });
</script>
@endif
@endsection