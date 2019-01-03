
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


 @if (session('boocked'))
<div class="alert alert-success">
{{ session('boocked') }}
</div>
@endif
      
     @if($no_of_sessions>0)
      <ul class="tabs" id="hide-menu">
        <li class="active bb" id="t5" rel="tab5"><a href="#"  data-toggle="tab" id="li1" class="li1">Book By Trainer</a></li>
        <li class="bb" rel="tab6" id="t6" ><a href="#"  data-toggle="tab" id="li2" class="li2">Book By Time</a></li>
      </ul>
    @endif

<div class="tab_container">

        

          <!-- #tab1 -->
          <h3 class="ed-p">Personal Training Session Booking&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
            Remaining Session {{$no_of_sessions}}
          </h3>
          <h3 class="d_active tab_drawer_heading" rel="tab5">Tab 5</h3>
          <div id="tab5" class="tab_content">
            <div class="form-box">

                @if($no_of_sessions>0)
                
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">

                 
                    <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                              <input type="hidden" id="total_slots" class="form-control" value="{{Session::get('sum_slots')}}"  >
                              <label>Address <small>*</small></label>
                             
                             
                            <select class="form-control" name="address" id="address">
                            <!-- <option value=" ">Please select address</option> -->
                            @if(!empty($pt_session_address))
                            @foreach($pt_session_address as $each_ptaddress)
                              <option value="{{$each_ptaddress->id}}">{{$each_ptaddress->address_line1}}</option>
                            @endforeach
                            @endif    
                          </select>
                          

                            </div>
                        </div>



              
                  <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                            
                              <label>Trainer Name <small>*</small></label>
                              <select class="form-control" name="id" id='trainer_id' onchange="get_alldate(this.value)">
                                <option value=""> Please select a name</option>
                                 @foreach($all_pt_trainer as $mydata)
                                <option value="{{$mydata->trainer_id}}"> {{$mydata->trainer_name}}</option>
                                @endforeach
                              </select>

                              

                            </div>
                        </div>

                    

                        <div class="col-md-6 col-sm-12 col-xs-12">
                      <div class="form-group available_date">
                        <label>Available Date <small>*</small></label>
                        <input type="text" id="pt_date" name="pt_date" class="form-control" readonly="true" disabled="disabled">
                      </div>
                    </div>
                     

                            <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group" >
                      <label>Available Time <small>*</small></label>
                        <select class="form-control" name="session_time" id="session_time" disabled="disabled" style="background:#3d3648;">
                                
                        </select>
                        </div> 
                    </div>
                        

                        <div id="old_session_data">
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input name="form_botcheck" class="form-control" value="" type="hidden">
                          <input type="hidden" id="session_no" name="session_no" value="1">
                          <button id="add_sess" class="btn btn-dark btn-theme-colored btn-flat">Add Session</button>
                        </div>

                </div>

                 <div  class="col-md-6 col-sm-12 col-xs-12" id='loadingimg' style="display: none;">
                                <div class="form-group" >
                              <img src="{{asset('backend/images/loader_session_time.gif')}}" style="width: 85px;margin-top: -30px;margin-left: -21px;"/>
                            </div>
                            </div> 

                
             
            </div>
