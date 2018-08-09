@extends('frontend.main') 
@section('content')
	
	<div align="center">
    
    @if($data)
    
	<form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"  action="{!! URL:: to('customer/paypalpayment')!!}">
  {{ csrf_field() }}
  <h2 class="w3-text-blue">Pay from here</h2>
  <p>You can choose to pay by using payapl</p>
  <p>      
  <label class="w3-text-blue"><b>Payable Amount</b></label>
  <input class="w3-input w3-border" name="amount" type="text" value="{{$data['slots_price']}}" readonly>
  <input class="w3-input w3-border" name="slots_name" type="hidden" value="{{$data['slots_name']}}">
  <input class="w3-input w3-border" name="slots_number" type="hidden" value="{{$data['slots_number']}}">
  <input class="w3-input w3-border" name="slot_id" type="hidden" value="{{$data['slot_id']}}" >
  <input class="w3-input w3-border" name="payment_options" type="hidden" value="{{$data['payment_options']}}" >
  <input class="w3-input w3-border" name="purchases_date" type="hidden" value="{{$data['purchases_date']}}" >
  <input class="w3-input w3-border" name="package_validity_date" type="hidden" value="{{$data['package_validity_date']}}" >
  <input class="w3-input w3-border" name="customer_id" type="hidden" value="{{$data['customer_id']}}" >

  </p>      
  <button class="w3-btn w3-blue">Pay with PayPal</button></p>
</form>
</div>

@endif

@endsection