@extends('layouts.app')
@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-red-600 via-orange-500 to-blue-600 bg-clip-text text-transparent">
                Discussion Rooms
            </h1>
            <p class="mt-2 text-gray-600">Manage your discussion room reservations</p>
        </div>

        <!-- Action Button -->
        <div class="mb-6">
            <a href="{{ route('reservations.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 text-white font-semibold rounded-lg shadow-sm transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Reservation
            </a>
        </div>

        <!-- Available Rooms -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Discussion Rooms</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($rooms as $room)
                    <div class="border rounded-lg p-4 relative">
                        <!-- Room Header -->
                        <div class="flex justify-between items-start">
                            <h3 class="font-semibold text-lg">{{ $room->name }}</h3>
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
    {{ $room->availability_status === 'occupied' ? 'bg-red-100 text-red-800' : 
       ($room->availability_status === 'reserved' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
    {{ ucfirst($room->availability_status) }}
</span>
                        </div>

                        <div class="mt-2 text-sm text-gray-600">
                            Capacity: {{ $room->capacity }} people
                        </div>

                        <!-- Current Reservation Info -->
                        @if($room->current_reservation)
                        <div class="mt-4 p-3 bg-gray-50 rounded-md">
                            <div class="text-sm">
                                <p class="font-medium text-gray-700">Current Session:</p>
                                <div class="mt-1 space-y-1">
                                    <p>Reserved by: {{ $room->current_reservation->user->name }}</p>
                                    <p>Until: {{ $room->current_reservation->end_time->format('h:i A') }}</p>
                                    <p class="text-xs text-gray-500">Purpose: {{ $room->current_reservation->purpose }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Upcoming Reservations -->
                        @if($room->upcoming_reservations->isNotEmpty())
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700">Upcoming Today:</p>
                            <div class="mt-2 space-y-2">
                                @foreach($room->upcoming_reservations as $reservation)
                                <div class="text-xs bg-gray-50 p-2 rounded">
                                    <p>{{ $reservation->start_time->format('h:i A') }} - 
                                       {{ $reservation->end_time->format('h:i A') }}</p>
                                    <p class="text-gray-500">{{ $reservation->user->name }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Your Active Reservations List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Active Reservations</h2>

                @if($userReservations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($userReservations as $reservation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $reservation->discussionRoom->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $reservation->start_time->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $reservation->end_time->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        @if($reservation->status === 'approved') bg-green-100 text-green-800
                                        @elseif($reservation->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No active reservations</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new reservation.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection