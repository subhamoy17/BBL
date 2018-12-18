@extends('frontend.dashboard_submain') 
@section('content')                              




      <div class="ofr-bnr">
        <article class="ofr1-caption">
          <h2><span>Welcome</span> To Body By Lekan</h2>
          <p>Free Bootcamp Session For You</p>
          <div class="ofr1-btn">
            <!-- <a href="{{url('customer/mybooking')}}">Back To Dashboard</a> -->
            <a href="{{url('customer/booking-bootcamp')}}">Book Your Bootcamp Session</a>
            <div class="clearfix"></div>
          </div>
        </article>
      </div>
  


@endsection