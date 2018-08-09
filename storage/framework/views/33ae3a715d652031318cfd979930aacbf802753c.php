 
<?php $__env->startSection('content'); ?>


<section class="pricing">
    <div class="container">
        <h3 class="gyl_header">Choose <span>Your Plan</span></h3>

          <div class="row">
             <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                         </div>
                            <?php endif; ?>
               <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-4 col-xs-12">
              <div class="price-box">
                <div class="p-box-head cmn-3">
                  <h3><span><?php echo e($mydata->slots_name); ?></span></h3>
                  <h1><i class="fa fa-gbp"></i> <?php echo e($mydata->slots_price); ?> <span></span></h1>
                 <span class="small-msg">No. of slots</span>
                  <span class="small-msg"><?php echo e($mydata->slots_number); ?></span>
                  <span class="small-msg">/ Validity <?php echo e($mydata->slots_validity); ?> Days</span>
                  <div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
                  <div class="plan-batch bch-3">Premium</div>
                </div>
                <div class="p-box-bdy">
                  <h2><?php echo e($mydata->slots_number); ?><span>Slots</span></h2>
                  <?php if(Auth::guard('customer')->check()): ?>
                  <a href="<?php echo e(url('customer/purchase_form')); ?>/<?php echo e($mydata->id); ?>" class="sign-btn2">Subscribe</a>
                <?php else: ?>
                <a href="#" class="sign-btn2">sign-up</a>
                <?php endif; ?>
                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
  </section>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>