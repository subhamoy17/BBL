@extends('frontend.main') 
@section('content')


<section class="pricing">
    <div class="container">
        <h3 class="gyl_header">Choose <span>Your Plan</span></h3>

          <div class="row">
             @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                         </div>
                            @endif
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
                <a href="#" class="sign-btn2">sign-up</a>
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
        <h3 class="gyl_header">Choose <span>Your Personal Training Plan</span></h3>
          <div class="row">
        <div id="bootcamp-slider" class="owl-carousel">
            @foreach($personal_training_product_details as $pt_key=>$each_personal_training_product)
            <div class="price-box">
              <div class="p-box-head cmn-3">
              <h3><span>{{$each_personal_training_product->training_name}}</span></h3>
              <h1><i class="fa fa-gbp"></i> {{$each_personal_training_product->total_price}} <span>/ ({{$each_personal_training_product->payment_type_name}})</span></h1>
              <span class="small-msg">No. of slots</span>
              <span class="small-msg">{{$each_personal_training_product->total_sessions}}</span>
              <span class="small-msg">/ Validity {{$each_personal_training_product->validity}} Days</span>
              <div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
              <div class="plan-batch bch-3">Premium</div>
              <div class="cntrct"><h5>Contract <span> - {{$each_personal_training_product->contract}}</span></h5></div>
              </div>
              <div class="p-box-bdy">
              

              <h2>
                @if($each_personal_training_product->total_sessions!='Unlimited')
                  {{$each_personal_training_product->total_sessions}}<span>Slots</span>
                @else
                  {{substr($each_personal_training_product->total_sessions,0,1)}}<span>{{substr($each_personal_training_product->total_sessions,1,8)}}</span>
                @endif
              </h2>
              <div class="date-time">
                <h5>Timing 
                  <span>
                   @foreach($personal_training_product_details[$pt_key]->personal_training_st_time as $each_pt_st_time)
                  
                {{date('h:i A', strtotime($each_pt_st_time->product_st_time))}} To
                {{date('h:i A', strtotime($each_pt_st_time->product_end_time))}},
                @endforeach 
               

           </span>


              </h5>
                <h5>Days of a Week <span>
                (
                @foreach($each_personal_training_product->personal_training_day as $each_pt_day)

                  {{$each_pt_day->product_days}},
                @endforeach
              )</span</h5>
              </div>


              <div class="clearfix"></div>



              <a href="" class="sign-btn2">Subscribe</a>
              </div>
            </div>
          
            @endforeach


          </div>
          </div>
        </div>
      </div>
            </div>
        </div>
  </section>
  <section class="pricing df-pricing">
    <div class="container">
        <h3 class="gyl_header">Choose <span>Your Bootcamp Plan</span></h3>
          <div class="row">
        <div id="bootcamp-slider2" class="owl-carousel">
            @foreach($bootcamp_product_details as $bc_key=>$each_bootcamp_product)
            <div class="price-box">
              <div class="p-box-head cmn-3">
              <h3><span>{{$each_bootcamp_product->training_name}}</span></h3>
              <h1><i class="fa fa-gbp"></i> {{$each_bootcamp_product->total_price}} <span>/ ({{$each_bootcamp_product->payment_type_name}})</span></h1>
              <span class="small-msg">No. of slots</span>
              <span class="small-msg">{{$each_bootcamp_product->total_sessions}}</span>
              <span class="small-msg">/ Validity {{$each_bootcamp_product->validity}} Days</span>
              <div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
              <div class="plan-batch bch-3">Premium</div>
              <div class="cntrct"><h5>Contract <span> - {{$each_bootcamp_product->contract}}</span></h5></div>
              </div>
              <div class="p-box-bdy">
              

              <h2>
                @if($each_bootcamp_product->total_sessions!='Unlimited')
                  {{$each_bootcamp_product->total_sessions}}<span>Slots</span>
                @else
                  {{substr($each_bootcamp_product->total_sessions,0,1)}}<span>{{substr($each_bootcamp_product->total_sessions,1,8)}}</span>
                @endif
              </h2>
              <div class="date-time">
                <h5>Timing 
                 

                <span>
                   @foreach($bootcamp_product_details[$bc_key]->bootcamp_st_time as $each_pt_st_time)
                  
                {{date('h:i A', strtotime($each_pt_st_time->product_st_time))}} To
                {{date('h:i A', strtotime($each_pt_st_time->product_end_time))}},
                @endforeach 
               

           </span>

              </h5>
                <h5>Days of a Week <span>
                (
                @foreach($each_bootcamp_product->bootcamp_day as $each_bootcamp_day)

                  {{$each_bootcamp_day->product_days}},
                @endforeach
              )</span></h5>

              </div>
              <div class="clearfix"></div>
              <a href="" class="sign-btn2">Subscribe</a>
              </div>
            </div>
          
            @endforeach
          </div>
          </div>
        </div>
      </div>
            </div>
        </div>
  </section>
  <section class="pricing df-pricing">
    <div class="container">
        <h3 class="gyl_header">Choose <span>Your Gym Plan</span></h3>
          <div class="row">
        <div id="bootcamp-slider3" class="owl-carousel">
            @foreach($gym_product_details as $gym_key=>$each_gym_product)
            <div class="price-box">
              <div class="p-box-head cmn-3">
              <h3><span>{{$each_gym_product->training_name}}</span></h3>
              <h1><i class="fa fa-gbp"></i> {{$each_gym_product->total_price}} <span>/ ({{$each_gym_product->payment_type_name}})</span></h1>
              <span class="small-msg">No. of slots</span>
              <span class="small-msg">{{$each_gym_product->total_sessions}}</span>
              <span class="small-msg">/ Validity {{$each_gym_product->validity}} Days</span>
              <div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
              <div class="plan-batch bch-3">Premium</div>
              <div class="cntrct"><h5>Contract <span> - {{$each_gym_product->contract}}</span></h5></div>
              </div>
              <div class="p-box-bdy">
              

              <h2>
                @if($each_gym_product->total_sessions!='Unlimited')
                  {{$each_gym_product->total_sessions}}<span>Slots</span>
                @else
                  {{substr($each_gym_product->total_sessions,0,1)}}<span>{{substr($each_gym_product->total_sessions,1,8)}}</span>
                @endif
              </h2>
              <div class="date-time">
                <h5>Timing 
                  

              <span>
                   @foreach($gym_product_details[$gym_key]->gym_st_time as $each_pt_st_time)
                  
                {{date('h:i A', strtotime($each_pt_st_time->product_st_time))}} To
                {{date('h:i A', strtotime($each_pt_st_time->product_end_time))}},
                @endforeach 
               

           </span>
            </h5>
             <h5>Days of a Week <span>
                (
                @foreach($each_gym_product->gym_day as $each_gym_day)

                  {{$each_gym_day->product_days}},
                @endforeach
              )</span></h5>
              </div>
              <div class="clearfix"></div>
              <a href="" class="sign-btn2">Subscribe</a>
              </div>
            </div>
          
            @endforeach
          </div>
          </div>
        </div>
      </div>
            </div>
        </div>
  </section>



@endsection