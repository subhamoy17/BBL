<body>
<div class="loader"></div>
	<header>
    	<div class="header-top">
    		<div class="container">
    			<div class="row">
    				<div class="col-lg-12">

    					<div class="all-links">
                            <ul>
                                 <li><a href="https://www.instagram.com/lekanfitness" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                 <li><a href="mailto:info@example.com"><i class="fa fa-envelope"></i></a></li>
                                <li><a href="https://www.facebook.com/bodybylekan" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="https://www.twitter.com" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                <!-- <li><a href="#"><i class="fa fa-google-plus"></i></a></li> -->
                                <li><a href="https://www.youtube.com" target="_blank"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                            @if(Auth::guard('customer')->check())
                            <div class="dropdown user-box">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Welcome {{Auth::guard('customer')->user()->name}}
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('customer/mybooking')}}">My Dashboard</a></li>
                                    <li><a href="{{url('customer/profile')}}">My Profile</a></li>
                                    <li><a href="{{ route('customerpanel.logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a></li>
                                    <form id="logout-form" action="{{ route('customerpanel.logout') }}" method="POST" style="display: none;">
                                        @csrf

                                 </form>
                                </ul>
                                <span class="noification-d"><a href="{{url('customer/mybooking')}}"><i class="fa fa-bell"></i><small>{{Session::get('sum_slots')?Session::get('sum_slots'):0}}</small></a></span>
                            </div>
                            <div class="clearfix"></div>
                            
              @else
                <div class="reg-area">
                  <p><a href="{{route('customer-register')}}" class="jn-us"><i class="fa fa-hand-o-right"></i> Join Us</a></p>
                  <p><a href="{{url('customer-login')}}" class="sgn-in"><i class="fa fa-user"></i>Sign In</a></p>
                  <div class="srch-box">
                    <input type="text" placeholder="search">
                    <input type="button" value="Search">
                  </div>
                </div>
              @endif
    						
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
    	<div class="heder-bottom">
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
                        <a href="{{url('/')}}">Home</a>
                      </li>
                       <li class="{{ Request::segment(2) === 'about-us' ? 'active' : null }}">
                        <a href="{{url('customer/about-us')}}">About Us</a>
                      </li>
                <li class="{{ Request::segment(2) === 'pricing' ? 'active' : null }}">
                        <a href="{{url('customer/pricing')}}">Pricing</a>
                      </li>
                     
                    <li class="{{ Request::segment(2) === 'services' ? 'active' : null }}">
                        <a href="{{url('customer/services')}}">Services</a>
                      </li>
                      <li class="{{ Request::segment(2) === 'exercise' ? 'active' : null }}">
                        <a href="{{url('customer/exercise')}}">Exercise</a>
                      </li>

                  <li class="{{ Request::segment(2) === 'contact-us' ? 'active' : null }}">
                        <a href="{{url('customer/contact-us')}}">Contact Us</a>
                      </li>
                      <li class="{{ Request::segment(2) === 'testimonial' ? 'active' : null }}">
                        <a href="{{url('customer/testimonial')}}">Testimonial</a>
                      </li>

                      @if(Auth::guard('customer')->check())
                      <li class="{{ Request::segment(2) === 'mybooking' || Request::segment(2) === 'purchase_history' || Request::segment(2) === 'my_mot' ? 'active' : null }}">
                        <a href="{{url('customer/mybooking')}}">My Dashboard</a>
                      </li>
                      @endif


    						</ul>
						</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </header>



