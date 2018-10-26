@extends('frontend.main') 
@section('content')


<div class="contact-box">
            <div class="container">
                <div class="row">
         
                    <div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
                        
                        <div class="form-box form-box-pay2">
                            <div class="row">
	
	<div class="paymnt-paypal paymnt-paypal2">
    
    @if($data)
    <div class="form-group">
	<form class="w3-container w3-display-middle w3-card-4" enctype="multipart/form-data" method="POST" id="bank_payment-form"  action="{{url('customer/bankpaymentsuccess')}}">
  {{ csrf_field() }}
  <h6>Pay from here</h6>
  <div class="acnt-det">
    <!-- <p><h5>Name: </h5> <span>Body By Lekan</span></p> -->
    <p><h5>Sort Code: </h5> <span> 23-69-72</span></p>
    <p><h5>Account No: </h5> <span> 04449181</span></p>
  </div>
  <label class="w3-text-blue"><b>Payable amount is </b>&nbsp;  <span class="pay-pal-price"><i class="fa fa-gbp"></i> {{$data['slots_price']}}</span></label>
  <input class="w3-input w3-border" name="slots_price" type="hidden" value="{{$data['slots_price']}}" readonly >
  <input class="w3-input w3-border" name="slots_name" type="hidden" value="{{$data['slots_name']}}">
  <input class="w3-input w3-border" name="slots_number" type="hidden" value="{{$data['slots_number']}}">
  <input class="w3-input w3-border" name="slot_id" type="hidden" value="{{$data['slot_id']}}" >
  <input class="w3-input w3-border" name="payment_options" type="hidden" value="{{$data['payment_options']}}" >
  <input class="w3-input w3-border" name="purchases_date" type="hidden" value="{{$data['purchases_date']}}" >
  <input class="w3-input w3-border" name="package_validity_date" type="hidden" value="{{$data['package_validity_date']}}" >
  <input class="w3-input w3-border" name="customer_id" type="hidden" value="{{$data['customer_id']}}" >
    <label><h5 class="line-h5">Description</h5>
    </br> <strong>Please use the same reference used in bank transfer</strong>

     <!--  <span id="gg" class="toolclip" data-tooltipster='{"side":"left","animation":"fade"}' data-tooltip-content="#tooltip_content"><i class="fa fa-info-circle" style="margin-left: 5px;font-size: 15px;"></i></span>
              <div class="tooltip_templates">
          <span id="tooltip_content">
              
                            
          </span>
      </div> -->

    </label><textarea  name="package_description" id="package_description"></textarea><br>
    <label><h5 class="line-h5">Upload Payment Document</h5> </br>
      <strong>Alternatively you can provide the screenshot of the bank transfer</strong>
    </label><input type="file" name="package_image" id="package_image">
       
  <button class="btn btn-dark btn-theme-colored btn-flat" id="aba">Pay with Bank</button>
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