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
	<script type="text/javascript">
		$(window).ready(function() {
		$(".loader").fadeOut("fast");
	});
</script>

 <script>
    $(document).ready(function() {  
  // $('input[name="coupon_sub"]:checked');
 
// $('input:checkbox[name=coupon_sub]').each(function() 
// {   
// // alert(); 
//     if($(this).is(':checked'))
//       alert($(this).val());
// });
$("#coupon_sub").find("checkbox").each(function(){
    if ($(this).prop('checked')==true){ 
        //do something
         alert(); 
    }
});

});
  
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
   
    $("#aqb").click(function(e){
    alert('asd');
    
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
	</body>

</html>