@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">PC Room Management</h1>

    <!-- PC Room Status Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Current Status</h2>
            <div class="text-lg font-medium {{ $occupancy >= $maxCapacity ? 'text-red-600' : 'text-green-600' }}">
                Occupancy: {{ $occupancy }}/{{ $maxCapacity }}
            </div>
        </div>

        <!-- Check for current session -->
        @if($currentUserSession)
        <!-- Show Current Session Information if there is an active or pending session -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-800">Your Current Session</h3>
            <p>Status: {{ $currentUserSession->status }}</p>
            <p>Start Time: {{ $currentUserSession->start_time }}</p>
            <p>End Time: {{ $currentUserSession->end_time }}</p>
            <p class="mt-4 text-gray-700">Purpose: {{ $currentUserSession->purpose }}</p>
        </div>
        @else
        <!-- Show Access Request Modal if there is no session -->
        <div id="accessRequestModal" class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-800">Request Access to PC Room</h2>
            <p>You currently do not have an active session. Request access to start one.</p>
            <div class="mt-4">
                <label for="purpose" class="block text-gray-700 font-medium">Purpose:</label>
                <select id="purpose" class="mt-2 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select purpose</option>
                    <option value="assignment">Assignment</option>
                    <option value="print">Printing</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <button onclick="requestAccess()" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Request Access
            </button>
        </div>
        @endif
    </div>

    <!-- PC Room Rules -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">PC Room Rules</h2>
        <ul class="list-disc list-inside text-gray-700 mt-4">
            <li>No food or drinks allowed in the PC room.</li>
            <li>Maintain a quiet and focused environment.</li>
            <li>Respect other users and their work.</li>
            <li>Report any technical issues or concerns to the staff.</li>
            <li>Maximum session time is 1 hours per user.</li>
            <li>Printing is allowed for academic and work-related purposes only.</li>
        </ul>
    </div>
</div>

<script>
    function requestAccess() {
        const purposeSelect = document.getElementById('purpose');
        const purpose = purposeSelect.value;

        if (!purpose) {
            alert('Please select the purpose of your PC room access request.');
            return;
        }

        fetch('/pc-room/request-access', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    purpose
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to request access');
                return response.json();
            })
            .then(data => {
                alert(data.message);
                location.reload(); // Reload to update the session status
            })
            .catch(error => alert(error.message));
    }
</script>
@endsection