@extends('layouts.admin')

@section('title', 'Expired Reservations')
@section('header', 'Expired Reservations')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Expired Reservations</h2>
        <a href="{{ route('admin.discussion_rooms.index') }}"
            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
            Back to Dashboard
        </a>
    </div>

    @if($expiredReservations->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($expiredReservations as $reservation)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->discussionRoom->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->start_time->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reservation->end_time->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @php
                        $durationInMinutes = $reservation->start_time->diffInMinutes($reservation->end_time);
                        @endphp

                        @if($durationInMinutes < 60)
                            {{ $durationInMinutes }} minutes
                            @else
                            {{ round($durationInMinutes / 60, 1) }} hours
                            @endif
                            </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-500 text-center py-4">No expired reservations.</p>
    @endif
</div>
@endsection