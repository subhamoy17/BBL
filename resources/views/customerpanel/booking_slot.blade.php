
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
  <link rel="stylesheet" href="{{url('frontend/css/jquery-ui.css')}}">
  <link href="{{url('frontend/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />
  <link href="{{url('frontend/css/responsive.css')}}" rel="stylesheet" type="text/css" media="all" />
  <!-- font-awesome-icons -->
  <link href=" {{url('frontend/css/font-awesome.css')}}" rel="stylesheet">
  <!-- //font-awesome-icons -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800" rel="stylesheet">
  <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
  <link href="//fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">

  

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
                            <div class="dropdown user-box">
                           
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Welcome {{Auth::user()->name}}
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="{{url('customer/mybooking')}}">My Dashboard</a></li>
                  <li><a href="{{url('customer/profile')}}/{{Auth::user()->id}}">My Profile</a></li>
                  <li><a href="{{ route('customerpanel.logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a></li>
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
                <a href="{{url('/')}}"><img src="{{asset('frontend/images/logo.png')}}">
                                <ul> 
                            </a>
              </div>
            </div>
                  
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
              <div id="main-nav" class="stellarnav">
                <ul>

                <li class="{{ Request::segment(2) === 'bbl' ? 'active' : null }}">
                        <a href="{{url('customer/bbl')}}">Home</a>
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

                      <li class="{{ Request::segment(2) === 'profile' ? 'active' : null }}">
                        <a href="{{url('customer/profile')}}/{{Auth::user()->id}}">My Profile</a>
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
 
  <div class="inner-padding">

    <div class="container">
      <div class="hstry-box">
        <!-- @if($total_remaining_session>0) -->
      <ul class="tabs">
        <li class="active bb" rel="tab5"><a href="#">Book By Trainer</a></li>
        <li class="bb" rel="tab6"><a href="#">Book By Time</a></li>
      </ul>
      <!-- @endif -->
      <div class="tab_container">
        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>

    <?php Session::forget('success'); ?>
  @endif
          <!-- #tab1 -->
          <h3 class="ed-p">Session Booking Form</h3>
          <h3 class="d_active tab_drawer_heading" rel="tab5">Tab 5</h3>
          <div id="tab5" class="tab_content">
            <div class="form-box">
                
                @if($total_remaining_session>0)
                
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">

                 
                    <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                              <input type="hidden" id="total_slots" class="form-control" value="{{Session::get('sum_slots')}}"  >
                              <label>Location<small>*</small></label>
                              <select class="form-control" >
                                <option value="Basingstoke">Basingstoke</option>
                                
                              </select>

                              

                            </div>
                        </div>

              
                  <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                            
                              <label>Trainer Name <small>*</small></label>
                              <select class="form-control" name="id" id='trainer_id' onchange="jsfunction()">
                                <option value=""> Please select a name</option>
                                 @foreach($data as $mydata)
                                <option value="{{$mydata->id}}"> {{$mydata->name}}</option>
                                @endforeach
                              </select>

                              

                            </div>
                        </div>

                          <div class="col-md-6 col-sm-12 col-xs-12">
                          <label>Date <small>*</small></label>
                          <input type="text" id="slots_datepicker" name="date" class="form-control date-control" onchange="jsfunction()" readonly="true">

                        

                        </div>
                        <!-- <div class="clearfix"></div> -->
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group" >
                              <label>Available Time <small>*</small></label>
                              <select class="form-control" name="time" id="slot_time">
                                
                              </select>
                            </div>
                            
                        </div>
                         
                              <div  class="col-md-6 col-sm-12 col-xs-12" id='loadingimg' style='display:none'  >
                                <div class="form-group" >
                              <img src="{{asset('backend/images/loader_session_time.gif')}}" style="width: 98px;margin-top: -2px;margin-left: -28px;"/>
                            </div>
                            </div>

                        <div id="old_session_data">
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input name="form_botcheck" class="form-control" value="" type="hidden">
                          <input type="hidden" id="session_no" name="session_no" value="1">
                          <button id="add_sess" class="btn btn-dark btn-theme-colored btn-flat">Add Session</button>
                        </div>

                </div>
             
            </div>
