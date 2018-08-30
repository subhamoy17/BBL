<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Gym Trainer a Sports Category Bootstrap Responsive Website Template | Home :: gylayouts</title>
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

    <link href="{{url('frontend/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{url('frontend/css/responsive.css')}}" rel="stylesheet" type="text/css" media="all" />
    <!-- font-awesome-icons -->
    <link href=" {{url('frontend/css/font-awesome.css')}}" rel="stylesheet">
    <!-- //font-awesome-icons -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">
</head>

<body class="lg-body">

    <div class="whole-wrp"></div>

    <div class="logo-m"><a href="{{route('bbldb')}}"><img src="{{asset('frontend/images/logo.png')}}"></a></div>
     <section class="login-section">
      <div class="container-fluid">
          <!--social login block -->
          @if($customer_social_data1['name'])
                <?php $social_name=$customer_social_data1['name']?>
            @else
            <?php $social_name=''?>
            @endif

            @if($customer_social_data1['email'])
                <?php $social_email=$customer_social_data1['email']?>
            @else
            <?php $social_email=''?>
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

             @if($errors->has('email') || $errors->has('ph_no'))
            <?php $social_email=old('email');  $social_name=old('name'); 

            $social_provider_id=old('provider_id');
            $social_provider_name=old('provider_name');
            ?>
            @endif

            
          <!--social login block end-->
         
            <div class="container-fluid">
            
                    <div class="reg-wrapper">
                         @if (session('confirm_message'))
                     <div class="alert alert-success">
                        {{ session('confirm_message') }}
                                    </div>
                                @endif
                    <form action="{{route('customer-register-success')}}" method="POST" enctype="multipart/form-data" class="form-horizontal" id="myregistration">
                          {{ csrf_field() }}

                         <!-- for social login  -->
                        <input  type="hidden" name="provider_id" value="{{$social_provider_id}}" >
                        <input  type="hidden" name="provider_name" value="{{$social_provider_name}}" >


                        <div class="log-box-header">
                            <h3>Register With Us</h3>
                        </div>
                        <div class="input-box">
                            <input class="yr-name" placeholder="Your Name" type="text" id="name" 
                            name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $social_name }}" required autofocus>
                          
                            <input class="yr-email" placeholder="Email"  id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$social_email}}" >
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            <input class="yr-phn" placeholder="Phone"  id="ph_no" type="text" class="form-control{{ $errors->has('ph_no') ? ' is-invalid' : '' }}" name="ph_no" value="{{ old('ph_no') }}" required>
                            @if ($errors->has('ph_no'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('ph_no') }}</strong>
                                    </span>
                                @endif
                            <input class="yr-pswrd" placeholder="Password"  id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                              @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                            <input class="cnfm-pswrd" placeholder="Confirm Password" type="password"  id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                            <button class="lg-in" type="submit" name="submit" id="submit">Register</button>
                            

                            <span class="nw-user"><a class="cm-cls">
                                <a href="{{route('social-auth-login',['provider' => 'facebook'])}}" class="signup"><i class="fa fa-facebook-square" style="color: #5277f8;margin-right: 4px;"></i> Login With Facebook</a> |
                                <a href="{{route('social-auth-login',['provider' => 'google'])}}" class="signup"><i class="fa fa-google-plus" style="color: #cf1508;margin-right: 4px;"></i> Login With Google</a>
                            </a></span>
                        </div>
                    </form>
                </div>
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
    "ph_no": {
      required: true,
      minlength: 10,
      maxlength: 10,
       numericOnly: true
      
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
  
  "ph_no": {
      required: 'Please enter your mobile number',
      minlength: 'Minimum 10 digits mobile number is required',
      maxlength: 'Maximum 10 digits mobile number is required'
  },
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
    $(document).ready(function(){

        $.validator.addMethod("alpha", function(value, element){
    return this.optional(element) || value == value.match(/^[a-zA-Z, '']+$/);
    }, "Alphabetic characters only please");

  // mobile number can contant only numeric
  $.validator.addMethod('numericOnly', function (value) {
       return /^[0-9]+$/.test(value);
    }, 'Please enter only numeric values');
      
$('#myregistration').validate({  
  /// rules of error 
  rules: {
    "name": {
    alpha:true,
      minlength:6,
      required: true
    },
    
 "email": {
      required: true,
      email: true
     
    },
    "ph_no": {
      required: true,
      minlength: 10,
      maxlength: 12,
       numericOnly: true
      
    },

"password": {
      required: true,
      minlength: 6,
       maxlength:10

    },
"password_confirmation":{
       required: true,
    equalTo :"#password"

}

  },
   ////for show error message
  messages: {
    "name":{
    required: 'Please enter your name',
    minlength:'Minimum length 6 is required'
  },
"email":{
    required: "Please enter an email",
        email: "Email is invalid"
  },
  "ph_no": {
      required: 'Please enter your mobile number',
      minlength: 'Minimum 10 digits mobile number is required',
      maxlength: 'Maximum 12 digits mobile number is required'
  },
"password": {
      required: 'Please enter your password',
      minlength: 'Minimum 6 length is required',
      maxlength: 'Maximum 10 length is required'
  },

"password_confirmation": {
      required: 'Please enter your confirm password'
     
  }
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



