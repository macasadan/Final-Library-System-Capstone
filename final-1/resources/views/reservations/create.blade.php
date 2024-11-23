<!-- resources/views/reservations/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-red-600 via-orange-500 to-blue-600 bg-clip-text text-transparent">
                Reserve a Room
            </h1>
            <p class="mt-2 text-gray-600">Book a discussion room for your study session</p>
        </div>

        <!-- Reservation Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                @if(session('error'))
                <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <!-- Room Selection -->
                        <div>
                            <label for="discussion_room_id" class="block text-sm font-medium text-gray-700">
                                Select Room
                            </label>
                            <select name="discussion_room_id" id="discussion_room_id"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 rounded-md">
                                @foreach($roomDropdown as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Time Selection -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="start_time">
                                    Start Time
                                </label>
                                <input type="datetime-local" name="start_time" id="start_time"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="end_time">
                                    End Time (Max 5 hours)
                                </label>
                                <input type="datetime-local" name="end_time" id="end_time"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                            </div>
                        </div>

                        <!-- Purpose -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="purpose">
                                Purpose of Reservation
                            </label>
                            <textarea name="purpose" id="purpose" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"
                                placeholder="Briefly describe the purpose of your reservation"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 text-white font-semibold rounded-lg shadow-sm transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Submit Reservation
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.getElementById('discussion_room_id');
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const availabilityMessage = document.createElement('div');
        availabilityMessage.classList.add('text-sm', 'mt-1');
        startTimeInput.parentNode.insertBefore(availabilityMessage, startTimeInput.nextSibling);

        function checkRoomAvailability() {
            const roomId = roomSelect.value;
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            if (roomId && startTime && endTime) {
                fetch('{{ route("reservations.check-availability") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            room_id: roomId,
                            start_time: startTime,
                            end_time: endTime
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        availabilityMessage.textContent = data.is_available ?
                            'Room is available' :
                            'Room is not available for selected time';
                        availabilityMessage.classList.toggle('text-green-600', data.is_available);
                        availabilityMessage.classList.toggle('text-red-600', !data.is_available);
                    });
            }
        }

        roomSelect.addEventListener('change', checkRoomAvailability);
        startTimeInput.addEventListener('change', checkRoomAvailability);
        endTimeInput.addEventListener('change', checkRoomAvailability);
    });
</script>