<div id="sesssion_table">
  <form action="{{route('customer.slotinsert')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="">

    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="idd" id="id" value="{{Auth::guard('customer')->user()->id}}">
    <div id="add_session_req" >

    </div>
            
      <button type="submit" name="submit" class="btn btn-dark btn-theme-colored btn-flat btn-drk2 save_button"  style="display:none;" id="save_btn" onclick="button_name_change()">Book Session (S)</button>
       </form>
    </div>

                </div>

                @endif

                @if($total_remaining_session<=0)

                <h3>You don't have any purchased session & to book a new session you have to purchase a new package, So do you want to purchase?</h3><br>
                <a href="{{url('customer/pricing')}}"class="btn btn-dark btn-theme-colored btn-flat">Yes</a>
                <a href="{{url('customer/purchase_history')}}"class="btn btn-dark btn-theme-colored btn-flat">No</a>

                @endif

              </div>
          </div>



          <div id="tab6" class="tab_content">
            <div class="form-box">


                
                @if($total_remaining_session>0)
                
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">

                 
                    <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                              <input type="hidden" id="total_slots2" class="form-control" value="{{Session::get('sum_slots')}}"  >
                              <label>Location<small>*</small></label>
                              <select class="form-control" >
                                <option value="Basingstoke">Basingstoke</option>
                                
                              </select>

                              

                            </div>
                        </div>              

                         <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group" >


                              <label>Booking Time <small>*</small></label>
                              <select class="form-control" name="slot_time2" id="slot_time2" onchange="jsfunction2()">
                                
                                <option value=""> Please select time</option>
                                 @foreach($data2 as $mydata)
                                <option value="{{$mydata->id}}"> 
                                  {{date('h A', strtotime($mydata->time))}}
                                </option>
                                @endforeach
                              </select>
                            </div>
                            
                        </div>

                          <div class="col-md-6 col-sm-12 col-xs-12">
                          <label>Date <small>*</small></label>
                          <input type="text" id="slots_datepicker2" name="date" class="form-control date-control" onchange="jsfunction2()" readonly="true">

                        

                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                            
                              <label>Available Trainer<small>*</small></label>
                              <select class="form-control" name="trainer_id2" id='trainer_id2'>
                               
                              </select>

                              

                            </div>
                        </div>
                        <!-- <div class="clearfix"></div> -->
                       
                         
                              <div  class="col-md-6 col-sm-12 col-xs-12" id='loadingimg2' style='display:none'  >
                                <div class="form-group" >
                              <img src="{{asset('backend/images/loader_session_time.gif')}}" style="width: 98px;margin-top: -2px;margin-left: -28px;"/>
                            </div>
                            </div>

                        <div id="old_session_data2">
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input name="form_botcheck" class="form-control" value="" type="hidden">
                          <input type="hidden" id="session_no2" name="session_no2" value="1">
                          <button id="add_sess2" class="btn btn-dark btn-theme-colored btn-flat">Add Session</button>
                        </div>

                        </div>
              </div>
            
<div id="sesssion_table">
  <form action="{{route('customer.slotinsert')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="">

    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="idd" id="id" value="{{Auth::guard('customer')->user()->id}}">
    <div id="add_session_req2" >

    </div>
            
      <button type="submit" name="submit" class="btn btn-dark btn-theme-colored btn-flat btn-drk2 save_button"  style="display:none;" id="save_btn2" onclick="button_name_change()">Book Session (S)</button>
       </form>
    </div>

                </div>

                @endif



                

              </div>
          </div>



              

                

      </div>
      </div>
      <!-- .tab_container -->
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
    <script src="{{url('frontend/js/accotab.js')}}"></script>

<script>
   
   function  jsfunction(){
    
    if($('#trainer_id').val()!='' && $('#slots_datepicker').val()!='')
    {
      $('#loadingimg').show();
      var slot_time = $('#slot_time');
                    slot_time.prop("disabled",false);
                    slot_time.empty();
                    slot_time.append(
                $('<option>', {value: ''}).text('Please select time'));
    $.ajax({
                  type: "GET",
                  url: "{{route('get_slot_time')}}",
                  data: {'trainer_id': $('#trainer_id').val(),'slot_date': $('#slots_datepicker').val()},
                  success: function (data){
                    $('#loadingimg').hide();
                    console.log(data);

                    var obj = $.parseJSON(data);
                    var convert_time=0;
                    var set_am=0;
                    var set_pm=0;

                    if(obj.length > 0){ 
                    for(var i = 0; i < obj.length; i++){

                      convert_time=obj[i]['time'].substring(0,obj[i]['time'].indexOf(':'));
                      
                      if(convert_time==12) { set_am_pm='12 PM';}
                      else if(convert_time==13) { set_am_pm='1 PM';}
                      else if(convert_time==14) { set_am_pm='2 PM';}
                      else if(convert_time==15) { set_am_pm='3 PM';}
                      else if(convert_time==16) { set_am_pm='4 PM';}
                      else if(convert_time==17) { set_am_pm='5 PM';}
                      else if(convert_time==18) { set_am_pm='6 PM';}
                      else if(convert_time==19) { set_am_pm='7 PM';}
                      else if(convert_time==20) { set_am_pm='8 PM';}
                      else if(convert_time==21) { set_am_pm='9 PM';}
                      else if(convert_time==22) { set_am_pm='10 PM';}
                      else if(convert_time==23) { set_am_pm='11 PM';}
                      else if(convert_time==24) { set_am_pm='12 AM';}
                      else { set_am_pm=convert_time  + ' AM';}
                      
                    slot_time.append(
                $('<option>', {value: obj[i]['id']}).text(set_am_pm));
                  }
                  }
                    
                  }
      });
  }

  else
  {
    $('#slot_time').attr('disabled','disabled');
    $("#slot_time").css("background","#3d3648");
  }
    
  }
  
  </script>
