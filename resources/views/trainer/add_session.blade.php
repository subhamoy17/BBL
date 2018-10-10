<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<script type="text/javascript">

  $(document).ready(function(){
    $('#add_slot').validate({  
/// rules of error 
rules: {

  "apply2":
  {
    required: true,
     // email:true
  },

  "trainer_id":
  {
    required: true,
  },

  "slots_datepicker":
  {
    required: true,
  },
  "slot_time":
  {
    required: true,
  } 

},

messages: {

  "apply2":
  {
    required: "Please select a customer name",
     // email: "Please enter valid email id"
  },

  "trainer_id":
  {
    required: "Please select a trainer name"
  },
  "slots_datepicker":
  {
    required: "Please select a date"
  },
  "slot_time":
  {
    required: "Please select a time"
  }



}
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

@if(Auth::user()->master_trainer==1)


  <div class="breadcrumbs">
    <div class="col-sm-4">
      <div class="page-header float-left">
        <div class="page-title">
          <h1>Add Customer's Session Request</h1>
        </div>
      </div>
    </div>    
  </div>



  <div class="breadcrumbs">
    <div class="col-sm-12">
      <div class="page-header float-left">
        <div class="page-title ttl-wrp">
          <label>Customer Info</label>
    <input type="text" id="apply2" name="apply2" placeholder="Customer info" class="form-control apply2 required" >
        </div>
      </div>
    </div>    
  </div>
  <div class="breadcrumbs">
<div class="col-lg-12 ct-d">
 <div class="col-md-12 col-sm-12 col-xs-12">
<div class=""  id="mail" style="display: none;">
        <label>Customer Details</label>
          <div class="">
              <div  id="cus_det"></div>
              
          </div>
        </div>
      </div>
	  </div>
	  </div>
    <div class="inner-padding"  id="right"  style="display: none;">
    <div class="container">
      <div class="hstry-box">
        <!-- @if($total_remaining_session>0) -->
      <ul class="tabs">
        <li class="active bb" rel="tab5" id="t5"><a href="#"  data-toggle="tab" class="li1">Book By Trainer</a></li>
        <li class="bb" rel="tab6" id="t6"><a href="#"  data-toggle="tab" class="li2">Book By Time</a></li>
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



          
          <div id="tab5" class="tab_content">
            <div class="form-box">
                
                
                
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">

                 
                    <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                              <input type="hidden" id="total_slots" class="form-control">
                              <label>Location <small>*</small></label>
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
                                 @foreach($trainer_data as $mydata)
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
  <form class="form-horizontal" id="add_session_form1">

    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="customer_id" id="customer_id">

    <div id="add_session_req" >

    </div>
            
      
      <button type="button" name="submit" class="btn btn-dark btn-theme-colored btn-flat btn-drk2 save_button"  style="display:none;" id="save_btn" onclick="button_name_change()">Submit</button>
       </form>
    </div>

                </div>

              </div>
          </div>



          <div id="tab6" class="tab_content" style="display:none;">
            <div class="form-box">

                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">

                 
                    <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                              <input type="hidden" id="total_slots2" class="form-control"  >
                              <label>Location <small>*</small></label>
                              <select class="form-control" >
                                <option value="Basingstoke">Basingstoke</option>
                                
                              </select>

                              

                            </div>
                        </div>              


                         <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group" >
                              <label>Date <small>*</small></label>
                          <input type="text" id="slots_datepicker2" name="date" class="form-control date-control" onchange="jsfunction2(); gettime();" readonly="true">
                            </div>
                            
                        </div>


                        
                          <div class="col-md-6 col-sm-12 col-xs-12">
                          

                        

                              <label>Booking Time <small>*</small></label>
                              <select class="form-control" name="slot_time2" id="slot_time2" onchange="jsfunction2()">
                               
                                
                              </select>

                        </div>


                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              
                            
                              <label>Available Trainer <small>*</small></label>
                              <select class="form-control" name="trainer_id2" id='trainer_id2'>
                               
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
  <form  class="form-horizontal" id="add_session_form2">

    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="customer_id" id="customer_idd">
    <div id="add_session_req2" >

    </div>
            
      <button type="button" name="submit" class="btn btn-dark btn-theme-colored btn-flat btn-drk2 save_button"  style="display:none;" id="save_btn2" onclick="button_name_change()">Submit</button>
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
  <div class="breadcrumbs">
<div class="inner-padding" id="wrong" style="display: none;">
   This customer's have not any available session.
</div>
</div>
@endif


<script>
    $(document).ready(function(){  

$('a[data-toggle="tab"]').on('click', function (e) { 
  var tab_val=$(this).prop('class'); 
  if(tab_val=='li2')
  {
   $('#trainer_id').val('');
   $('#slots_datepicker').val('');
   $('#slot_time').val('');
   $('#session_no').val(1);
   
   add_session_req.innerHTML='';
   old_session_data.innerHTML='';
   

   $('#save_btn').hide();
  }
  else if(tab_val=='li1')
  {
    $('#trainer_id2').val('');
   $('#slots_datepicker2').val('');
   $('#slot_time2').val('');
   $('#session_no2').val(1);
   add_session_req2.innerHTML='';
   old_session_data2.innerHTML='';
   
   $('#save_btn2').hide();
  }
});

    });  
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
  $(document).ready(function(){
  $('#slot_time2').mouseover(function() {
    if($('#slots_datepicker2').val()=='')
    {
      return gettime();
    } 
   
  });

  });

</script>

<script>
   
   function  jsfunction(){
    
    if($('#trainer_id').val()!='' && $('#slots_datepicker').val()!='')
    {
    
    var get_current_time=0;
      var get_current_date_trainer=0;
      var same_trainer_date=$('#trainer_id').val() + '#' + $('#slots_datepicker').val();

      var all_previous_time = $(".all_previous_time");
      var all_previous_trainer_date = $(".all_previous_trainer_date");

      var all_time=new Array();

    for(var k = 0; k < all_previous_time.length; k++)
    {
      
      if($(all_previous_time[k]).val()!='' && $(all_previous_trainer_date[k]).val()==same_trainer_date)
      {
        get_current_time=1;
      }

      all_time[k]=$(all_previous_time[k]).val();

    }

    if(get_current_time==1)
    {

      $('#loadingimg').show();
      var slot_time = $('#slot_time');
                    slot_time.prop("disabled",false);
                    slot_time.empty();
                    slot_time.append(
                $('<option>', {value: ''}).text('Please select time'));
    $.ajax({
                  type: "GET",
                  url: "{{route('admin_get_current_slot_time')}}",
                  data: {'trainer_id': $('#trainer_id').val(),'slot_date': $('#slots_datepicker').val(),'time_id':all_time},
                  success: function (data){
                    $('#loadingimg').hide();
                    console.log(data);

                    var obj = $.parseJSON(data);
                    var convert_time=0;

                    if(obj.length > 0){ 
                    for(var i = 0; i < obj.length; i++){

                      convert_time=obj[i]['time'];
                     
                      
                    slot_time.append(
                $('<option>', {value: obj[i]['id']}).text(convert_time));
                  }
                  }
                    
                  }
      });

  }else{

    $('#loadingimg').show();
      var slot_time = $('#slot_time');
                    slot_time.prop("disabled",false);
                    slot_time.empty();
                    slot_time.append(
                $('<option>', {value: ''}).text('Please select time'));
    $.ajax({
                  type: "GET",
                  url: "{{route('admin_get_slot_time')}}",
                  data: {'trainer_id': $('#trainer_id').val(),'slot_date': $('#slots_datepicker').val(),'customer_id': $('#customer_id').val()},
                  success: function (data){
                    $('#loadingimg').hide();
                    console.log(data);

                    var obj = $.parseJSON(data);
                    var convert_time=0;

                    if(obj.length > 0){ 
                    for(var i = 0; i < obj.length; i++){

                      convert_time=obj[i]['time'];
                     
                      
                    slot_time.append(
                $('<option>', {value: obj[i]['id']}).text(convert_time));
                  }
                  }
                    
                  }
      });

  }
  }

  else
  {
    $('#slot_time').attr('disabled','disabled');
  }
    
  }
  
  </script>

  <script>
   
   function  jsfunction2(){
    
    if($('#slot_time2').val()!='' && $('#slots_datepicker2').val()!='')
    {

      $('#loadingimg2').show();
      var slot_trainer = $('#trainer_id2');
                    slot_trainer.prop("disabled",false);
                    slot_trainer.empty();
                    slot_trainer.append(
                $('<option>', {value: ''}).text('Please select trainer'));
    $.ajax({
                  type: "GET",
                  url: "{{route('admin_get_slot_trainer')}}",
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
  }
    
  }
  

  </script>



  <script>
   
   function  gettime(){
    
    if($('#slots_datepicker2').val()!='')
    {

      var get_current_time=0;
      var get_current_date_trainer=0;
      var same_trainer_date=$('#slots_datepicker2').val();

      var all_previous_time = $(".all_previous_time");
      var all_previous_trainer_date = $(".all_previous_trainer_date");

      var all_time=new Array();

    for(var k = 0; k < all_previous_time.length; k++)
    {
      
      if($(all_previous_time[k]).val()!='' && $(all_previous_trainer_date[k]).val()==same_trainer_date)
      {
        get_current_time=1;
      }

      all_time[k]=$(all_previous_time[k]).val();

    }

    if(get_current_time==1)
    {

      $('#loadingimg2').show();
      var slot_trainer = $('#slot_time2');
                    slot_trainer.prop("disabled",false);
                    slot_trainer.empty();
                    slot_trainer.append(
                $('<option>', {value: ''}).text('Please select time'));
    $.ajax({
                  type: "GET",
                  url: "{{route('admin_get_current_time')}}",
                  data: {'slot_date': $('#slots_datepicker2').val(),'time_id': all_time},
                  success: function (data){
                    $('#loadingimg2').hide();
                    //console.log(data);

                    var obj = $.parseJSON(data);
                    

                    if(obj.length > 0){ 
                    for(var i = 0; i < obj.length; i++){

                     slot_trainer.append(
                 $('<option>', {value: obj[i]['id']}).text(obj[i]['time']));
                   }
                 }
                  }
      });
  }
  else
  {
    $('#loadingimg2').show();
      var slot_trainer = $('#slot_time2');
                    slot_trainer.prop("disabled",false);
                    slot_trainer.empty();
                    slot_trainer.append(
                $('<option>', {value: ''}).text('Please select time'));
    $.ajax({
                  type: "GET",
                  url: "{{route('admin_get_time')}}",
                  data: {'slot_date': $('#slots_datepicker2').val()},
                  success: function (data){
                    $('#loadingimg2').hide();
                    //console.log(data);

                    var obj = $.parseJSON(data);
                    

                    if(obj.length > 0){ 
                    for(var i = 0; i < obj.length; i++){

                     slot_trainer.append(
                 $('<option>', {value: obj[i]['id']}).text(obj[i]['time']));
                   }
                 }
                  }
      });
  }
  }

  else
  {
    $('#slot_time2').attr('disabled','disabled');
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
        alertify.alert("This customer's have not any available session to add"); 
        return false;
      }

      else if(duplicate_flag==1)
      {
        alertify.alert("You can't choose same time and date for a same trainer"); 

        return false;
      }

    else if ($( "#trainer_id" ).val().length==0 || $("#slots_datepicker").val().length==0 || $("#slot_time").val().length==0 )
    {
    alertify.alert("Please choose trainer name, date and time"); 
      
      return false;
    }
    else{


      add_session_req.innerHTML = add_session_req.innerHTML +'<input type=text class="form-control blank1"  readonly name="trainer_name[]"' + 'id="trainer_name[]"' + 'value="' + trainer_name + '"/>&nbsp;'


    add_session_req.innerHTML = add_session_req.innerHTML +'<input type=text class="form-control blank1" readonly name="slots_date[]"' + 'id="slots_date[]"' + 'value="' + slots_date + '" />&nbsp;'

    add_session_req.innerHTML = add_session_req.innerHTML +'<input type=text class="form-control blank1" readonly name="slots_time[]"' +'id="slots_time[]"' +'value="' + slots_time + '" />&nbsp;'

    add_session_req.innerHTML = add_session_req.innerHTML +'<input type=hidden class="form-control blank1"  readonly name="trainer_id[]"' + 'id="trainer_id[]"' + 'value="' + trainer_id + '" />&nbsp;'

    add_session_req.innerHTML = add_session_req.innerHTML +'<input type=hidden class="form-control blank1" readonly name="slots_time_id[]"' +'id="slots_time_id[]"' +'value="' + slots_time_id + '" />&nbsp;'

    add_session_req.innerHTML = add_session_req.innerHTML +'<input type=hidden class="form-control blank1"  readonly name=total_slots '+ 'id=total_slots ' + 'value="' + i + '" />&nbsp;'
    
    add_session_req.innerHTML = add_session_req.innerHTML +'<br>'


    var duplicatvalue=trainer_id + '#' + slots_date + '#' + slots_time_id;

    var duplicattarinerdate=trainer_id + '#' + slots_date;

    old_session_data.innerHTML = old_session_data.innerHTML +'<input type=hidden class="duplicate blank1"  readonly name="all_previous_data[]"' + 'id="all_previous_data[]"' + 'value="' + duplicatvalue + '" />&nbsp;'


    old_session_data.innerHTML = old_session_data.innerHTML +'<input type=hidden class="all_previous_time"  readonly name="all_previous_time[]"' + 'id="all_previous_time[]"' + 'value="' + slots_time_id + '" />&nbsp;'

    old_session_data.innerHTML = old_session_data.innerHTML +'<input type=hidden class="all_previous_trainer_date"  readonly name="all_previous_trainer_date[]"' + 'id="all_previous_trainer_date[]"' + 'value="' + duplicattarinerdate + '" />&nbsp;'

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
      
      
      duplicate_flag=0;
    

      i=$('#session_no2').val();

      trainer_name=$("#trainer_id2 option:selected").text();
      slots_date=$("#slots_datepicker2").val();
      slots_time=$("#slot_time2 option:selected").text();

      trainer_id=$("#trainer_id2").val();

      slots_time_id=$("#slot_time2").val();

      total_remaining_session=$("#total_slots2").val();

      var all_data=trainer_id + '#' + slots_date + '#' + slots_time_id;

      var inputs = $(".duplicate2");

    for(var k = 0; k < inputs.length; k++)
    {
      if($(inputs[k]).val()==all_data)
      {
        duplicate_flag=1;
      }
    }



      if(parseInt(i)>parseInt(total_remaining_session))
      {
       alertify.alert("This customer's have not any available session to add"); 
        return false;
      }

      else if(duplicate_flag==1)
      {
        alertify.alert("You can't choose same time and date for a same trainer"); 

        return false;
      }

    else if ($("#slots_datepicker2").val().length==0 || $( "#trainer_id2" ).val().length==0 || $("#slot_time2").val().length==0 )
    {
    alertify.alert("Please choose trainer name, date and time"); 
      
      return false;
    }
    else{


    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=text class="form-control blank2"  readonly name="trainer_name[]"' + 'id="trainer_name[]"' + 'value="' + trainer_name + '"/>&nbsp;'


    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=text class="form-control blank2" readonly name="slots_date[]"' + 'id="slots_date[]"' + 'value="' + slots_date + '" />&nbsp;'

    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=text class="form-control blank2" readonly name="slots_time[]"' +'id="slots_time[]"' +'value="' + slots_time + '" />&nbsp;'

    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=hidden class="form-control blank2"  readonly name="trainer_id[]"' + 'id="trainer_id[]"' + 'value="' + trainer_id + '" />&nbsp;'

    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=hidden class="form-control blank2" readonly name="slots_time_id[]"' +'id="slots_time_id[]"' +'value="' + slots_time_id + '" />&nbsp;'

    add_session_req2.innerHTML = add_session_req2.innerHTML +'<input type=hidden class="form-control blank2"  readonly name=total_slots '+ 'id=total_slots ' + 'value="' + i + '" />&nbsp;'
    
    add_session_req2.innerHTML = add_session_req2.innerHTML +'<br>'


    var duplicatvalue=trainer_id + '#' + slots_date + '#' + slots_time_id;


    old_session_data2.innerHTML = old_session_data2.innerHTML +'<input type=hidden class="duplicate2 blank2"  readonly name="all_previous_data[]"' + 'id="all_previous_data[]"' + 'value="' + duplicatvalue + '" />&nbsp;'

    old_session_data2.innerHTML = old_session_data2.innerHTML +'<input type=hidden class="all_previous_time"  readonly name="all_previous_time[]"' + 'id="all_previous_time[]"' + 'value="' + slots_time_id + '" />&nbsp;'

    old_session_data2.innerHTML = old_session_data2.innerHTML +'<input type=hidden class="all_previous_trainer_date"  readonly name="all_previous_trainer_date[]"' + 'id="all_previous_trainer_date[]"' + 'value="' + slots_date + '" />&nbsp;'
        

    $('#save_btn2').show();
    
    $("#trainer_id2").val("");
    $("#slots_datepicker2").val("");
    $("#slot_time2").val("");
    
    i=1+parseInt(i);
    $("#session_no2").val(i);

    
}


  
    });
  
</script>


<script>
$(document).ready(function(){
var form=$("#add_session_form1");
$("#save_btn").click(function(){ 

$.ajax({
        type:"POST",
        url:"{{route('trainer_slotinsert')}}",
        data:form.serialize(),
        success: function(response){ 
            if(response.success==1 && response.session_remaining>0)
            {
             alertify.alert('All session booking request is sent successfully!');
              $('#trainer_id').val('');
              $('#slots_datepicker').val('');
              $('#slot_time').val('');
              $('#session_no').val(1);
   
              add_session_req.innerHTML='';
              old_session_data.innerHTML='';

              $('#save_btn').hide();
            }
            else
            {
              $('#trainer_id').val('');
              $('#slots_datepicker').val('');
              $('#slot_time').val('');
              $('#session_no').val(1);
   
              add_session_req.innerHTML='';
              old_session_data.innerHTML='';

              $('#save_btn').hide();
              $('#right').hide();
              $('#wrong').show();

            }
        }
    });

 
});
});
</script>

<script>
$(document).ready(function(){
var form=$("#add_session_form2");
$("#save_btn2").click(function(){ 
$.ajax({
        type:"POST",
        url:"{{route('trainer_slotinsert')}}",
        data:form.serialize(),
        success: function(response){
            if(response.success==1 && response.session_remaining>0)
            {
              alertify.alert('All session booking request is sent successfully!');
              
              $('#trainer_id2').val('');
              $('#slots_datepicker2').val('');
              $('#slot_time2').val('');
              $('#session_no2').val(1);
              add_session_req2.innerHTML='';
              old_session_data2.innerHTML='';
              $('#save_btn2').hide();
               $('#tab5').hide();
              $('#tab6').show();

            }
            else
            {
              $('#trainer_id2').val('');
              $('#slots_datepicker2').val('');
              $('#slot_time2').val('');
              $('#session_no2').val(1);
              add_session_req2.innerHTML='';
              old_session_data2.innerHTML='';
              $('#save_btn2').hide();
              $('#right').hide();
              $('#wrong').show();


            }
        }
    });
});
});
</script>



@endsection

