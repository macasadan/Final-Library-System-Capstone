<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white fixed h-full">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Library Admin</h1>
            </div>
            <nav class="mt-6">
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="block py-3 px-6 hover:bg-blue-700 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-700' : ''); ?>">
                    Dashboard
                </a>
                <a href="<?php echo e(route('admin.books.index')); ?>"
                    class="block py-3 px-6 hover:bg-blue-700 <?php echo e(request()->routeIs('admin.books.*') ? 'bg-blue-700' : ''); ?>">
                    Manage Books
                </a>
                <a href="<?php echo e(route('admin.borrows.pending')); ?>"
                    class="block py-3 px-6 hover:bg-blue-700 <?php echo e(request()->routeIs('admin.borrows.pending') ? 'bg-blue-700' : ''); ?>">
                    Pending Borrows
                </a>
                <a href="<?php echo e(route('admin.borrows.index')); ?>"
                    class="block py-3 px-6 hover:bg-blue-700 <?php echo e(request()->routeIs('admin.borrows.index') ? 'bg-blue-700' : ''); ?>">
                    Borrowed Books
                </a>
                <a href="<?php echo e(route('admin.returnedBooks')); ?>"
                    class="block py-3 px-6 hover:bg-blue-700 <?php echo e(request()->routeIs('admin.returnedBooks') ? 'bg-blue-700' : ''); ?>">
                    Returned Books
                </a>
                <a href="<?php echo e(route('admin.discussion_rooms.index')); ?>"
                    class="block py-3 px-6 hover:bg-blue-700 <?php echo e(request()->routeIs('admin.discussion_rooms.index') ? 'bg-blue-700' : ''); ?>">
                    Discussion Rooms
                </a>
                <a href="<?php echo e(route('admin.discussion_rooms.expired')); ?>"
                    class="block py-3 px-6 hover:bg-blue-700 <?php echo e(request()->routeIs('admin.discussion_rooms.expired') ? 'bg-blue-700' : ''); ?>">
                    Reservations
                </a>
                <a href="<?php echo e(route('admin.pc-room.dashboard')); ?>"
                    class="block py-3 px-6 hover:bg-blue-700 <?php echo e(request()->routeIs('admin.pc-room.*') ? 'bg-blue-700' : ''); ?>">
                    PC Room Management
                </a>
                <a href="<?php echo e(route('admin.lost_items.index')); ?>"
                    class="block py-3 px-6 hover:bg-blue-700 <?php echo e(request()->routeIs('admin.pc-room.*') ? 'bg-blue-700' : ''); ?>">
                    Lost Item Management
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow-md">
                <div class="flex justify-between items-center px-6 py-4">
                    <h1 class="text-xl font-bold text-gray-800"><?php echo $__env->yieldContent('header', 'Admin Dashboard'); ?></h1>
                    <div class="flex items-center">
                        <span class="text-gray-600 mr-4">Welcome, <?php echo e(Auth::user()->name); ?></span>
                        <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
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
                <?php if(session('success')): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <?php echo e(session('success')); ?>

                </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <?php echo e(session('error')); ?>

                </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>

            <!-- Footer -->
            <footer class="text-center py-6 text-gray-600 border-t">
                <p>Library Management System &copy; <?php echo e(date('Y')); ?></p>
            </footer>
        </div>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\dashboard\FINAL_CPSTN\final-1\resources\views/layouts/admin.blade.php ENDPATH**/ ?>