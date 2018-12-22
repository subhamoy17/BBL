
<!DOCTYPE html>
<html lang="zxx">

<head>
  <!-- <title>Gym Trainer a Sports Category Bootstrap Responsive Website Template | Home :: gylayouts</title> -->
  <!-- custom-theme -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!-- //custom-theme -->
<title>{{ config('app.customerpaneltitle') }}</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="{{url('frontend/css/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" />
      
  <!-- Owl-carousel-CSS -->
  
  <!-- Testimonials-slider-css-files -->
  <link rel="stylesheet" href="{{url('frontend/css/owl.carousel.css')}}" type="text/css" media="all">

  <link href="{{url('frontend/css/owl.theme.default.css')}}" rel="stylesheet">
  <!-- //Testimonials-slider-css-files -->
  <!--Main Menu-->
    <link href="{{url('frontend/css/stellarnav.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{url('frontend/css/jquery-ui.css')}}">
  <link href="{{url('frontend/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />
  <link href="{{url('frontend/css/responsive.css')}}" rel="stylesheet" type="text/css" media="all" />
  <!-- font-awesome-icons -->
  <link href=" {{url('frontend/css/font-awesome.css')}}" rel="stylesheet">
  <!-- //font-awesome-icons -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800" rel="stylesheet">
  <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
  <link href="//fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">

  
</head>
<body>
  <div class="loader"></div>
  <header>
<!-- modal -->




      <div class="header-top">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">

              <div class="all-links">
                            <ul>
                                 <li><a href="https://www.instagram.com" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                 <li><a href="mailto:info@example.com"><i class="fa fa-envelope"></i></a></li>
                                <li><a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="https://www.twitter.com" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                <!-- <li><a href="#"><i class="fa fa-google-plus"></i></a></li> -->
                                <li><a href="https://www.youtube.com" target="_blank"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                            <div class="dropdown user-box">
                           
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Welcome {{Auth::user()->name}}
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="{{url('customer/mybooking')}}">My Dashboard</a></li>
                  <li><a href="{{url('customer/profile')}}">My Profile</a></li>
                  <li><a href="{{ route('customerpanel.logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a></li>
                                    <form id="logout-form" action="{{ route('customerpanel.logout') }}" method="POST" style="display: none;">
                                        @csrf

                                 </form>
                </ul>
                
              </div>
              <div class="clearfix"></div>
                
                <!-- <div class="reg-area">
                  <a class="srch-icon"> <i class="fa fa-search"></i><i class="fa fa-times"></i></a>
                  <div class="srch-box">
                    <input type="text" placeholder="search">
                    <input type="button" value="Search">
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="heder-bottom">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <div class="logo text-left">
                <a href="{{url('/')}}"><img src="{{asset('frontend/images/logo.png')}}">
                                <ul> 
                            </a>
              </div>
            </div>
                  
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
              <div id="main-nav" class="stellarnav">
                <ul>

                <li class="{{ Request::is('/') ? 'active' : null }}">
                        <a href="{{route('bbldb')}}">Home</a>
                      </li>
                       <li class="{{ Request::segment(2) === 'about-us' ? 'active' : null }}">
                        <a href="{{url('customer/about-us')}}">About Us</a>
                      </li>
                <li class="{{ Request::segment(2) === 'pricing' ? 'active' : null }}">
                        <a href="{{url('customer/pricing')}}">Pricing</a>
                      </li>
                     
                    <li class="{{ Request::segment(2) === 'services' ? 'active' : null }}">
                        <a href="{{url('customer/services')}}">Services</a>
                      </li>
                      <li class="{{ Request::segment(2) === 'exercise' ? 'active' : null }}">
                        <a href="{{url('customer/exercise')}}">Exercise</a>
                      </li>

                  <li class="{{ Request::segment(2) === 'contact-us' ? 'active' : null }}">
                        <a href="{{url('customer/contact-us')}}">Contact Us</a>
                      </li>
                      <li class="{{ Request::segment(2) === 'testimonial' ? 'active' : null }}">
                        <a href="{{url('customer/testimonial')}}">Testimonial</a>
                      </li>

                      @if(Auth::guard('customer')->check())
                      <li class="{{ Request::segment(2) === 'mybooking' || Request::segment(2) === 'purchase_history' || Request::segment(2) === 'my_mot' ? 'active' : null }}">
                        <a href="{{url('customer/mybooking')}}">My Dashboard</a>
                      </li>
                      @endif


                </ul>
            </div>
            </div>
          </div>
        </div>
      </div>
    </header>


      
 
  <div class="inner-padding opacity_div">
    <div class="container">
      <div class="hstry-box">
      
     

<div class="tab_container">

        

          <!-- #tab1 -->
          <h3 class="ed-p">Personal Training Session Booking&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
            Remaining Session {{$no_of_sessions}}
          </h3>
          <h3 class="d_active tab_drawer_heading" rel="tab5">Tab 5</h3>
          <div id="tab5" class="tab_content">
            <div class="form-box">

                <h3>Personal Training online booking coming soon on 3rd January.<br>
                    Contact Person: Lekan<br>
                    Contact Number: +44 7706 975795
                </h3><br>
                <!-- <a href="{{url('customer/pricing')}}"class="btn btn-dark btn-theme-colored btn-flat">Yes</a>
                <a href="{{url('customer/purchase_history')}}"class="btn btn-dark btn-theme-colored btn-flat">No</a> -->

              </div>
          </div>



         
          </div>         

      </div>
      </div>
      <!-- .tab_container -->
    </div>



<!-- js -->
  <script type="text/javascript" src="{{url('frontend/js/jquery-2.1.4.min.js')}}"></script>
  <!-- //js -->
<script src="{{asset('backend/assets/js/jquery.validate.min.js')}}"></script>
  <!-- Slider script -->
  <script src="{{url('frontend/js/responsiveslides.min.js')}}"></script>

 <script src="{{url('frontend/js/jquery-ui.js')}}"></script>


  <script type="text/javascript" src="{{url('frontend/js/bootstrap-3.1.1.min.js')}}"></script>

  <!-- for testimonials slider-js-file-->
      <script src="{{url('frontend/js/owl.carousel.js')}}"></script>
<!-- for testimonials slider-js-script-->
<!-- stats -->
  <script src="{{url('frontend/js/jquery.waypoints.min.js')}}"></script>


  <script src="{{url('frontend/js/jquery.countup.js')}}"></script>

  <script>
    $('.counter').countUp();
  </script>
  <!-- //stats -->
  <script src="{{url('frontend/js/stellarnav.min.js')}}"></script>


  <script src="{{url('frontend/js/accotab.js')}}"></script>

  <script>
    $(document).ready(function() { 
    $('#price-slider').owlCarousel({
        loop:true,
        margin:30,
        nav:true,
      items: 3,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    })

    }); 
</script>


<script>
$(document).ready(function() { 
    $('#team-slider').owlCarousel({
        loop:true,
      autoplay: true,
        margin:30,
        nav:true,
      items: 4,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    })

});
  </script>

  

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
      /*Scroll to top when arrow up clicked BEGIN*/
$(window).scroll(function() {
    var height = $(window).scrollTop();
    if (height > 100) {
        $('#back2Top').fadeIn();
    } else {
        $('#back2Top').fadeOut();
    }
});
$(document).ready(function() {
    $("#back2Top").click(function(event) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

});
 /*Scroll to top when arrow up clicked END*/
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

 

<script type="text/javascript">
    $(window).ready(function() {
    $(".loader").fadeOut("fast");
  });
</script>

</body>

</html>




