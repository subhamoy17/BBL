@extends('frontcustomerlayout.main') 
@section('content')

<div class="banner_top">
		<div class="slider">
			<div class="wrapper">
				
				<!-- Slideshow 3 -->
				<ul class="rslides" id="slider">
					<li>
						<div class="agile_banner_text_info">
							<h3>Become Strong And Healthy </h3>
							<p>Train hard is the right place to start new life as an athletic, strong and healthy person with a strong will.</p>
						</div>
					</li>
					<li>
						<div class="agile_banner_text_info">
							<h3>Exceptional Life Fitness </h3>
							<p>Train hard is the right place to start new life as an athletic, strong and healthy person with a strong will.</p>
						</div>
					</li>
					<li>
						<div class="agile_banner_text_info">
							<h3>Build Your Body With Us </h3>
							<p>Train hard is the right place to start new life as an athletic, strong and healthy person with a strong will.</p>
						</div>
					</li>
					<li>
						<div class="agile_banner_text_info">
							<h3>Exceptional Life Fitness </h3>
							<p>Train hard is the right place to start new life as an athletic, strong and healthy person with a strong will.</p>
						</div>
					</li>
				</ul>
				<!-- Slideshow 3 Pager -->
				<ul id="slider3-pager">
					<li><a href="#"><img src="{{asset('frontend/images/banner11.jpg')}}" data-selector="img" alt=""></a></li>
					<li><a href="#"><img src="{{asset('frontend/images/banner22.jpg')}}" data-selector="img" alt=""></a></li>
					<li><a href="#"><img src="{{asset('frontend/images/banner33.jpg')}}" data-selector="img" alt=""></a></li>
					<li><a href="#"><img src="{{asset('frontend/images/banner44.jpg')}}" data-selector="img" alt=""></a></li>

				</ul>
			</div>
		</div>
	</div>
	<!-- //banner -->

<!-- //banner -->
	<!-- About us -->
	<div class="about-3">
		<div class="wthree_head_section">
				<h3 class="gyl_header">What We <span>Do?</span></h3>
                <p align="center">We believe physical fitness is must for a healthy life. So, we design your workout and daily regime to take your fitness level high.</p>
			</div>
		<div class="container">
			<div class="d-flex">
				
				<div class="about1"> 
					<h4>GYM TRAINING & WORKOUT PLANS FOR A HEALTHY YOU</h4>
					<p class="details">From Gym training to diet plans and comprehensive health packages. We design your daily workout to fit your mind and body at its best.</p>
					<ul class="about-list">
						<li>
							<div class="col-md-4 we-gyl">
								<img src="{{asset('frontend/images/1.jpg')}}" alt="" class="img-responsive" />
							</div>
							<div class="col-md-8 in-block">
								<h5>GYM TRAINING </h5>
								<p>Get the best fitness training techniques which includes personal training, Strength training, group exercises & much more.</p>
							</div>
							<div class="clearfix"> </div>
						</li>
						<li>
						<div class="col-md-4 we-gyl">
								<img src="{{asset('frontend/images/3.jpg')}}" alt="" class="img-responsive" />
							</div>
							<div class="col-md-8 in-block">
								<h5>DIET PLANS</h5>
								<p>Let our dieticians plan the perfect diet chart for you according to your body weight, structure and health conditions.</p>
							</div>
							<div class="clearfix"> </div>
						</li>
						<li>
							<div class="col-md-4 we-gyl">
								<img src="{{asset('frontend/images/hp1.jpg')}}" alt="" class="img-responsive" />
							</div>
							<div class="col-md-8 in-block">
								<h5>BOOTCAMP TRAINING</h5>
								<p>Get a complete high intensity bootcamp training sessions with us & burn excess calories by full-body workout.</p>
							</div>
							<div class="clearfix"> </div>
						</li>
					</ul>
				</div>
				<div class="about2">
					
				</div>
			</div>
			
		</div>
	</div>
	<!-- //About us -->
	<!--Featured Slider-->
	<!--Services Section-->
    <section class="service-section">
    	<div class="container">
    		<h3 class="gyl_header">Featured <span>Services</span></h3>
    		<p>Our features services are designed to give you the dream body you always wanted.</p>
    		<div class="row">
    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    				<div class="box-hover-effect thumb-cross-effect forservice">
    					<div class="effect-wrapper">
    						<div class="thumb"><img src="{{asset('frontend/images/sr1.jpg')}}"></div>
    						<a class="hover-link">View more</a>
    					</div>
    					<div class="sr-text">
    						<h4>GYM TRAINING</h4>
    						<p>Fitness training in a state of art modern gym</p>
    						<a href="{{route('gym_training')}}" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    				<div class="box-hover-effect thumb-cross-effect forservice">
    					<div class="effect-wrapper">
    						<div class="thumb"><img src="{{asset('frontend/images/sr2.jpg')}}"></div>
    						<a class="hover-link">View more</a>
    					</div>
    					<div class="sr-text">
    						<h4>DIET PLANS</h4>
    						<p>Customized diet plans to fit all body types</p>
    						<a href="{{route('diet_plans')}}" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    				<div class="box-hover-effect thumb-cross-effect forservice">
    					<div class="effect-wrapper">
    						<div class="thumb"><img src="{{asset('frontend/images/hp1.jpg')}}"></div>
    						<a class="hover-link">View more</a>
    					</div>
    					<div class="sr-text">
    						<h4>BOOTCAMP TRAINING</h4>
    						<p>Bootcamp training sessions</p>
    						<a href="{{route('bootcamp_training')}}" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    				<div class="box-hover-effect thumb-cross-effect forservice">
    					<div class="effect-wrapper">
    						<div class="thumb"><img src="{{asset('frontend/images/instructin _videos.jpg')}}"></div>
    						<a class="hover-link">View more</a>
    					</div>
    					<div class="sr-text">
    						<h4>INSTRUCTIONAL VIDEOS</h4>
    						<p>Access to online gym videos for constant guidance</p>
    						<a href="{{url('/exercise')}}" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    				<div class="box-hover-effect thumb-cross-effect forservice">
    					<div class="effect-wrapper">
    						<div class="thumb"><img src="{{asset('frontend/images/gym instruction.jpg')}}"></div>
    						<a class="hover-link">View more</a>
    					</div>
    					<div class="sr-text">
    						<h4>PERSONAL INSTRUCTORS</h4>
    						<p>Personal fitness trainers, available at your convenience</p>
    						<a href="{{route('personal_instructor')}}" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    				<div class="box-hover-effect thumb-cross-effect forservice">
    					<div class="effect-wrapper">
    						<div class="thumb"><img src="{{asset('frontend/images/online booking.jpg')}}"></div>
    						<a class="hover-link">View more</a>
    					</div>
    					<div class="sr-text">
    						<h4>ONLINE BOOKING</h4>
    						<p>Easy online booking of packages and tracking your health plan</p>
    						<a href="{{url('/pricing')}}" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
    					</div>
    				</div>
    			</div>
    			<div class="clearfix"></div>
    		</div>
    	</div>
    </section>
	<!--//Featured Slider-->
	<!--Get started-->
	<section class="gt-strt">
		<div class="container">
			<div class="gt-strt-text">
				<h1>HAVE EXTRA WEIGHT?<span>Get special nutrition program</span></h1>
				<p>Our special nutrition program helps you with a balanced diet that is required to keep your body fighting fit every day. Our experienced and trained nutritionists will consult with you personally to help you with the best balanced diet chart as per your body weight, medical conditions and structure.</p>
				<a href="#" class="gt-btn">Get Started</a>
			</div>
		</div>
	</section>
	
