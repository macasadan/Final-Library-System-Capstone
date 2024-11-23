<!-- resources/views/admin/dashboard.blade.php -->


<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Admin Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Books Management Section -->
        <div class="p-6 bg-green-100 rounded-lg shadow-md border border-green-300">
            <h3 class="text-xl font-semibold text-gray-700">Books Management</h3>
            <p class="text-gray-600 mt-1">Oversee library books: Add, update, or remove books from the collection.</p>
            <a href="<?php echo e(route('admin.books.index')); ?>" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Manage Books
            </a>
        </div>

        <!-- Borrowed Books Management Section -->
        <div class="p-6 bg-blue-100 rounded-lg shadow-md border border-blue-300">
            <h3 class="text-xl font-semibold text-gray-700">Borrowed Books</h3>
            <p class="text-gray-600 mt-1">Manage book borrowing requests and track borrowed books.</p>
            <div class="flex flex-col space-y-2">
                <a href="<?php echo e(route('admin.borrows.pending')); ?>" class="mt-4 inline-block bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                    Pending Requests
                    <?php if(isset($pendingCount) && $pendingCount > 0): ?>
                    <span class="ml-2 bg-white text-yellow-600 px-2 rounded-full"><?php echo e($pendingCount); ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.borrows.index')); ?>" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    All Borrowed Books
                </a>
            </div>
        </div>

        <!-- Returned Books Section -->
        <div class="p-6 bg-yellow-100 rounded-lg shadow-md border border-yellow-300">
            <h3 class="text-xl font-semibold text-gray-700">Returned Books</h3>
            <p class="text-gray-600 mt-1">Monitor books that have been returned by users.</p>
            <a href="<?php echo e(route('admin.returnedBooks')); ?>" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                View Returned Books
            </a>
        </div>

        <!-- Discussion Rooms Management Section -->
        <div class="p-6 bg-purple-100 rounded-lg shadow-md border border-purple-300">
            <h3 class="text-xl font-semibold text-gray-700">Discussion Rooms</h3>
            <p class="text-gray-600 mt-1">Manage and update the status of discussion rooms.</p>
            <a href="<?php echo e(route('admin.discussion_rooms.index')); ?>" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Manage Rooms
            </a>
        </div>

        <!-- Reservations and Notifications Section -->
        <div class="p-6 bg-orange-100 rounded-lg shadow-md border border-orange-300">
            <h3 class="text-xl font-semibold text-gray-700">Room Reservations</h3>
            <p class="text-gray-600 mt-1">Check active room reservations and expired notifications.</p>
            <a href="<?php echo e(route('admin.discussion_rooms.index')); ?>" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                View Reservations
            </a>
            <?php if(isset($expiredReservations)): ?>
            <?php if($expiredReservations->count() > 0): ?>
            <p class="mt-4 text-red-600 font-semibold">
                <?php echo e($expiredReservations->count()); ?> reservations have expired!
            </p>
            <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Lost Item Management Section -->
        <div class="p-6 bg-red-100 rounded-lg shadow-md border border-red-300">
            <h3 class="text-xl font-semibold text-gray-700">Lost Item Management</h3>
            <p class="text-gray-600 mt-1">Manage reported lost items and create new reports.</p>
            <a href="<?php echo e(route('admin.lost_items.index')); ?>" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                View Lost Items
            </a>
            <a href="<?php echo e(route('admin.lost_items.create')); ?>" class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Report Lost Item
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\FINAL_CPSTN\final-1\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>