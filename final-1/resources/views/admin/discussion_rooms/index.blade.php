@extends('layouts.admin')

@section('title', 'Discussion Room Management')
@section('header', 'Discussion Room Management')

@section('content')
<div class="space-y-6">
    <!-- Pending Reservations Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Discussion Room Management</h2>
            <a href="{{ route('admin.discussion_rooms.expired') }}"
                class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition-colors">
                View Expired Reservations ({{ $expiredReservations }})
            </a>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Pending Reservations</h3>
            @if($pendingReservations->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pendingReservations as $reservation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->discussionRoom->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->start_time->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->end_time->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->purpose }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <form action="{{ route('admin.discussion_rooms.update-status', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit"
                                            class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition-colors">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.discussion_rooms.update-status', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-center py-4">No pending reservations.</p>
            @endif
        </div>

        <!-- Discussion Rooms List -->
        <div class="mt-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Discussion Rooms</h3>
                <a href="{{ route('admin.discussion_rooms.create') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                    Add New Room
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($rooms as $room)
                <div class="border rounded-lg p-4 bg-white shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">{{ $room->name }}</h4>
                            <p class="text-gray-600">Capacity: {{ $room->capacity }} people</p>
                        </div>
                        <div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $room->getStatusColorClass() }}">
                                {{ $room->getStatusLabel() }}
                            </span>
                        </div>
                    </div>

                    @if($room->availability_status === 'occupied')
                    @php
                    $currentReservation = $room->getCurrentReservation();
                    @endphp
                    @if($currentReservation)
                    <div class="mt-3 p-3 bg-gray-50 rounded-md">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Current Session:</span><br>
                            Ends at: {{ $currentReservation->end_time->format('h:i A') }}<br>
                            Purpose: {{ Str::limit($currentReservation->purpose, 50) }}
                        </p>
                    </div>
                    @endif
                    @endif

                    @if($room->status === 'maintenance')
                    <div class="mt-3 p-2 bg-yellow-50 rounded border border-yellow-200">
                        <p class="text-sm text-yellow-800">
                            This room is currently under maintenance
                        </p>
                    </div>
                    @endif

                    @if(auth()->user()->isAdmin)
                    <div class="mt-3">
                        <form action="{{ route('admin.discussion_rooms.update-status', $room) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="status"
                                onchange="this.form.submit()"
                                class="text-sm rounded border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200">
                                <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>
                                    Set Available
                                </option>
                                <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>
                                    Set Maintenance
                                </option>
                            </select>
                        </form>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection