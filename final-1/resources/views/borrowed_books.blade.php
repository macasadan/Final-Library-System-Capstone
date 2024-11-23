@extends('layouts.app')

@section('content')
<div class="flex-1 min-h-screen bg-gray-50">
    <div class="p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Borrowed Books</h1>
            <p class="mt-2 text-gray-600">Manage your currently borrowed books and returns</p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="mb-6">
            <div class="px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
        @endif

        <!-- Borrowed Books List -->
        <div class="overflow-hidden bg-white rounded-lg shadow">
            @forelse($borrowedBooks as $borrow)
            <div id="borrowed-book-{{ $borrow->id }}"
                class="p-6 transition-colors border-b border-gray-200 hover:bg-gray-50">
                <div class="flex items-start justify-between">
                    <div class="flex-1 space-y-4">
                        <!-- Book Details -->
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $borrow->book->title }}</h3>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Author</span>
                                    <p class="mt-1 text-gray-900">{{ $borrow->book->author }}</p>
                                </div>
                                <div>
                                    @if($borrow->book->categories->isNotEmpty())
                                    <span class="text-sm font-medium text-gray-500">Categories</span>
                                    <p class="mt-1 text-gray-900">
                                        @foreach($borrow->book->categories as $category)
                                        {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </p>
                                    @endif
                                </div>

                                <!-- Student Information -->
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Student ID</span>
                                    <p class="mt-1 text-gray-900">{{ $borrow->id_number }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Course</span>
                                    <p class="mt-1 text-gray-900">{{ $borrow->course }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Department</span>
                                    <p class="mt-1 text-gray-900">{{ $borrow->department }}</p>
                                </div>

                                <!-- Borrowing Dates -->
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Borrowed Date</span>
                                    <p class="mt-1 text-gray-900">
                                        {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('M d, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Due Date</span>
                                    <p class="mt-1 {{ \Carbon\Carbon::parse($borrow->due_date)->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ \Carbon\Carbon::parse($borrow->due_date)->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div class="flex items-center mt-2">
                                <span class="text-sm font-medium text-gray-500 mr-2">Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $borrow->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($borrow->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($borrow->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Return Button -->
                    @if($borrow->isApproved())
                    <div class="ml-4">
                        <button
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200 return-book-btn"
                            data-borrow-id="{{ $borrow->id }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                            Return Book
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="flex items-center justify-center p-6 text-center">
                <div class="max-w-sm">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <p class="mt-4 text-lg font-medium text-gray-900">No borrowed books</p>
                    <p class="mt-2 text-gray-500">You haven't borrowed any books yet.</p>
                    <a href="{{ route('books.search') }}"
                        class="inline-flex items-center justify-center px-4 py-2 mt-6 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Browse Books
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.return-book-btn').forEach(button => {
            button.addEventListener('click', function() {
                const borrowId = this.getAttribute('data-borrow-id');

                if (confirm('Are you sure you want to return this book?')) {
                    fetch(`/books/return/${borrowId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Smooth removal animation
                                const bookElement = document.getElementById(`borrowed-book-${data.borrow_id}`);
                                if (bookElement) {
                                    bookElement.style.transition = 'all 0.3s ease-out';
                                    bookElement.style.opacity = '0';
                                    bookElement.style.transform = 'translateX(-100%)';
                                    setTimeout(() => {
                                        bookElement.remove();
                                        // Check if no more books
                                        if (document.querySelectorAll('[id^="borrowed-book-"]').length === 0) {
                                            location.reload(); // Reload to show empty state
                                        }
                                    }, 300);
                                }
                                // Show success notification
                                const notification = document.createElement('div');
                                notification.className = 'fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50';
                                notification.textContent = data.success;
                                document.body.appendChild(notification);
                                setTimeout(() => {
                                    notification.style.transition = 'all 0.3s ease-out';
                                    notification.style.opacity = '0';
                                    setTimeout(() => notification.remove(), 300);
                                }, 3000);
                            } else {
                                alert(data.error || 'An error occurred while returning the book.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while returning the book. Please try again.');
                        });
                }
            });
        });
    });
</script>
@endpush
@endsection