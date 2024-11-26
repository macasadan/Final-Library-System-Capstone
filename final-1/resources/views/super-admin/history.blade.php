@extends('layouts.superadmin')
@section('title', 'Discussion Room Reservation History')
@section('header', 'Discussion Room Reservation Logs')
@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg border border-gray-200 flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Total Reservations</h3>
                <p class="text-2xl font-bold">{{ $stats['total_reservations'] }}</p>
            </div>
            <i class="fas fa-book-open text-gray-400 text-3xl"></i>
        </div>
        <div class="bg-green-50 p-4 rounded-lg border border-green-200 flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Approved</h3>
                <p class="text-2xl font-bold text-green-600">{{ $stats['approved_count'] }}</p>
            </div>
            <i class="fas fa-check-circle text-green-400 text-3xl"></i>
        </div>
        <div class="bg-red-50 p-4 rounded-lg border border-red-200 flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Rejected</h3>
                <p class="text-2xl font-bold text-red-600">{{ $stats['rejected_count'] }}</p>
            </div>
            <i class="fas fa-times-circle text-red-400 text-3xl"></i>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Pending</h3>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_count'] }}</p>
            </div>
            <i class="fas fa-hourglass-half text-yellow-400 text-3xl"></i>
        </div>
    </div>
    <!-- Advanced Filter Form -->
<div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
    <form action="{{ route('super-admin.history') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Search Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" placeholder="User, Room, Purpose" 
                   class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" 
                   value="{{ request('search') }}">
        </div>

        <!-- Status Dropdown -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Statuses</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>

        <!-- Start Date -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
            <input type="date" name="start_date" 
                   class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                   value="{{ request('start_date') }}">
        </div>

        <!-- End Date -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
            <input type="date" name="end_date" 
                   class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                   value="{{ request('end_date') }}">
        </div>

        <!-- Filter Button -->
        <div class="flex items-end">
            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <i class="fas fa-filter mr-2"></i>Apply Filters
            </button>
        </div>

        <!-- Reset Button -->
        <div class="flex items-end">
            <a href="{{ route('super-admin.history') }}" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-center">
                <i class="fas fa-redo mr-2"></i>Reset Filters
            </a>
        </div>
    </form>
</div>
<div class="flex items-end">
    <button id="downloadPdf" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
        <i class="fas fa-download mr-2"></i>Download PDF
    </button>
</div>

<!-- Reservations Table -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($reservations as $reservation)
            <tr class="hover:bg-gray-50 transition duration-200">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $reservation->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $reservation->user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $reservation->discussionRoom->name }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    {{ $reservation->purpose ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $reservation->start_time->format('M d, Y H:i') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $reservation->end_time->format('M d, Y H:i') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($reservation->status === 'approved') bg-green-100 text-green-800
                        @elseif($reservation->status === 'rejected') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucfirst($reservation->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $reservation->created_at->format('M d, Y H:i') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                        <i class="fas fa-exclamation-circle text-4xl text-gray-300 mb-4"></i>
                        <p>No reservations found matching your search criteria</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $reservations->links() }}
</div>
</div>
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endpush
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
<script>
document.getElementById('downloadPdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape');
    
    // Add title
    doc.setFontSize(18);
    doc.text('Discussion Room Reservation History', 14, 20);
    
    // Create table data
    const tableData = Array.from(document.querySelectorAll('table tbody tr:not(.empty-row)'))
        .map(row => {
            const cells = row.querySelectorAll('td');
            return [
                cells[0].textContent.trim(), // User
                cells[1].textContent.trim(), // Room
                cells[2].textContent.trim(), // Purpose
                cells[3].textContent.trim(), // Start Time
                cells[4].textContent.trim(), // End Time
                cells[5].textContent.trim(), // Status
                cells[6].textContent.trim()  // Created At
            ];
        });

    // Generate table
    doc.autoTable({
        startY: 30,
        head: [['User', 'Room', 'Purpose', 'Start Time', 'End Time', 'Status', 'Created At']],
        body: tableData,
        theme: 'striped',
        styles: { fontSize: 10 },
        headStyles: { fillColor: [79, 70, 229], textColor: 255 } // Indigo color to match theme
    });

    // Save the PDF
    doc.save('discussion_room_reservations.pdf');
});
</script>
@endpush
