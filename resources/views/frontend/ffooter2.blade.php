<!-- js -->
	<script type="text/javascript" src="{{url('frontend/js/jquery-2.1.4.min.js')}}"></script>
	<!-- //js -->
<script src="{{asset('backend/assets/js/jquery.validate.min.js')}}"></script>
	<!-- Slider script -->
	
<script src="{{url('frontend/js/responsiveslides.min.js')}}"></script>
<!-- <script src="{{asset('frontend/js/moment.min.js')}}"></script> -->
 <!-- <script src="{{asset('frontend/js/daterangepicker.js')}}"></script> -->

<script src="{{url('frontend/js/jquery.waypoints.min.js')}}"></script>


  <script src="{{url('frontend/js/jquery.countup.js')}}"></script>
  <script src="{{url('frontend/js/accotab.js')}}"></script>
  <script src="{{url('frontend/js/stellarnav.min.js')}}"></script>
	<!--tooltip js-->
	<script src="{{url('frontend/js/tooltipster.bundle.min.js')}}"></script>
  <!-- @if(Request::segment(2) == 'mybooking')

  <link rel="stylesheet" href="{{ asset('backend/assets/css/totancss/style.css') }}">

    <script src="{{ asset('backend/assets/js/totanjs/alertify.min.js') }}"></script>
 @endif -->
 <script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
                          $('.session-delete').hide();
                      }, 5000);
});
</script>
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

//     $(".asd").on( 'click', function () { 
//   alertify.alert('Alert Message!', function(){ alertify.success('Ok'); });
// });
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


<script>
$(document).ready(function() {

$('#frm1').validate({  
  /// rules of error 
  rules: {
    "selector1": {
      required: true
    }

  },

  messages: {
    "selector1":{
    required: 'Please select your payment mode'
   
  }

}
  });
 $('#mot_option').on('change', function() {
  if($('#mot_option').val()=='metric')
  {
   
  $('.inch').hide();
  
   $('.cm').show();

    }
    else 
  {
    
  $('.inch').show();
  
   $('.cm').hide();

    }
    

});

 $('#convert_option').on('change', function() {
  if($('#convert_option').val()=='metric')
  {
    
  $('.inch').hide();
  
   $('.cm').show();

    }
    else 
  {
    
  $('.inch').show();
  
   $('.cm').hide();

    }
    

});

});
</script>

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





