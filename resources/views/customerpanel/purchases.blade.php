@extends('frontend.main') 
@section('content')



        <div class="contact-box">
            <div class="container">
                <div class="row">
         
                    <div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
                        
                        <div class="form-box">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">

                          
                                      <label>Name <small>*</small></label>
                                      <h6>{{$data->name}}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                      <label>Email <small>*</small></label>
                                     <h6>{{$data->email}}</h6>
                                    </div>
                                </div>
                               
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                      <label>Phone</label>
                                       <h6>{{$data->ph_no}}</h6>
                                    </div>
                                </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="inputs-w3ls">
                            <form enctype="multipart/form-data" id="frm1" method="post" action="{{route('customer.purchaseinsert')}}">
                               <input type="hidden" name="_token" value="{{csrf_token()}}">
                              <input type="hidden" name="id" id="id" value="{{$slot_id}}">


                            <label>Specify your current employment status</label>
                              <ul>
                                <li>
                                  <input type="radio" id="a-option" name="selector1" value="Paypal">
                                  <label for="a-option" >Paypal </label>
                                  <div class="check"></div>
                                </li>
                                <li>
                                  <input type="radio" id="b-option" name="selector1" value="Banking Transter">
                                  <label for="b-option" >Banking transter</label>
                                  <div class="check"></div>
                                </li>
                              </ul>
                              <label for="selector1" class="error" style="display:none;"></label>
                              <div class="clear"></div>
                              @if($errors->has('selector1'))
                    <span class="required_field_color">
                      <strong>{{ $errors->first('selector1') }}</strong>
                       </span>
                        @endif
                </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="form-group">
                    <input name="form_botcheck" class="form-control" value="" type="hidden">
                        <button type="submit" class="btn btn-dark btn-theme-colored btn-flat" data-loading-text="Please wait...">Submit</button>
                        </div>  
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
  <script src="{{url('frontend/css/jquery-ui.js')}}"></script>
 <script src="{{url('frontend/css/jquery-1.12.4.js')}}"></script>
    <script>
  $( function() {
    $("#datepicker").datepicker();
  } );
  </script>
@endsection