<body>
	<header>
    	<div class="header-top">
    		<div class="container">
    			<div class="row">
    				<div class="col-lg-12">

    					<div class="all-links">
                              Welcom <?php echo e(Auth::user()->name); ?>

                            <ul>
                                 
                                <ul>
                                 <li><a href="https://www.instagram.com" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                 <li><a href="mailto:info@example.com"><i class="fa fa-envelope"></i></a></li>
                                <li><a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="https://www.twitter.com" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                <!-- <li><a href="#"><i class="fa fa-google-plus"></i></a></li> -->
                                <li><a href="https://www.youtube.com" target="_blank"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                            
                          
    						
    						<!-- <div class="reg-area">
    							<a class="srch-icon"> <i class="fa fa-search"></i><i class="fa fa-times"></i></a>
    							<div class="srch-box">
    								<input type="text" placeholder="search">
    								<input type="button" value="Search">
    							</div>
    						</div> -->
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div id="myHeader" class="heder-bottom">
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
    		<div class="container">
    			<div class="row">
    				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    					<div class="logo text-left">
    						<a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('frontend/images/logo.png')); ?>">
                                <ul> 
                            </a>
    					</div>
    				</div>
                  
    				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    					<div id="main-nav" class="stellarnav">
    						<ul>

                <li class="<?php echo e(Request::segment(2) === 'bbl' ? 'active' : null); ?>">
                        <a href="<?php echo e(url('customer/bbl')); ?>">Home</a>
                      </li>
                       <li class="<?php echo e(Request::segment(2) === 'about-us' ? 'active' : null); ?>">
                        <a href="<?php echo e(url('customer/about-us')); ?>">About Us</a>
                      </li>
                <li class="<?php echo e(Request::segment(2) === 'pricing' ? 'active' : null); ?>">
                        <a href="<?php echo e(url('customer/pricing')); ?>">Pricing</a>
                      </li>
                     
                    <li class="<?php echo e(Request::segment(2) === 'services' ? 'active' : null); ?>">
                        <a href="<?php echo e(url('customer/services')); ?>">Services</a>
                      </li>
                      <li class="<?php echo e(Request::segment(2) === 'exercise' ? 'active' : null); ?>">
                        <a href="<?php echo e(url('customer/exercise')); ?>">Exercise</a>
                      </li>

                  <li class="<?php echo e(Request::segment(2) === 'contact-us' ? 'active' : null); ?>">
                        <a href="<?php echo e(url('customer/contact-us')); ?>">Contact Us</a>
                      </li>
                      <li class="<?php echo e(Request::segment(2) === 'testimonial' ? 'active' : null); ?>">
                        <a href="<?php echo e(url('customer/testimonial')); ?>">Testimonial</a>
                      </li>

                      <li class="<?php echo e(Request::segment(2) === 'profile' ? 'active' : null); ?>">
                        <a href="<?php echo e(url('customer/profile')); ?>/<?php echo e(Auth::user()->id); ?>">My Profile</a>
                      </li>

    						</ul>
						</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </header>



