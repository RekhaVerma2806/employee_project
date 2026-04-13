<?php if($paginator->hasPages()): ?>
<nav class="d-flex justify-content-center align-items-center gap-2 mt-2">
    
    <?php if($paginator->onFirstPage()): ?>
        <span class="btn btn-sm btn-outline-secondary disabled">Previous</span>
    <?php else: ?>
        <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="btn btn-sm btn-outline-secondary">Previous</a>
    <?php endif; ?>

    
    <span class="btn btn-sm btn-primary px-3"><?php echo e($paginator->currentPage()); ?></span>
    <span class="text-muted small">of <?php echo e($paginator->lastPage()); ?></span>

    
    <?php if($paginator->hasMorePages()): ?>
        <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="btn btn-sm btn-outline-primary">Next</a>
    <?php else: ?>
        <span class="btn btn-sm btn-outline-secondary disabled">Next</span>
    <?php endif; ?>
</nav>
<?php endif; ?>
<?php /**PATH C:\laragon\www\employee-app\resources\views/vendor/pagination/bootstrap-5.blade.php ENDPATH**/ ?>