

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Lost Item Management</h2>

    <div class="mb-6">
        <a href="<?php echo e(route('admin.lost_items.create')); ?>" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Report Lost Item
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-300 overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-3 text-left">Item Type</th>
                    <th class="px-4 py-3 text-left">Description</th>
                    <th class="px-4 py-3 text-left">Date Lost</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Reported By</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $lostItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b border-gray-200">
                    <td class="px-4 py-3"><?php echo e($item->item_type); ?></td>
                    <td class="px-4 py-3"><?php echo e($item->description); ?></td>
                    <td class="px-4 py-3"><?php echo e($item->date_lost->format('F j, Y')); ?></td>
                    <td class="px-4 py-3"><?php echo e(ucfirst($item->status)); ?></td>
                    <td class="px-4 py-3"><?php echo e($item->user->name); ?></td>
                    <td class="px-4 py-3 text-right">
                        <a href="<?php echo e(route('admin.lost_items.show', $item)); ?>" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">
                            View
                        </a>
                        <form action="<?php echo e(route('admin.lost_items.update-status', $item)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <select name="status" class="bg-gray-200 px-4 py-2 rounded">
                                <option value="lost" <?php echo e($item->status == 'lost' ? 'selected' : ''); ?>>Lost</option>
                                <option value="found" <?php echo e($item->status == 'found' ? 'selected' : ''); ?>>Found</option>
                            </select>
                            <button type="submit" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 ml-2">
                                Update
                            </button>
                        </form>
                        <form action="<?php echo e(route('admin.lost_items.destroy', $item)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-2">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\FINAL_CPSTN\final-1\resources\views/admin/lost_items/index.blade.php ENDPATH**/ ?>