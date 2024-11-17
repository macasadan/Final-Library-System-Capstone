@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-red-600 via-orange-500 to-blue-600 bg-clip-text text-transparent">
                PC Room
            </h1>
            <p class="mt-2 text-gray-600">Manage your computer access and sessions</p>
        </div>

        <!-- Status Overview Card -->
        <div class="mb-6 grid gap-6 md:grid-cols-2">
            <!-- Occupancy Status -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Current Occupancy</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $occupancy >= $maxCapacity ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $occupancy }}/{{ $maxCapacity }} PCs
                    </span>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-600 to-orange-500 h-2 rounded-full"
                            style="width: {{ ($occupancy / $maxCapacity) * 100 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Session Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Max Duration</p>
                        <p class="text-lg font-medium text-gray-900">1 Hour</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Available PCs</p>
                        <p class="text-lg font-medium text-gray-900">{{ $maxCapacity - $occupancy }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Session or Request Access -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                @if($currentUserSession)
                <!-- Active Session Display -->
                <div class="border-l-4 border-green-500 bg-green-50 p-6 rounded-r-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Your Active Session</h2>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            {{ ucfirst($currentUserSession->status) }}
                        </span>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <p class="text-sm text-gray-500">Start Time</p>
                            <p class="mt-1 font-medium">{{ $currentUserSession->start_time }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">End Time</p>
                            <p class="mt-1 font-medium">{{ $currentUserSession->end_time }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-sm text-gray-500">Purpose</p>
                            <p class="mt-1 font-medium">{{ $currentUserSession->purpose }}</p>
                        </div>
                    </div>
                </div>
                @else
                <!-- Access Request Form -->
                <div id="accessRequestModal">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-800">Request PC Access</h2>
                    </div>
                    <div class="max-w-2xl">
                        <div class="mb-6">
                            <label for="purpose" class="block text-sm font-medium text-gray-700 mb-1">
                                Select Purpose
                            </label>
                            <select id="purpose"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 rounded-md">
                                <option value="">Choose a purpose...</option>
                                <option value="assignment">Assignment Work</option>
                                <option value="print">Printing Services</option>
                                <option value="other">Other Academic Purpose</option>
                            </select>
                        </div>
                        <div>
                            <button onclick="requestAccess()"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 text-white font-semibold rounded-lg shadow-sm transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Request Access
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Rules and Guidelines -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">PC Room Guidelines</h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-orange-500 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span class="text-gray-700">No food or drinks allowed in the PC room</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-orange-500 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                            </svg>
                            <span class="text-gray-700">Maintain a quiet and focused environment</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-orange-500 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="text-gray-700">Respect other users and their work</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-orange-500 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span class="text-gray-700">Report any technical issues to staff</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-orange-500 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Maximum session time is 1 hour per user</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-orange-500 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            <span class="text-gray-700">Printing for academic purposes only</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                location.reload();
            })
            .catch(error => alert(error.message));
    }
</script>
@endsection