@extends('frontcustomerlayout.main') 
@section('content')
<div class="exercise-sec">
  <div class="container">
    <div class="wthree_head_section">
      <h3 class="gyl_header">Top <span>Exercise</span></h3>
    </div>
    <div class="exercise-wrp">
      <div class="row">
        @foreach($data as $mydata)
        <div class="exr-box">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 exr-txt">
            <div class="exr-emg">
              <h4><span>{{$mydata->title}}</span></h4>
              <p>{{$mydata->description}}</p>
              <h5><span>Duration:</span> {{$mydata->duration}} <span>Days</span></h5>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="exr-emg">
              @if(isset($mydata->video) && !empty($mydata->video))
                <iframe src="{{$mydata->video}}" width="100%" height="315" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
              @elseif(isset($mydata->image) && !empty($mydata->image))
                <img src="{{asset('backend/images')}}/{{$mydata->image}}" height="315">
              @endif
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        @endforeach
      </div>
    </div>
  </div> 
</div> 
@endsection