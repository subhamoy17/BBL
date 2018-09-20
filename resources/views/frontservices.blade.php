@extends('frontcustomerlayout.main') 
@section('content')

	<!-- banner -->
	<div class="main_section_agile inner">
	</div>
	<!-- //banner -->
	<div class="wthree-blog padding-min">
	<div class="container">
		<div class="wthree_head_section">
				<h3 class="gyl_header">Our <span>Services</span></h3>
			</div>
		<div class="blog1">
			<div class="blog-box">
				<a href="#" data-toggle="modal" data-target="#myModal1"><img src="{{asset('frontend/images/1.jpg')}}" alt="blog image" class="img-responsive" /></a>
				<div class="blog-txt">
					<h3><a href="#" data-toggle="modal" data-target="#myModal1">Gym Services</a></h3>
					<h4>December 15,2017</h4>
					<p>Our advanced gym facilities come with the best equipment’s and trainers. Our fitness trainers will provide you with the latest fitness trends and methods to keep your body fit and healthy. You can use our state of art world class gym at any time of your convenience.</p>
					
					

				</div>
			</div>
			
		</div>
		<div class="blog2">
			<div class="blog-box">
				<div class="blog-txt">
					<h3><a href="#" data-toggle="modal" data-target="#myModal1">Personalized Trainers</a></h3>
					<h4>December 25,2017</h4>
					<p>We provide personalized trainers for advising and guiding you on the best exercises and dietary regime to keep your body fit. Personal attention given by our experienced trainers will go a long way in giving you the fitness you always wanted. Your trainer can also provide you training at home at your convenient time.</p>
					
				</div>
				<a href="#" data-toggle="modal" data-target="#myModal1"><img src="{{asset('frontend/images/7.jpg')}}" alt="blog image" class="img-responsive" /></a>
				
			</div>
		</div>
		<div class="blog1">
			<div class="blog-box">
				<a href="#" data-toggle="modal" data-target="#myModal1"><img src="{{asset('frontend/images/3.jpg')}}" alt="blog image" class="img-responsive" /></a>
				<div class="blog-txt">
					<h3><a href="#" data-toggle="modal" data-target="#myModal1">Diet Plans</a></h3>
					<h4>December 15,2017</h4>
					<p>Body by Lekan provides dietary plans, charts and modules to help you eat healthy and keep your body fit. Daily food charts, dietary plans to help you to reduce weight, suggestions to include proteins and nutrients to make the body strong are some of the other factors covered in the diet plans provided to our customers.</p>
					
					

				</div>
			</div>
			
		</div>
		<div class="blog2">
			<div class="blog-box">
				<div class="blog-txt">
					<h3><a href="#" data-toggle="modal" data-target="#myModal1">Health Packages</a></h3>
					<h4>December 25,2017</h4>
					<p>We provide a multitude of health packages to suit your need and budget. Customized health packages are also provided in consultation with our training experts to give your body the best. We accept bulk booking for institutions and corporates at discounted rates. Our registered customers will also enjoy the benefit of tracking their personal training calendar and diet charts online.</p>
					
				</div>
				<a href="#" data-toggle="modal" data-target="#myModal1"><img src="{{asset('frontend/images/2.jpg')}}" alt="blog image" class="img-responsive" /></a>
				
			</div>
		</div>
		</div>	
	</div> 



@endsection