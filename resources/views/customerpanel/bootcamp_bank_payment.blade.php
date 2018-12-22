@extends('frontend.main') 
@section('content')


<script >

  function bank_description()
  {
    // alert('fg');
    if($('#package_description').val()!='')
    {
      
      $('#bank_sub').attr('disabled',false);
      $("#bank_sub").html('Confirm you have paid via Bank transfer');
    }
    else
    {
      $('#bank_sub').attr('disabled',true);
    }
  }


function bank_image()
  {
    // alert('fg');
    if($('#package_image').val()!='')
    {
      
      $('#bank_sub').attr('disabled',false);
      $("#bank_sub").html('Confirm you have paid via Bank transfer');
    }
    else
    {
      $('#bank_sub').attr('disabled',true);
    }
  }
</script>



<div class="contact-box">
            <div class="container">
                <div class="row">
         
                    <div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
                        
                        <div class="form-box form-box-pay2">
                            <div class="row">
	
	<div class="paymnt-paypal paymnt-paypal2">
    
    @if($package_details)
    <div class="form-group">
	<form class="w3-container w3-display-middle w3-card-4" enctype="multipart/form-data" method="POST" id="bank_payment-form"  action="{{url('customer/bootcamp_bankpaymentsuccess')}}">
  {{ csrf_field() }}
  <h6>Pay via Bank Transfer</h6>
  <div class="acnt-det">
    <p><h5>Account Name: </h5> <span>BODYBYLEKAN FITNESS LIMITED</span></p>
    <p><h5>Sort Code: </h5> <span> 09-01-29</span></p>
    <p><h5>Account No: </h5> <span>33473491</span></p>
  </div>
  <label class="w3-text-blue"><b>Payable amount is </b>&nbsp;  <span class="pay-pal-price"><i class="fa fa-gbp"></i> @if($package_details->payment_type_name=='Subscription')
    {{$package_details->price_session_or_month}}
                @else
    {{$package_details->total_price}}
  @endif</span></label>
  
  <input class="w3-input w3-border" name="product_id" type="hidden" value="{{$package_details->product_id}}" readonly >
  
    <label><h5 class="line-h5">Description</h5>
    </br> <strong>Please use the same reference used in bank transfer</strong>

     <!--  <span id="gg" class="toolclip" data-tooltipster='{"side":"left","animation":"fade"}' data-tooltip-content="#tooltip_content"><i class="fa fa-info-circle" style="margin-left: 5px;font-size: 15px;"></i></span>
              <div class="tooltip_templates">
          <span id="tooltip_content">
              
                            
          </span>
      </div> -->

    </label><textarea  name="package_description" id="package_description" onkeypress="bank_description();"></textarea><br>
    <label><h5 class="line-h5">Upload Payment Document</h5> </br>
      <strong>Alternatively you can provide the screenshot of the bank transfer</strong>
    </label><input type="file" name="package_image" id="package_image" onchange="bank_image();">
      

         @if($package_details->payment_type_name=='Subscription')
          <label>Subscription Start Date</label>
          <input type="text" id="subscription_start_date" name="subscription_start_date" class="form-control date-control"  readonly="true">
          @endif

       
  <button class="btn btn-dark btn-theme-colored btn-flat" id="bank_sub" name="submit">Confirm you have paid via Bank transfer</button>
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
