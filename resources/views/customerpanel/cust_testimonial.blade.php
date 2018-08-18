@extends('frontend.main') 
@section('content')

<!--Testimonial Section-->
    <section class="testimonial-section">
     <h3 class="gyl_header">Testimonials</h3>
      <div class="container">
        <div class="owl-carousel" id="testi-slider">
            @foreach($data as $mydata)
        <div class="test-box">
          <div class="test-img">
            <div class="test-img-box">
              <img src="{{asset('backend/images')}}/{{$mydata->image}}" >
            </div>
          </div>
          <div class="test-text-box">
            <h4>{{$mydata->designation}} : {{$mydata->name}} <span class="designation"></span></h4>
            <p>{{$mydata->description}}</p>
          </div>
        </div>
          @endforeach
        </div>
      </div>
    </section>
@endsection