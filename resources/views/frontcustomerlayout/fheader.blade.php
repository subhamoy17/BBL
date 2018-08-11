<body>
	<header>
    	<div class="header-top">
    		<div class="container">
    			<div class="row">
    				<div class="col-lg-12">
    					<div class="all-links">
    						<ul>
    							 <li><a href="https://www.instagram.com" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                 <li><a href="mailto:info@example.com"><i class="fa fa-envelope"></i></a></li>
                                <li><a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="https://www.twitter.com" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                <!-- <li><a href="#"><i class="fa fa-google-plus"></i></a></li> -->
                                <li><a href="https://www.youtube.com" target="_blank"><i class="fa fa-youtube"></i></a></li>
    						</ul>
    						<div class="reg-area">
    							<p><a href="{{route('customer-register')}}" class="jn-us"><i class="fa fa-hand-o-right"></i> Join Us</a></p>
                                <p><a href="{{url('customer-login')}}" class="sgn-in"><i class="fa fa-user"></i>Sign In</a></p>
    							<!-- <a class="srch-icon"><i class="fa fa-search"></i><i class="fa fa-times"></i></a> -->
    							<div class="srch-box">
    								<input type="text" placeholder="search">
    								<input type="button" value="Search">
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div id="myHeader" class="heder-bottom">
            

             
    		<div class="container">
    			<div class="row">
    				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    					<div class="logo text-left">
    						<a href="{{url('/')}}"><img src="{{asset('frontend/images/logo.png')}}">
                                <ul> 
                            </a>
    					</div>
    				</div>
                    
    				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    					<div id="main-nav" class="stellarnav">
    						<ul>
 <li class="{{ Request::is('/') ? 'active' : null }}">
                        <a href="{{route('bbldb')}}">Home</a>
                      </li>
<li class="{{ Request::segment(1) === 'about-us' ? 'active' : null }}">
                        <a href="{{route('about-us')}}">About Us</a>
                      </li>
<li class="{{ Request::segment(1) === 'services' ? 'active' : null }}">
                        <a href="{{route('services')}}">Services</a>
                      </li>
<li class="{{ Request::segment(1) === 'pricing' ? 'active' : null }}">
                        <a href="{{route('pricing')}}">Pricing</a>
                      </li>
<li class="{{ Request::segment(1) === 'contact-us' ? 'active' : null }}">
                        <a href="{{route('contact-us')}}">Contact Us</a>
                      </li>
                      
           <li class="{{ Request::segment(1) === 'exercise' ? 'active' : null }}">
                        <a href="{{route('exercise')}}">Exercise</a>
                      </li>           
                    
<li class="{{ Request::segment(1) === 'testimonial' ? 'active' : null }}">
                        <a href="{{route('testimonial')}}">Testimonial</a>
                      </li>

                      
                     
    						</ul>
						</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </header>