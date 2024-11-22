@extends('layouts.superadmin')

@section('title', 'Super Admin Dashboard')

@section('header', 'Dashboard Overview')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Total Users</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Total Books</h2>
            <p class="text-3xl font-bold text-green-600">{{ $totalBooks }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Discussion Rooms</h2>
            <p class="text-3xl font-bold text-red-600">{{ $totalDiscussionRooms }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Existing cards -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Total Administrators</h2>
        <p class="text-3xl font-bold text-purple-600">{{ $totalAdmins }}</p>
    </div>
</div>
    </div>

    <div class="mt-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('super-admin.manage-admins') }}" 
               class="bg-indigo-500 text-white py-3 px-6 rounded-lg text-center hover:bg-indigo-600 transition">
                Manage Admins
            </a>
            <a href="{{ route('super-admin.create-admin') }}" 
               class="bg-green-500 text-white py-3 px-6 rounded-lg text-center hover:bg-green-600 transition">
                Create New Admin
            </a>
            <a href="{{ route('super-admin.system-logs') }}" 
               class="bg-red-500 text-white py-3 px-6 rounded-lg text-center hover:bg-red-600 transition">
                System Logs
            </a>
        </div>
    </div>
</div>
@endsection