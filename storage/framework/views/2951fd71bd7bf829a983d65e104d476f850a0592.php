 
<?php $__env->startSection('content'); ?>



      <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab3">Tab 3</h3>
          <div id="tab3" class="tab_content">
            <div class="form-box">
                <h4 class="ed-p">My Profile</h4>
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
                              <label>Address <small>*</small></label>
                              <h6><?php echo e($data->address); ?></h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Phone No. <small>*</small></label>
                              <h6><?php echo e($data->ph_no); ?></h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group file-box">
                              <label>Image</label>

                              <h6><img src="<?php echo e(asset('backend/images')); ?>/<?php echo e(Auth::user()->image); ?>" height="50" width="50"></h6>
                            
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input name="form_botcheck" class="form-control" value="" type="hidden">
                         <button type="submit"  class="btn btn-dark btn-theme-colored btn-flat" data-loading-text="Please wait..."> <a href="<?php echo e(url('customer/editprofile')); ?>/<?php echo e(Auth::user()->id); ?>">Edit</a></button>
                        </div>
                </div>
                </div>
              </div>
          </div>

         
      </div>
      </div>
      <!-- .tab_container -->
    </div>
  </div>
  
 


<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.submain', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>