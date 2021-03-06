

<!-- validation of  email and password for login -->


<head>
  
      <title>Login - Fitness & Health Experts in Basingstoke | Body By Lekan</title>
  <meta name="description" content="Login to book classes, view your calendar and timetable, manage your membership and get the latest health and fitness insights, tools and special offers.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.bodybylekan.com/customer-login">
            
            <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    <!-- //font-awesome-icons -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">
</head>
            @if($customer_social_data1['name'])
                <?php $social_name=$customer_social_data1['name']?>
            @else
            <?php $social_name=''?>
            @endif

            @if($customer_social_data1['email'])
                <?php $social_email=$customer_social_data1['email']?>
            @elseif($errors->has('email_not_here'))
            <?php $social_email=old('email');?>
            @elseif($errors->has('email_here'))
            <?php $social_email=old('email');?>
            @elseif($errors->has('email'))
            <?php $social_email=old('email');?>
            @else
            <?php $social_email='';?>
            @endif

            @if($customer_social_data1['provider_id'] && $customer_social_data1['provider_name'])

            <?php 
            $social_provider_id=$customer_social_data1['provider_id'];
            $social_provider_name=$customer_social_data1['provider_name'];
            ?>
            @else
             <?php 
            $social_provider_id='';
            $social_provider_name='';
            ?>
            @endif

             @if($errors->duplicate_ph_email->has('email') || $errors->duplicate_ph_email->has('ph_no'))
            <?php $social_email=old('email');  $social_name=old('name'); 

            $social_provider_id=old('provider_id');
            $social_provider_name=old('provider_name');
            ?>
            @endif




<body class="lg-body">
    <div class="whole-wrp login"></div>
    <div class="logo-m"><a href="{{route('bbldb')}}"><img src="{{asset('frontend/images/logo.png')}}"></a></div>
<section class="login-section">
      <div class="container-fluid">
          <div class="login-wrapper" style="display: block;">
             <form method="POST" action="{{ route('customer-purchase-login-success') }}" id="myeditform">
                  @csrf
                  <div class="input-box">

                    <input type="hidden" name="plan_id" value="{{Session::get('plan_id')}}">

                     <input  type="hidden" name="provider_id" value="{{$social_provider_id}}" >
                        <input  type="hidden" name="provider_name" value="{{$social_provider_name}}" >

                    <div class="log-box-header">
                      <h3>Package Purchase</h3>
                  </div>
                              
                    <input  class="yr-email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" id="email" value="{{$social_email}}" autofocus>

                    <input  class="yr-email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Re-type Email" name="re-email" value="{{$social_email}}" autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                      @endif
                      @if ($errors->has('email_not_here'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('email_not_here') }}</strong>
                              </span>
                      @endif
                      
                      @if ($errors->duplicate_ph_email->has('email'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->duplicate_ph_email->first('email') }}</strong>
                              </span>
                          @endif
                      @if ($errors->has('email_here') || $errors->duplicate_ph_email->has('email') || $errors->duplicate_ph_email->has('ph_no') || $errors->has('email') || $customer_social_data1['provider_id'])
                       <input id="password" type="password" class="yr-pswrd" placeholder="Password"  name="password">

                       @endif
                     
                      @if ($errors->has('email_not_here'))

                       <input id="password" type="password" class="yr-pswrd" placeholder="Password"  name="password">
                       
                      <input class="yr-name" placeholder="Your Name" type="text" id="name" 
                      name="name" class=""  required autofocus>

                      <input class="yr-phn" placeholder="Phone"  id="ph_no" type="text" class="" name="ph_no" required>

                      @endif

                      @if(($errors->duplicate_ph_email->has('email') || $errors->duplicate_ph_email->has('ph_no')) || $customer_social_data1['provider_id'])
                       <input class="yr-name" placeholder="Your Name" type="text" id="name" 
                      name="name"  required autofocus value="{{ $social_name }}" >
                      <input class="yr-phn" placeholder="Phone"  id="ph_no" type="text" class="form-control{{ $errors->duplicate_ph_email->has('ph_no') ? ' is-invalid' : '' }}" name="ph_no" value="{{ old('ph_no') }}" required>
                      @if ($errors->duplicate_ph_email->has('ph_no'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->duplicate_ph_email->first('ph_no') }}</strong>
                              </span>
                          @endif
                      @endif
                     @if ($errors->has('email'))
                     <span class="checkbox1">
                          <label class="checkbox"></label>
                      </span>
                       <a href="{{ route('customerpanel.password.request') }}" class="forgot-p"> Forgot Password</a>
                      @endif
                      <button class="lg-in" type="submit">Next</button>

                      <span class="nw-user"><a class="cm-cls">
                          <a href="{{route('social-auth-login',['provider' => 'facebook'])}}" class="signup"><i class="fa fa-facebook-square" style="color: #5277f8;margin-right: 5px;"></i> Login With Facebook</a> |
                          <a href="{{route('social-auth-login',['provider' => 'google'])}}" class="signup"><i class="fa fa-google-plus" style="color: #cf1508;margin-right: 5px;"></i> Login With Google</a>
                      </a></span>
                  </div>
              </form>
          </div>
      </div> 
    </section>


