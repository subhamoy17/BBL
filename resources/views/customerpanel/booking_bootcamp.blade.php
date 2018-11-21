
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
                  <li><a href="{{ route('customerpanel.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                      <form id="logout-form" action="{{ route('customerpanel.logout') }}" method="POST" style="display: none;">
                      @csrf
                      </form>
                </ul>
                <span class="noification-d"><a href="{{url('customer/mybooking')}}"><i class="fa fa-bell"></i><small>{{Session::get('sum_slots')?Session::get('sum_slots'):0}}</small></a></span>
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
            <a href="{{url('/')}}"><img src="{{asset('frontend/images/logo.png')}}"></a>
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
          <h3 class="ed-p">Bootcamp Session Booking Form</h3>
          <h3 class="d_active tab_drawer_heading" rel="tab5">Tab 5</h3>
          <div id="tab5" class="tab_content">
            <div class="form-box">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="hidden" id="total_slots" class="form-control" value="{{Session::get('sum_slots')}}"  >
                        <label>Location/ Address <small>*</small></label>
                          <select class="form-control">
                            <option value="">Please select location/address</option>
                            @if(!empty($bootcampaddress))
                            @foreach($bootcampaddress as $each_bootcampaddress)
                              <option value="{{$each_bootcampaddress->address_id}}">{{$each_bootcampaddress->address_line1}}</option>
                            @endforeach
                            @endif    
                          </select>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label>Available Date <small>*</small></label>
                        <input type="text" id="bootcamp_date" name="bootcamp_date" class="form-control" onchange="jsfunction()" readonly="true">
                        @foreach($bootcampdate as $bootcampdate1)
                        <input type="hidden" id="all_date[]" name="all_date[]" value="{{$bootcampdate1}}" readonly="true">
                        @endforeach
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                      <label>Available Time <small>*</small></label>
                        <select class="form-control" name="time" id="slot_time">
                                
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12" id='loadingimg' style="display: none;">
                      <div class="form-group" >
                        <img src="{{asset('backend/images/loader_session_time.gif')}}" style="width: 85px;margin-top: -30px;margin-left: -21px;"/>
                      </div>   
                    </div>
                         
                    <div id="old_session_data"> </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input name="form_botcheck" class="form-control" value="" type="hidden">
                        <input type="hidden" id="session_no" name="session_no" value="1">
                        <button id="add_sess" class="btn btn-dark btn-theme-colored btn-flat">Add Session</button>
                      </div>
                    </div>
                  </div>
                  <div id="sesssion_table">
                    <form action="{{route('customer.slotinsert')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="add_session_form1">

                      <input type="hidden" name="_token" value="{{csrf_token()}}">
                      <input type="hidden" name="idd" id="id" value="{{Auth::guard('customer')->user()->id}}">
                      <input type="hidden" name="nd_btn" id="nd_btn" value="1">
                      <div id="add_session_req" >  </div>
            
                      <button class="btn btn-dark btn-theme-colored btn-flat btn-drk2 save_button"  style="display:none;" id="save_btn">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
          </div>         
        </div>
      </div>
      <!-- .tab_container -->
  </div>
</div> 

<!-- end -->

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
    // You can also use "$(window).load(function() {"
    $(function () {
      $("#slider").responsiveSlides({
        auto: true,
        nav: true,
        manualControls: '#slider3-pager',
      });
    });
  </script>

  <script>

    var disabledDays =$("input[name='all_date[]']")
              .map(function(){return $(this).val();}).get();

    /* utility functions */
function nationalDays(date) {
  var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
  //console.log('Checking (raw): ' + y + '-' + m + '-' + d);
  for (i = 0; i < disabledDays.length; i++) {

    if($.inArray(y + '-' + (m+1) + '-' + d,disabledDays) != -1) {
      //console.log('bad:  ' + (m+1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
      return [true];
    }
  }
  //console.log('good:  ' + (m+1) + '-' + d + '-' + y);
  return [false];
}
// function noWeekendsOrHolidays(date) {
//   var noWeekend = jQuery.datepicker.noWeekends(date);
//   return noWeekend[0] ? nationalDays(date) : noWeekend;
// }

/* create datepicker */
$(document).ready(function() {
  $('#bootcamp_date').datepicker({
    dateFormat: "yy-mm-dd",
    beforeShowDay: nationalDays
  });
});

    

//   $(function () {
//     $( "#slots_datepicker").datepicker({
//   dateFormat: "yy-mm-dd",
//   beforeShowDay: NotBeforeToday
// });
//   } );

//   function NotBeforeToday(date)
// {
//     var now = new Date();//this gets the current date and time
//     if (date.getFullYear() == now.getFullYear() && date.getMonth() == now.getMonth() && date.getDate() > now.getDate())
//         return [true];
//     if (date.getFullYear() >= now.getFullYear() && date.getMonth() > now.getMonth())
//        return [true];
//      if (date.getFullYear() > now.getFullYear())
//        return [true];
//     return [false];
// }

  


  </script>


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



