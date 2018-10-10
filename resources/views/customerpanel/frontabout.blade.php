@extends('frontend.main') 
@section('content')

	<!-- banner -->
	<div class="main_section_agile about inner">
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
					 <p>Body By Lekan – Because each new day gives us a fresh opportunity to improve yourself… Join us and make the most of it!
Begin your journey to fitness with Body by Lekan, your new health and fitness partner, since 1st March 2018.  The brain child of Lekan, a former world-class athlete whohas competed in manyNational and International sporting and fitness events. With his wide spread knowledge and experience in the field of fitness and well-being, his sole aim is to share his knowledge and experience with you to bring out the best in you and help you achieve your fitness goals.</p><br>

<h5>Our Goal</h5>
<p>
To improveand help people live their life at the fullest through our comprehensive weight loss programs, muscle toning exercises and well planned nutrition plans with the help of our fitness experts. What’s more, we also ensure that you have fun working out with us!</p><br>

<h5>Our Facilities</h5>
<p>
Our world class fitness training facilities comprise of training at our state-of-art gym, boot camp and personal training.
So get set to go for a healthier you. So, no matter if you are planning to work out for fitness for the first time or a fitness freak, get started by booking your fitness package with us today and let the best people from the world of fitness train your body to be its best!
</p>
<p></p>
				</div>
				<div class="clearfix"> </div>
			</div>
</div>
<div class="about-agile inner-padding second">
	<div class="container">
		<h3 class="heading-agileinfo white-gyls">TrainHard is the right place to start new life as an athletic, strong and healthy person with a strong will.</h3>
		<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia .</p>
			<div class="more-button">
				<a href="mailto:info@bodybylekan.com">Mail Us</a>
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