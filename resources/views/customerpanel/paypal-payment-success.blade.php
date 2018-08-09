@extends('frontend.main') 
@section('content')
	<div  align="center">
		@if ($message = Session::get('success_paypalpay'))
    <div class="w3-panel w3-green w3-display-container">
        <span onclick="this.parentElement.style.display='none'"
                class="w3-button w3-green w3-large w3-display-topright">&times;</span>
        <p>{!! $message !!}</p>
    </div>
    <?php Session::forget('success_paypalpay');?>
    @endif
@if ($message = Session::get('failed_paypalpay'))
    <div class="w3-panel w3-red w3-display-container">
        <span onclick="this.parentElement.style.display='none'"
                class="w3-button w3-red w3-large w3-display-topright">&times;</span>
        <p>{!! $message !!}</p>
    </div>
    <?php Session::forget('failed_paypalpay');?>
    @endif
	</div>
	

@endsection