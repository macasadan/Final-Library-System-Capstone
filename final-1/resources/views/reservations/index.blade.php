<!-- resources/views/reservations/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Discussion Room Reservations</h2>
                    <a href="{{ route('reservations.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        New Reservation
                    </a>
                </div>

                <!-- Your Reservations -->
                <div class="mt-6">
                    <h3 class="text-xl font-semibold mb-4">Your Reservations</h3>
                    @if($userReservations->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b">Room</th>
                                    <th class="px-6 py-3 border-b">Start Time</th>
                                    <th class="px-6 py-3 border-b">End Time</th>
                                    <th class="px-6 py-3 border-b">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userReservations as $reservation)
                                <tr>
                                    <td class="px-6 py-4 border-b">{{ $reservation->discussionRoom->name }}</td>
                                    <td class="px-6 py-4 border-b">{{ $reservation->start_time->format('M d, Y H:i') }}</td>
                                    <td class="px-6 py-4 border-b">{{ $reservation->end_time->format('M d, Y H:i') }}</td>
                                    <td class="px-6 py-4 border-b">
                                        <span class="px-2 py-1 rounded text-sm
                                                        @if($reservation->status === 'approved') bg-green-200 text-green-800
                                                        @elseif($reservation->status === 'rejected') bg-red-200 text-red-800
                                                        @else bg-yellow-200 text-yellow-800
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
                    <p class="text-gray-500">You don't have any reservations yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection