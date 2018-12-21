@extends('frontcustomerlayout.main') 
@section('content')
	<!-- banner -->
<div class="main_section_agile about"></div>
	<!-- //banner -->
	<!-- about inner -->
<div class="about-bottom inner-padding">
	<div class="container">
		<div class="wthree_head_section">
			<h3 class="gyl_header">Diet <span>Plans</span></h3>
		</div>

			<div class="about-bott-right pti">
				@if(!empty($all_common_diet_plan))
					@foreach($all_common_diet_plan as $each_common_diet_plan)
						<div class="col-lg-5 col-xs-12">
							<div class="pt-vd-box  image_space">
								@if($each_common_diet_plan->video!='')
									<iframe width="100%" src="{{$each_common_diet_plan->video}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
								@elseif($each_common_diet_plan->image!='')
									<img width="100%" height="290px" src="{{url('backend/common_diet_plan_images')}}/{{$each_common_diet_plan->image}}">
								@endif
							</div>
						</div>
						<div class="col-lg-7 col-xs-12">
							<div class="pt-box">
								<div class="pt-img">
									@if($each_common_diet_plan->author_image!='')
										<img src="{{asset('backend/common_diet_plan_images')}}/{{$each_common_diet_plan->author_image}}" height="76px" width="60px">
									@else
										<img src="{{asset('backend/images/1539433106_trainerimg.jpg')}}" height="76px" width="60px">
										
									@endif
								</div>
								<div class="pt-name">
									<h5>{{$each_common_diet_plan->diet_plan_name}}</h5>
									<h6>By {{$each_common_diet_plan->author_name}}</h6>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="pt-text">
								<p>{{$each_common_diet_plan->description}}</p>
							</div>
							<!-- <h5 class="prc-amnt"><span>Price</span> <i class="fa fa-gbp"></i> {{$each_common_diet_plan->price}}</h5> -->
							<!-- <button type="button" id="purchase_button">Purchase</button> -->
			<!-- 				@if(Auth::guard('customer')->check())
								<form action="{{url('customer/diet-plan-purchase')}}" method="post">
									{{ csrf_field() }}
									<input type="hidden" name="common_diet_plan_id" value="{{$each_common_diet_plan->id}}">
									<button type="submit">Purchase</button>
								</form>
               
              @else
                <a href="{{url('customer-login')}}" class="dietplan-purchase-btn2">Purchase</a>
              @endif -->
							<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
					@endforeach
				@else
					No Record Found
				@endif
			</div>
	</div>
</div>

  


@endsection