@extends('frontend.main') 
@section('content')
<div class="contact-box">
            <div class="container">
                <div class="row">
         
                    <div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
                        
                        <div class="form-box form-box-pay" style="width: 500px;">
                            <div class="row">
  
  <div align="center" class="paymnt-paypal">
    
    @if($package_details)
    <div class="form-group">
	<form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"  action="{!! URL:: to('customer/bootcamp-onlinepayment')!!}">
  {{ csrf_field() }}
  <h6>Pay from here</h6>
  <label>You can choose to pay by using online payment</label></br>
  <label class="w3-text-blue"><b>Payable amount is </b>&nbsp;  <span class="pay-pal-price"><i class="fa fa-gbp"></i> {{$package_details->total_price}}</span></label>
 
  <input class="w3-input w3-border" name="product_id" type="hidden" value="{{$package_details->product_id}}" >
  </p>      
  <button class="btn btn-dark btn-theme-colored btn-flat"> Pay Online</button></p>
</form>
</div>
</div>



@endif

</div>
</div>
</div>
</div>
</div>
</div>
@endsection