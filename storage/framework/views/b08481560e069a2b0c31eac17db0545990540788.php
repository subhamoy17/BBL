
  <div class="inner-padding">
    <div class="container">
      <div class="hstry-box">
      <ul class="tabs">
        <li class="<?php echo e(Request::segment(2) === 'booking_history' ? 'active' : null); ?>" rel="tab1"><a href="<?php echo e(url('customer/booking_history')); ?>"><i class="fa fa-check"></i> Booking History</a></li>

          <li class="<?php echo e(Request::segment(2) === 'purchase_history' ? 'active' : null); ?>" rel="tab2"><a href="<?php echo e(url('customer/purchase_history')); ?>"><i class="fa fa-check"></i> Purchases History</a></li>


        <li class="<?php echo e(Request::segment(2) === 'profile' ? 'active' : null); ?>" rel="tab3"><a href="<?php echo e(url('customer/profile')); ?>/<?php echo e(Auth::user()->id); ?>"><i class="fa fa-check"></i>Profile</a></li>

<li class="<?php echo e(Request::segment(2) === 'my_mot' ? 'active' : null); ?>" rel="tab3"><a href="<?php echo e(url('customer/my_mot')); ?>"><i class="fa fa-check"></i>My MOT</a></li>



    <li class="<?php echo e(Request::segment(2) === 'changepassword' ? 'active' : null); ?>" rel="tab4"><a href="<?php echo e(route('customer.changepassword')); ?>"><i class="fa fa-check"></i>Change Password</a></li>






         <li rel="tab5"><a href="a class="nav-link" href="<?php echo e(route('customerpanel.logout')); ?>" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fa fa-user">
                                            </i>Logout </a></li>
                                                <form id="logout-form" action="<?php echo e(route('customerpanel.logout')); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>

                                 </form>

                         </ul>