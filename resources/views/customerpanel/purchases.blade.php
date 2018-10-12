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
                                      <label>Name - <h6>{{$data->name}}</h6></label>
                                      
                                      <label>Email - <h6>{{$data->email}}</h6></label>
                                      
                                      <label>Phone - <h6>{{$data->ph_no}}</h6></label>
                                       
                                    </div>
                                </div>
              <div class="col-md-4 col-sm-12 col-xs-12">
                   <div class="packg-dt">
                   		<h5>Package Details</h5>
                   		 <div class="form-group">
                                      <label>Package Name - <h6>{{$package_details->slots_name}}</h6></label>
                                      
                                      <label>Cost - <h6><i class="fa fa-gbp"></i> {{$package_details->slots_price}}</h6></label>
                                      
                                      <label>No. Of Slots - <h6>{{$package_details->slots_number}}</h6></label>
                                       
                                       <label>Validity - <h6>{{$package_details->slots_validity}} Days</h6></label>
                                       
                                    </div>
                   </div>     
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
               <div class="inputs-w3ls">
                            <form enctype="multipart/form-data" id="frm1" method="post" action="{{route('customer.package_purchase')}}">
                               <input type="hidden" name="_token" value="{{csrf_token()}}">
                              <input type="hidden" name="id" id="id" value="{{$package_details->id}}">

  <!--  -->

                            <h5>Payment Option</h5>
                              <ul>
                                <li>
                                  <input type="radio" id="a-option" name="selector1" value="Paypal">
                                  <label for="a-option" >Paypal </label>
                                  <div class="check"></div>
                                </li>
                                <li>
                                  <input type="radio" id="b-option" name="selector1" value="Bank Transfer">
                                  <label for="b-option" >Bank Transfer</label>
                                  <div class="check"></div>
                                </li>
                              </ul>
                              <label for="selector1" class="error" style="display:none;"></label>
                              <div class="clear"></div>
                          <div class="form-group btn-wrp">
                    <input name="form_botcheck" class="form-control" value="" type="hidden">
                        <button type="submit" id="aqb" class="btn btn-dark btn-theme-colored btn-flat">Submit</button>
                        </div> 
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
  <!-- <script src="{{url('frontend/css/jquery-ui.js')}}"></script> -->
 <!-- <script src="{{url('frontend/css/jquery-1.12.4.js')}}"></script> -->
   <!--  <script>
  $( function() {
    $("#datepicker").datepicker();
  } );
  </script> -->
  
@endsection