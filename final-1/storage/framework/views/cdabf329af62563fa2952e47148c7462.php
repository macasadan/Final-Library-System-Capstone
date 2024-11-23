<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Library Books</h1>

        
        <form action="<?php echo e(route('books.search')); ?>" method="GET" class="mt-4 sm:mt-0">
            <div class="flex gap-2">
                <input
                    type="text"
                    name="query"
                    class="flex-1 min-w-[200px] rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                    placeholder="Search books..."
                    value="<?php echo e(request('query')); ?>">
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Search
                </button>
            </div>
        </form>
    </div>

    
    <?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Book Categories</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('books.category', ['category' => $category->id])); ?>"
                class="flex justify-between items-center px-4 py-2 rounded-lg border border-red-500 text-red-600 hover:bg-red-50 transition-colors">
                <?php echo e($category->name); ?>

                <span class="ml-2 text-sm"><?php echo e($category->books_count); ?> books</span>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h5 class="text-xl font-semibold text-gray-900 mb-2"><?php echo e($book->title); ?></h5>
                <h6 class="text-sm text-gray-600 mb-4">by <?php echo e($book->author); ?></h6>

                <?php if($book->categories->isNotEmpty()): ?>
                <p class="text-sm mb-4">
                    <span class="font-semibold">Categories:</span>
                    <?php $__currentLoopData = $book->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('books.category', ['category' => $category->id])); ?>"
                        class="text-blue-600 hover:underline">
                        <?php echo e($category->name); ?>

                    </a>
                    <?php if(!$loop->last): ?>, <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </p>
                <?php endif; ?>

                <p class="text-sm mb-4">
                    <span class="font-semibold">Available Copies:</span> <?php echo e($book->quantity); ?>

                </p>

                <?php if($book->quantity > 0): ?>
                <button type="button"
                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                    data-bs-toggle="modal"
                    data-bs-target="#borrowModal<?php echo e($book->id); ?>">
                    Borrow Book
                </button>
                <?php else: ?>
                <button class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed" disabled>
                    Out of Stock
                </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Borrow Modal -->
        <!-- Borrow Modal -->
        <div class="modal fade" id="borrowModal<?php echo e($book->id); ?>" tabindex="-1" aria-labelledby="borrowModalLabel<?php echo e($book->id); ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-white rounded-lg shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold text-gray-900" id="borrowModalLabel<?php echo e($book->id); ?>">Borrow "<?php echo e($book->title); ?>"</h3>
                            <button type="button" class="text-gray-400 hover:text-gray-500" data-bs-dismiss="modal" aria-label="Close">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form action="<?php echo e(route('books.borrow', $book->id)); ?>" method="POST" class="space-y-4">
                            <?php echo csrf_field(); ?>
                            <div>
                                <label for="id_number<?php echo e($book->id); ?>" class="block mb-1 text-sm font-medium text-gray-700">
                                    ID Number
                                </label>
                                <input type="text"
                                    id="id_number<?php echo e($book->id); ?>"
                                    name="id_number"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>

                            <div>
                                <label for="course<?php echo e($book->id); ?>" class="block mb-1 text-sm font-medium text-gray-700">
                                    Course
                                </label>
                                <input type="text"
                                    id="course<?php echo e($book->id); ?>"
                                    name="course"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>

                            <div>
                                <label for="department<?php echo e($book->id); ?>" class="block mb-1 text-sm font-medium text-gray-700">
                                    Department
                                </label>
                                <select id="department<?php echo e($book->id); ?>"
                                    name="department"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="">Select Department</option>
                                    <option value="COT">College of Technology (COT)</option>
                                    <option value="COE">College of Engineering (COE)</option>
                                    <option value="CEAS">College of Education, Arts and Sciences (CEAS)</option>
                                    <option value="CME">College of Management and Economics (CME)</option>
                                </select>
                            </div>

                            <div class="flex justify-end gap-3 mt-6">
                                <button type="button"
                                    class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Confirm Borrow
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($books->isEmpty()): ?>
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg">
        No books found.
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\FINAL_CPSTN\final-1\resources\views/books/index.blade.php ENDPATH**/ ?>