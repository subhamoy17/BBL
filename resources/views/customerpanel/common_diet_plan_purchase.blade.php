@extends('frontend.main') 
@section('content')



        <div class="contact-box">
            <div class="container">
                <div class="row">
         
                    <div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
                        
                        <div class="form-box form-pur">
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                    <h5>Customer Details</h5>
                                      <label>Name - <h6>{{Auth::guard('customer')->user()->name}}</h6></label>
                                      
                                      <label>Email - <h6>{{Auth::guard('customer')->user()->email}}</h6></label>
                                      
                                      <label>Phone - <h6>{{Auth::guard('customer')->user()->ph_no}}</h6></label>
                                       
                                    </div>
                                </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                   <div class="packg-dt">
                      <h5>Diet Plan Details</h5>
                       <div class="form-group">
                                      <label>Diet Plan Name - <h6>{{$common_diet_plan->diet_plan_name}}</h6></label>
                                      <span class="rev-line">
                                      <label class="line-t">Price - <h6 class="line-t"><i class="fa fa-gbp"></i> {{$common_diet_plan->price}}</h6></label>
                                      </span>
                                      <label>Author Name - <h6>{{$common_diet_plan->author_name}}</h6></label>
                                       
                                    </div>
                   </div>     
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
               <div class="inputs-w3ls">
                           <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"  action="{!! URL:: to('customer/common-diet-plan-pay')!!}">
  {{ csrf_field() }}
  <h5>Pay from here</h5>
  <label class="w3-text-blue"><b>Payable amount is </b>&nbsp;  <span class="pay-pal-price"><i class="fa fa-gbp"></i> {{$common_diet_plan->price}}</span></label>
  <input class="w3-input w3-border" name="diet_plan_id" type="hidden" value="{{$common_diet_plan->id}}">
  <input class="w3-input w3-border" name="customer_id" type="hidden" value="{{Auth::guard('customer')->user()->id}}">
  </p>      
  <button class="btn btn-dark btn-theme-colored btn-flat"><i class="fa fa-paypal"></i> Pay with PayPal</button></p>
</form>
                    </div> 
                        
                         </div>
                  <div class="clearfix"></div>
                           <div class="col-lg-12 text-right">
                            
                           </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <link rel="stylesheet" href="{{url('frontend/css/jquery-ui.css')}}">
 <link href="{{url('frontend/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />
 
  
@endsection