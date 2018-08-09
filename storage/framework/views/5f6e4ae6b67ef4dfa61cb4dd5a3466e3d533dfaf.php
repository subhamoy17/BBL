 
<?php $__env->startSection('content'); ?>
	
	<div align="center">
    
    <?php if($data): ?>
    
	<form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"  action="<?php echo URL:: to('customer/paypalpayment'); ?>">
  <?php echo e(csrf_field()); ?>

  <h2 class="w3-text-blue">Pay from here</h2>
  <p>You can choose to pay by using payapl</p>
  <p>      
  <label class="w3-text-blue"><b>Payable Amount</b></label>
  <input class="w3-input w3-border" name="amount" type="text" value="<?php echo e($data['slots_price']); ?>" readonly>
  <input class="w3-input w3-border" name="slots_name" type="hidden" value="<?php echo e($data['slots_name']); ?>">
  <input class="w3-input w3-border" name="slots_number" type="hidden" value="<?php echo e($data['slots_number']); ?>">
  <input class="w3-input w3-border" name="slot_id" type="hidden" value="<?php echo e($data['slot_id']); ?>" >
  <input class="w3-input w3-border" name="payment_options" type="hidden" value="<?php echo e($data['payment_options']); ?>" >
  <input class="w3-input w3-border" name="purchases_date" type="hidden" value="<?php echo e($data['purchases_date']); ?>" >
  <input class="w3-input w3-border" name="package_validity_date" type="hidden" value="<?php echo e($data['package_validity_date']); ?>" >
  <input class="w3-input w3-border" name="customer_id" type="hidden" value="<?php echo e($data['customer_id']); ?>" >

  </p>      
  <button class="w3-btn w3-blue">Pay with PayPal</button></p>
</form>
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>