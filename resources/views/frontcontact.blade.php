@extends('frontcustomerlayout.main') 
@section('content')

<!-- banner -->
	<div class="main_section_agile inner">
	</div>
	<!-- //banner -->
	<!--Inner Section body-->
   	<section class="inner-body">
   		<div class="contact-top">
   			<div class="container">
   				<h3 class="gyl_header">Contact <span>Us</span></h3>
   				<div class="section-content">
          <div class="row">
            <div class="col-sm-12 col-md-4">
              <div class="contact-info text-center">
                <i class="fa fa-phone font-36 mb-10 text-theme-colored"></i>
                <h4>Call Us</h4>
                <h6 class="text-gray">Phone: +262 695 2601</h6>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="contact-info text-center">
                <i class="fa fa-map-marker-alt font-36 mb-10 text-theme-colored"></i>
                <h4>Address</h4>
                <h6 class="text-gray">121 King Street, Australia</h6>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="contact-info text-center">
                <i class="fa fa-envelope font-36 mb-10 text-theme-colored"></i>
                <h4>Email</h4>
                <h6 class="text-gray">you@yourdomain.com</h6>
              </div>
            </div>
          </div>
        </div>
			</div>	
   		</div>
   		<div class="contact-box">
   			<div class="container">
   				<div class="row">
   					<div class="col-lg-7 col-md-7 col-sm-12 colxs-12">
   						<h4>Interested in discussing?</h4>
   						<div class="form-box">
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
                  					  <input name="form_subject" class="form-control required" placeholder="Enter Subject" aria-required="true" type="text">
                  					</div>
                				</div>
                				<div class="col-md-6 col-sm-12 col-xs-12">
                  					<div class="form-group">
                  					  <label>Phone</label>
                  					  <input name="form_phone" class="form-control" placeholder="Enter Phone" type="text">
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
   					<div class="col-lg-5 col-md-5 col-sm-12 colxs-12">
   						<div class="map">
   							<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14735.757260694843!2d88.4397378!3d22.5813729!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x639638c83b7f297a!2sSoftclique+Software+Services+LLP!5e0!3m2!1sen!2sin!4v1518768352355" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
   						</div>
   					</div>
   				</div>
   			</div>
   		</div>
   	</section>

@endsection