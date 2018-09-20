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
					 <p>We are your complete fitness solution. From regular weight checkups to periodic heart rate monitoring, checking of blood pressure and body fat ratio measure, to suggesting the right diet according to your body, we have it all. Every package we offer is designed under the supervision of body building experts to give you the best.</p>
				</div>
				<div class="clearfix"> </div>
			</div>
</div>
<div class="about-agile inner-padding">
	<div class="container">
		<h3 class="heading-agileinfo white-gyls">Body by Lekan is the right place to begin a healthy life with a strong will that will keep you fit for days to come.</h3>
		<p>To know more about the services we offer.</p>
			<div class="more-button">
				<a href="mailto:info@example.com">Mail Us</a>
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