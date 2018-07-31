<body>
	<header>
    	<div class="header-top">
    		<div class="container">
    			<div class="row">
    				<div class="col-lg-12">

    					<div class="all-links">
                              Welcom {{Auth::user()->name}}
                            <ul>
                                 <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                                <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
         
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
              @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
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

                <li class="{{ Request::segment(2) === 'bbl' ? 'active' : null }}">
                        <a href="{{url('customer/bbl')}}">Home</a>
                      </li>
                       <li class="{{ Request::segment(2) === 'about' ? 'active' : null }}">
                        <a href="{{url('customer/about-us')}}">About </a>
                      </li>
                <li class="{{ Request::segment(2) === 'pricing' ? 'active' : null }}">
                        <a href="{{url('customer/pricing')}}">Pricing</a>
                      </li>
                     
                    <li class="{{ Request::segment(2) === 'services' ? 'active' : null }}">
                        <a href="{{url('customer/services')}}">Services</a>
                      </li>
                      <li class="{{ Request::segment(2) === 'gym_gallery' ? 'active' : null }}">
                        <a href="{{url('customer/customer_gym_gallery')}}">Exercise</a>
                      </li>

                  <li class="{{ Request::segment(2) === 'contact' ? 'active' : null }}">
                        <a href="{{url('customer/contact-us')}}">Contact Us</a>
                      </li>

                      <li class="{{ Request::segment(2) === 'profile' ? 'active' : null }}">
                        <a href="{{url('customer/profile')}}/{{Auth::user()->id}}">My Profile</a>
                      </li>

    						</ul>
						</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </header>



