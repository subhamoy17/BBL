<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')



<script>

  $(document).ready(function(){



    $.validator.addMethod("alpha", function(value, element){
      return this.optional(element) || value == value.match(/^[a-zA-Z, '']+$/);
    }, "Alphabetic characters only please");

// mobile number can contant only numeric
$.validator.addMethod('numericO nly', function (value) {
  return /^[0-9]+$/.test(value);
}, 'Please enter only numeric values');

$.validator.addMethod('blood', function (value) {
  return /^[0-9]*[/]?[0-9]*$/.test(value);
}, 'Please enter only numeric values');

$.validator.addMethod("alphanumeric", function(value, element) {
  return this.optional(element) || /^[\w.]+$/i.test(value);
}, "Letters, numbers, and underscores only please");


$.validator.addMethod("dollarsscents", function(value, element) {
  return this.optional(element) || /^\d{0,5}(\.\d{0,3})?$/i.test(value);
}, "Please enter value betwwen 1 to 999990.99");


$('#couponaddform').validate({  
/// rules of error 
rules: {

  "slots_name":
  {
    required: true,
  },

  "coupon_code": {
 required: true,


},

"discount_price": {
 required: true,
number: true,
range: [1, 99999.99]
},
"valid_from": {
required: true,

},
"daterange": {
required: true,

}




},

messages: {

  "slots_name":
  {
    required: "Please enter slot name"
  },

  "coupon_code":
  {
    required: "Please enter coupon code"
  },

  "discount_price":{
 required: 'Please enter the discount price',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 99999.99"
},

"valid_from":{
required: "Please select a date"
},

"daterange":{
 required: "Please select a date",
 
}



}
});


});

</script>

<script>

  $(function () {
    $( "#valid_from" ).datepicker({
  dateFormat: "yy-mm-dd",
  beforeShowDay: NotAfterToday1
});
  } );

  function NotAfterToday1(date)
{
    var now = new Date();//this gets the current date and time
    if (date.getFullYear() == now.getFullYear() && date.getMonth() == now.getMonth() && date.getDate() >= now.getDate())
        return [true];
    if (date.getFullYear() >= now.getFullYear() && date.getMonth() > now.getMonth())
       return [true];
     if (date.getFullYear() > now.getFullYear())
       return [true];
    return [false];
}


  </script>

  <script>

  $(function () {
    $( "#valid_to" ).datepicker({
  dateFormat: "yy-mm-dd",
  beforeShowDay: NotAfterToday2
});
  } );

  function NotAfterToday2(date)
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

    <div class="card-header" style="padding-left: 0px;padding-right: 0px;padding-bottom: 0px;padding-top: 10px;">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('delete'))
                            <div class="alert alert-danger">
                                {{ session('delete') }}
                            </div>
                        @endif
                    </div>

@if(Auth::user()->master_trainer==1)
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Add Discount Coupon</h1>
                    </div>
                </div>
            </div>    
</div>
        <div class="col-lg-12">
        <div class="card">
                      <div class="card-body card-block">
                        <form action="{{route('coupon_insert')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="couponaddform" data-parsley-validate>

                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Package Name<span class="required_field_color">*</span></label></div>
                         
                            <div class="col-12 col-md-9"><input type="text" id="slots_name" name="slots_name" placeholder="Enter Package Name" class="form-control slots_name required" onkeyup=" return jsnull()">
                               <input type="hidden" id="apply_slots" name="apply_slots">
                            </div>
                          </div>

                          <div   id="slot_details" style="display: none;">
                            <div class="row form-group" id="s_d">
          <div class="col col-md-3">
            <label for="text-input" class=" form-control-label">Package Details</label>
          </div>
          
           
           <label class="sl3">Session Number : </label> <div class="sl2" id="slots_number" name="slots_number"></div><span>,</span>
             <lable class="sl">Package Price : <i class="fa fa-gbp"></i> </lable></span><div class="sl2" id="slots_price" name="slots_price"></div><span>,</span>
              
              <label class="sl"> Package Validity : </label><div class="sl2" id="slots_validity" name="slots_validity"></div>
                
      </div>
 <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Discount Coupon Code<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="coupon_code" name="coupon_code" placeholder="Coupon Code" class="form-control" >
                              <div id="duplicate_coupon" class="coupon-error2"></div>
                            </div>
                          </div>
                           <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Discount Coupon Price (<i class="fa fa-gbp"></i>)<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="discount_price" name="discount_price" placeholder="Discount Price" class="form-control" >
                              <div id="lessthan_slot" class="coupon-error2"></div>
                            </div>
                          </div>

                           <!-- <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Valid From<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="valid_from" name="valid_from" placeholder="Valid From" class="form-control" value="">
                            </div>
                          </div> -->


                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Discount Coupon Validity<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input class="drange form-control" type="text" name="daterange" id="daterange" value="" placeholder="Select Date" readonly/>
                            </div>
                          </div>


                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Discount Coupon Status<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9">
                              <input type="radio"  id="is_active_yes" name="is_active" value="1" checked="checked">Active &nbsp;
                              <input type="radio"  id="is_active_no" name="is_active" value="0">Inactive
                            </div>
                          </div> 
      
                         <div class="row form-group">
                          <div class="col col-md-10">
                          </div>
                            <div class="col col-md-2" >
                                <button  type="submit" id="cupon_sub" name="submit" class="btn btn-primary cupon_sub" style="width: 65%; float: right;">
                                   Submit
                                </button>
                            </div>
                          </div>
                       

                        </form>


    </div>
                                      
                           
                      </div>
                    </div>
                    <!-- </div> -->


