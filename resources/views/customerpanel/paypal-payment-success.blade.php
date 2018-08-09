@extends('frontend.main') 
@section('content')
	<div  align="center">
		@if ($message = Session::get('success_paypalpay'))
        <?php $payment_id=Session::get('payment_id');?>
    <div class="w3-panel w3-green w3-display-container">        
        <div class="alert alert-success">
                            <p>{!! $message !!}</p>
                            <p>Your payment ID is {!! $payment_id !!}. Please not down that payment id for future reference.</p>
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
                            <p>{!! $message !!}</p>
                        </div>
    </div>
    <?php Session::forget('failed_paypalpay');?>
    @endif
	</div>
	

@endsection