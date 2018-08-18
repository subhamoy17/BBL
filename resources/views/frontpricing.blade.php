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

@endsection