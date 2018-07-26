@extends('frontcustomerlayout.main') 
@section('content')

<!--Testimonial Section-->
    <section class="testimonial-section">
      <div class="container">
        <div class="row">
          @foreach($data as $mydata)
          <div class="test-box">
          <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
            <div class="test-img">
              <img src="{{asset('backend/images')}}/{{$mydata->image}}">
            </div>
            <h5>{{$mydata->name}}</h5>
            <h6>{{$mydata->designation}}</h6>
          </div>
          <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
            <div class="test-text">
              <p>{{$mydata->description}}</p>
            </div>
          </div>
          <div class="clearfix"></div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
@endsection