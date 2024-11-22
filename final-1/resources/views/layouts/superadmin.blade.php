<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-800 text-white fixed h-full">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Super Admin Panel</h1>
            </div>
            <nav class="mt-6">
                <a href="{{ route('super-admin.dashboard') }}"
                    class="block py-3 px-6 hover:bg-indigo-700 {{ request()->routeIs('super-admin.dashboard') ? 'bg-indigo-700' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('super-admin.manage-admins') }}"
                    class="block py-3 px-6 hover:bg-indigo-700 {{ request()->routeIs('super-admin.manage-admins') ? 'bg-indigo-700' : '' }}">
                    Manage Admins
                </a>
                <a href="{{ route('super-admin.create-admin') }}"
                    class="block py-3 px-6 hover:bg-indigo-700 {{ request()->routeIs('super-admin.create-admin') ? 'bg-indigo-700' : '' }}">
                    Create Admin
                </a>
                <a href="{{ route('super-admin.books.index') }}"
    class="block py-3 px-6 hover:bg-indigo-700 {{ request()->routeIs('super-admin.books.index') ? 'bg-indigo-700' : '' }}">
    Manage Books
</a>
<a href="{{ route('super-admin.session-logs') }}"
    class="block py-3 px-6 hover:bg-indigo-700 {{ request()->routeIs('super-admin.session-logs') ? 'bg-indigo-700' : '' }}">
    PC Room Session Logs
</a>
<a href="{{ route('super-admin.lost-item-logs') }}"
    class="block py-3 px-6 hover:bg-indigo-700 {{ request()->routeIs('super-admin.lost-item-logs') ? 'bg-indigo-700' : '' }}">
    Lost Item Logs
</a>
<a href="{{ route('super-admin.returned-book-logs') }}"
    class="block py-3 px-6 hover:bg-indigo-700 {{ request()->routeIs('super-admin.returned-book-logs') ? 'bg-indigo-700' : '' }}">
    Returned Book Logs
</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow-md">
                <div class="flex justify-between items-center px-6 py-4">
                    <h1 class="text-xl font-bold text-gray-800">@yield('header', 'Super Admin Dashboard')</h1>
                    <div class="flex items-center">
                        <span class="text-gray-600 mr-4">Welcome, {{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6">
                @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="text-center py-6 text-gray-600 border-t">
                <p>Super Admin Dashboard &copy; {{ date('Y') }}</p>
            </footer>
        </div>
    </div>
    @stack('scripts')
</body>
</html>