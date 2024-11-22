@extends('layouts.superadmin')

@section('header', 'Manage Administrators')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($admins as $admin)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $admin->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $admin->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $admin->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="#" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Are you sure you want to remove this admin?')">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('super-admin.create-admin') }}" 
           class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
            Create New Admin
        </a>
    </div>
</div>
@endsection