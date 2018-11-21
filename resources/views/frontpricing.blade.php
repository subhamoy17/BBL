@extends('frontcustomerlayout.main') 
@section('content')

<section class="pricing">
    <div class="container">
        <h3 class="gyl_header">Choose <span>Your Plan</span></h3>
          <div class="row">
               @foreach($data as $mydata)
            <div class="col-lg-4 col-md-4 col-xs-12">
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
                <a href="{{url('customer-login')}}" class="sign-btn2">sign-up</a>
                @endif
                </div>
              </div>
            </div>
            @endforeach
			</div>
				</div>
  </section>
  <section class="pricing df-pricing">
    <div class="container">
        <h3 class="gyl_header">Choose <span>Your Plan</span></h3>
          <div class="row">
				<div id="bootcamp-slider" class="owl-carousel">
						<div class="price-box">
							<div class="p-box-head cmn-3">
							<h3><span>{{$mydata->slots_name}}</span></h3>
							<h1><i class="fa fa-gbp"></i> {{$mydata->slots_price}} <span>/ (Subscription)</span></h1>
							<span class="small-msg">No. of slots</span>
							<span class="small-msg">{{$mydata->slots_number}}</span>
							<span class="small-msg">/ Validity {{$mydata->slots_validity}} Days</span>
							<div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
							<div class="plan-batch bch-3">Premium</div>
							<div class="cntrct"><h5>Contract <span> - Annual</span></h5></div>
							</div>
							<div class="p-box-bdy">
							
							<h2>{{$mydata->slots_number}}<span>Slots</span></h2>
							<div class="date-time">
								<h5>Timing <span>(6AM - 7AM)</span></h5>
								<h5>Days of a Week <span>(All Days of the Week)</span</h5>
							</div>
							<div class="clearfix"></div>
							<a href="{{url('customer/purchase_form')}}/{{$mydata->id}}" class="sign-btn2">Subscribe</a>
							</div>
						</div>
						<div class="price-box">
							<div class="p-box-head cmn-3">
							<h3><span>{{$mydata->slots_name}}</span></h3>
							<h1><i class="fa fa-gbp"></i> {{$mydata->slots_price}} <span>/ (Subscription)</span></h1>
							<span class="small-msg">No. of slots</span>
							<span class="small-msg">{{$mydata->slots_number}}</span>
							<span class="small-msg">/ Validity {{$mydata->slots_validity}} Days</span>
							<div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
							<div class="plan-batch bch-3">Premium</div>
							<div class="cntrct"><h5>Contract <span> - Annual</span></h5></div>
							</div>
							<div class="p-box-bdy">
							
							<h2>{{$mydata->slots_number}}<span>Slots</span></h2>
							<div class="date-time">
								<h5>Timing <span>(6AM - 7AM)</span></h5>
								<h5>Days of a Week <span>(All Days of the Week)</span</h5>
							</div>
							<div class="clearfix"></div>
							<a href="{{url('customer/purchase_form')}}/{{$mydata->id}}" class="sign-btn2">Subscribe</a>
							</div>
						</div>
					
						<div class="price-box">
							<div class="p-box-head cmn-3">
							<h3><span>{{$mydata->slots_name}}</span></h3>
							<h1><i class="fa fa-gbp"></i> {{$mydata->slots_price}} <span>/ (Pay As You Go)</span></h1>
							<span class="small-msg">No. of slots</span>
							<span class="small-msg">{{$mydata->slots_number}}</span>
							<span class="small-msg">/ Validity {{$mydata->slots_validity}} Days</span>
							<div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
							<div class="plan-batch bch-3">Premium</div>
							<div class="cntrct"><h5>Contract <span> - Annual</span></h5></div>
							</div>
							<div class="p-box-bdy">
							<h2>U<span>nlimited</span></h2>
							<div class="date-time">
								<h5>Timing <span>(6AM - 7AM)</span></h5>
								<h5>Days of a Week <span>(Sun,Tue,Thu,Sat)</span</h5>
							</div>
							<a href="{{url('customer/purchase_form')}}/{{$mydata->id}}" class="sign-btn2">Subscribe</a>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
            </div>
        </div>
  </section>
  <section class="pricing df-pricing">
    <div class="container">
        <h3 class="gyl_header">Choose <span>Your Plan</span></h3>
          <div class="row">
				<div id="bootcamp-slider2" class="owl-carousel">
						<div class="price-box">
							<div class="p-box-head cmn-3">
							<h3><span>{{$mydata->slots_name}}</span></h3>
							<h1><i class="fa fa-gbp"></i> {{$mydata->slots_price}} <span>/ (Subscription)</span></h1>
							<span class="small-msg">No. of slots</span>
							<span class="small-msg">{{$mydata->slots_number}}</span>
							<span class="small-msg">/ Validity {{$mydata->slots_validity}} Days</span>
							<div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
							<div class="plan-batch bch-3">Premium</div>
							<div class="cntrct"><h5>Contract <span> - Annual</span></h5></div>
							</div>
							<div class="p-box-bdy">
							
							<h2>{{$mydata->slots_number}}<span>Slots</span></h2>
							<div class="date-time">
								<h5>Timing <span>(6AM - 7AM)</span></h5>
								<h5>Days of a Week <span>(All Days of the Week)</span</h5>
							</div>
							<div class="clearfix"></div>
							<a href="{{url('customer/purchase_form')}}/{{$mydata->id}}" class="sign-btn2">Subscribe</a>
							</div>
						</div>
						<div class="price-box">
							<div class="p-box-head cmn-3">
							<h3><span>{{$mydata->slots_name}}</span></h3>
							<h1><i class="fa fa-gbp"></i> {{$mydata->slots_price}} <span>/ (Subscription)</span></h1>
							<span class="small-msg">No. of slots</span>
							<span class="small-msg">{{$mydata->slots_number}}</span>
							<span class="small-msg">/ Validity {{$mydata->slots_validity}} Days</span>
							<div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
							<div class="plan-batch bch-3">Premium</div>
							<div class="cntrct"><h5>Contract <span> - Annual</span></h5></div>
							</div>
							<div class="p-box-bdy">
							
							<h2>{{$mydata->slots_number}}<span>Slots</span></h2>
							<div class="date-time">
								<h5>Timing <span>(6AM - 7AM)</span></h5>
								<h5>Days of a Week <span>(All Days of the Week)</span</h5>
							</div>
							<div class="clearfix"></div>
							<a href="{{url('customer/purchase_form')}}/{{$mydata->id}}" class="sign-btn2">Subscribe</a>
							</div>
						</div>
					
						<div class="price-box">
							<div class="p-box-head cmn-3">
							<h3><span>{{$mydata->slots_name}}</span></h3>
							<h1><i class="fa fa-gbp"></i> {{$mydata->slots_price}} <span>/ (Pay As You Go)</span></h1>
							<span class="small-msg">No. of slots</span>
							<span class="small-msg">{{$mydata->slots_number}}</span>
							<span class="small-msg">/ Validity {{$mydata->slots_validity}} Days</span>
							<div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
							<div class="plan-batch bch-3">Premium</div>
							<div class="cntrct"><h5>Contract <span> - Annual</span></h5></div>
							</div>
							<div class="p-box-bdy">
							<h2>U<span>nlimited</span></h2>
							<div class="date-time">
								<h5>Timing <span>(6AM - 7AM)</span></h5>
								<h5>Days of a Week <span>(Sun,Tue,Thu,Sat)</span</h5>
							</div>
							<a href="{{url('customer/purchase_form')}}/{{$mydata->id}}" class="sign-btn2">Subscribe</a>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
            </div>
        </div>
  </section>
  <section class="pricing df-pricing">
    <div class="container">
        <h3 class="gyl_header">Choose <span>Your Plan</span></h3>
          <div class="row">
				<div id="bootcamp-slider3" class="owl-carousel">
						<div class="price-box">
							<div class="p-box-head cmn-3">
							<h3><span>{{$mydata->slots_name}}</span></h3>
							<h1><i class="fa fa-gbp"></i> {{$mydata->slots_price}} <span>/ (Subscription)</span></h1>
							<span class="small-msg">No. of slots</span>
							<span class="small-msg">{{$mydata->slots_number}}</span>
							<span class="small-msg">/ Validity {{$mydata->slots_validity}} Days</span>
							<div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
							<div class="plan-batch bch-3">Premium</div>
							<div class="cntrct"><h5>Contract <span> - Annual</span></h5></div>
							</div>
							<div class="p-box-bdy">
							
							<h2>{{$mydata->slots_number}}<span>Slots</span></h2>
							<div class="date-time">
								<h5>Timing <span>(6AM - 7AM)</span></h5>
								<h5>Days of a Week <span>(All Days of the Week)</span</h5>
							</div>
							<div class="clearfix"></div>
							<a href="{{url('customer/purchase_form')}}/{{$mydata->id}}" class="sign-btn2">Subscribe</a>
							</div>
						</div>
						<div class="price-box">
							<div class="p-box-head cmn-3">
							<h3><span>{{$mydata->slots_name}}</span></h3>
							<h1><i class="fa fa-gbp"></i> {{$mydata->slots_price}} <span>/ (Subscription)</span></h1>
							<span class="small-msg">No. of slots</span>
							<span class="small-msg">{{$mydata->slots_number}}</span>
							<span class="small-msg">/ Validity {{$mydata->slots_validity}} Days</span>
							<div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
							<div class="plan-batch bch-3">Premium</div>
							<div class="cntrct"><h5>Contract <span> - Annual</span></h5></div>
							</div>
							<div class="p-box-bdy">
							
							<h2>{{$mydata->slots_number}}<span>Slots</span></h2>
							<div class="date-time">
								<h5>Timing <span>(6AM - 7AM)</span></h5>
								<h5>Days of a Week <span>(All Days of the Week)</span</h5>
							</div>
							<div class="clearfix"></div>
							<a href="{{url('customer/purchase_form')}}/{{$mydata->id}}" class="sign-btn2">Subscribe</a>
							</div>
						</div>
					
						<div class="price-box">
							<div class="p-box-head cmn-3">
							<h3><span>{{$mydata->slots_name}}</span></h3>
							<h1><i class="fa fa-gbp"></i> {{$mydata->slots_price}} <span>/ (Pay As You Go)</span></h1>
							<span class="small-msg">No. of slots</span>
							<span class="small-msg">{{$mydata->slots_number}}</span>
							<span class="small-msg">/ Validity {{$mydata->slots_validity}} Days</span>
							<div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
							<div class="plan-batch bch-3">Premium</div>
							<div class="cntrct"><h5>Contract <span> - Annual</span></h5></div>
							</div>
							<div class="p-box-bdy">
							<h2>U<span>nlimited</span></h2>
							<div class="date-time">
								<h5>Timing <span>(6AM - 7AM)</span></h5>
								<h5>Days of a Week <span>(Sun,Tue,Thu,Sat)</span</h5>
							</div>
							<a href="{{url('customer/purchase_form')}}/{{$mydata->id}}" class="sign-btn2">Subscribe</a>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
            </div>
        </div>
  </section>

@endsection