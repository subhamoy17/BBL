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

$.validator.addMethod("greaterThanZero", function(value, element) {
    return this.optional(element) || (parseFloat(value) != '');
}, "Amount must be greater than zero");
   
   

$('#submit_product').validate({  
/// rules of error 
rules: {

  "training_type":
  {
    greaterThanZero: true,
  },


  "payment_type": {
 greaterThanZero: true,


},

"price": {
 required: true,
number: true,
range: [1, 99999.99]
},
"no_session": {
required: true,
number: true,
range: [1, 99999.99]

},
"validity": {
greaterThanZero: true,

},
"validity_2": {
greaterThanZero: true,

},
"contant": {
greaterThanZero: true,

},

"notice_period": {
greaterThanZero: true,

},

"notice_period_2": {
greaterThanZero: true,

}

},

messages: {

  "training_type":
  {
    greaterThanZero: "Please select training name"
  },

  "payment_type":
  {
    greaterThanZero: "Please select payment name"
  },

  "price":{
 required: 'Please enter a price',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 99999.99"
},

"no_session":{
required: "Please enter a number of session",
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 99999.99"
},

"validity":{
 greaterThanZero: "Please select validity value",
 
},
"validity_2":{
 greaterThanZero: "Please select validity value",
 
},
"contant":{
 greaterThanZero: "Please select contant",
 
},
"notice_period":{
 greaterThanZero: "Please select notice period value",
 
},
"notice_period_2":{
 greaterThanZero: "Please select notice period value",
 
}

}
});


});

</script>