@endif
<script src="{{asset('backend/assets/js/moment.min.js')}}"></script>
<script src="{{asset('backend/assets/js/daterangepicker.min.js')}}"></script>


  <script>
  $(document).ready(function(){
var dis=false;
var cup=false;
$("#duplicate_coupon").hide();
$("#lessthan_slot").hide();
$('#couponaddform').bind('submit', function (e) {
    var button = $('#cupon_sub');

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

   $('#coupon_code').keyup(function(){

var dis=jscoupon();
console.log(dis);
   });

   $('#discount_price').keyup(function(){

var cup=jscountprice();
console.log(cup);
   });
   function  jscoupon(){
    
  if($('#coupon_code').val()!='') 
    { 

      $.post("{{route('duplicatecoupon')}}",$('#couponaddform').serialize(), function(data){
            if(data==1)
            { 
              
             
              $("#duplicate_coupon").show();
               // $("#lessthan_slot").hide();
              $("#duplicate_coupon").html("Duplicate coupon code is not allow");
               // $('.btn-primary').attr('disabled','disabled');
               dis=false;
        
            }

            else
            { 
              $("#duplicate_coupon").hide();
              // $("#lessthan_slot").hide();
               // $('.btn-primary').removeAttr('disabled');
             dis=true;
            }
check();

  });
      }      

 
  }


   function  jscountprice(){
    
  if($('#discount_price').val()!='') 
    { 

      $.post("{{route('checkdiscount_price')}}",$('#couponaddform').serialize(), function(data){
            if(data==2)
            { 
              
              $("#lessthan_slot").show();
              // $("#duplicate_coupon").hide();
              $("#lessthan_slot").html("Discount price always lessthan of package price");
              // $('.btn-primary').attr('disabled','disabled');
               cup=false;
            }

            
            else
            { 
              $("#lessthan_slot").hide();
              // $("#duplicate_coupon").hide();
               // $('.btn-primary').removeAttr('disabled');
             cup=true;
              
            }
check();

  });
      }      

 
  }

  check();
function check(){
  console.log('Dis'+dis);
  console.log('Cup'+cup);
    if(dis && cup){
      console.log('asd');
      // button.prop('disabled', true);
     // $('.btn-primary').attr('disabled','disabled');
     $('.btn-primary').removeAttr('disabled');

    }
    else{
      console.log('azxc');
      $('.btn-primary').attr('disabled','disabled');
       
    }
  }

 });
  
  </script>
  <script>
 
     function  jsnull(){

    if($('#slots_name').val()=='') 
    { 
      $('#apply_slots').val('');
       $("#slot_details").hide();
       $('#slots_number').val('');
       $('#slots_price').val('');
       $('#slots_validity').val('');
       $('#coupon_code').val('');
       $('#discount_price').val('');     
       $("#lessthan_slot").hide();
       $("#duplicate_coupon").hide();
    }
   }
  
  </script>





<script>
$(function() {
  var start, end;
  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
     minDate:moment().startOf('hour'),
       // end : moment().subtract(29, 'days'),
    locale: {
            format: 'YYYY-MM-DD'
            
        }
  }, 

  function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });




});
</script>


<script src="{{url('js/parsley.js')}}"></script>
<script src="{{url('js/parsley.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection