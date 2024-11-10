@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Returned Books</h1>

    <!-- Search and Filter Section -->
    <div class="bg-white p-4 rounded shadow mb-4">
        <form method="GET" action="{{ route('admin.returnedBooks') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input
                    type="text"
                    name="search"
                    placeholder="Search by title or user..."
                    value="{{ request('search') }}"
                    class="w-full px-3 py-2 border rounded">
            </div>
            <div class="flex gap-2">
                <input
                    type="date"
                    name="date_from"
                    value="{{ request('date_from') }}"
                    class="px-3 py-2 border rounded"
                    placeholder="From Date">
                <input
                    type="date"
                    name="date_to"
                    value="{{ request('date_to') }}"
                    class="px-3 py-2 border rounded"
                    placeholder="To Date">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Filter
            </button>
            @if(request()->hasAny(['search', 'date_from', 'date_to']))
            <a href="{{ route('admin.returnedBooks') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Clear Filters
            </a>
            @endif
        </form>
    </div>

    <div class="bg-white p-4 rounded shadow">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="bg-blue-50 p-4 rounded">
                <h3 class="font-bold text-blue-800">Total Returns Today</h3>
                <p class="text-2xl">{{ $returnedBooks->where('returned_at', '>=', \Carbon\Carbon::today())->count() }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded">
                <h3 class="font-bold text-green-800">Total Returns This Month</h3>
                <p class="text-2xl">{{ $returnedBooks->where('returned_at', '>=', \Carbon\Carbon::now()->startOfMonth())->count() }}</p>
            </div>
            <div class="bg-purple-50 p-4 rounded">
                <h3 class="font-bold text-purple-800">All Time Returns</h3>
                <p class="text-2xl">{{ $returnedBooks->count() }}</p>
            </div>
        </div>

        <!-- Returned Books List -->
        <div class="space-y-4">
            @forelse($returnedBooks as $borrow)
            <div class="p-4 bg-gray-50 border rounded hover:bg-gray-100 transition-colors">
                <div class="flex flex-wrap justify-between items-start gap-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800">{{ $borrow->book->title }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                            <div>
                                <p class="text-gray-600"><strong>Author:</strong> {{ $borrow->book->author }}</p>
                                <p class="text-gray-600"><strong>User:</strong> {{ $borrow->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">
                                    <strong>Borrowed:</strong>
                                    {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('Y-m-d H:i') }}
                                </p>
                                <p class="text-gray-600">
                                    <strong>Returned:</strong>
                                    {{ \Carbon\Carbon::parse($borrow->returned_at)->format('Y-m-d H:i') }}
                                    ({{ \Carbon\Carbon::parse($borrow->returned_at)->diffForHumans() }})
                                </p>
                            </div>
                        </div>
                        @if($borrow->return_notes)
                        <p class="mt-2 text-gray-600">
                            <strong>Notes:</strong> {{ $borrow->return_notes }}
                        </p>
                        @endif
                    </div>
                    <div class="bg-green-100 px-3 py-1 rounded-full text-green-800 text-sm">
                        Returned
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500">
                <p class="text-xl">No returned books found.</p>
                @if(request()->hasAny(['search', 'date_from', 'date_to']))
                <p class="mt-2">Try adjusting your search filters.</p>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $returnedBooks->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit form when date inputs change
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.addEventListener('change', () => {
            input.closest('form').submit();
        });
    });
</script>
@endpush
@endsection