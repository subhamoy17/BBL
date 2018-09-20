@extends('frontend.main') 
@section('content')


  <!-- //banner -->

<!-- //banner -->
  <!-- About us -->
  <div class="about-3">
    <div class="wthree_head_section">
        <h3 class="gyl_header">Customer Dashboard </h3>
      </div>
    <div class="container">
      <div class="d-flex">
        
        <div class="about1"> 
          <h4>CrossFit and TrainHard GYM </h4>
          <p class="details">Nullam pulvinar vulputate aliquam. Pellentesque venenatis ut mi ac porta. Praesent interdum nibh libero, id malesuada libero aliquet quis. Donec at odio nibh.</p>
          <ul class="about-list">
            <li>
              <div class="col-md-4 we-gyl">
                <img src="{{asset('frontend/images/1.jpg')}}" alt="" class="img-responsive" />
              </div>
              <div class="col-md-8 in-block">
                <h5>ELEMENTS</h5>
                <p>Suspendisse maximus leo vel facilisis porta. Aliquam posuere mollis auctor. Nunc eget massa eleifend, finibus.</p>
              </div>
              <div class="clearfix"> </div>
            </li>
            <li>
            <div class="col-md-4 we-gyl">
                <img src="{{asset('frontend/images/2.jpg')}}" alt="" class="img-responsive" />
              </div>
              <div class="col-md-8 in-block">
                <h5>BOOT CAMP</h5>
                <p>Suspendisse maximus leo vel facilisis porta. Aliquam posuere mollis auctor. Nunc eget massa eleifend, finibus.</p>
              </div>
              <div class="clearfix"> </div>
            </li>
            <li>
              <div class="col-md-4 we-gyl">
                <img src="{{asset('frontend/images/3.jpg')}}" alt="" class="img-responsive" />
              </div>
              <div class="col-md-8 in-block">
                <h5>CROSSFIT</h5>
                <p>Suspendisse maximus leo vel facilisis porta. Aliquam posuere mollis auctor. Nunc eget massa eleifend, finibus.</p>
              </div>
              <div class="clearfix"> </div>
            </li>
          </ul>
        </div>
        <div class="about2">
          
        </div>
      </div>
      
    </div>
  </div>



@endsection