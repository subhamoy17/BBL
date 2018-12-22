@extends('frontcustomerlayout.main') 
@section('content')

<script type="text/javascript">
    function bt_plan() {
        $('#bt_plan').show();
        $('#pt_plan').hide();
    }
    function pt_plan() {
        $('#bt_plan').hide();
        $('#pt_plan').show();
    }
</script>



<section class="pricing df-pricing">
    <div class="container">
        <h3 class="gyl_header">Choose Your<span id="bt_plan"> Bootcamp </span><span id="pt_plan" style="display: none;"> Personal Training </span> Plan</h3>
          <div class="row">
            <div id="plantabs">
                <ul>
                    <li><a href="#tabs-1"  onclick="bt_plan();">Bootcamp Plans</a></li>
                    <li><a href="#tabs-2"  onclick="pt_plan();">Personal Training Plans</a></li>
                    <!-- <li><a href="#tabs-4">Aenean lacinia</a></li> -->
                </ul>
                
                <div id="tabs-1">
        <div id="bootcamp-slider2" class="owl-carousel">
          @if(count($bootcamp_product_details)>0)
            @foreach($bootcamp_product_details as $bc_key=>$each_bootcamp_product)
            <div class="price-box" style="background: url(/frontend/images/banner1.jpg)no-repeat center top / cover; min-height:300px;">
              <div class="p-box-head cmn-3">
              <h3><span>{{$each_bootcamp_product->validity? 'Validity '.$each_bootcamp_product->validity.' Days' : 'Monthly'}}</span></h3>
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
                  <a href="{{route('bootcamp_plan_purchase',['bootcamp_plan_id' => Crypt::encrypt($each_bootcamp_product->product_id) ])}}" class="sign-btn2">Purchase</a>
                   @else
                <a href="{{route('customer_purchase_login',['bootcamp_plan_id' => Crypt::encrypt($each_bootcamp_product->product_id) ])}}" class="sign-btn2">Purchase</a>
                @endif
              </div>
            </div>
          
            @endforeach
          @endif
         
          </div>
      </div>
       <div id="tabs-2">
        <div id="bootcamp-slider2" class="owl-carousel">
          @if(count($personal_training_product_details)>0)
             @foreach($personal_training_product_details as $pt_key=>$each_personal_training_product)
            <div class="price-box" style="background: url(/frontend/images/banner4.jpg)no-repeat center top / cover; min-height:300px;">
              <div class="p-box-head cmn-3">
           
              <h3><span> {{$each_personal_training_product->validity? 'Validity '.$each_personal_training_product->validity.' Days' : 'Monthly'}}</span></h3>
              <h1><i class="fa fa-gbp"></i> {{$each_personal_training_product->total_price}} <br> 
                <span>{{$each_personal_training_product->payment_type_name}}
                     @if($each_personal_training_product->payment_type_name=='Subscription')
                (Notice Period 
                {{$each_personal_training_product->notice_period_value*$each_bootcamp_product->notice_period_duration}} Days)
                @endif
                </span></h1>
              
              <div class="btm-arow"><i class="fa fa-arrow-circle-down"></i></div>
              <div class="plan-batch bch-3">PT Plan</div>
              <div class="cntrct"><h5>Contract <span> - {{$each_personal_training_product->contract? $each_personal_training_product->contract : 'N/A'}}</span></h5></div>
              </div>
              <div class="p-box-bdy">
              

              <h2>
                @if($each_personal_training_product->total_sessions!='Unlimited')
                  {{$each_personal_training_product->total_sessions}}<span>Slots</span>
                @else
                  {{substr($each_personal_training_product->total_sessions,0,1)}}<span>{{substr($each_personal_training_product->total_sessions,1,8)}}</span>
                @endif
              </h2>
              


              <div class="clearfix"></div>

             @if(Auth::guard('customer')->check())
                  <a href="{{route('pt_plan_purchase',['bootcamp_plan_id' => Crypt::encrypt($each_personal_training_product->product_id) ])}}" class="sign-btn2">Purchase</a>
                   @else
                <a href="{{route('customer_purchase_login',['bootcamp_plan_id' => Crypt::encrypt($each_personal_training_product->product_id) ])}}" class="sign-btn2">Purchase</a>
                @endif
              </div>
            </div>
          
            @endforeach
         @endif
          </div>
      </div>
      <!-- <div id="tabs-4">
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
      </div> -->
          </div>
        </div>
        </div>
      </div>
            </div>
        </div>
  </section>



@endsection