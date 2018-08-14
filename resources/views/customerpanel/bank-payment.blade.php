@extends('frontend.main') 
@section('content')

<div class="contact-box">
            <div class="container">
                <div class="row">
         
                    <div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
                        
                        <div class="form-box">
                            <div class="row">
	
	<div align="center">
    
    @if($data)
    <div class="form-group">
	<form class="w3-container w3-display-middle w3-card-4" enctype="multipart/form-data"method="POST" id="bank_payment-form"  action="bankpaymentsuccess">
  {{ csrf_field() }}
  <h6>Pay from here</h6>
 </br>
  <label class="w3-text-blue"><b>Payable amount is </b>&nbsp;  <i class="fa fa-gbp"></i> {{$data['slots_price']}}</label>
  <br>
  <input class="w3-input w3-border" name="slots_price" type="hidden" value="{{$data['slots_price']}}" readonly >
  <input class="w3-input w3-border" name="slots_name" type="hidden" value="{{$data['slots_name']}}">
  <input class="w3-input w3-border" name="slots_number" type="hidden" value="{{$data['slots_number']}}">
  <input class="w3-input w3-border" name="slot_id" type="hidden" value="{{$data['slot_id']}}" >
  <input class="w3-input w3-border" name="payment_options" type="hidden" value="{{$data['payment_options']}}" >
  <input class="w3-input w3-border" name="purchases_date" type="hidden" value="{{$data['purchases_date']}}" >
  <input class="w3-input w3-border" name="package_validity_date" type="hidden" value="{{$data['package_validity_date']}}" >
  <input class="w3-input w3-border" name="customer_id" type="hidden" value="{{$data['customer_id']}}" >
<label>Description</label>
    <textarea  name="description" id="description"></textarea>
    <input type="file" name="image" id="image">
       
  <button class="btn btn-dark btn-theme-colored btn-flat">Pay with Bank</button></p>
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