<div id="sesssion_table">
  <form action="{{route('ptsession_booking_customer')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="add_session_form1">

    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="idd" id="id" value="{{Auth::guard('customer')->user()->id}}">
    <input type="hidden" name="nd_btn" id="nd_btn" value="1">
    <div id="add_session_req" class="col-md-12 col-sm-12 col-xs-12">

    </div>
            
      <button class="btn btn-dark btn-theme-colored btn-flat btn-drk2 save_button"  style="display:none;" id="save_btn">Submit</button>
       </form>
    </div>

                </div>

                @endif

              </div>
          </div>

 <div id="tab6" class="tab_content">
            <div class="form-box">


                
                @if($no_of_sessions>0)
                
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">

                 
                    <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                              <input type="hidden" id="total_slots2" class="form-control" value="{{Session::get('sum_slots')}}"  >

                              <label>Address <small>*</small></label>
                              <select class="form-control" name="address2" id="address2">
                            <!-- <option value=" ">Please select address</option> -->
                            @if(!empty($pt_session_address))
                            @foreach($pt_session_address as $each_ptaddress)
                              <option value="{{$each_ptaddress->id}}">{{$each_ptaddress->address_line1}}</option>
                            @endforeach
                            @endif    
                          </select>
                            </div>
                        </div>              


                         <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group" >

                               <label>Date <small>*</small></label>
                        @if(count($date_details)>0)
                        <input type="text" id="pt_date2" name="pt_date2" class="form-control" readonly="true">
                        @foreach($date_details as $each_date)
                        <input type="hidden" name="all_date2[]" id="all_date2"  value="{{$each_date->plan_date}}">
                        @endforeach
                        @else
                        <input type="text" id="pt_date2" name="pt_date2" class="form-control" readonly="true" value="No dates are available to apply" disabled="disabled">
                        @endif
                              

                            </div>
                            
                        </div>

                          <div class="col-md-6 col-sm-12 col-xs-12">
                         
                            
                        
                          <label>Booking Time <small>*</small></label>
                               <select class="form-control" name="session_time2" id="session_time2" disabled="disabled" style="background:#3d3648;" onchange="pt_trainer(this.value)">
                                
                        </select>



                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                            
                              <label>Available Trainer <small>*</small></label>
                              <select class="form-control" name="trainer_id2" id='trainer_id2' disabled="disabled" style="background:#3d3648;">
                               
                              </select>

                              

                            </div>
                        </div>
                        <!-- <div class="clearfix"></div> -->
                      

                        <div id="old_session_data2">
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input name="form_botcheck" class="form-control" value="" type="hidden">
                          <input type="hidden" id="session_no2" name="session_no2" value="1">
                          <button id="add_sess2" class="btn btn-dark btn-theme-colored btn-flat">Add Session</button>
                        </div>

                        </div>

                        <div  class="col-md-6 col-sm-12 col-xs-12" id='loadingimg2' style="display: none;">
                                <div class="form-group" >
                              <img src="{{asset('backend/images/loader_session_time.gif')}}" style="width: 85px;margin-top: -30px;margin-left: -21px;"/>
                            </div>
                            </div> 
              </div>
            
<div id="sesssion_table">
  <form action="{{route('ptsession_booking_customer_bytime')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="add_session_form2">

    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="idd" id="id" value="{{Auth::guard('customer')->user()->id}}">
     <input type="hidden" name="nd_btn" id="nd_btn" value="2">
    <div id="add_session_req2" class="col-md-12 col-sm-12 col-xs-12">

      <div style="display: none;" id='add_session_loadingimg'>
          <img src="{{asset('backend/images/loader_session_time.gif')}}" style="width: 85px;margin-top: -30px;margin-left: -21px;"/>
        </div>

    </div>
            
      <button class="btn btn-dark btn-theme-colored btn-flat btn-drk2 save_button"  style="display:none;" id="save_btn2">Submit</button>
       </form>
    </div>

                </div>

                @endif



                

              </div>
          </div>   

         
          </div>         

      </div>
      </div>
      <!-- .tab_container -->
    </div>

