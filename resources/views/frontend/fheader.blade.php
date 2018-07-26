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
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
         
                            </ul>
                          
    						
    						<div class="reg-area">
    							<a class="srch-icon"> <i class="fa fa-search"></i><i class="fa fa-times"></i></a>
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

                <li class="{{ Request::segment(2) === 'bbl' ? 'active' : null }}">
                        <a href="{{url('customer/bbl')}}">Home</a>
                      </li>


                <li class="{{ Request::segment(2) === 'pricing' ? 'active' : null }}">
                        <a href="{{url('customer/pricing')}}">Pricing</a>
                
                      </li>

                      <li class="{{ Request::segment(2) === 'about' ? 'active' : null }}">
                        <a href="{{url('customer/about')}}">About</a>
                      </li>

                    <li class="{{ Request::segment(1) === 'services' ? 'active' : null }}">
                        <a href="{{url('customer/services')}}">Services</a>
                      </li>

                      <li class="{{ Request::segment(1) === 'contact' ? 'active' : null }}">
                        <a href="{{url('customer/contact')}}">Contact Us</a>
                      </li>

    						</ul>
						</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </header>


  <div class="inner-padding">
    <div class="container">
      <div class="hstry-box">
      <ul class="tabs">
        <li class="{{ Request::segment(2) === 'bbl' ? 'active' : null }}" rel="tab1"><a href="{{url('customer/bbl')}}"><i class="fa fa-check"></i> Booking History</a></li>

          <li class="{{ Request::segment(2) === 'purchase_history' ? 'active' : null }}" rel="tab2"><a href="{{url('customer/purchase_history')}}"><i class="fa fa-check"></i> Purchases History</a></li>


        <li class="{{ Request::segment(2) === 'profile' ? 'active' : null }}" rel="tab3"><a href="{{url('customer/profile')}}/{{Auth::user()->id}}"><i class="fa fa-check"></i>Profile</a></li>

<li class="{{ Request::segment(2) === 'profile' ? 'active' : null }}" rel="tab3"><a href="{{url('customer/my_mot')}}"><i class="fa fa-check"></i>My MOT</a></li>



    <li class="{{ Request::segment(2) === 'changepassword' ? 'active' : null }}" rel="tab4"><a href="{{ route('customer.changepassword') }}"><i class="fa fa-check"></i>Change Password</a></li>






         <li rel="tab5"><a href="a class="nav-link" href="{{ route('customerpanel.logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fa fa-user">
                                            </i>Logout </a></li>
                                                <form id="logout-form" action="{{ route('customerpanel.logout') }}" method="POST" style="display: none;">
                                        @csrf

                                 </form>

                         </ul>