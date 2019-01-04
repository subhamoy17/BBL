@extends('frontend.main') 
@section('content')
	<div  align="center">

    <!-- bank payment -->

    @if ($message = Session::get('success_bootcamp_stripe'))
        <?php $order_id=Session::get('order_id');?>
    <div class="w3-panel w3-green w3-display-container">        
        <div class="alert alert-success">
                           <div class="status-ico">
                                <img src="{{asset('frontend/images/tick-flat.png')}}">
                            </div>
                            <p>{!! $message !!}</p>
                            <p>Your Order Ref ID is {!! $order_id !!}. Please note down that Order Ref ID for future reference.</p>
                        </div>
    </div>
    <?php 
    Session::forget('success_bootcamp_stripe');
    Session::forget('order_id');
    ?>
    <a href="{{url('customer/purchased-history')}}" class="btbb">Back</a>
    <a href="{{url('pricing/bc')}}" class="btbb">Purchase Another Bootcamp Package</a>
    @endif

    @if ($message = Session::get('failed_bootcamp_stripe'))
    <div class="w3-panel w3-green w3-display-container">        
        <div class="alert alert-success">
                           <div class="status-ico">
                                <img src="{{asset('frontend/images/cross-flat.png')}}">
                            </div>
                            <p>{!! $message !!}</p>
                        </div>
    </div>
    <?php 
    Session::forget('failed_bootcamp_stripe');
    ?>
    <a href="{{url('customer/purchased-history')}}" class="btbb">Back</a>
    <a href="{{url('pricing/bc')}}" class="btbb">Purchase Another Bootcamp Package</a>
    @endif

    @if ($message = Session::get('success_bootcamp_bank'))
        <?php $payment_id=Session::get('payment_id');?>
    <div class="w3-panel w3-green w3-display-container">        
        <div class="alert alert-success">
                            <div class="status-ico">
                                <img src="{{asset('frontend/images/tick-flat.png')}}">
                            </div>
                            <p>Thank You for the payment!</p>
                            <p>Your Order Ref ID is {!! $payment_id !!}. Please note down that Order Ref ID for future reference.</p>
                            
                        </div>
                        
    </div>
    <?php 
    Session::forget('success_bootcamp_bank');
    Session::forget('payment_id');
    ?>
    <a href="{{url('customer/purchased-history')}}" class="btbb">Back</a>
    <a href="{{url('pricing/bc')}}" class="btbb">Purchase Another Bootcamp Package</a>
    @endif

    @if ($message = Session::get('success_pt_stripe'))
        <?php $order_id=Session::get('order_id');?>
    <div class="w3-panel w3-green w3-display-container">        
        <div class="alert alert-success">
                           <div class="status-ico">
                                <img src="{{asset('frontend/images/tick-flat.png')}}">
                            </div>
                            <p>{!! $message !!}</p>
                            <p>Your Order Ref ID is {!! $order_id !!}. Please note down that Order Ref ID for future reference.</p>
                        </div>
    </div>
    <?php 
    Session::forget('success_pt_stripe');
    Session::forget('order_id');
    ?>
    <a href="{{url('customer/purchased-history')}}" class="btbb">Back</a>
    <a href="{{url('pricing/pt')}}" class="btbb">Purchase Another PT Package</a>
    @endif

    @if ($message = Session::get('failed_pt_stripe'))
    <div class="w3-panel w3-green w3-display-container">        
        <div class="alert alert-success">
                           <div class="status-ico">
                                <img src="{{asset('frontend/images/cross-flat.png')}}">
                            </div>
                            <p>{!! $message !!}</p>
                        </div>
    </div>
    <?php 
    Session::forget('failed_pt_stripe');
    ?>

    <a href="{{url('customer/purchased-history')}}" class="btbb">Back</a>
    <a href="{{url('pricing/pt')}}" class="btbb">Purchase Another PT Package</a>
    @endif

    @if ($message = Session::get('success_pt_bank'))
        <?php $payment_id=Session::get('payment_id');?>
    <div class="w3-panel w3-green w3-display-container">        
        <div class="alert alert-success">
                            <div class="status-ico">
                                <img src="{{asset('frontend/images/tick-flat.png')}}">
                            </div>
                            <p>Thank You for the payment!</p>
                            <p>Your Order Ref ID is {!! $payment_id !!}. Please note down that Order Ref ID for future reference.</p>
                            
                        </div>
                        
    </div>
    <?php 
    Session::forget('success_pt_bank');
    Session::forget('payment_id');
    ?>
    <a href="{{url('customer/purchased-history')}}" class="btbb">Back</a>
    <a href="{{url('pricing/pt')}}" class="btbb">Purchase Another PT Package</a>
    @endif

	
</div>
	<br>

@endsection