@if(Auth::user()->master_trainer==1)



  <div class="breadcrumbs">
    <div class="col-sm-4">
      <div class="page-header float-left">
        <div class="page-title">
          <h1>Add Product</h1>
        </div>
      </div>
    </div>    
  </div>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body card-block">
			

			<div class="add_bootcamp_div col-lg-12">
				<form  action="{{route('insert_bootcamp_plan')}}" class="slct-margin" id="submit_product" method="post" autocomplete="off">
					{{ csrf_field() }}
				
				<div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Training Type<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-8"><select name="training_type" id="training_type" class="form-control" placeholder="Training Type">
		            <option value="0">Select Any Training Type</option>
		            @if(!empty($all_traning_type))
		            	@foreach($all_traning_type as $each_traning_type)
            		<option value="{{$each_traning_type->id}}">{{$each_traning_type->training_name}}</option>
            	    @endforeach
			            @endif
			        </select>
                              <div id="err" class="err"></div>
                            </div>
                            
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Payment Type<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-8">
                	<select name="payment_type" id="payment_type" class="form-control" onchange="valueUnlimitep()">
		            <option value="0">Select Any Payment Type</option>
		            @if(!empty($all_payment_type))
		            	@foreach($all_payment_type as $each_payment_type)
            		<option value="{{$each_payment_type->id}}">{{$each_payment_type->payment_type_name}}</option>
            	    @endforeach
			            @endif
			        </select>
                              <div id="err1" class="err1"></div>
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> No. of Available Session<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-6"><input type="text" id="no_session" name="no_session" placeholder="No. of Available Session" class="form-control" >
                              
                            </div>
                            <div class="col-12 col-md-2"><input type="checkbox" name="unlimited" id="unlimited" class="unlimited" onchange="valueUnlimited()">&nbsp; &nbsp;<label for="text-input" class="form-control-label">Unlimited</label>
                              
                            </div>
                            <!-- <div class="col col-md-1"><label for="text-input" class=" form-control-label">Unlimited</label></div> -->
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Price<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-6"><input type="text" id="price" name="price" placeholder="Price" class="form-control" >
                              
                            </div>
                            <div class="col-12 col-md-2 ses" id="session"><label for="text-input" class=" form-control-label">/Session</label>
                              
                            </div>
                            <div class="col-12 col-md-2 mon" id="month" style="display: none;"><label for="text-input" class=" form-control-label">/Month</label>
                              
                            </div>
                          </div>

                          <div class="row form-group" id="total_p">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Total Price<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-8"><input type="text" id="total_price" name="total_price" placeholder="Name" class="form-control" >
                              
                            </div>
                          </div>

				<div class="row form-group">
					<div class="col-lg-4">
						<label>Validity<span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-4">
						<select name="validity" id="validity" class="form-control">
		            <option value="0">Select Any One</option>
		            
            		<option value="1">1</option>
            	    <option value="2">2</option>
            	    <option value="3">3</option>
            	    <option value="4">4</option>
            	    <option value="5">5</option>
            	    <option value="6">6</option>
            	    <option value="7">7</option>
            	    <option value="8">8</option>
            	    <option value="9">9</option>
            	    <option value="10">10</option>
            	    <option value="11">11</option>
            	    <option value="12">12</option>
			        </select>
					</div>
					
					<div class="col-lg-4">
							<select name="validity_2" id="validity_2" class="form-control">
		            <option value="0">Select Any One</option>
		            
            		<option value="7">Week</option>
            	    <option value="30">Month</option>
            	    
			        </select>
					</div>
				</div>
				 <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Contract<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-8">
                            	<select name="contant" id="contant" class="form-control">
		            <option value="0">Select Any One</option>
		            
            		<option value="30">Monthly</option>
            	    <option value="365">Annually</option>
            	    <option value="n/a">N/A</option>
			        </select>
                              
                            </div>
                          </div>
                          <div></div>

                          	<div class="row form-group">
					<div class="col-lg-4">
						<label>Notice Period<span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-4">
						<select name="notice_period" id="notice_period" class="form-control">
		            <option value="0">Select Any One</option>
		            
            		<option value="1">1</option>
            	    <option value="2">2</option>
            	    <option value="3">3</option>
            	    <option value="4">4</option>
            	    <option value="5">5</option>
            	    <option value="6">6</option>
            	    <option value="7">7</option>
            	    <option value="8">8</option>
            	    <option value="9">9</option>
            	    <option value="10">10</option>
            	    <option value="11">11</option>
            	    <option value="12">12</option>
			        </select>
					</div>
					
					<div class="col-lg-4">
						<select name="notice_period_2" id="notice_period_2" class="form-control">
		            <option value="0">Select Any One</option>
		            
            		<option value="7">Week</option>
            	    <option value="30">Month</option>
            	    
			        </select>
					</div>
				</div>
				
				<div class="row form-group">
                            <div class="col col-md-1"><label for="text-input" class=" form-control-label">Monday</label></div>
                            <div class="col col-md-3"><input type="checkbox" name="monday" id="monday"  class="monday" onchange="valueChanged()"></div>
                            <div class="col col-md-8 monday_show_time" style="display: none">
                            <div class="col col-md-6">
                           <select name="st_time" id="st_time" class="form-control">
		            <option>Chose Start Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select></div>
                            	<div class="col col-md-6">
                            <select name="end_time" id="end_time" class="form-control">
		            <option>Chose End Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select>
                              
                            </div>
                        </div>
                            </div>
                          <div class="row form-group">
                            <div class="col col-md-1"><label for="text-input" class="form-control-label">Tuesday</label></div>
                            <div class="col-12 col-md-3"><input type="checkbox" name="tuesday" id="tuesday" class="tuesday" onchange="valueChanged1()"></div>
                               <div class="col col-md-8 tuesday_show_time" style="display: none">
                              <div class="col col-md-6">
                           <select name="training_type" id="training_type" class="form-control">
		            <option>Chose Start Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select></div>
                            	<div class="col col-md-6">
                            <select name="training_type" id="training_type" class="form-control">
		            <option>Chose End Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select>
                              
                            </div>
                        </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-1"><label for="text-input" class="form-control-label">Wednesday</label></div>
                            <div class="col-12 col-md-3"><input type="checkbox" name="wednesday" id="wednesday" class="wednesday" onchange="valueChanged2()"></div>
                                <div class="col col-md-8 wednesday_show_time" style="display: none">
                             <div class="col col-md-6">
                           <select name="training_type" id="training_type" class="form-control">
		            <option>Chose Start Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select></div>
                            	<div class="col col-md-6">
                            <select name="training_type" id="training_type" class="form-control">
		            <option>Chose End Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select>
                              
                            </div>
                        </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-1"><label for="text-input" class="form-control-label">Thursday</label></div>
                            <div class="col-12 col-md-3"><input type="checkbox" name="thursday" id="thursday" class="thursday" onchange="valueChanged3()"></div>
                              <div class="col col-md-8 thursday_show_time" style="display: none">
                             <div class="col col-md-6">
                           <select name="training_type" id="training_type" class="form-control">
		            <option>Chose Start Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select></div>
                            	<div class="col col-md-6">
                            <select name="training_type" id="training_type" class="form-control">
		            <option>Chose End Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select>
                              
                            </div>
                        </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-1"><label for="text-input" class="form-control-label">Friday</label></div>
                            <div class="col-12 col-md-3"><input type="checkbox" name="friday" id="friday" class="friday" onchange="valueChanged4()"></div>
                            <div class="col col-md-8 friday_show_time" style="display: none">
                              <div class="col col-md-6">
                           <select name="training_type" id="training_type" class="form-control">
		            <option>Chose Start Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select></div>
                            	<div class="col col-md-6">
                            <select name="training_type" id="training_type" class="form-control">
		            <option>Chose End Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select>
                              
                            </div>
                        </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-1"><label for="text-input" class="form-control-label">Saturday</label></div>
                            <div class="col-12 col-md-3"><input type="checkbox" name="saturday" id="saturday" class="saturday" onchange="valueChanged5()"></div>
                            <div class="col col-md-8 saturday_show_time" style="display: none">
                             <div class="col col-md-6">
                           <select name="training_type" id="training_type" class="form-control">
		            <option>Chose Start Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select></div>
                            	<div class="col col-md-6">
                            <select name="training_type" id="training_type" class="form-control">
		            <option>Chose End Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select>
                              
                            </div>
                        </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-1"><label for="text-input" class="form-control-label">Sunday</label></div>
                            <div class="col col-md-3"><input type="checkbox" name="sunday" id="sunday" class="sunday" onchange="valueChanged6()"></div>
                               <div class="col col-md-8 sunday_show_time" style="display: none">
                              <div class="col col-md-6">
                           <select name="training_type" id="training_type" class="form-control">
		            <option>Chose Start Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select></div>
                            	<div class="col col-md-6">
                            <select name="training_type" id="training_type" class="form-control">
		            <option>Chose End Time</option>
		            
		            	@foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			           
			        </select>
                              
                            </div>
                        </div>
                        </div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
						<div class="col-lg-10"></div>
							<div class="col-lg-2">
								<button name="bootcamp_session_submit" id="bootcamp_session_submit" class="btn btn-primary pull-right" style="width: 100px;">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