<div id="pt_session_modal" class="modal fade  mot-mod session-modal" role="dialog" >
  <div class="modal-dialog">
    
    <div class="modal-content">
    <div class="modal-header">
      @if(session('success'))
      <h2>You have successfully booked the below personal training session(s).</h2>
    </div>
      <div class="modal-body" id="hall_details_edit">
      <table class="table table-border" width="100%">
        <tbody>
        <tr><td>Address</td><td>Trainer Name</td><td>Date</td><td>Time</td></tr>
        
      @foreach(session('all_data') as $key => $eachdata)
    
      @for($i=0;$i<$eachdata->total_sessions;$i++)
      <tr>
      <td>
        {{$eachdata->pt_address[$i]}}
      </td>
      <td>
        {{$eachdata->pt_trainer[$i]}}
      </td>
      <td>
        {{$eachdata->pt_date[$i]}}
      </td>
      <td>
        {{$eachdata->pt_time[$i]}}
    </td>
    </tr>
    @endfor
     @endforeach    
     </tbody>
   </table>

      @endif
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <br class="clear" />
        </div>
        <div class="col-sm-12 col-xs-12">
      <div class="row">
          
    </div>
      </div>
  </div>
</div>
<button type="button" class="btn btn-default success-close" data-dismiss="modal">Close</button>
</div>
</div>
</div>

<div id="pt_session_modal1" class="modal fade  mot-mod session-modal" role="dialog" >
  <div class="modal-dialog">
    
    <div class="modal-content">
    <div class="modal-header">
      @if(session('success1'))
      <h2>You have successfully booked the below personal training session(s).</h2>
    </div>
      <div class="modal-body" id="hall_details_edit">
      <table class="table table-border" width="100%">
        <tbody>
        <tr><td>Address</td><td>Trainer Name</td><td>Date</td><td>Time</td></tr>
        
      @foreach(session('all_data') as $key => $eachdata)
    
      @for($i=0;$i<$eachdata->total_sessions;$i++)
      <tr>
      <td>
        {{$eachdata->pt_address[$i]}}
      </td>
      <td>
        {{$eachdata->pt_trainer[$i]}}
      </td>
      <td>
        {{$eachdata->pt_date[$i]}}
      </td>
      <td>
        {{$eachdata->pt_time[$i]}}
    </td>
    </tr>
    @endfor
     @endforeach    
     </tbody>
   </table>

      @endif
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <br class="clear" />
        </div>
        <div class="col-sm-12 col-xs-12">
      <div class="row">
          
    </div>
      </div>
  </div>
</div>
<button type="button" class="btn btn-default success-close" data-dismiss="modal">Close</button>
</div>
</div>
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

   @if (session('success'))
    <script>
      $(document).ready(function(){ 
       $('#pt_session_modal').modal('show');
      });
    </script>
<?php Session::forget('success'); ?>

  @endif

  @if (session('success1'))
    <script>
      $(document).ready(function(){ 
       $('#pt_session_modal1').modal('show');
      });
    </script>
<?php Session::forget('success1'); ?>

  @endif

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
  $(document).ready(function(){ 
function nationalDays2(date) {

                var disabledDays2 =$("input[name='all_date2[]']")
              .map(function(){return $(this).val();}).get();

                var m2 = date.getMonth(), d2 = date.getDate(), y2 = date.getFullYear(); 
                 m2=m2+1;

                if(m2<10){ m2="0" + m2;}
                if(d2<10){ d2="0" + d2;}

                for (i = 0; i < disabledDays2.length; i++) {

                  if($.inArray(y2 + '-' + m2 + '-' + d2,disabledDays2) != -1 ) {
                    //console.log('bad:  ' + (m+1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
                    return [true];
                  }
                }
                  return [false];
              }
  // get all date after choose address of bootcamp and set enabled date into calender
           $('#pt_date2').datepicker({
                  dateFormat: "yy-mm-dd",
                  beforeShowDay: nationalDays2,
                  onSelect: getalltime2
                 
                });


function getalltime2(choose_date2)
  {
    $('#loadingimg2').show();
    
    $('#session_time2').find('option').remove();
    var session_time2 = $('#session_time2');
                    session_time2.prop("disabled",false);
                    // session_time2.empty();
    $.ajax({
          type: "GET",
          url: "{{route('get_pt_time2')}}",
          data: {'pt_date2': choose_date2},
          success: function (data){
            $('#loadingimg2').hide();
            // console.log(data);
            var obj = $.parseJSON(data);

            if(obj.length > 0){

              session_time2.append(
                $('<option>', {value: ''}).text('Please select time'));

              var plan_time2='';
              var plan_time_id2=0;
              for(var i = 0; i < obj.length; i++)
              {
                plan_time2=obj[i]['all_time2'];
                plan_time_id2=obj[i]['plan_st_time_id'];
                 //console.log(plan_time_id2);
                session_time2.append($('<option>', {value: obj[i]['plan_st_time_id']}).text(plan_time2));
              }
            }
          } // end of ajax success
        }); //end of ajax call
  } //end of function call


 });
