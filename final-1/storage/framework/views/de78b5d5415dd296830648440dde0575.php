<?php $__env->startSection('title', 'Add Discussion Room'); ?>
<?php $__env->startSection('header', 'Add Discussion Room'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="<?php echo e(route('admin.discussion_rooms.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Room Name</label>
                <input type="text"
                    id="name"
                    name="name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>

            <div>
                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                <input type="number"
                    id="capacity"
                    name="capacity"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="<?php echo e(route('admin.discussion_rooms.index')); ?>"
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add Room
                </button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\FINAL_CPSTN\final-1\resources\views/admin/discussion_rooms/create.blade.php ENDPATH**/ ?>