
  <div class="inner-padding">
    <div class="container">
      <div class="hstry-box">
      <ul class="tabs">
        <li class="{{ Request::segment(2) === 'mybooking' ? 'active' : null }}" rel="tab1"><a href="{{url('customer/mybooking')}}"><i class="fa fa-check"></i> My Booking</a></li>

          <li class="{{ Request::segment(2) === 'purchase_history' ? 'active' : null }}" rel="tab2"><a href="{{url('customer/purchase_history')}}"><i class="fa fa-check"></i> Purchases History</a></li>

<li class="{{ Request::segment(2) === 'my_mot' ? 'active' : null }}" rel="tab3"><a href="{{url('customer/my_mot')}}"><i class="fa fa-check"></i>My MOT</a></li>

                         </ul>