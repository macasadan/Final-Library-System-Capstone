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
                                    <form action="{{ route('admin.discussion_rooms.reservation-status', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.discussion_rooms.reservation-status', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
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
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                @if(!empty($roomDropdown))
                <div class="mb-4">
                    <label for="admin_room_select" class="block text-sm font-medium text-gray-700">
                        Select Discussion Room
                    </label>
                    <select
                        id="admin_room_select"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">All Rooms</option>
                        @foreach($roomDropdown as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($rooms as $room)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $room->name }}</div>
                            <div class="text-sm text-gray-500">Capacity: {{ $room->capacity }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $room->getStatusColorClass() }}">
                                {{ $room->getStatusLabel() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                @if($room->availability_status === 'occupied')
                                <form action="{{ route('admin.discussion_rooms.room-status', $room) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $room->status === 'available' ? 'maintenance' : 'available' }}">
                                    <button type="submit" class="inline-flex items-center px-3 py-1 rounded-md text-white 
                                        {{ $room->status === 'available' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }}">
                                        {{ $room->status === 'available' ? 'Set Maintenance' : 'Set Available' }}
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.discussion_rooms.update-status', $room) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $room->status === 'available' ? 'maintenance' : 'available' }}">
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white {{ $room->status === 'available' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ $room->status === 'available' ? 'Set Maintenance' : 'Set Available' }}
                                    </button>
                                </form>
                                @if($room->availability_status === 'occupied')
                                <form action="{{ route('admin.discussion_rooms.end-session', $room) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        End Session
                                    </button>
                                </form>
                                @endif
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.getElementById('admin_room_select');
        const tableRows = document.querySelectorAll('tbody tr');

        roomSelect.addEventListener('change', function() {
            const selectedRoomId = this.value;

            tableRows.forEach(row => {
                if (selectedRoomId === '' || row.getAttribute('data-room-id') === selectedRoomId) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>