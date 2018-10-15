@extends('frontcustomerlayout.main') 
@section('content')
	<!-- banner -->
	<div class="main_section_agile about">
	</div>
	<!-- //banner -->
	<!-- about inner -->
<div class="about-bottom inner-padding">
	<div class="container">
		<div class="wthree_head_section">
				<h3 class="gyl_header">Diet <span>Plans</span></h3>
			</div>
				<div class="about-bott-right pti">
					<div class="col-lg-5 col-xs-12">
						<div class="pt-vd-box">
							<iframe width="100%" src="https://www.youtube.com/embed/aYaFyAtPrB4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						</div>
					</div>
					<div class="col-lg-7 col-xs-12">
						<div class="pt-box">
							<div class="pt-img">
								<img src="{{asset('frontend/images/t3.jpg')}}">
							</div>
							<div class="pt-name">
								<h5>Diet Plan 1</h5>
								<h6>Don't Fall for Fad Diets</h6>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="pt-text">
							<p>Discover how high-protein diets may help you lose weight and feel full. Find out the best sources of protein for weight loss.</p>
						</div>
						<button type="button">Purchase</button>
					</div>
					<div class="clearfix"></div>
					<div class="col-lg-5 col-xs-12">
						<div class="pt-vd-box">
							<iframe width="100%" src="https://www.youtube.com/embed/tccdbY5xcf4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						</div>
					</div>
					<div class="col-lg-7 col-xs-12">
						<div class="pt-box">
							<div class="pt-img">
								<img src="{{asset('frontend/images/t2.jpg')}}">
							</div>
							<div class="pt-name">
								<h5>Diet Plan 2</h5>
								<h6>Don't Fall for Fad Diets</h6>
							</div>

						</div>
						<div class="clearfix"></div>
						<div class="pt-text">
							<p>Numerous weight loss products and diets promise rapid weight loss. Learn about rapid weight loss claims, types of diets, and the risks and benefits of rapid weight loss.</p>
						</div>
						<button type="button">Purchase</button>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
</div>


@endsection