<script>
   
   function  jsfunction2(){
    
    if($('#slot_time2').val()!='' && $('#slots_datepicker2').val()!='')
    {


      // alert('gg');
      $('#loadingimg2').show();
      var slot_trainer = $('#trainer_id2');
                    slot_trainer.prop("disabled",false);
                    slot_trainer.empty();
                    slot_trainer.append(
                $('<option>', {value: ''}).text('Please select trainer'));
    $.ajax({
                  type: "GET",
                  url: "{{route('get_slot_trainer')}}",
                  data: {'slot_time': $('#slot_time2').val(),'slot_date': $('#slots_datepicker2').val()},
                  success: function (data){
                    $('#loadingimg2').hide();
                    //console.log(data);

                    var obj = $.parseJSON(data);
                    

                    if(obj.length > 0){ 
                    for(var i = 0; i < obj.length; i++){

                     slot_trainer.append(
                 $('<option>', {value: obj[i]['id']}).text(obj[i]['name']));
                   }
                 }
                  }
      });
  }

  else
  {
    $('#trainer_id2').attr('disabled','disabled');
    $("#trainer_id2").css("background","#3d3648");
  }
    
  }
  

  </script>

  <script>
   $('#add_sess').click(function()
    {

      
      duplicate_flag=0;
    

      i=$('#session_no').val();

      trainer_name=$("#trainer_id option:selected").text();
      slots_date=$("#slots_datepicker").val();
      slots_time=$("#slot_time option:selected").text();

      trainer_id=$("#trainer_id").val();

      slots_time_id=$("#slot_time").val();

      total_remaining_session=$("#total_slots").val();

      var all_data=trainer_id + '#' + slots_date + '#' + slots_time_id;

      var inputs = $(".duplicate");

    for(var k = 0; k < inputs.length; k++)
    {
      if($(inputs[k]).val()==all_data)
      {
        duplicate_flag=1;
      }
    }



      if(parseInt(i)>parseInt(total_remaining_session))
      {
        alert ("You don't have any session"); 
        return false;
      }

      else if(duplicate_flag==1)
      {
        alert ("You can't choose same time and date for a same trainer"); 

        return false;
      }

    else if ($( "#trainer_id" ).val().length==0 || $("#slots_datepicker").val().length==0 || $("#slot_time").val().length==0 )
    {
    alert ("Please choose trainer name, date and time"); 
      
      return false;
    }
    else{


      add_session_req.innerHTML = add_session_req.innerHTML +'<input type=text class="form-control"  readonly name="trainer_name[]"' + 'id="trainer_name[]"' + 'value="' + trainer_name + '"/>&nbsp;'


    add_session_req.innerHTML = add_session_req.innerHTML +'<input type=text class="form-control" readonly name="slots_date[]"' + 'id="slots_date[]"' + 'value="' + slots_date + '" />&nbsp;'

    add_session_req.innerHTML = add_session_req.innerHTML +'<input type=text class="form-control" readonly name="slots_time[]"' +'id="slots_time[]"' +'value="' + slots_time + '" />&nbsp;'

    add_session_req.innerHTML = add_session_req.innerHTML +'<input type=hidden class="form-control"  readonly name="trainer_id[]"' + 'id="trainer_id[]"' + 'value="' + trainer_id + '" />&nbsp;'

    add_session_req.innerHTML = add_session_req.innerHTML +'<input type=hidden class="form-control" readonly name="slots_time_id[]"' +'id="slots_time_id[]"' +'value="' + slots_time_id + '" />&nbsp;'

    add_session_req.innerHTML = add_session_req.innerHTML +'<input type=hidden  readonly name=total_slots '+ 'id=total_slots ' + 'value="' + i + '" />&nbsp;'
    
    add_session_req.innerHTML = add_session_req.innerHTML +'<br>'


    var duplicatvalue=trainer_id + '#' + slots_date + '#' + slots_time_id;


    old_session_data.innerHTML = old_session_data.innerHTML +'<input type=hidden class="duplicate"  readonly name="all_previous_data[]"' + 'id="all_previous_data[]"' + 'value="' + duplicatvalue + '" />&nbsp;'
        

    $('#save_btn').show();
    
    $("#trainer_id").val("");
    $("#slots_datepicker").val("");
    $("#slot_time").val("");
    
    i=1+parseInt(i);
    $("#session_no").val(i);

    
}

    });
  
