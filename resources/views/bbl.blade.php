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
							<p>TrainHard is the right place to start new life as an athletic, strong and healthy person with a strong will.</p>
						</div>
					</li>
					<li>
						<div class="agile_banner_text_info">
							<h3>Exceptional Life Fitness </h3>
							<p>TrainHard is the right place to start new life as an athletic, strong and healthy person with a strong will.</p>
						</div>
					</li>
					<li>
						<div class="agile_banner_text_info">
							<h3>Build Your Body With Us </h3>
							<p>TrainHard is the right place to start new life as an athletic, strong and healthy person with a strong will.</p>
						</div>
					</li>
					<li>
						<div class="agile_banner_text_info">
							<h3>Exceptional Life Fitness </h3>
							<p>TrainHard is the right place to start new life as an athletic, strong and healthy person with a strong will.</p>
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
			</div>
		<div class="container">
			<div class="d-flex">
				
				<div class="about1"> 
					<h4>CrossFit and TrainHard GYM </h4>
					<p class="details">Nullam pulvinar vulputate aliquam. Pellentesque venenatis ut mi ac porta. Praesent interdum nibh libero, id malesuada libero aliquet quis. Donec at odio nibh.</p>
					<ul class="about-list">
						<li>
							<div class="col-md-4 we-gyl">
								<img src="{{asset('frontend/images/1.jpg')}}" alt="" class="img-responsive" />
							</div>
							<div class="col-md-8 in-block">
								<h5>ELEMENTS</h5>
								<p>Suspendisse maximus leo vel facilisis porta. Aliquam posuere mollis auctor. Nunc eget massa eleifend, finibus.</p>
							</div>
							<div class="clearfix"> </div>
						</li>
						<li>
						<div class="col-md-4 we-gyl">
								<img src="{{asset('frontend/images/2.jpg')}}" alt="" class="img-responsive" />
							</div>
							<div class="col-md-8 in-block">
								<h5>BOOT CAMP</h5>
								<p>Suspendisse maximus leo vel facilisis porta. Aliquam posuere mollis auctor. Nunc eget massa eleifend, finibus.</p>
							</div>
							<div class="clearfix"> </div>
						</li>
						<li>
							<div class="col-md-4 we-gyl">
								<img src="{{asset('frontend/images/3.jpg')}}" alt="" class="img-responsive" />
							</div>
							<div class="col-md-8 in-block">
								<h5>CROSSFIT</h5>
								<p>Suspendisse maximus leo vel facilisis porta. Aliquam posuere mollis auctor. Nunc eget massa eleifend, finibus.</p>
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
    		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.Acque quidem eaque, amet doloribus, error inventore, quisquam totam magni cumque.</p>
    		<div class="row">
    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    				<div class="box-hover-effect thumb-cross-effect forservice">
    					<div class="effect-wrapper">
    						<div class="thumb"><img src="{{asset('frontend/images/sr1.jpg')}}"></div>
    						<a class="hover-link">View more</a>
    					</div>
    					<div class="sr-text">
    						<h4>Lorem Ipsum</h4>
    						<p>dolor sit amet</p>
    						<a href="#" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
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
    						<h4>Lorem Ipsum</h4>
    						<p>dolor sit amet</p>
    						<a href="#" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    				<div class="box-hover-effect thumb-cross-effect forservice">
    					<div class="effect-wrapper">
    						<div class="thumb"><img src="{{asset('frontend/images/sr3.jpg')}}"></div>
    						<a class="hover-link">View more</a>
    					</div>
    					<div class="sr-text">
    						<h4>Lorem Ipsum</h4>
    						<p>dolor sit amet</p>
    						<a href="#" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    				<div class="box-hover-effect thumb-cross-effect forservice">
    					<div class="effect-wrapper">
    						<div class="thumb"><img src="{{asset('frontend/images/sr1.jpg')}}"></div>
    						<a class="hover-link">View more</a>
    					</div>
    					<div class="sr-text">
    						<h4>Lorem Ipsum</h4>
    						<p>dolor sit amet</p>
    						<a href="#" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
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
    						<h4>Lorem Ipsum</h4>
    						<p>dolor sit amet</p>
    						<a href="#" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    				<div class="box-hover-effect thumb-cross-effect forservice">
    					<div class="effect-wrapper">
    						<div class="thumb"><img src="{{asset('frontend/images/sr3.jpg')}}"></div>
    						<a class="hover-link">View more</a>
    					</div>
    					<div class="sr-text">
    						<h4>Lorem Ipsum</h4>
    						<p>dolor sit amet</p>
    						<a href="#" class="rd-btn2">read more <i class="fa fa-long-arrow-right"></i></a>
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
				<p>Phasellus elementum commodo aliquet. Sed vitae sem in arcu auctor pharetra vel ut erat. Praesent mattis nisi laoreet ex tempus auctor. Nullam vitae arcu euismod, placerat mi id, ornare lorem. Morbi vulputate dui purus, ut sodales dolor hendrerit. Curabitur et purus at urna tristique pharetra.</p>
				<a href="#" class="gt-btn">Get Started</a>
			</div>
		</div>
	</section>
	

 <!--Pricing Section-->
  <section class="pricing">
  <div class="container">
        <h3 class="gyl_header">Choose <span>Your Plan</span></h3>
          <div class="row">
              
               <div class="owl-carousel" id="price-slider">
                 @foreach($data as $mydata)
            <div class="price-wrp">
              <div class="price-box">
                <div class="p-box-head cmn-3">
                  <h3><span>{{$mydata->slots_name}}</span></h3>
                <h1><i class="fa fa-gbp"></i> {{$mydata->slots_price}} <span></span></h1>
                  <span class="small-msg">No. of slots</span>
                  <span class="small-msg">{{$mydata->slots_number}}</span>
                  <span class="small-msg">/ Validity {{$mydata->slots_validity}} Days</span>
                  <div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
                  <div class="plan-batch bch-3">Premium</div>
                </div>
                <div class="p-box-bdy">
                  <h2>{{$mydata->slots_number}}<span>Slots</span></h2>
                  
                   @if(Auth::guard('customer')->check())
                  <a href="{{url('customer/purchase_form')}}/{{$mydata->id}}" class="sign-btn2">Subscribe</a>

                   @else
                <a href="{{url('customer-login')}}" class="sign-btn2">Sign Up</a>
                @endif

                </div>
              </div>
            </div>
     @endforeach
        </div>
     
            </div>
        </div>
  </section>





@endsection
