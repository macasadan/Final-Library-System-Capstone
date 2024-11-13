@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Pending Borrow Requests</h2>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($pendingBorrows->isEmpty())
        <div class="p-6 text-center text-gray-500">
            No pending borrow requests found.
        </div>
        @else
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($pendingBorrows as $borrow)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $borrow->user->name }}</div>
                        <div class="text-sm text-gray-500">ID: {{ $borrow->id_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $borrow->book->title }}</div>
                        <div class="text-sm text-gray-500">ISBN: {{ $borrow->book->isbn }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $borrow->course }}</div>
                        <div class="text-sm text-gray-500">{{ $borrow->department }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $borrow->created_at->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="approveBorrow(this.dataset.borrowId)"
                            class="text-green-600 hover:text-green-900 mr-3" data-borrow-id="{{ $borrow->id }}">Approve</button>
                        <button onclick="showRejectModal(this.dataset.borrowId)"
                            class="text-red-600 hover:text-red-900" data-borrow-id="{{ $borrow->id }}">Reject</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $pendingBorrows->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Borrow Request</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for rejection</label>
                    <textarea name="rejection_reason"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                        rows="3" required></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideRejectModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function approveBorrow(id) {
        console.log('Approve borrow request called with id:', id);
        if (confirm('Are you sure you want to approve this borrow request?')) {
            console.log('Sending request to approve borrow...');
            fetch(`/admin/borrows/${id}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response received:', response);
                    if (response.status === 200) {
                        location.reload();
                    } else {
                        return response.json().then(data => {
                            alert(data.message || 'Error approving request');
                        });
                    }
                })
                .catch(error => {
                    console.error('Error approving borrow:', error);
                    alert('An error occurred while approving the borrow request. Please try again later.');
                });
        }
    }

    function showRejectModal(id) {
        document.getElementById('rejectForm').action = `/admin/borrows/${id}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function hideRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endpush
@endsection