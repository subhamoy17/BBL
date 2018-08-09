 
<?php $__env->startSection('content'); ?>



        <div class="contact-box">
            <div class="container">
                <div class="row">
         
                    <div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
                        
                        <div class="form-box">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">

                          
                                      <label>Name <small>*</small></label>
                                      <h6><?php echo e($data->name); ?></h6>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                      <label>Email <small>*</small></label>
                                     <h6><?php echo e($data->email); ?></h6>
                                    </div>
                                </div>
                               
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                      <label>Phone</label>
                                       <h6><?php echo e($data->ph_no); ?></h6>
                                    </div>
                                </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="inputs-w3ls">
                            <form enctype="multipart/form-data" id="frm1" method="post" action="<?php echo e(route('customer.package_purchase')); ?>">
                               <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                              <input type="hidden" name="id" id="id" value="<?php echo e($slot_id); ?>">

  <!--  -->

                            <label>Payment Mode</label>
                              <ul>
                                <li>
                                  <input type="radio" id="a-option" name="selector1" value="Paypal">
                                  <label for="a-option" >Paypal </label>
                                  <div class="check"></div>
                                </li>
                                <li>
                                  <input type="radio" id="b-option" name="selector1" value="Banking Transter">
                                  <label for="b-option" >Banking transter</label>
                                  <div class="check"></div>
                                </li>
                              </ul>
                              <label for="selector1" class="error" style="display:none;"></label>
                              <div class="clear"></div>
                          
                </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="form-group">
                    <input name="form_botcheck" class="form-control" value="" type="hidden">
                        <button type="submit" class="btn btn-dark btn-theme-colored btn-flat" data-loading-text="Please wait...">Submit</button>
                        </div>  
                         </div>
             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <link rel="stylesheet" href="<?php echo e(url('frontend/css/jquery-ui.css')); ?>">
 <link href="<?php echo e(url('frontend/css/style.css')); ?>" rel="stylesheet" type="text/css" media="all" />
  <script src="<?php echo e(url('frontend/css/jquery-ui.js')); ?>"></script>
 <script src="<?php echo e(url('frontend/css/jquery-1.12.4.js')); ?>"></script>
    <script>
  $( function() {
    $("#datepicker").datepicker();
  } );
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>