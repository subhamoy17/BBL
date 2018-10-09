@extends('frontend.main') 
@section('content')

<!-- banner -->
	<div class="main_section_agile inner contact_us">
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
                <i class="fa fa-map-marker font-36 mb-10 text-theme-colored"></i>
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
            <div class="col-lg-7 col-md-7 col-sm-12 colxs-12"   id="contact_msg_success">
              <h4>Interested in discussing?</h4>
              <div class="form-box">
                 <form action="{{route('front_contact_insert')}}" method="post" enctype="multipart/form-data" class="" id="contactusform">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                <div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Name <small>*</small></label>
                              <input name="form_name" class="form-control" placeholder="Enter Name" type="text">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Email <small>*</small></label>
                              <input name="form_email" class="form-control required email" placeholder="Enter Email" type="email">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Subject <small>*</small></label>
                              <input name="form_subject" class="form-control required" placeholder="Enter Subject"  type="text">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Phone <small>*</small></label>
                              <input name="form_phone" class="form-control" placeholder="Enter Phone" type="text">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label>Message</label>
                          <textarea name="form_message" class="form-control" rows="5" placeholder="Enter Message"> </textarea>
                        </div>
                        <div class="form-group">
                          
                          <button type="submit"  name="submit" class="btn btn-dark btn-theme-colored btn-flat" data-loading-text="Please wait...">Send your message</button>
                        </div>
                         <div class="form-group">
                          @if (session('success'))

                             <script type="text/javascript">
                              window.location.hash = "contact_msg_success";
                            </script>
                              <!-- <span style="color: white;">Test</span> -->
                              <div class="alert alert-success">
                                  {{ session('success') }}
                              </div>
                          @endif
                          
                        </div>
                        
                </div>
                </div>
              </form>
              </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 colxs-12">
              <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14735.757260694843!2d88.4397378!3d22.5813729!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x639638c83b7f297a!2sSoftclique+Software+Services+LLP!5e0!3m2!1sen!2sin!4v1518768352355" width="100%" height="467" frameborder="0" style="border:0" allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection