@extends('frontend.main') 
@section('content')

	<!-- banner -->
	<div class="inner">
	</div>
	<!-- //banner -->
	<!-- about inner -->
<div class="about-bottom inner-padding">
	<div class="container">
		<div class="wthree_head_section">
				<h3 class="gyl_header">About <span>Us</span></h3>
			</div>
				<div class="about-bott-right">
					 <h5>Who We Are</h5>
					 <p>Masagni dolores eoquie int Basmodi temporant, ut laboreas dolore magnam aliquam kuytase uaeraquis autem vel eum iure reprehend.Unicmquam eius, Basmodi temurer sehsMunim.Masagni dolores eoquie int Basmodi temporant, ut laboreas dolore magnam aliquam kuytase uaeraquis autem vel eum iure reprehend.</p>
				</div>
				<div class="clearfix"> </div>
			</div>
</div>
<div class="about-agile inner-padding">
	<div class="container">
		<h3 class="heading-agileinfo white-gyls">TrainHard is the right place to start new life as an athletic, strong and healthy person with a strong will.</h3>
		<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia .</p>
			<div class="more-button">
				<a href="#">Mail Us</a>
			</div>
	</div>
</div>
<!-- //about inner -->
<!-- Team -->
<div class="team">
		<div class="container">

		<div class="wthree_head_section">
				<h3 class="gyl_header">Our <span>Trainers</span></h3>
			</div>
		 
			<div class="owl-carousel" id="team-slider">
				@foreach($data as $mydata)
				<div class="agile_team_grid">
					<div class="view view-sixth"> 

						<img src="{{asset('backend/images')}}/{{$mydata->image}}" alt=" " class="img-responsive">
						<div class="mask">
							<h5>{{$mydata->title}}</h5>
							<p>{{$mydata->description}}</p>
							<div class="agileits_social_icons">
								<ul class="social_agileinfo">
									<li><a href="{{$mydata->facebook}}" target="_blank" class="gy_facebook"><i class="fa fa-facebook"></i></a></li>
									<li><a href="{{$mydata->twitter}}" target="_blank" class="gy_twitter"><i class="fa fa-twitter"></i></a></li>
									<li><a href="{{$mydata->instagram}}" target="_blank" class="gy_instagram"><i class="fa fa-instagram"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
					<h4>{{$mydata->name}}</h4>
					<p>{{$mydata->designation}}</p>
				</div>
		 @endforeach
			</div>
	
		</div>
	</div>




@endsection