</script>
<script type="text/javascript">
  // $(document).ready(function(){ 
  function pt_trainer(value) {
$('#loadingimg2').show();
$('#trainer_id2').find('option').remove();
     var session_time2 = $('#session_time2');
      var trainer_id2 = $('#trainer_id2');
       trainer_id2.prop("disabled",false);
     console.log(session_time2);
                     
$.ajax({
        type: "GET",
        url: "{{route('get_pt_all_trainer')}}",
        data: {'session_time_id2': value,'choose_date': $('#pt_date2').val()},
          
          success: function (data){
            $('#loadingimg2').hide();
            // console.log(data);
            var obj = $.parseJSON(data);

            if(obj.length > 0){
            $('#trainer_id2').removeAttr('disabled');
              trainer_id2.append(
                $('<option>', {value: ''}).text('Please select Trainer'));

              var trainer_id='';
              var trainer_name='';
                //slot_time.append($('<option>', {value: ''}).text('Please select time'));
              for(var i = 0; i < obj.length; i++)
              {
                 // $('#session_time2').removeAttr('disabled');
                trainer_id=obj[i]['trainer_id'];
                trainer_name=obj[i]['trainer_name'];
                 //console.log(trainer_name);
                trainer_id2.append($('<option>', {value: obj[i]['schedule_id2']}).text(trainer_name));
              }
            }
            else
            {
              trainer_id2.append(
                $('<option>', {value: ''}).text('No trainer are available'));
              trainer_id2.attr("disabled",true);
            }
          } // end of ajax success
        }); //end of ajax call

}

// });
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
    $(document).ready(function(){  

$('a[data-toggle="tab"]').on('click', function (e) { 
  var tab_val=$(this).attr('id'); 
  if(tab_val=='li2')
  { 
    $('#session_time').find('option').remove();

   $('#pt_date').val('');
   $('#session_no').val(1);
   add_session_req.innerHTML='';
   old_session_data.innerHTML='';

   $('.first-success').hide();
   $('#save_btn').hide();
  }
  else if(tab_val=='li1')
  {

    $('#trainer_id2').val('');
    $('#pt_date2').val('');
   $('#session_time2').find('option').remove();
   $('#trainer_id2').find('option').remove();
   $('#session_no2').val(1);
   add_session_req2.innerHTML='';
   old_session_data2.innerHTML='';
   $('.second-success').hide();
   $('#save_btn2').hide();


  }
});

    });  
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


