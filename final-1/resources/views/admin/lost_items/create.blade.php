@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Report Lost Item</h2>

    <div class="bg-white rounded-lg shadow-md border border-gray-300 p-6">
        <form action="{{ route('admin.lost_items.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="item_type" class="block text-gray-700 font-bold mb-2">Item Type</label>
                <input type="text" id="item_type" name="item_type" class="border rounded-md p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea id="description" name="description" rows="3" class="border rounded-md p-2 w-full"></textarea>
            </div>

            <div class="mb-4">
                <label for="date_lost" class="block text-gray-700 font-bold mb-2">Date Lost</label>
                <input type="date" id="date_lost" name="date_lost" class="border rounded-md p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label for="time_lost" class="block text-gray-700 font-bold mb-2">Time Lost</label>
                <input type="time" id="time_lost" name="time_lost" class="border rounded-md p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700 font-bold mb-2">Location</label>
                <input type="text" id="location" name="location" class="border rounded-md p-2 w-full" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Report Lost Item
                </button>
            </div>
        </form>
    </div>
</div>
@endsection