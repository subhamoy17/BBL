
<!DOCTYPE html>
<html lang="zxx">

<head>
  <title>Gym Trainer a Sports Category Bootstrap Responsive Website Template | Home :: gylayouts</title>
  <!-- custom-theme -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- //custom-theme -->




  <link href="{{url('frontend/css/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" />
      

  <!-- Owl-carousel-CSS -->
  
  <!-- Testimonials-slider-css-files -->
  <link rel="stylesheet" href="{{url('frontend/css/owl.carousel.css')}}" type="text/css" media="all">

  <link href="{{url('frontend/css/owl.theme.default.css')}}" rel="stylesheet">
  <!-- //Testimonials-slider-css-files -->
  <!--Main Menu-->
    <link href="{{url('frontend/css/stellarnav.min.css')}}" rel="stylesheet">

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
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-126555915-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-126555915-1');
  </script>
  
</head>

<body>
  <header>
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

                            @if(Auth::guard('customer')->check())
                            <div class="dropdown user-box">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Welcome {{Auth::guard('customer')->user()->name}}
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('customer/mybooking')}}">My Dashboard</a></li>
                                    <li><a href="{{url('customer/profile')}}">My Profile</a></li>
                                    <li><a href="{{route('customerpanel.logout')}}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a></li>
                                    <form id="logout-form" action="{{ route('customerpanel.logout') }}" method="POST" style="display: none;">
                                        @csrf

                                 </form>
                                </ul>
                                <span class="noification-d"><a href="{{url('customer/mybooking')}}"><i class="fa fa-bell"></i><small>{{Session::get('sum_slots')?Session::get('sum_slots'):0}}</small></a></span>
                            </div>
                            <div class="clearfix"></div>
                            @else
                <div class="reg-area">
                  <p><a href="{{route('customer-register')}}" class="jn-us"><i class="fa fa-hand-o-right"></i> Join Us</a></p>
                                <p><a href="{{url('customer-login')}}" class="sgn-in"><i class="fa fa-user"></i>Sign In</a></p>
                  <!-- <a class="srch-icon"><i class="fa fa-search"></i><i class="fa fa-times"></i></a> -->
                  <div class="srch-box">
                    <input type="text" placeholder="search">
                    <input type="button" value="Search">
                  </div>
                </div>
                            @endif

              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="myHeader" class="heder-bottom">
            

             
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
<li class="{{ Request::segment(1) === 'about-us' ? 'active' : null }}">
                        <a href="{{route('about-us')}}">About Us</a>
                      </li>
<li class="{{ Request::segment(1) === 'services' ? 'active' : null }}">
                        <a href="{{route('services')}}">Services</a>
                      </li>
<li class="{{ Request::segment(1) === 'pricing' ? 'active' : null }}">
                        <a href="{{route('pricing')}}">Pricing</a>
                      </li>
<li class="{{ Request::segment(1) === 'contact-us' ? 'active' : null }}">
                        <a href="{{route('contact-us')}}">Contact Us</a>
                      </li>
                      
           <li class="{{ Request::segment(1) === 'exercise' ? 'active' : null }}">
                        <a href="{{route('exercise')}}">Exercise</a>
                      </li>           
                    
                    <li class="{{ Request::segment(1) === 'testimonial' ? 'active' : null }}">
                        <a href="{{route('testimonial')}}">Testimonial</a>
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

<audio controls autoplay loop hidden="hidden">
<source src="http://s0.vocaroo.com/media/download_temp/Vocaroo_s0Jz5C4gpgE0.mp3" type="audio/ogg">
</audio>
<div class="container">
  
  <div  class="error">
    <p class="p">4</p>
    <span class="dracula">      
      <div class="con">
        <div class="hair"></div>
        <div class="hair-r"></div>
        <div class="head"></div>
        <div class="eye"></div>
        <div class="eye eye-r"></div>
        <div class="mouth"></div>
        <div class="blod"></div>
        <div class="blod blod2"></div>
      </div>
    </span>
    <p class="p">4</p>
    
    <div class="page-ms">
      <p class="page-msg"> Oops, the page you're looking for Disappeared </p>
     <a href="/"> <button class="go-back">Go Back</button></a>
    </div>
