@extends('frontend.main') 
@section('content')

<style type="text/css">
    .submit-button {
  margin-top: 10px;
}
</style>
<script src='https://js.stripe.com/v2/' type='text/javascript'></script>

<div class="contact-box">
            <div class="container">
                <div class="row">
         
                    <div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
                        
                        <div  class="form-box form-box-pay2">
                            <div class="row">
  
  <div align="center" class="paymnt-paypal">
    <h6>Pay from here</h6>
  <label>You can choose to pay by using stripe payment gateway</label></br>
    @if($package_details)
     <form accept-charset="UTF-8" action="{{route('pt_strip_payment')}}" class="require-validation"
    data-cc-on-file="false"
    data-stripe-publishable-key="{{env('STRIPE_PUBLIC_KEY')}}"
    id="payment-form" method="post">
    {{ csrf_field() }}
    <input class="w3-input w3-border" name="product_id" type="hidden" value="{{$package_details->product_id}}" >
    <div class='form-row'>
        <div class='col-md-12 form-group required'>
            <label class='control-label'>Name on Card</label> <input
                class='form-control' size='4' type='text'>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-md-12 form-group card required'>
            <label class='control-label'>Card Number</label> <input
                autocomplete='off' class='form-control card-number' size='20'
                type='text'>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-md-4 form-group cvc required'>
            <label class='control-label'>CVC</label> <input autocomplete='off'
                class='form-control card-cvc' placeholder='ex. 311' size='4'
                type='text'>
        </div>
        <div class='col-md-4 form-group expiration required'>
            <label class='control-label'>Expiration</label> <input
                class='form-control card-expiry-month' placeholder='MM' size='2'
                type='text'>
        </div>
        <div class='col-md-4 form-group expiration required'>
            <label class='control-label'>&nbsp;</label> <input
                class='form-control card-expiry-year' placeholder='YYYY' size='4'
                type='text'>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-md-12'>
            <div class='form-control total btn-info' style="padding: 13px;">
                Total payable amount is <span class='amount'><i class="fa fa-gbp"></i> {{intval($package_details->total_price)}}</span>
            </div>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-md-12 form-group'>
            <button class='form-control btn btn-primary submit-button stripe-pay-btn'
                type='submit' style="margin-top: 10px;">Pay »</button>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-md-12 error form-group hide'>
            <div class='alert-danger alert' style="font-size: 17px;">Please correct the errors and try again.</div>
        </div>
    </div>
</form>
        </div>
        <div class='col-md-4'></div>
    </div>
</div>



@endif

</div>
</div>
</div>
</div>
</div>
</div>
</div>


@endsection