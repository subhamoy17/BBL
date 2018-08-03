
<?php echo $__env->make('frontend.fhead', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('frontend.fheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- <?php echo $__env->make('frontend.myprofile_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> -->
<?php echo $__env->yieldContent('content'); ?>
<?php echo $__env->make('frontend.ffooter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('frontend.ffooter2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
