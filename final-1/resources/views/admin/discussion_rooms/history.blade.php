@extends('layouts.admin')

@section('title', 'Reservation History')
@section('header', 'Reservation History')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <h3 class="text-gray-500 text-sm">Total Reservations</h3>
            <p class="text-2xl font-bold">{{ $stats['total_reservations'] }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <h3 class="text-gray-500 text-sm">Approved</h3>
            <p class="text-2xl font-bold text-green-600">{{ $stats['approved_count'] }}</p>
        </div>
        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
            <h3 class="text-gray-500 text-sm">Rejected</h3>
            <p class="text-2xl font-bold text-red-600">{{ $stats['rejected_count'] }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
            <h3 class="text-gray-500 text-sm">Pending</h3>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_count'] }}</p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="mb-6">
        <form action="{{ route('admin.discussion_rooms.history') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Search by user or room" 
                       class="w-full rounded-md border-gray-300" 
                       value="{{ request('search') }}">
            </div>
            <div class="flex-1">
                <select name="status" class="w-full rounded-md border-gray-300">
                    <option value="">All Statuses</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Filter
            </button>
        </form>
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
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $reservation->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $reservation->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $reservation->discussionRoom->name }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $reservation->purpose }}
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
                        No reservations found
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
@endsection