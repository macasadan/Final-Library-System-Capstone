@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">All Borrowed Books</h2>
        <div class="flex space-x-4">
            <select id="statusFilter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                <option value="">All Status</option>
                <option value="approved">Approved</option>
                <option value="returned">Returned</option>
            </select>
            <input type="text" id="search" placeholder="Search by title or student name"
                class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book & Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($allBorrows as $borrow)
                @if($borrow->status === 'approved' || $borrow->status === 'returned')
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $borrow->book->title }}</div>
                        <div class="text-sm text-gray-500">
                            Student: {{ $borrow->user->name }} ({{ $borrow->id_number }})
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        @if($borrow->status === 'approved') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($borrow->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $borrow->borrow_date ? $borrow->borrow_date->format('M d, Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $borrow->due_date ? $borrow->due_date->format('M d, Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $borrow->returned_at ? $borrow->returned_at->format('M d, Y') : '-' }}
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $allBorrows->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Add event listeners for filtering and search
    document.getElementById('statusFilter').addEventListener('change', function() {
        // Implement status filtering
    });

    document.getElementById('search').addEventListener('input', function() {
        // Implement search functionality
    });
</script>
@endpush
@endsection