<section class="pricing df-pricing">
    <div class="container">
        <h3 class="gyl_header">Choose <span>Your Bootcamp Plan</span></h3>
          <div class="row">
        <div id="bootcamp-slider2" class="owl-carousel">
          @if(count($bootcamp_product_details)>0)
            @foreach($bootcamp_product_details as $bc_key=>$each_bootcamp_product)
            <div class="price-box">
              <div class="p-box-head cmn-3">
              <h3><span>{{$each_bootcamp_product->validity? $each_bootcamp_product->validity.' Days' : 'Validity N/A'}}</span></h3>
              <h1><i class="fa fa-gbp"></i> {{$each_bootcamp_product->total_price}} 
                <br><span> {{$each_bootcamp_product->payment_type_name}}
                    @if($each_bootcamp_product->payment_type_name=='Subscription')
                (Notice Period 
                {{$each_bootcamp_product->notice_period_value*$each_bootcamp_product->notice_period_duration}} Days)
                @endif
                </span></h1>
              <div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
              <div class="plan-batch bch-3">Bootcamp</div>
              <div class="cntrct"><h5>Contract <span> - {{$each_bootcamp_product->contract? $each_bootcamp_product->contract : 'N/A'}}</span></h5></div>
              </div>
              <div class="p-box-bdy">
              <h2>
                @if($each_bootcamp_product->total_sessions!='Unlimited')
                  {{$each_bootcamp_product->total_sessions}}<span>Sessions</span>
                @else
                  {{substr($each_bootcamp_product->total_sessions,0,1)}}<span>{{substr($each_bootcamp_product->total_sessions,1,8)}} Sessions</span>
                @endif
              </h2>
              
              <div class="clearfix"></div>
              @if(Auth::guard('customer')->check())
                  <a href="{{route('bootcamp_plan_purchase',['bootcamp_plan_id' => Crypt::encrypt($each_bootcamp_product->product_id) ])}}" class="sign-btn2">Subscribe</a>
                   @else
                <a href="{{url('customer-login')}}" class="sign-btn2">Sign Up</a>
                @endif
              </div>
            </div>
          
            @endforeach
          @else
            No bootcamp plan available
          @endif
          </div>
          </div>
        </div>
      </div>
            </div>
        </div>
  </section>


@endsection
