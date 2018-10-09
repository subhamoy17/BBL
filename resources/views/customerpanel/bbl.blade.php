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
          <h4>GYM TRAINING & WORKOUT PLANS FOR A HEALTHY YOU</h4>
          <p class="details">From Gym training to diet plans and comprehensive health packages. We design your daily workout to fit your mind and body at its best.</p>
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