</script>


  

<script>
   $('#add_sess2').click(function()
    {
// alert('dfd');
      
      duplicate_flag=0;
    

      i=$('#session_no2').val();

      trainer_name=$("#trainer_id2 option:selected").text();
      slots_date=$("#slots_datepicker2").val();
      slots_time=$("#slot_time2 option:selected").text();

      trainer_id=$("#trainer_id2").val();

      slots_time_id=$("#slot_time2").val();

      total_remaining_session=$("#total_slots2").val();

      var all_data=trainer_id + '#' + slots_date + '#' + slots_time_id;

      var inputs = $(".duplicate");

    for(var k = 0; k < inputs.length; k++)
    {
      if($(inputs[k]).val()==all_data)
      {
        duplicate_flag=1;
      }
    }



      if(parseInt(i)>parseInt(total_remaining_session))
      {
        alert ("You don't have any session"); 
        return false;
      }

      else if(duplicate_flag==1)
      {
        alert ("You can't choose same time and date for a same trainer"); 

        return false;
      }

    else if ($( "#trainer_id2" ).val().length==0 || $("#slots_datepicker2").val().length==0 || $("#slot_time2").val().length==0 )
    {
    alert ("Please choose trainer name, date and time"); 
      
      return false;
    }
    else{


      add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=text class="form-control"  readonly name="trainer_name[]"' + 'id="trainer_name[]"' + 'value="' + trainer_name + '"/>&nbsp;'


    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=text class="form-control" readonly name="slots_date[]"' + 'id="slots_date[]"' + 'value="' + slots_date + '" />&nbsp;'

    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=text class="form-control" readonly name="slots_time[]"' +'id="slots_time[]"' +'value="' + slots_time + '" />&nbsp;'

    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=hidden class="form-control"  readonly name="trainer_id[]"' + 'id="trainer_id[]"' + 'value="' + trainer_id + '" />&nbsp;'

    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=hidden class="form-control" readonly name="slots_time_id[]"' +'id="slots_time_id[]"' +'value="' + slots_time_id + '" />&nbsp;'

    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=hidden  readonly name=total_slots '+ 'id=total_slots ' + 'value="' + i + '" />&nbsp;'
    
    add_session_req2.innerHTML = add_session_req2.innerHTML +'<br>'


    var duplicatvalue=trainer_id + '#' + slots_date + '#' + slots_time_id;


    old_session_data2.innerHTML = old_session_data2.innerHTML +'<input type=hidden class="duplicate"  readonly name="all_previous_data[]"' + 'id="all_previous_data[]"' + 'value="' + duplicatvalue + '" />&nbsp;'
        

    $('#save_btn2').show();
    
    $("#trainer_id2").val("");
    $("#slots_datepicker2").val("");
    $("#slot_time2").val("");
    
    i=1+parseInt(i);
    $("#session_no2").val(i);

    
}


  
    });
  
</script>


<script type="text/javascript">
  
  function button_name_change() // no ';' here
{
    $('.save_button').text('Please wait...');
}
</script>

<script>
  $(document).ready(function(){
  $('#slot_time').mouseover(function() {
    if($('#trainer_id').val()=='' || $('#slots_datepicker').val()=='')
    {
      return jsfunction();
    } 
   
  });

  });

</script>

<script>
  $(document).ready(function(){
  $('#trainer_id2').mouseover(function() {
    if($('#slot_time2').val()=='' || $('#slots_datepicker2').val()=='')
    {
      return jsfunction2();
    } 
   
  });

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

  <script>

  $(function () {
    $( ".date-control").datepicker({
  dateFormat: "yy-mm-dd",
  beforeShowDay: NotBeforeToday
});
  } );

  function NotBeforeToday(date)
{
    var now = new Date();//this gets the current date and time
    if (date.getFullYear() == now.getFullYear() && date.getMonth() == now.getMonth() && date.getDate() > now.getDate())
        return [true];
    if (date.getFullYear() >= now.getFullYear() && date.getMonth() > now.getMonth())
       return [true];
     if (date.getFullYear() > now.getFullYear())
       return [true];
    return [false];
}


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

<!-- For slot trainer -->

  


  <!--Fontawesome script-->
  <!--<script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>-->
</body>

</html>




