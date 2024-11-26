<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Mobile Burger Menu Button -->
        <button id="mobile-menu-toggle" class="fixed top-4 left-4 z-50 md:hidden">
            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Sidebar -->
        <aside id="sidebar" class="
            w-64 bg-white text-gray-800 shadow-lg
            fixed h-full 
            transform transition-transform duration-300 
            -translate-x-full md:translate-x-0 
            z-40
        ">
            <div class="p-6 relative border-b">
                <h1 class="text-2xl font-bold text-blue-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Library Admin
                </h1>
                
                <!-- Mobile Close Button -->
                <button id="mobile-sidebar-close" class="absolute top-2 right-2 md:hidden">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center py-3 px-6 hover:bg-blue-50 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-800' : 'text-gray-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.books.index') }}"
                    class="flex items-center py-3 px-6 hover:bg-blue-50 {{ request()->routeIs('admin.books.*') ? 'bg-blue-100 text-blue-800' : 'text-gray-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Manage Books
                </a>
                <a href="{{ route('admin.borrows.pending') }}"
                    class="flex items-center py-3 px-6 hover:bg-blue-50 {{ request()->routeIs('admin.borrows.pending') ? 'bg-blue-100 text-blue-800' : 'text-gray-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pending Borrows
                </a>
                <a href="{{ route('admin.borrows.borrowed') }}"
                    class="flex items-center py-3 px-6 hover:bg-blue-50 {{ request()->routeIs('admin.borrows.borrowed') ? 'bg-blue-100 text-blue-800' : 'text-gray-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    Borrowed Books
                </a>
                <a href="{{ route('admin.returnedBooks') }}"
                    class="flex items-center py-3 px-6 hover:bg-blue-50 {{ request()->routeIs('admin.returnedBooks') ? 'bg-blue-100 text-blue-800' : 'text-gray-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Returned Books
                </a>
                <a href="{{ route('admin.discussion_rooms.index') }}"
                    class="flex items-center py-3 px-6 hover:bg-blue-50 {{ request()->routeIs('admin.discussion_rooms.index') ? 'bg-blue-100 text-blue-800' : 'text-gray-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Discussion Rooms
                </a>
                <a href="{{ route('admin.discussion_rooms.history') }}"
                    class="flex items-center py-3 px-6 hover:bg-blue-50 {{ request()->routeIs('admin.discussion_rooms.history') ? 'bg-blue-100 text-blue-800' : 'text-gray-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Reservation History
                </a>
                <a href="{{ route('admin.discussion_rooms.expired') }}"
                    class="flex items-center py-3 px-6 hover:bg-blue-50 {{ request()->routeIs('admin.discussion_rooms.expired') ? 'bg-blue-100 text-blue-800' : 'text-gray-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h16M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    Reservations
                </a>
                <a href="{{ route('admin.pc-room.dashboard') }}"
                    class="flex items-center py-3 px-6 hover:bg-blue-50 {{ request()->routeIs('admin.pc-room.*') ? 'bg-blue-100 text-blue-800' : 'text-gray-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    PC Room Management
                </a>
                <a href="{{ route('admin.lost_items.index') }}"
                    class="flex items-center py-3 px-6 hover:bg-blue-50 {{ request()->routeIs('admin.lost_items.index') ? 'bg-blue-100 text-blue-800' : 'text-gray-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Lost Item Management
                </a>
            </nav>
        </aside>
        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-30 hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64 ml-0 transition-all duration-300">
            <!-- Top Navigation -->
            <header class="bg-white shadow-md">
                <div class="flex justify-between items-center px-6 py-4">
                    <h1 class="text-xl font-bold text-gray-800">@yield('header', 'Admin Dashboard')</h1>
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
                <p>Library Management System &copy; {{ date('Y') }}</p>
            </footer>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileSidebarClose = document.getElementById('mobile-sidebar-close');

            // Toggle sidebar on mobile
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            });

            // Close sidebar on mobile
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }

            mobileSidebarClose.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);
        });
    </script>
    @endpush
</body>

</html>
        <!-- Main Content -->
        <div class="flex-1 ml-64">
   

        
        </div>
    </div>
    @stack('scripts')
</body>

</html>