</div>
  

<!--  <p>Auto back to home page</p> -->
  </div>

  <div class="footer">
    <div class="f-bg-gyl">
        <div class="col-md-5 gylayouts_footer_grid">
          <h3>Recent <span>Works</span></h3>
           <ul class="con_inner_text midimg">
            <li><a href="{{route('exercise')}}"><img src="{{asset('frontend/images/banner22.jpg')}}" alt="" class="img-responsive" /></a></li>
              <li><a href="{{route('exercise')}}"><img src="{{asset('frontend/images/banner33.jpg')}}" alt="" class="img-responsive" /></a></li>
            <li><a href="{{route('exercise')}}"><img src="{{asset('frontend/images/banner44.jpg')}}" alt="" class="img-responsive" /></a></li>
            <li><a href="{{route('exercise')}}"><img src="{{asset('frontend/images/banner11.jpg')}}" alt="" class="img-responsive" /></a></li>
            <li><a href="{{route('exercise')}}"><img src="{{asset('frontend/images/55.jpg')}}" alt="" class="img-responsive" /></a></li>
              <li><a href="{{route('exercise')}}"><img src="{{asset('frontend/images/66.jpg')}}" alt="" class="img-responsive" /></a></li>
             <li><a href="{{route('exercise')}}"><img src="{{asset('frontend/images/77.jpg')}}" alt="" class="img-responsive" /></a></li>
            <li><a href="{{route('exercise')}}"><img src="{{asset('frontend/images/88.jpg')}}" alt="" class="img-responsive" /></a></li>
             </ul>
          
        </div>
        <div class="col-md-2 gylayouts_footer_grid">
          <h3>Popular <span>Links</span> </h3>
            <ul class="links">
              <li><a href="{{route('bbldb')}}">Home</a></li>
              <li><a href="{{route('services')}}">Services</a></li>
              <li><a href="{{route('pricing')}}">Pricing</a></li>
            
            </ul>
        </div>



<div class="col-md-2 gylayouts_footer_grid">
          <h3>Our <span>Links</span> </h3>
            <ul class="links">
              <li><a href="{{route('about-us')}}">About Us</a></li>
              <li><a href="{{route('contact-us')}}">Contact Us</a></li>
              <li><a href="{{route('testimonial')}}">Testimonial</a></li>
            </ul>
        </div>



        <div class="col-md-3 gylayouts_footer_grid">
          <h2>Contact <span>Us</span></h2>
              <ul class="con_inner_text">
              <li><span class="fa fa-map-marker" aria-hidden="true"></span>6 Brighton Hill RG22 4EH,<label>Basingstoke</label></li>
              <li><span class="fa fa-envelope-o" aria-hidden="true"></span> <a href="mailto:info@example.com">info@bodybylekan.com</a></li>
              <li><span class="fa fa-phone" aria-hidden="true"></span>+44 7706 975795</li>
            </ul>

          <ul class="social_agileinfo">
            <li><a href="https://www.facebook.com/bodybylekan" target="_blank" class="gy_facebook"><i class="fa fa-facebook-f"></i></a></li>
            <li><a href="https://www.twitter.com" target="_blank" class="gy_twitter"><i class="fa fa-twitter"></i></a></li>
            <li><a href="https://www.instagram.com/lekanfitness" target="_blank" class="gy_instagram"><i class="fa fa-instagram"></i></a></li>
            <li><a href="https://plus.google.com" target="_blank" class="gy_google"><i class="fa fa-google-plus"></i></a></li>
          </ul>
        </div>


        <div class="clearfix"> </div>
          
      </div>
      <p class="copyright">© 2018 Body By Lekan. All Rights Reserved |Powered by <a href="https://www.softcliquesoftware.in/" target="_blank">Softclique Software Services LLP</a></p>
      <!--scroll to top button-->
        <a id="back2Top" title="Back to top" href="#"><i class="fa fa-hand-o-up"></i></a>

  </div>
  <!-- //footer -->
