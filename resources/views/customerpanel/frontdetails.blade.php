@extends('frontend.main') 
@section('content')


	<div class="inner">
	</div>
	<div class="inner-padding upld-file">
		<div class="container">
			<h3 class="gyl_header">Edit <span>Profile</span></h3>
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-7 colxs-12">
   						<div class="form-box">
   							<h4 class="ed-p">Edit Profile</h4>
   							<div class="row">
   								<div class="col-md-6 col-sm-12 col-xs-12">
                  					<div class="form-group">
                  					  <label>Name <small>*</small></label>
                  					  <input name="form_name" class="form-control" placeholder="Enter Name" required="" aria-required="true" type="text">
                  					</div>
                				</div>
                				<div class="col-md-6 col-sm-12 col-xs-12">
                  					<div class="form-group">
                  					  <label>Email <small>*</small></label>
                  					  <input name="form_email" class="form-control required email" placeholder="Enter Email" aria-required="true" type="email">
                  					</div>
                				</div>
                				<div class="col-md-6 col-sm-12 col-xs-12">
                  					<div class="form-group">
                  					  <label>Subject <small>*</small></label>
                  					  <select class="form-control">
                  					  	<option>sub1</option>
                  					  	<option>sub1</option>
                  					  	<option>sub1</option>
                  					  	<option>sub1</option>
                  					  	<option>sub1</option>
                  					  </select>
                  					</div>
                				</div>
                				<div class="col-md-6 col-sm-12 col-xs-12">
                  					<div class="form-group file-box">
                  					  <label>Phone</label>
                  					  <input name="form_file" class="file" type="file">
                  					  <!--<span class="file-hax"></span>-->
                  					</div>
                				</div>
                				<div class="col-md-12 col-sm-12 col-xs-12">
                				<div class="form-group">
                					<label>Message</label>
                					<textarea name="form_message" class="form-control required" rows="5" placeholder="Enter Message" aria-required="true">	</textarea>
              					</div>
              					<div class="form-group">
                					<input name="form_botcheck" class="form-control" value="" type="hidden">
                					<button type="submit" class="btn btn-dark btn-theme-colored btn-flat" data-loading-text="Please wait...">Send your message</button>
              					</div>
								</div>
   							</div>
   						</div>
   					</div>
   					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
   						<div class="upld-img">
   							<img src="{{asset('frontend/images/about-fitness-img.png')}}">
   						</div>
   					</div>
			</div>
		</div>
	</div>

@endsection