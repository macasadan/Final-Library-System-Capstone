

<?php $__env->startSection('content'); ?>
<div class="flex-1 min-h-screen bg-gray-50">
    <div class="p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Borrowing History</h1>
            <p class="mt-2 text-gray-600">View all your past and current borrowed books</p>
        </div>

        <!-- Filters Section -->
        <div class="mb-6">
            <div class="flex flex-wrap gap-4 p-4 bg-white rounded-lg shadow">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Status:</label>
                    <select id="status-filter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="all">All</option>
                        <option value="current">Currently Borrowed</option>
                        <option value="returned">Returned</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Sort by:</label>
                    <select id="sort-filter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- History List -->
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Details</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $borrowHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900"><?php echo e($borrow->book->title); ?></span>
                                    <span class="text-sm text-gray-500">by <?php echo e($borrow->book->author); ?></span>
                                    <span class="text-xs text-gray-500">ISBN: <?php echo e($borrow->book->isbn); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($borrow->borrow_date ? Carbon\Carbon::parse($borrow->borrow_date)->format('M d, Y') : 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e(Carbon\Carbon::parse($borrow->due_date)->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($borrow->returned_at ? Carbon\Carbon::parse($borrow->returned_at)->format('M d, Y') : '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($borrow->returned_at): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Returned
                                </span>
                                <?php elseif($borrow->status === 'approved'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e(Carbon\Carbon::parse($borrow->due_date)->isPast() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800'); ?>">
                                    <?php echo e(Carbon\Carbon::parse($borrow->due_date)->isPast() ? 'Overdue' : 'Borrowed'); ?>

                                </span>
                                <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <?php echo e(ucfirst($borrow->status)); ?>

                                </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <p class="mt-4 text-lg font-medium text-gray-900">No borrowing history</p>
                                    <p class="mt-2 text-gray-500">You haven't borrowed any books yet.</p>
                                    <a href="<?php echo e(route('books.index')); ?>"
                                        class="inline-flex items-center justify-center px-4 py-2 mt-6 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                        Browse Books
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($borrowHistory->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200">
                <?php echo e($borrowHistory->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('status-filter');
        const sortFilter = document.getElementById('sort-filter');

        function updateFilters() {
            const status = statusFilter.value;
            const sort = sortFilter.value;
            const url = new URL(window.location.href);

            url.searchParams.set('status', status);
            url.searchParams.set('sort', sort);

            window.location.href = url.toString();
        }

        statusFilter.addEventListener('change', updateFilters);
        sortFilter.addEventListener('change', updateFilters);

        // Set initial values from URL params
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('status')) {
            statusFilter.value = urlParams.get('status');
        }
        if (urlParams.has('sort')) {
            sortFilter.value = urlParams.get('sort');
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\FINAL_CPSTN\final-1\resources\views/books/history.blade.php ENDPATH**/ ?>