<!-- title and some link of admin panel are here -->

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="{{ app()->getLocale() }}"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.trainerpaneltitle') }}</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" href="{{ asset('backend/apple-icon.png')}}">
    <link rel="shortcut icon" href="{{ asset('backend/favicon.ico')}}">
     <script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>

     <script src="{{asset('backend/assets/js/jquery.js')}}"></script>
<script src="{{asset('backend/assets/js/jquery-ui.min.js')}}"></script>
     <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="{{asset('backend/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/additional-methods.js')}}"></script>

<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/cs-skin-elastic.css') }}">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="{{ asset('backend/assets/scss/style.css')}}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

   

    <link rel="stylesheet" href="{{ asset('backend/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/assets/css/totancss/style.css') }}"></script>
    <link rel="stylesheet" href="{{url('frontend/css/jquery-ui.css')}}">


@if(Request::segment(2) == 'add_session')

<script>

  $(function () {
    $( "#slots_datepicker" ).datepicker({
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
                  url: "{{route('slot_time')}}",
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
    $(document).ready(function() {

    $('#search_cus').on('click',function(e) {


        $('#cus_search').validate({  
/// rules of error 
rules: {

  "cust_email":
  {
    required: true,
    email: true
  }

 

},

messages: {

  "cust_email":
  {
    required: "Please enter customer email",
    email: "invalid email"
  }
 
}
});
  
    
      var user_email=$("#cust_email").val();

 $.ajax({
          url: "{{route('add_customer')}}",
          type: "GET",
         
        data: {
  
            user_email:user_email,
  
            },
          success: function (data)
          {
            if(data==1){

                $("add_ses").show();
            }
            else if(data==2){

                $("no_session").show();
            }
       
          }
        });


     
    });


//    $('#save_btn').click(function()
//     {

      
//       duplicate_flag=0;
    

//       i=$('#session_no').val();
//       customer_name=$("#idd option:selected").text();

//       trainer_name=$("#trainer_id option:selected").text();
//       slots_date=$("#slots_datepicker").val();
//       alert(slots_date);
//       slots_time=$("#slot_time option:selected").text();
//         customer_id=$("#idd").val();
        
//       trainer_id=$("#trainer_id").val();
  

//       slots_time_id=$("#slot_time").val();
//  alert(slots_time_id);
//       total_remaining_session=$("#total_slots").val();

//       var all_data=trainer_id + '#' + slots_date + '#' + slots_time_id;

//       var inputs = $(".duplicate");

//     for(var k = 0; k < inputs.length; k++)
//     {
//       if($(inputs[k]).val()==all_data)
//       {
//         duplicate_flag=1;
//       }
//     }



//       if(parseInt(i)>parseInt(total_remaining_session))
//       {
//         alert ("You don't have any session"); 
//         return false;
//       }

//       else if(duplicate_flag==1)
//       {
//         alert ("You can't choose same time and date for a same trainer"); 

//         return false;
//       }

//     else if ($( "#trainer_id" ).val().length==0 || $("#slots_datepicker").val().length==0 || $("#slot_time").val().length==0 )
//     {
//     alert ("Please choose trainer name, date and time"); 
      
//       return false;
//     }
//     else{


//       add_session_req.innerHTML = add_session_req.innerHTML +'<input type=text class="form-control"  readonly name="trainer_name[]"' + 'id="trainer_name[]"' + 'value="' + trainer_name + '"/>&nbsp;'


//     add_session_req.innerHTML = add_session_req.innerHTML +'<input type=text class="form-control" readonly name="slots_date[]"' + 'id="slots_date[]"' + 'value="' + slots_date + '" />&nbsp;'

//     add_session_req.innerHTML = add_session_req.innerHTML +'<input type=text class="form-control" readonly name="slots_time[]"' +'id="slots_time[]"' +'value="' + slots_time + '" />&nbsp;'

//     add_session_req.innerHTML = add_session_req.innerHTML +'<input type=hidden class="form-control"  readonly name="trainer_id[]"' + 'id="trainer_id[]"' + 'value="' + trainer_id + '" />&nbsp;'

//     add_session_req.innerHTML = add_session_req.innerHTML +'<input type=hidden class="form-control" readonly name="slots_time_id[]"' +'id="slots_time_id[]"' +'value="' + slots_time_id + '" />&nbsp;'

//     add_session_req.innerHTML = add_session_req.innerHTML +'<input type=hidden  readonly name=total_slots '+ 'id=total_slots ' + 'value="' + i + '" />&nbsp;'
    
//     add_session_req.innerHTML = add_session_req.innerHTML +'<br>'


//     var duplicatvalue=trainer_id + '#' + slots_date + '#' + slots_time_id;


//     old_session_data.innerHTML = old_session_data.innerHTML +'<input type=hidden class="duplicate"  readonly name="all_previous_data[]"' + 'id="all_previous_data[]"' + 'value="' + duplicatvalue + '" />&nbsp;'
        

    
    
//     $("#trainer_id").val("");
//     $("#slots_datepicker").val("");
//     $("#slot_time").val("");
    
//     i=1+parseInt(i);
//     $("#session_no").val(i);

    
// }

//  });
  
    });
  
</script>

@endif


</head>