<!-- js -->
    <script type="text/javascript" src="{{url('frontend/js/jquery-2.1.4.min.js')}}"></script>
    <!-- //js -->
<script src="{{asset('backend/assets/js/jquery.validate.min.js')}}"></script>
    <!-- Slider script -->
    
<script src="{{url('frontend/js/responsiveslides.min.js')}}"></script>
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


  <script>
    $(document).ready(function(){

        $.validator.addMethod("alpha", function(value, element){
    return this.optional(element) || value == value.match(/^[a-zA-Z, '']+$/);
    }, "Alphabetic characters only please");

  // mobile number can contant only numeric
  $.validator.addMethod('numericOnly', function (value) {
       return /^[0-9]+$/.test(value);
    }, 'Please enter only numeric values');
      
$('#myeditform').validate({  
  /// rules of error 
  rules: {
    "name": {
    alpha:true,
      minlength:6,
      required: true
    },
    "address": {
      required: true
    },
 "email": {
      required: true,
      email: true
     
    },
    "re-email": {
      required: true,
      equalTo :"#email"
     
    },
    "ph_no": {
      required: true,
      minlength: 10,
      maxlength: 10,
       numericOnly: true
      
    },
    "password": {
      required: true,
      minlength: 6,
       maxlength:10

    }
   
  },
   ////for show error message
  messages: {
    "name":{
    required: 'Please enter your name',
    minlength:'Minimum length 6 is required'
  },
  "address":{
    required: 'Please enter your address' 
  },

"email":{
    required: "Please enter an email",
        email: "Email is invalid"
  },
  "re-email": {
      required: 'Please enter re-type email',
      equalTo : 'Please enter your re-type email same as email'
    },
  
  "ph_no": {
      required: 'Please enter your mobile number',
      minlength: 'Minimum 10 digits mobile number is required',
      maxlength: 'Maximum 10 digits mobile number is required'
  },
   "password": {
      required: 'Please enter your password',
      minlength: 'Minimum 6 length is required',
      maxlength: 'Maximum 10 length is required'
  }
  }
  });
  
  ///show uploading image and check validation of image

  $("#image").change(function(){ 

    /// check the extension of image

    var ext = $('#image').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    alertify.alert('Only accept gif/png/jpg/jpeg extension formate of image');
    $("#image").val('');
    return false;
    }

    /// check the size of image

    var fileSize = (this.files[0].size / 1024); //size in KB
    if (fileSize > 30) /// not more than 30 kb
    {
        alertify.alert("Please Upload maximum 30KB file size of image");// if Maxsize from Model > real file size
        $("#image").val('');
        return false;
    }

    // show image after upload
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#profile_thumbnail').attr('src', e.target.result);
        }
        $("#profile_thumbnail").show();
        reader.readAsDataURL(this.files[0]);
      }
});

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
    <!--Fontawesome script-->
    <!--<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>-->
</body>

</html>



