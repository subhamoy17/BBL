@extends('frontcustomerlayout.main') 
@section('content')
	<!-- banner -->
	<div class="main_section_agile about ">
	</div>
	<!-- //banner -->
	<!-- about inner -->
<div class="about-bottom inner-padding">
	<div class="container">
		<div class="wthree_head_section">
				<h3 class="gyl_header">Personal <span>Instructors</span></h3>
			</div>
				<div class="about-bott-right pti">
					<div class="col-lg-5 col-xs-12">
						<div class="pt-vd-box">
							<iframe width="100%" height="300px" src="https://www.youtube.com/embed/aYaFyAtPrB4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						</div>
					</div>
					<div class="col-lg-7 col-xs-12">
						<div class="pt-box">
							<div class="pt-img">
								<img src="{{asset('frontend/images/t3.jpg')}}">
							</div>
							<div class="pt-name">
								<h5>Personal Instructor 1</h5>
								<h6>Designation</h6>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="pt-text">
							<p>When working as personal trainer you’ll be at a more advanced level than those working as a fitness instructor; as you’ll be trained to level 3. It’s also worth noting that those who become fitness instructors, often train and advance to being personal trainers.</p>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-lg-5 col-xs-12">
						<div class="pt-vd-box">
							<iframe width="100%" height="300" src="https://www.youtube.com/embed/tccdbY5xcf4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						</div>
					</div>
					<div class="col-lg-7 col-xs-12">
						<div class="pt-box">
							<div class="pt-img">
								<img src="{{asset('frontend/images/t2.jpg')}}">
							</div>
							<div class="pt-name">
								<h5>Personal Instructor 2</h5>
								<h6>Designation</h6>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="pt-text">
							<p>Most personal trainers are also self-employed, with almost 50% of those within the sector becoming their own boss [1]. With this, many different leisure centres, health clubs and gyms will have different propositions they give to self-employed staff; where they’ll take a percentage of what they earn, in order for the trainer to use the establishment’s facilities to train their clients. Most personal trainers charge between £20 and £40 an hour [1]; this also mean that things such as tax is the responsibility of the personal trainer.</p>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
</div>


@endsection