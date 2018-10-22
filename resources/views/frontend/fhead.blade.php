
<!DOCTYPE html>
<html lang="zxx">

<head>

@if(Request::is('/'))
<title>Personal Trainer & Fitness Center in Basingstoke | Body By Lekan</title>

  <meta name="description" content="Body By Lekan is the leading fitness center in Basingstoke specializing in providing physical training and fitness tips helps you to build perfect body shape.">

  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.bodybylekan.com">
@endif

@if(Request::segment(1) == 'about-us')
<title>Fitness & Nutrition Experts in Basingstoke | Body By Lekan</title>

  <meta name="description" content="Body By Lekan is the leading fitness club in Basingstoke and a renowned personal trainer with 15 years of experience helps to transform body in perfect shape.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.bodybylekan.com/about-us">

@endif

@if(Request::segment(1) == 'services')
<title>Best Fitness Club Services in Basingstoke  | Body By Lekan</title>
  <meta name="description" content="Body By Lekan offers best fitness Services in Basingstoke providing equipment, classes, programs and personal trainer to help members reach their fitness goals.">

  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.bodybylekan.com/services">
@endif

@if(Request::segment(1) == 'pricing')
<title>Gym Membership in Basingstoke at Affordable Price | Body By Lekan</title>
  <meta name="description" content="Body By Lekan offers an affordable range of gym memberships include fitness classes, nutrition advice, onsite experts to help you achieve your fitness goals.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.bodybylekan.com/pricing">
@endif

@if(Request::segment(1) == 'contact-us')
<title>Contact Us - Fitness Instructor in Basingstoke | Body By Lekan</title>
  <meta name="description" content="Contact us for all enquiries related to Membership or fitness Classes by filling our online form or call us to get in touch with our team. We're happy to help!">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.bodybylekan.com/contact-us">
@endif

@if(Request::segment(1) == 'exercise')
<title>Fitness Classes & Boot Camps in Basingstoke | Body By Lekan</title>
  <meta name="description" content="Body By Lekan provides best workout videos for muscle building, fat loss, abs and more with our exercise guides which helps to transform body in perfect shape.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.bodybylekan.com/exercise">
@endif
@if(Request::segment(1) == 'testimonial')
<title>Testimonial - Fitness Success Stories & Reviews | Body By Lekan</title>
  <meta name="description" content="We endeavour to be the best fitness club in Basingstoke. We believe that our happy trainers are our biggest strength. We believe in good customer service.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.bodybylekan.com/testimonial">
@endif
@if(Request::segment(1) == 'customer-registration')
<title>Register - Physical Training In Basingstoke | Body By Lekan</title>
  <meta name="description" content="Register with us for a free and get health tips and fitness training from our best professional fitness trainer offers to transform your body in perfect shape.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.bodybylekan.com/customer-registration">
@endif
@if(Request::segment(1) == 'customer-login')
<title>Login - Fitness & Health Experts in Basingstoke | Body By Lekan</title>
  <meta name="description" content="Login to book classes, view your calendar and timetable, manage your membership and get the latest health and fitness insights, tools and special offers.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.bodybylekan.com/customer-login">
@endif
	<!-- <title>Gym Trainer a Sports Category Bootstrap Responsive Website Template | Home :: gylayouts</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	

  			<title>{{ config('app.customerpaneltitle') }}</title> -->


  			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  			<meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="{{url('frontend/css/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" />
			

	<!-- Owl-carousel-CSS -->
	
	<!-- Testimonials-slider-css-files -->
	<link rel="stylesheet" href="{{url('frontend/css/owl.carousel.css')}}" type="text/css" media="all">

	<link href="{{url('frontend/css/owl.theme.default.css')}}" rel="stylesheet">
	<!-- //Testimonials-slider-css-files -->
	<!--Main Menu-->
    <link href="{{url('frontend/css/stellarnav.min.css')}}" rel="stylesheet">
    <link href="{{url('frontend/css/daterangepicker.css')}}" rel="stylesheet">
	<!--tootltip css-->
	<link href="{{url('frontend/css/tooltipster.bundle.min.css')}}" rel="stylesheet">
	<link href="{{url('frontend/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />
	<link href="{{url('frontend/css/responsive.css')}}" rel="stylesheet" type="text/css" media="all" />
	<!-- font-awesome-icons -->
	<link href=" {{url('frontend/css/font-awesome.css')}}" rel="stylesheet">
	<!--DatePicker css-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- //font-awesome-icons -->
	<link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">
	
</head>

