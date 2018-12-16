
  <div class="inner-padding">
    <div class="container">
      <div class="hstry-box">
      <ul class="tabs">

        <li class="{{ Request::segment(2) === 'mybooking' ? 'active' : null }}" rel="tab1"><a href="{{url('customer/mybooking')}}"><i class="fa fa-check"></i> My Booking</a></li>

        <!-- <li class="{{ Request::segment(2) === 'purchase_history' ? 'active' : null }}" rel="tab2"><a href="{{url('customer/purchase_history')}}"><i class="fa fa-check"></i> Purchase History</a></li> -->

				<li class="{{ Request::segment(2) === 'my_mot' ? 'active' : null }}" rel="tab3"><a href="{{url('customer/my_mot')}}"><i class="fa fa-check"></i>My MOT</a></li>
				<!-- <li class="{{ Request::segment(2) === 'my-diet-plan' ? 'active' : null }}" rel="tab4"><a href="{{url('customer/my-diet-plan')}}"><i class="fa fa-check"></i>Purchased Diet Plan</a></li> -->
				<li class="{{ Request::segment(2) === 'purchased-history' ? 'active' : null }}" rel="tab4"><a href="{{url('customer/purchased-history')}}"><i class="fa fa-check"></i>Purchased History</a></li>

				@if(Session::has('free_sessions_booking') && Session::get('free_sessions_booking')==1)
				
        <li class="{{ Request::segment(2) === 'free-sessions' ? 'active' : null }}" rel="tab1"><a href="{{url('customer/free-sessions')}}"><i class="fa fa-check"></i>Free Session</a></li>

        @endif
			</ul>