<!-- js -->
  <script type="text/javascript" src="{{asset('frontend/js/jquery-2.1.4.min.js')}}"></script>
  <!-- //js -->
<script src="{{asset('backend/assets/js/jquery.validate.min.js')}}"></script>

  <!-- Slider script -->
  <script src="{{url('frontend/js/responsiveslides.min.js')}}"></script>
  <script src="{{asset('frontend/js/daterangepicker.js')}}"></script>
<script src="{{asset('frontend/js/moment.min.js')}}"></script>

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
  <script type="text/javascript" src="{{url('frontend/js/bootstrap-3.1.1.min.js')}}"></script>

  <!-- for testimonials slider-js-file-->
      <script src="{{url('frontend/js/owl.carousel.js')}}"></script>

  <script>
    $(document).ready(function() { 
    $('#price-slider').owlCarousel({
      autoPlay: true,
        loop:true,
        margin:30,
        nav:false,
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
    });
  
});

  </script>


  <script>
    $('#testi-slider').owlCarousel({
  autoplay: true,
    loop:true,
    margin:30,
    nav:false,
  dots: true,
  smartSpeed: 1500,
  autoplayHoverPause:true,   
  responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});
  </script>

<!-- for testimonials slider-js-script-->
<!-- stats -->
  <script src="{{url('frontend/js/jquery.waypoints.min.js')}}"></script>


  <script src="{{url('frontend/js/jquery.countup.js')}}"></script>

  <script>
    $('.counter').countUp();
  </script>
  <!-- //stats -->
  <script src="{{url('frontend/js/stellarnav.min.js')}}"></script>
  

  <script>
    $(document).ready(function(){
      jQuery('#main-nav').stellarNav();
      
    });  
  </script>
  <!-- <script>
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
  </script> -->
  
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


  <script src="{{url('frontend/js/accotab.js')}}"></script>
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
    <script src="{{url('frontend/js/accotab.js')}}"></script>






<script>
$(document).ready(function() {

  $.validator.addMethod("alpha", function(value, element){
    return this.optional(element) || value == value.match(/^[a-zA-Z, '']+$/);
    }, "Alphabetic characters only please");

  // mobile number can contant only numeric
  $.validator.addMethod('numericOnly', function (value) {
       return /^[0-9]+$/.test(value);
    }, 'Please enter only numeric values');


$('#contactusform').validate({  
  /// rules of error 
  rules: {
    "form_name": {
      alpha:true,
      minlength:6,
      required: true
    },
    "form_subject": {
      required: true
    },

    "form_phone": {
      required: true,
      minlength: 10,
      maxlength: 12,
      numericOnly: true
    },
    "form_message": {
      required: true
    },


    "form_email": {
      required: true,
      email: true
     
    }




  },

  messages: {
    "form_name":{
    required: 'Please enter your name',
    minlength:'Minimum length 6 is required'
  },
  "form_subject":{
    required: 'Please enter your subject' 
  },
  "form_phone": {
      required: 'Please enter your mobile number',
      minlength: 'Minimum 10 digits mobile number is required',
      maxlength: 'Maximum 12 digits mobile number is required'
  },
  "form_email": {
      required: 'Please enter your email',
      email: "Email is invalid"
  }
  



}
  });
 

});
</script>
<!--DatePicker js-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
      $( function() {
        $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#format" ).on( "change", function() {
          $( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
        });
      } );
    </script>
    <script>
      $( function() {
        $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#format" ).on( "change", function() {
          $( "#datepicker2" ).datepicker( "option", "dateFormat", $( this ).val() );
        });
      } );
    </script>
    <script>
      $( function() {
        $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#format" ).on( "change", function() {
          $( "#datepicker3" ).datepicker( "option", "dateFormat", $( this ).val() );
        });
      } );
    </script>
    <script>
      $( function() {
        $( "#datepicker4" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#format" ).on( "change", function() {
          $( "#datepicker4" ).datepicker( "option", "dateFormat", $( this ).val() );
        });
      } );
    </script>
<!--Fontawesome script-->
  <!--<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>-->
</body>

</html>