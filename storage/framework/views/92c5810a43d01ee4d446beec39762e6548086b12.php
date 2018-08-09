 
<?php $__env->startSection('content'); ?>
	<div  align="center">
		<?php if($message = Session::get('success_paypalpay')): ?>
    <div class="w3-panel w3-green w3-display-container">
        <span onclick="this.parentElement.style.display='none'"
                class="w3-button w3-green w3-large w3-display-topright">&times;</span>
        <p><?php echo $message; ?></p>
    </div>
    <?php Session::forget('success_paypalpay');?>
    <?php endif; ?>
<?php if($message = Session::get('failed_paypalpay')): ?>
    <div class="w3-panel w3-red w3-display-container">
        <span onclick="this.parentElement.style.display='none'"
                class="w3-button w3-red w3-large w3-display-topright">&times;</span>
        <p><?php echo $message; ?></p>
    </div>
    <?php Session::forget('failed_paypalpay');?>
    <?php endif; ?>
	</div>
	

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>