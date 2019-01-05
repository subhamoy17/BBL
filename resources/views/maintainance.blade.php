<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>Gym Trainer a Sports Category Bootstrap Responsive Website Template | Home :: gylayouts</title>
	<!-- custom-theme -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- //custom-theme -->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<!-- Owl-carousel-CSS -->
	<!--Main Menu-->
    <link href="css/stellarnav.min.css" rel="stylesheet">
	<!-- Testimonials-slider-css-files -->
	<link rel="stylesheet" href="css/owl.carousel.css" type="text/css" media="all">
	<link href="css/owl.theme.css" rel="stylesheet">
	<!-- //Testimonials-slider-css-files -->

	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- font-awesome-icons -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- //font-awesome-icons -->
	<link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">
</head>
<style>
	.cmn-soon-img {
		text-align: center;
		position: relative;
		top: 110px;
	}
	.cmn-soon-img img {
		width: 220px;
		margin: 20px 0;
	}
	.cmn-soon-img h3 {
		font-size: 32px;
		font-weight: 600;
	}
	.cmn-soon-img h3 span:nth-child(1), .cmn-soon-img h3 span:nth-child(2){
		font-size: 40px;
		color: #fb5b21;
	}
	.cmn-soon-img img:first-child {
		display: block;
		margin: 0 auto;
		width: 180px;
	}
	.inner-padding {
		background: #f8f8f8;
		height: 100vh;
	}
	@media only screen and (max-width: 767px) {
		.cmn-soon-img img {
			width: 150px;
			margin: 20px 0;
		}
		.cmn-soon-img {
			top: 80px;
		}
		.cmn-soon-img h3 {
			font-size: 22px;
		}
		.cmn-soon-img h3 span:nth-child(1), .cmn-soon-img h3 span:nth-child(2){
			font-size: 32px;
		}
	}

	/*.ofr1-btn a:first-child{
		float: left;
	}
	.ofr1-btn a:nth-child(2) {
		float: right;
	}*/
</style>

<body>
	<div class="inner-padding">
		<div class="container">
			<div class="cmn-soon-img">
				<img src="{{asset('frontend/images/logo.png')}}">
				<img src="{{asset('frontend/images/cmng-soon2.png')}}">
				<h3><span>C</span>ooming <span>S</span>oon <span> ...</span></h3>
			</div>
			<!-- .tab_container -->
		</div>
	</div>
	<!-- js -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<!-- //js -->
	<!--Fontawesome script-->
	<!--<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>-->
	<!-- Slider script -->
	<script src="js/responsiveslides.min.js"></script>
	<script>
		// You can also use "$(window).load(function() {"
		$(function () {
			$("#slider").responsiveSlides({
				auto: true,
				nav: true,
				manualControls: '#slider3-pager',
			});
		});
	</script>
	<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
	<!--Accordion tab js-->
	<script src="js/accotab.js"></script>

	<!-- for testimonials slider-js-file-->
			<script src="js/owl.carousel.js"></script>
	<!-- //for testimonials slider-js-file-->
		<script>
		$(document).ready(function() { 
		$("#owl-demo").owlCarousel({
 
			autoPlay: 3000, //Set AutoPlay to 3 seconds
			autoPlay:true,
			items : 3,
			itemsDesktop : [640,5],
			itemsDesktopSmall : [414,4]
		});
		}); 
</script>
<!-- for testimonials slider-js-script-->
<!-- stats -->
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/jquery.countup.js"></script>
	<script>
		$('.counter').countUp();
	</script>
	<!-- //stats -->
	<script src="js/stellarnav.min.js"></script>
	<script>
		$(document).ready(function(){
			jQuery('#main-nav').stellarNav();
		});  
	</script>
	<script>
		window.onscroll = function() {myFunction()};
		var header = document.getElementById("myHeader");
		var sticky = header.offsetTop;
		function myFunction() {
  			if (window.pageYOffset >= sticky) {
    			header.classList.add("sticky");
  			} else {
    			header.classList.remove("sticky");
  			}
		}
	</script>
	<script>
		$(document).ready(function(){
			$(".fa-search").click(function(){
    				$(".fa-search").hide();
    				$(".fa-times").show();
    				$(".srch-box").show();
				});

				$(".fa-times").click(function(){
					$(".fa-times").hide();
					$(".fa-search").show();
					$(".srch-box").hide();
				});
		});  
	</script>
	<script src="js/accotab.js"></script>
    <script>
		 $(document).ready(function(){
    $(".cm-cls").click(function(){
		$(".login-wrapper").fadeToggle("slow", "linear");
        $(".login-wrapper").hide("slow", "linear");
		$(".reg-wrapper").fadeToggle("slow", "linear");
		 $(".reg-wrapper").show("slow", "linear");
		
    });
		$(".cmr-cls").click(function(){
		$(".reg-wrapper").fadeToggle("slow", "linear");
        $(".reg-wrapper").hide("slow", "linear");
		$(".login-wrapper").fadeToggle("slow", "linear");
		 $(".login-wrapper").show("slow", "linear");
		
    }); 
		 });
	</script>
</body>
</html>