<script>

    function get_alldate(value)
  { 

    if(value>0)
    {
      $('#loadingimg').show();
      $.ajax({
          type: "GET",
          url: "{{route('get_pt_date')}}",
          data: {'trainer_id': value},
          success: function (data){
            $('#loadingimg').hide();
            // console.log(data);
            var obj = $.parseJSON(data);

            var plan_date='';
            

            if(obj.length > 0)
            { 
            console.log(obj.length);
              $('#pt_date').removeAttr('disabled');
              $('#pt_date').val('');
              $(".all_date_class").remove();
              var disabledDays ='';

              for(var i = 0; i < obj.length; i++)
              {
                plan_date=obj[i]['plan_date'];

                $('.available_date').append($('<input type="hidden" name="all_date[]" id="all_date" class="all_date_class" value="' + plan_date + '">'));
              }

              // console.log(disabledDays);
               
              function nationalDays(date) {

                var disabledDays =$("input[name='all_date[]']")
              .map(function(){return $(this).val();}).get();

                var m = date.getMonth(), d = date.getDate(), y = date.getFullYear(); 
                 m=m+1;

                if(m<10){ m="0" + m;}
                if(d<10){ d="0" + d;}

                for (i = 0; i < disabledDays.length; i++) {

                  if($.inArray(y + '-' + m + '-' + d,disabledDays) != -1 ) {
                    //console.log('bad:  ' + (m+1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
                    return [true];
                  }
                }
                  return [false];
              }
                /* create datepicker */
                $('#pt_date').datepicker({
                  dateFormat: "yy-mm-dd",
                  beforeShowDay: nationalDays,
                   onSelect: getalltime
                });
            $('#pt_date').removeAttr('disabled',true); 
            }
            else
            {
              $('#pt_date').val('No dates are available for this trainer');
              $('#pt_date').attr('disabled',true); 
              return false;             
            }
          } //end of ajax success
        }); // end of ajax call
    }
    else{
      $('#pt_date').attr('disabled',true); 
    }  // end of address select
  } 

function getalltime(choose_date)
  {
    $('#loadingimg').show();
    var session_time = $('#session_time');
                    session_time.prop("disabled",false);
                    session_time.empty();
    $.ajax({
          type: "GET",
          url: "{{route('get_pt_time')}}",
          data: {'pt_date': choose_date,'trainer_id': $('#trainer_id').val()},
          success: function (data){
            $('#loadingimg').hide();
            // console.log(data);
            var obj = $.parseJSON(data);

            if(obj.length > 0){ 
              session_time.append(
                $('<option>', {value: ''}).text('Please select time'));

              var plan_time='';
              var plan_time_id='';
                //slot_time.append($('<option>', {value: ''}).text('Please select time'));
              for(var i = 0; i < obj.length; i++)
              {
                plan_time=obj[i]['all_time'];
                plan_time_id=obj[i]['all_time_id'];
                 // console.log(plan_time_id);
                session_time.append($('<option>', {value: obj[i]['schedule_id']}).text(plan_time));
              }
            }
            else
            {
              session_time.append(
                $('<option>', {value: ''}).text('No time are available for this trainer and date'));
              session_time.attr('disabled',true); 
            }
          } // end of ajax success
        }); //end of ajax call
  } //end of function call

  
</script>
<script>
   $(document).ready(function() {
    $('body').on('click','#add_sess',function(e) {
      e.preventDefault();

    var total_session=$("#total_session").val();

    var total_applicable_sessions=$("#total_applicable_sessions").val();

    var address_text=$("#address option:selected").text();
    var session_time_text=$("#session_time option:selected").text();
    var trainer_name=$("#trainer_id option:selected").text();
    

    var address=$("#address").val();
    var bootcamp_date=$("#pt_date").val();
    var session_time=$("#session_time").val();

    var duplicate_date=0;

    var all_previous_date = $(".all_previous_date");

    for(var k = 0; k < all_previous_date.length; k++)
    {
      if($(all_previous_date[k]).val()==bootcamp_date)
      {
        duplicate_date=1;
      }
    }

    if(address=='' || bootcamp_date=='' || session_time=='')
    {
      alert('Please select address, trainer name, date and time');
    }
    else if(total_session==0)
    {
      alert("You don't have any bootcamp session");
    }
    else if(total_applicable_sessions>5)
    {
      alert("You sent maximum 5 session at a time");
    }
    else if(duplicate_date==1)
    {
      alert("You can't choose same date");
    }
    else
    {
      $("#add_session_req").append('<div class="col-md-4 col-sm-12 col-xs-12"><input readonly  class="form-control" type="text" name="bootcamp_address[]" value="' + address_text + '" /></div><div class="col-md-4 col-sm-12 col-xs-12"><input readonly  class="form-control" name="bootcamp_trainer[]" type="text" value="' + trainer_name + '" /></div><div class="col-md-2 col-sm-12 col-xs-12"><input readonly  class="form-control" name="bootcamp_date[]" type="text" value="' + bootcamp_date + '" /></div><div class="col-md-2 col-sm-12 col-xs-12"><input readonly  class="form-control" type="text" name="bootcamp_time[]" value="' + session_time_text + '" /></div><input type=hidden class="all_previous_date"  readonly name="all_previous_date[]"' + 'id="all_previous_date[]"' + 'value="' + bootcamp_date + '" /><input type="hidden" name="schedule_id[]"' + 'value="' + session_time + '" /></div><br>');
       $("#bootcamp_date").val('');$("#session_time").val('');

      $('#bootcamp_date').attr('disabled',true); $('#session_time').attr('disabled',true);

      $('#save_btn').show();

        total_session=parseInt(total_session)-1;
      $('#total_session').val(total_session);
      
        total_applicable_sessions=parseInt(total_applicable_sessions)+1;
      $('#total_applicable_sessions').val(total_applicable_sessions);
     
    }
  });
});
  
