@extends('frontend.main') 
@section('content')
	<div  align="center">
		@if ($message = Session::get('success_paypalpay'))
        <?php $payment_id=Session::get('payment_id');?>
    <div class="w3-panel w3-green w3-display-container">        
        <div class="alert alert-success">
                           <div class="status-ico">
                                <img src="{{asset('frontend/images/tick-flat.png')}}">
                            </div>
                            <p>{!! $message !!}</p>
                            <p>Your Order Ref ID is {!! $payment_id !!}. Please note down that Order Ref ID for future reference.</p>
                        </div>
    </div>
    <?php 
    Session::forget('success_paypalpay');
    Session::forget('payment_id');
    ?>

    @endif
@if ($message = Session::get('failed_paypalpay'))
    <div class="w3-panel w3-red w3-display-container">
                <div class="alert alert-success">
                        <div class="status-ico">
                                <img src="{{asset('frontend/images/cross-flat.png')}}">
                            </div>
                            <p>{!! $message !!}</p>
                        </div>
    </div>
    <?php Session::forget('failed_paypalpay');?>
    @endif

    <a href="{{url('customer/purchase_history')}}" class="btbb">Back</a>
    <a href="{{url('/diet-plan')}}" class="btbb">Purchase Another Diet Plan</a>

	
</div>
	<br>

@endsection