<script src="{{asset('backend/assets/js/semantic.js')}}"></script>
<script src="{{asset('backend/assets/js/timepicki.js')}}"></script>
<script src="{{asset('backend/assets/js/moment.min.js')}}"></script>
<script>
	$('#search-address,#search-day,#search-start-time,#search-end-time,#search-start-date,#search-end-date').dropdown();
</script>
 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDDK5MydVx-HkNyQcPTBdDyIyrqbwVPST0&&libraries=places"></script>

<script>
function toggleField(hideObj,showObj){
  hideObj.disabled=true;        
  hideObj.style.display='none';
  showObj.disabled=false;   
  showObj.style.display='block';
  showObj.focus();
}

function toggleField1(hideObj,showObj){
  hideObj.disabled=true;        
  hideObj.style.display='none';
  showObj.disabled=false;   
  showObj.style.display='block';
  showObj.focus();
}
</script>

<script>		                                                     
function valueChanged()
{
	
    if($('.monday').is(":checked"))   
        $(".monday_show_time").show();
    
    else
        $(".monday_show_time").hide();
   
}
  function valueChanged1()
{
	
    if($('.tuesday').is(":checked"))   
        $(".tuesday_show_time").show();
    else
        $(".tuesday_show_time").hide();
}
function valueChanged2()
{
	
    if($('.wednesday').is(":checked"))   
        $(".wednesday_show_time").show();
    else
        $(".wednesday_show_time").hide();
}
function valueChanged3()
{
	
    if($('.thursday').is(":checked"))   
        $(".thursday_show_time").show();
    else
        $(".thursday_show_time").hide();
}
function valueChanged4()
{
	
    if($('.friday').is(":checked"))   
        $(".friday_show_time").show();
    else
        $(".friday_show_time").hide();
}
function valueChanged5()
{
	
    if($('.saturday').is(":checked"))   
        $(".saturday_show_time").show();
    else
        $(".saturday_show_time").hide();
}
function valueChanged6()
{
	
    if($('.sunday').is(":checked"))   
        $(".sunday_show_time").show();
    else
        $(".sunday_show_time").hide();
}
function valueUnlimited()
{
	
    if($('.unlimited').is(":checked"))  {


        $(".mon").show();
    	$(".ses").hide();
		}

    else {
    	 $(".mon").hide();
    	 $(".ses").show();
   		 }
        
}
</script>


<!-- <script>

  $(function () {
    $( "#plan_st_date" ).datepicker({
  		dateFormat: "yy-mm-dd",
  		beforeShowDay: NotBeforeToday,
  		onSelect: function(dateText, inst){
     $("#plan_end_date").datepicker("option","minDate",
     $("#plan_st_date").datepicker("getDate"));
  }
		});

		$( "#plan_end_date" ).datepicker({
  		dateFormat: "yy-mm-dd",
  		beforeShowDay: NotBeforeToday,
  		onSelect: function(dateText, inst){
     $("#plan_st_date").datepicker("option","maxDate",
     $("#plan_end_date").datepicker("getDate"));
  }
		});
  } );

  function NotBeforeToday(date)
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
</script> -->

<script>
  $(document).ready(function(){
  	$('#session_st_time').timepicki();
    $("#session_end_time").timepicki();
  });
</script>




@endif
@endsection