</script>

<script>
   $(document).ready(function() {
    $('body').on('click','#add_sess2',function(e) {
      e.preventDefault();

    var total_session=$("#total_session2").val();

    var total_applicable_sessions=$("#total_applicable_sessions2").val();

    var address_text=$("#address2 option:selected").text();
    var session_time_text=$("#session_time2 option:selected").text();
    var trainer_name=$("#trainer_id2 option:selected").text();
    var schedule_id=$("#trainer_id2").val();

    var address=$("#address2").val();
    var bootcamp_date=$("#pt_date2").val();
    var session_time=$("#session_time2").val();

    var duplicate_date=0;

    var all_previous_date = $(".all_previous_date2");

    for(var k = 0; k < all_previous_date.length; k++)
    {
      if($(all_previous_date[k]).val()==bootcamp_date)
      {
        duplicate_date=1;
      }
    }

    if(address=='' || bootcamp_date=='' || session_time=='')
    {
      alert('Please select address, trainer name, date and time');
    }
    else if(total_session==0)
    {
      alert("You don't have any bootcamp session");
    }
    else if(total_applicable_sessions>5)
    {
      alert("You sent maximum 5 session at a time");
    }
    else if(duplicate_date==1)
    {
      alert("You can't choose same date");
    }
    else
    {
      $("#add_session_req2").append('<div class="col-md-4 col-sm-12 col-xs-12"><input readonly  class="form-control" type="text" name="bootcamp_address[]" value="' + address_text + '" /></div><div class="col-md-4 col-sm-12 col-xs-12"><input readonly  class="form-control" name="bootcamp_trainer[]" type="text" value="' + trainer_name + '" /></div><div class="col-md-2 col-sm-12 col-xs-12"><input readonly  class="form-control" name="bootcamp_date[]" type="text" value="' + bootcamp_date + '" /></div><div class="col-md-2 col-sm-12 col-xs-12"><input readonly  class="form-control" type="text" name="bootcamp_time[]" value="' + session_time_text + '" /></div><input type=hidden class="all_previous_date2"  readonly name="all_previous_date[]"' + 'id="all_previous_date[]"' + 'value="' + bootcamp_date + '" /><input type="hidden" name="schedule_id[]"' + 'value="' + schedule_id + '" /><br>');
     $('#session_time2').find('option').remove();
     $('#trainer_id2').find('option').remove();
       $('#session_time2').attr('disabled',true);
        $('#trainer_id2').attr('disabled',true);
// $('#trainer_id2').prop('selectedIndex',0);
      $('#save_btn2').show();

        total_session=parseInt(total_session)-1;
      $('#total_session2').val(total_session);
      
        total_applicable_sessions=parseInt(total_applicable_sessions)+1;
      $('#total_applicable_sessions2').val(total_applicable_sessions);
      

      
      
    }
  });
  
});
  
</script>
 

</body>

</html>