<script>
$(document).ready(function() { 
		$('#team-slider').owlCarousel({
    		loop:true,
			autoplay: true,
    		margin:30,
    		nav:true,
			items: 4,
      margin: 30,
    		responsive:{
    		    0:{
    		        items:1
    		    },
    		    600:{
    		        items:1
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
	

	<script>
		$('.counter').countUp();
	</script>
	<!-- //stats -->
	
	

	<script>
		$(document).ready(function(){
			jQuery('#main-nav').stellarNav();

		});  
	</script>

  <script>
    $(document).ready(function(){  
$('#slotform').validate({  
  /// rules of error 
  rules: {
    "date": {
    required: true
    },

"id": {
    required: true
    },
"time":
    {
    required: true
    }

  },

  messages: {
    "date":{
    required: 'Please enter date'
  },
"id":{
    required: 'Please select trainer name'
  },
"time":{
    required: 'Please select time'
  }
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

var row;
var row2;
       $(".common_mot").click(function() {
         row2 = $(this);
            var right_arm = $(this).data("right_arm");
            var left_arm = $(this).data("left_arm");
            var chest = $(this).data("chest");
            var waist = $(this).data("waist");
            var hips = $(this).data("hips");
            var right_thigh = $(this).data("right_thigh");
            var left_thigh = $(this).data("left_thigh");
            var right_calf = $(this).data("right_calf");
            var left_calf = $(this).data("left_calf");
            var starting_weight = $(this).data("starting_weight");
            var ending_weight = $(this).data("ending_weight");
            var heart_beat = $(this).data("heart_beat");
            var blood_pressure = $(this).data("blood_pressure");
            var height = $(this).data("height");
            
            var description = $(this).data("description");

           if(right_arm!=''){ $('div.right_arm').text(right_arm);} 
           else{  $('div.right_arm').text('-');} 
           if(left_arm!=''){ $('div.left_arm').text(left_arm);}
           else{  $('div.left_arm').text('-');}
           if(chest!=''){ $('div.chest').text(chest);}
           else{ $('div.chest').text('-');}
           if(waist!=''){$('div.waist').text(waist);}
           else{ $('div.waist').text('-');}
           if(hips!=''){ $('div.hips').text(hips);}
           else{ $('div.hips').text('-');}
           if(right_thigh!=''){ $('div.right_thigh').text(right_thigh);}
           else{ $('div.right_thigh').text('-');}
           if(left_thigh!=''){$('div.left_thigh').text(left_thigh);}
           else{ $('div.left_thigh').text('-');}
           if(right_calf!=''){ $('div.right_calf').text(right_calf);}
           else{ $('div.right_calf').text('-');}
           if(left_calf!=''){ $('div.left_calf').text(left_calf);}
           else{ $('div.left_calf').text('-');}
           if(starting_weight!=''){ $('div.starting_weight').text(starting_weight);}
           else{ $('div.starting_weight').text('-');}
           if(ending_weight!=''){ $('div.ending_weight').text(ending_weight);}
           else{ $('div.ending_weight').text('-');}
           if(heart_beat!=''){ $('div.heart_beat').text(heart_beat);}
           else{ $('div.heart_beat').text('-');}
           if(blood_pressure!=''){ $('div.blood_pressure').text(blood_pressure); }
           else{ $('div.blood_pressure').text('-'); }
           if(height!=''){  $('div.height').text(height);}
           else{ $('div.height').text('-');}
            if(description!=''){
              $('#mot_des').show();
            $('textarea.description').text(description);
          }
           else{
              $('#mot_des').hide();
            $('textarea.description').text('');
          }
          
            $('#reason_modal').modal('show');
        });
        
     
 $('#frm_search').on('submit', function(e) {

  e.preventDefault();

  url="{{url('customer/mybooking?page=1')}}"+'&'+$('#frm_search').serialize();

// $(this).attr('href',url);
window.location = url;

});
$('#book_history .page-link').on('click', function(e) {
e.preventDefault();
console.log($(this).attr('href')+'&'+$('#frm_search').serialize());
 url=$(this).attr('href')+'&'+$('#frm_search').serialize();
// url="{{url('customer/booking_history?page=1')}}"+'&'+$('#frm_search').serialize();
// $(this).attr('href',url);
window.location = url;
return true;
 
});

      $.validator.addMethod("alpha", function(value, element){
    return this.optional(element) || value == value.match(/^[a-zA-Z, '']+$/);
    }, "Alphabetic characters only please");

  // mobile number can contant only numeric
  $.validator.addMethod('numericOnly', function (value) {
       return /^[0-9]+$/.test(value);
    }, 'Please enter only numeric values');
      
$('#changepassword').validate({  
  /// rules of error 
  rules: {
    
    "new-password": {
      required: true,
      minlength: 6
    },
 "new-password_confirmation": {
      required: true,
       minlength: 6,
      equalTo :"#new-password"

     
    }
  },
   ////for show error message
  messages: {
   
  "new-password":{
    minlength: 'Password must be at least 6 characters long',
    required:'Please Enter your password' 
  },
"new-password_confirmation":{
    minlength: 'Confirm Password must be at least 6 characters long',
        required:'Please Enter Confirm password',
        equalTo:"Please enter confirm password same as password"
        
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

 $(".convert").click(function() {
             row = $(this);
            // $('#this_row').val(row);
            var right_arm = $(this).data("right_arm");
            var left_arm = $(this).data("left_arm");
            var chest = $(this).data("chest");
            var waist = $(this).data("waist");
            var hips = $(this).data("hips");
            var right_thigh = $(this).data("right_thigh");
            var left_thigh = $(this).data("left_thigh");
            var right_calf = $(this).data("right_calf");
            var left_calf = $(this).data("left_calf");
            var starting_weight = $(this).data("starting_weight");
            var ending_weight = $(this).data("ending_weight");
            var heart_beat = $(this).data("heart_beat");
            var blood_pressure = $(this).data("blood_pressure");
            var height = $(this).data("height");
            var description = $(this).data("description");

             if(right_arm!=''){ $('div.right_arm').text(right_arm);} 
           else{  $('div.right_arm').text('-');} 
           if(left_arm!=''){ $('div.left_arm').text(left_arm);}
           else{  $('div.left_arm').text('-');}
           if(chest!=''){ $('div.chest').text(chest);}
           else{ $('div.chest').text('-');}
           if(waist!=''){$('div.waist').text(waist);}
           else{ $('div.waist').text('-');}
           if(hips!=''){ $('div.hips').text(hips);}
           else{ $('div.hips').text('-');}
           if(right_thigh!=''){ $('div.right_thigh').text(right_thigh);}
           else{ $('div.right_thigh').text('-');}
           if(left_thigh!=''){$('div.left_thigh').text(left_thigh);}
           else{ $('div.left_thigh').text('-');}
           if(right_calf!=''){ $('div.right_calf').text(right_calf);}
           else{ $('div.right_calf').text('-');}
           if(left_calf!=''){ $('div.left_calf').text(left_calf);}
           else{ $('div.left_calf').text('-');}
           if(starting_weight!=''){ $('div.starting_weight').text(starting_weight);}
           else{ $('div.starting_weight').text('-');}
           if(ending_weight!=''){ $('div.ending_weight').text(ending_weight);}
           else{ $('div.ending_weight').text('-');}
           if(heart_beat!=''){ $('div.heart_beat').text(heart_beat);}
           else{ $('div.heart_beat').text('-');}
           if(blood_pressure!=''){ $('div.blood_pressure').text(blood_pressure); }
           else{ $('div.blood_pressure').text('-'); }
           if(height!=''){  $('div.height').text(height);}
           else{ $('div.height').text('-');}
            if(description!=''){
              $('#des').show();
            $('textarea.description').text(description);
          }
           else{
              $('#des').hide();
            $('textarea.description').text('');
          }
            $('#convert_modal').modal('show');
        });



     $('#convert_option').on('change', function()
    {
      // row=$('#this_row').val();
      // alert('fdsdsf');
    if($(this).val()=='metric')
      { 
           
            
            var right_arm = row.data("right_arm");
            var left_arm = row.data("left_arm");
            var chest = row.data("chest");
            var waist = row.data("waist");
            var hips = row.data("hips");
            var right_thigh = row.data("right_thigh");
            var left_thigh = row.data("left_thigh");
            var right_calf = row.data("right_calf");
            var left_calf = row.data("left_calf");
            var starting_weight = row.data("starting_weight");
            var ending_weight = row.data("ending_weight");
            var heart_beat = row.data("heart_beat");
            var blood_pressure = row.data("blood_pressure");
            var height = row.data("height");



            

            
            console.log('sas');
    
          }
    else{
      // var right_arm = $(this).data("right_arm")/0.393701;
            var right_arm = (row.data("right_arm")*0.393701).toFixed(2);
            var left_arm = (row.data("left_arm")*0.393701).toFixed(2);
            var chest = (row.data("chest")*0.393701).toFixed(2);
            var waist = (row.data("waist")*0.393701).toFixed(2);
            var hips = (row.data("hips")*0.393701).toFixed(2);
            var right_thigh = (row.data("right_thigh")*0.393701).toFixed(2);
            var left_thigh = (row.data("left_thigh")*0.393701).toFixed(2);
            var right_calf = (row.data("right_calf")*0.393701).toFixed(2);
            var left_calf = (row.data("left_calf")*0.393701).toFixed(2);
            var starting_weight = (row.data("starting_weight")*2.20462).toFixed(2);
            var ending_weight = (row.data("ending_weight")*2.20462).toFixed(2);
            var heart_beat = row.data("heart_beat");
            var blood_pressure = row.data("blood_pressure");
            var height = (row.data("height")*0.393701).toFixed(2);

    }
           

          if(right_arm!=''){ $('div.right_arm').text(right_arm);} 
           else{  $('div.right_arm').text('-');} 
           if(left_arm!=''){ $('div.left_arm').text(left_arm);}
           else{  $('div.left_arm').text('-');}
           if(chest!=''){ $('div.chest').text(chest);}
           else{ $('div.chest').text('-');}
           if(waist!=''){$('div.waist').text(waist);}
           else{ $('div.waist').text('-');}
           if(hips!=''){ $('div.hips').text(hips);}
           else{ $('div.hips').text('-');}
           if(right_thigh!=''){ $('div.right_thigh').text(right_thigh);}
           else{ $('div.right_thigh').text('-');}
           if(left_thigh!=''){$('div.left_thigh').text(left_thigh);}
           else{ $('div.left_thigh').text('-');}
           if(right_calf!=''){ $('div.right_calf').text(right_calf);}
           else{ $('div.right_calf').text('-');}
           if(left_calf!=''){ $('div.left_calf').text(left_calf);}
           else{ $('div.left_calf').text('-');}
           if(starting_weight!=''){ $('div.starting_weight').text(starting_weight);}
           else{ $('div.starting_weight').text('-');}
           if(ending_weight!=''){ $('div.ending_weight').text(ending_weight);}
           else{ $('div.ending_weight').text('-');}
           if(heart_beat!=''){ $('div.heart_beat').text(heart_beat);}
           else{ $('div.heart_beat').text('-');}
           if(blood_pressure!=''){ $('div.blood_pressure').text(blood_pressure); }
           else{ $('div.blood_pressure').text('-'); }
           if(height!=''){  $('div.height').text(height);}
           else{ $('div.height').text('-');}


          
   
});

 
  $('#mot_option').on('change', function()
    {
      // alert('fdsdsf');
    if($(this).val()=='metric')
      { 
            

            var right_arm = row2.data("right_arm");
            var left_arm = row2.data("left_arm");
            var chest = row2.data("chest");
            var waist = row2.data("waist");
            var hips = row2.data("hips");
            var right_thigh = row2.data("right_thigh");
            var left_thigh = row2.data("left_thigh");
            var right_calf = row2.data("right_calf");
            var left_calf = row2.data("left_calf");
            var starting_weight = row2.data("starting_weight");
            var ending_weight = row2.data("ending_weight");
            var heart_beat = row2.data("heart_beat");
            var blood_pressure = row2.data("blood_pressure");
            var height = row2.data("height");
            

            
          }
    else{
      
      
       var right_arm = (row2.data("right_arm")*0.393701).toFixed(2);
            var left_arm = (row2.data("left_arm")*0.393701).toFixed(2);
            var chest = (row2.data("chest")*0.393701).toFixed(2);
            var waist = (row2.data("waist")*0.393701).toFixed(2);
            var hips = (row2.data("hips")*0.393701).toFixed(2);
            var right_thigh = (row2.data("right_thigh")*0.393701).toFixed(2);
            var left_thigh = (row2.data("left_thigh")*0.393701).toFixed(2);
            var right_calf = (row2.data("right_calf")*0.393701).toFixed(2);
            var left_calf = (row2.data("left_calf")*0.393701).toFixed(2);
            var starting_weight = (row2.data("starting_weight")*2.20462).toFixed(2);
            var ending_weight = (row2.data("ending_weight")*2.20462).toFixed(2);
            var heart_beat = row2.data("heart_beat");
            var blood_pressure = row2.data("blood_pressure");
            var height = (row2.data("height")*0.393701).toFixed(2);
           
     

    }
   

            if(right_arm!=''){ $('div.right_arm').text(right_arm);} 
           else{  $('div.right_arm').text('-');} 
           if(left_arm!=''){ $('div.left_arm').text(left_arm);}
           else{  $('div.left_arm').text('-');}
           if(chest!=''){ $('div.chest').text(chest);}
           else{ $('div.chest').text('-');}
           if(waist!=''){$('div.waist').text(waist);}
           else{ $('div.waist').text('-');}
           if(hips!=''){ $('div.hips').text(hips);}
           else{ $('div.hips').text('-');}
           if(right_thigh!=''){ $('div.right_thigh').text(right_thigh);}
           else{ $('div.right_thigh').text('-');}
           if(left_thigh!=''){$('div.left_thigh').text(left_thigh);}
           else{ $('div.left_thigh').text('-');}
           if(right_calf!=''){ $('div.right_calf').text(right_calf);}
           else{ $('div.right_calf').text('-');}
           if(left_calf!=''){ $('div.left_calf').text(left_calf);}
           else{ $('div.left_calf').text('-');}
           if(starting_weight!=''){ $('div.starting_weight').text(starting_weight);}
           else{ $('div.starting_weight').text('-');}
           if(ending_weight!=''){ $('div.ending_weight').text(ending_weight);}
           else{ $('div.ending_weight').text('-');}
           if(heart_beat!=''){ $('div.heart_beat').text(heart_beat);}
           else{ $('div.heart_beat').text('-');}
           if(blood_pressure!=''){ $('div.blood_pressure').text(blood_pressure); }
           else{ $('div.blood_pressure').text('-'); }
           if(height!=''){  $('div.height').text(height);}
           else{ $('div.height').text('-');}
            
   
});



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

    <script>

  $(function () {
    $( "#datepicker_slot_request" ).datepicker({
  dateFormat: "yy-mm-dd"
});
  } );

  </script>
	<!--Fontawesome script-->
	<!--<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>-->

  <script>
$(document).ready(function(){
$("#extra_session").mouseover(function(){
        $('.extra_session_div').show();
    });
    $("#extra_session").mouseout(function(){
        $('.extra_session_div').hide();
    });

});
</script>


<script>

  $(document).ready(function() {

    $.validator.addMethod("multipeFieldValidator", function(value) {  
    if($("#package_image").val()=='' && $("#package_description").val()=='') {
        
      return false;
    }
    return true; 
}, 'Either image or description is required');

    $('#bank_payment-form').validate({  
      /// rules of error 
      rules: {
        
        "package_image": {
                    multipeFieldValidator:true
                  },
         "package_description": {
                    multipeFieldValidator:true,
                    maxlength: 300,
                  }
      },
      ////for show error message
      messages: {
        
        "package_image": "Image is required if no description is given",
        "package_description":
        {
          multipeFieldValidator:"Description is required if no image is given",
          maxlength: "Maximum 300 characters are allow"
        } 
      }
    });
    });
</script>






<script>
  $(document).ready(function() { 
 $("#package_image").change(function(){ 
    /// check the extension of image

    var ext = $('#package_image').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    alert('Only accept gif/png/jpg/jpeg extension formate of image');
    $("#package_image").val('');
    return false;
    }

    /// check the size of image

    var fileSize = (this.files[0].size / 1024); //size in KB
    if (fileSize > 250) /// not more than 30 kb
    {
       alert("Please Upload maximum 250KB file size of image");// if Maxsize from Model > real file size
        $("#package_image").val('');
        return false;
    }

    
});
});
</script>
<script>
        $(document).ready(function() {
            $('.toolclip').tooltipster({
				contentCloning: true,
				contentAsHTML: true,
				animation: 'grow',
   				delay: 500,
   				theme: 'tooltipster-punk',
				functionInit: function(instance, helper){

        var $origin = $(helper.origin),
            dataOptions = $origin.attr('data-tooltipster');

        if(dataOptions){
			
            dataOptions = JSON.parse(dataOptions);

            $.each(dataOptions, function(name, option){
                instance.option(name, option);
            });
        }
    }
			});
        });
    </script>

    <script type="text/javascript">
		$(window).ready(function() {
		$(".loader").fadeOut("fast");
	});
</script>

 <script type="text/javascript">
    $(document).ready(function() {
   
    $("#coupon_sub").click(function(e){
    // alert('asd');
    
      if($('#coupon_code').val()!='') 
    { 
      $('#coupon_sub').hide();
      $('#aqb').attr('disabled','disabled');
       $('#loadingimg2').show();
       
       var coupon_code = $('#coupon_code').val();
      // var package_id = $(this).attr("package_id");
       var package_id = $('#package_id').val();
       var package_price = $('#package_price').val();
        var coupon_id = $('#coupon_id').val();
     
       console.log(coupon_code);
       console.log(package_id);
       console.log(coupon_id);
        $.ajax({
          type: "GET",
          url: "{{route('cus_couponsearch')}}",
          data: {'coupon_code': coupon_code, 'package_id': package_id, 'package_price': package_price},
           dataType: "json",
        success: function(data){


            if(data.new_package_price)
            { 
              $('#loadingimg2').hide();
               $('#aqb').removeAttr('disabled');
              $('#coupon_sub').show();
              $('.rev-line').addClass('line_t');
              
              $('#new_price').show();
              $('#new_p').html("Discounted Price - <h6><i class='fa fa-gbp'></i> "+data.new_package_price+" </h6>");
               // $('#app_btn').hide();
                $('#new_package_price').val(data.new_package_price);
                $('#coupon_id').val(data.coupon_id);
                console.log(data.coupon_id);
                $("#invalid_coupon").hide();
                 $("#success_coupon").show();
               
              $("#success_coupon").html("Thank you using your coupon code");

            }
             else if(data.ex_coupon_code)
            { 
              // alert('ddd');
              $('#loadingimg2').hide();
              $('#coupon_sub').show();
              $('#aqb').attr('disabled','disabled');
              $('.rev-line').removeClass('line_t');
              $('#new_price').hide();
              $('#new_package_price').val('');
              $("#success_coupon").hide();
              $("#invalid_coupon").show();
              $("#invalid_coupon").html("Coupon code is not activated");
              
            }

              else if(data.coupon_expair)
            { 

               // alert('drd');
               $('#loadingimg2').hide();
               $('#coupon_sub').show();
               $('.rev-line').removeClass('line_t');
               $('#aqb').attr('disabled','disabled');
               $('#new_price').hide();
              $('#new_package_price').val('');
               $("#success_coupon").hide();
              $("#invalid_coupon").show();
              $("#invalid_coupon").html("Coupon code is expaired");
              
            }
               else if(data.wrong_details==0)
            { 
              // alert('ddd');
              $('#loadingimg2').hide();
              $('#coupon_sub').show();
              $('#aqb').attr('disabled','disabled');
              $('.rev-line').removeClass('line_t');
              $('#new_price').hide();
              $('#new_package_price').val('');
              $("#success_coupon").hide();
              $("#invalid_coupon").show();
              $("#invalid_coupon").html("Invalid coupon code");
              
            }
            else
            { 
              $('#loadingimg2').hide();
              $('#coupon_sub').show();
              $('#aqb').attr('disabled','disabled');
              $('#new_price').hide();
              $('#new_package_price').val('');
              $("#success_coupon").hide();
               $("#invalid_coupon").show();
              $("#invalid_coupon").html("Invalid coupon code");
              
            }
  }
     });
    }
else
{
   $("#invalid_coupon").show();
   $("#invalid_coupon").html("Enter a coupon code");
}

     });
});
  </script>

   <script>
 
     function  jsnull(){
// alert('sd');
    if($('#coupon_code').val()=='') 
    { 
$('#coupon_sub').show();
      $('#aqb').removeAttr('disabled');
      $('#new_price').hide();
       $('.rev-line').removeClass('line_t');
      $('#new_package_price').val('');
       $("#invalid_coupon").hide();
       $("#success_coupon").hide();
    }
   }
  
  </script>

 <script>
  $(document).ready(function(){



$('#bank_payment-form').bind('submit', function (e) {
    var button = $('#aba');

    // Disable the submit button while evaluating if the form should be submitted
    button.prop('disabled', true);

    var valid = true;    

    // Do stuff (validations, etc) here and set
    // "valid" to false if the validation fails

    if (!valid) { 
        // Prevent form from submitting if validation failed
        e.preventDefault();

        // Reactivate the button if the form was not submitted
        button.prop('disabled', false);
    }
});
});
</script>
 

<script>
   $('#bootcamp-slider,#bootcamp-slider2,#bootcamp-slider3').owlCarousel({
    autoplay: true,
    items: 3,
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
        items:3
      }
    }
  });
</script>


  <!--stripe payment gateway validation and form submission -->
  <script>
$(function() {
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(e.target).closest('form'),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;

    $errorMessage.addClass('hide');
    $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault(); // cancel on first error
      }
    });
  });
});

$(function() {
  var $form = $("#payment-form");

  $form.on('submit', function(e) {
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  });

  function stripeResponseHandler(status, response) {
    if (response.error) {
      $('.error')
        .removeClass('hide')
        .find('.alert')
        .text(response.error.message);
    } else {
      // token contains id, last4, and card type
      var token = response['id'];
      // insert the token into the form so it gets submitted to the server
      $form.find('input[type=text]').empty();
      $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
      $('.stripe-pay-btn').attr('disabled','disabled');
      $('.stripe-pay-btn').text('Please wait...');
      $form.get(0).submit();
    }
  }
})
</script>
</body>

</html>



