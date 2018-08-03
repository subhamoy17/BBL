
<?php echo $__env->make('frontcustomerlayout.fhead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('frontcustomerlayout.fheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldContent('content'); ?>
<?php echo $__env->make('frontcustomerlayout.ffooter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('frontcustomerlayout.ffooter2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
