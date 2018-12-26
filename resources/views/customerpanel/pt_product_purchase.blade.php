@extends('frontend.main') 
@section('content')
        <div class="contact-box">
            <div class="container">
                <div class="row">
                  <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3"></div>

         
                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
                        
                        <div class="form-box form-pur">
                            <div class="row">
                                <!-- <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
										<h5>Customer Details</h5>
                                      <label>Name - <h6>{{Auth::guard('customer')->user()->name}}</h6></label>
                                      
                                      <label>Email - <h6>{{Auth::guard('customer')->user()->email}}</h6></label>
                                      
                                      <label>Phone - <h6>{{Auth::guard('customer')->user()->ph_no}}</h6></label>
                                       
                                    </div>
                                </div> -->
              <div class="col-md-6 col-sm-12 col-xs-12">
                   <div class="packg-dt">
                   		<h5>Product Details</h5>
                   		 <div class="form-group">

                                      <label>Package Type - <h6>{{$package_details->product_name}}</h6></label>
                                      <span class="rev-line">
                                      <label class="line-t">Price - <h6 class="line-t"><i class="fa fa-gbp"></i> {{$package_details->total_price}}</h6></label>
                                      </span>
                                      <label>No. Of Sessions - <h6>{{$package_details->total_sessions}}</h6></label>
                                       
                                       <label>Validity - <h6>{{$package_details->validity? $package_details->validity.' Days' : 'N/A'}}</h6></label>
                                    </div>
                   </div>     
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
               <div class="inputs-w3ls">
                            <form enctype="multipart/form-data" id="frm1" method="post" action="{{route('pt_product_purchase_request')}}" autocomplete="off">
                               <input type="hidden" name="_token" value="{{csrf_token()}}" >
                              <input type="hidden" name="product_id" id="product_id" value="{{$package_details->product_id}}">

                            <h5>Payment Option</h5>
                              <ul>
                                @if($package_details->payment_type_name=='Pay as you go')
                                <li>
                                  <input type="radio" id="a-option" name="selector1" value="Stripe">
                                  <label for="a-option" >Stripe</label>
                                  <div class="check"></div>
                                </li>
                                @endif
                                <li>
                                  <input type="radio" id="b-option" name="selector1" value="Bank Transfer">
                                  <label for="b-option" >Bank Transfer</label>
                                  <div class="check"></div>
                                </li>
                              </ul>

                              <label for="selector1" id="check_error" class="error coupon-err-st" style="display:none;"></label>
                              <div class="clear"></div>
                          <div class="form-group btn-wrp">
                    <input name="form_botcheck" class="form-control" value="" type="hidden">
                        <button type="submit" id="aqb" class="btn btn-dark btn-theme-colored btn-flat">Submit</button>
                        </div> 
                		</div> 
                        
                         </div>
             			<div class="clearfix"></div>
                           
                            </div>
                        </div>
                    </div>
                  <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3"></div>
                </div>
            </div>
        </div>
    </section>
  <link rel="stylesheet" href="{{url('frontend/css/jquery-ui.css')}}">
 <link href="{{url('frontend/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />
 
  
@endsection