

<?php $__env->startSection('content'); ?>
<div id="react-book-category"
    data-category="<?php echo e(json_encode($category)); ?>"
    data-books="<?php echo e(json_encode($books)); ?>">
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\FINAL_CPSTN\final-1\resources\views/books/book-category.blade.php ENDPATH**/ ?>