<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

@if(Auth::user()->master_trainer==1)

  <div class="breadcrumbs">
    <div class="col-sm-4">
      <div class="page-header float-left">
        <div class="page-title">
          <h1>Edit Bootcamp Plan</h1>
        </div>
      </div>
    </div>    
  </div>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body card-block">
			<div class="add_bootcamp_div col-lg-12">
				<form  action="{{route('bootcamp_plan_edit_insert')}}" class="slct-margin" id="edit_bootcamp_session" enctype="multipart/form-data" method="post" autocomplete="off">
					{{ csrf_field() }}
					 <input type="hidden" name="id" id="id" value="{{$edit_bootcamp->bootcamp_plan_id}}">
				<div class="row cxz">
					<div class="col-lg-2">
						<label>Monday 
							@if($edit_bootcamp->mon_session_flg==1)
							<input type="checkbox" id="mon_session_flg" class="day_flg" name="mon_session_flg" checked="checked" >
							@else
							<input type="checkbox" id="mon_session_flg" class="day_flg" name="mon_session_flg" >
							@endif
						</label>
					</div>
					<div class="col-lg-2">
						<label>Tuesday 
							@if($edit_bootcamp->tue_session_flg==1)
							<input type="checkbox" id="tue_session_flg" class="day_flg" name="tue_session_flg" checked="checked" >
							@else
							<input type="checkbox" id="tue_session_flg" class="day_flg" name="tue_session_flg" >
							@endif
						</label>
					</div>
					<div class="col-lg-2">
						<label>Wednesday 
							@if($edit_bootcamp->wed_session_flg==1)
							<input type="checkbox" id="wed_session_flg" class="day_flg" name="wed_session_flg" checked="checked" >
							@else
							<input type="checkbox" id="wed_session_flg" class="day_flg" name="wed_session_flg">
							@endif
						</label>
					</div>
					<div class="col-lg-2">
						<label>Thursday 
							@if($edit_bootcamp->thu_session_flg==1)
							<input type="checkbox" id="thu_session_flg" class="day_flg" name="thu_session_flg" checked="checked" >
								@else
							<input type="checkbox" id="thu_session_flg" class="day_flg" name="thu_session_flg" >
							@endif
						</label>
					</div>
					<div class="col-lg-2">
						<label>Friday 
							@if($edit_bootcamp->fri_session_flg==1)
							<input type="checkbox" id="fri_session_flg" class="day_flg" name="fri_session_flg" checked="checked" >
							@else
							<input type="checkbox" id="fri_session_flg" class="day_flg" name="fri_session_flg" >
							@endif
						</label>
					</div>
					<div class="col-lg-1">
						<label>Saturday 
							@if($edit_bootcamp->sat_session_flg==1)
							<input type="checkbox" id="sat_session_flg" class="day_flg" name="sat_session_flg" checked="checked">
							@else
							<input type="checkbox" id="sat_session_flg" class="day_flg" name="sat_session_flg" >
							@endif
						</label>
					</div>
					<div class="col-lg-1">
						<label>Sunday
							@if($edit_bootcamp->sun_session_flg==1) 
							<input type="checkbox" id="sun_session_flg" class="day_flg" name="sun_session_flg" checked="checked">
							@else
							<input type="checkbox" id="sun_session_flg" class="day_flg" name="sun_session_flg" >
							@endif
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-2">
						<label>Session Start<br> Time <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-4">
						<input type="text" id="session_st_time" name="session_st_time" class="form-control" value="{{date('h:i A', strtotime($edit_bootcamp->session_st_time))}}">
					</div>
					<div class="col-lg-2">
						<label>Session End Time <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-4">
						<input type="text" id="session_end_time" name="session_end_time" class="form-control" value="{{date('h:i A', strtotime($edit_bootcamp->session_end_time))}}">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-2">
						<label>Planned Start<br> Date <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-4">
						<input type="text" id="plan_st_date" name="plan_st_date" class="form-control" readonly="true" value="{{$edit_bootcamp->plan_st_date}}">
					</div>
					<div class="col-lg-2">
						<label>Planned End Date </label>
					</div>
					<div class="col-lg-4">
						@if($edit_bootcamp->never_expire==0)
							<?php $plan_end_date=$edit_bootcamp->plan_end_date;?>
						@else
							<?php $plan_end_date='';?>
						@endif
						<input type="text" id="plan_end_date" name="plan_end_date" class="form-control" readonly="true" value="{{$plan_end_date}}">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-2">
						
					</div>
					<div class="col-lg-4">
						
					</div>
					<div class="col-lg-2">
						<label>Planned Never Ending</label>
					</div>
					<div class="col-lg-4">
						@if($edit_bootcamp->never_expire==1)
						<input type="checkbox" name="never_expire" id="never_expire" checked="checked" >
						@else
						<input type="checkbox" name="never_expire" id="never_expire" >
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-lg-2">
						<label>Maximum Allowed Booking <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-4">
						<input type="text" id="max_allowed" name="max_allowed" class="form-control"  onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="{{$edit_bootcamp->max_allowed}}">
					</div>
					<div class="col-lg-2">
						<label>Location </label>
					</div>
					<div class="col-lg-4">
						<select name="location_select" id="location_select" class="form-control"
          onchange="if(this.options[this.selectedIndex].value=='customOption'){
              toggleField(this,this.nextSibling);
              this.selectedIndex='0';
          }">
          	<option></option>
            <option value="customOption">Click to type a custom location</option>
            @if(!empty($form_location))
            	@foreach($form_location as $each_form_location)
            	 @if($each_form_location->address_line1==$edit_bootcamp->address_line1)
            		<option value="{{$edit_bootcamp->address_id}}" selected="selected">{{$edit_bootcamp->address_line1}}</option>
            		@else
            		<option value="{{$each_form_location->address_id}}">{{$each_form_location->address_line1}}</option>
            		@endif
            	@endforeach
           	@endif
        </select>

 

        <input name="location" style="display:none;" disabled="disabled" 
            onblur="if(this.value==''){toggleField(this,this.previousSibling);}" class="form-control" placeholder="Location" id="location">
						
					</div>
				</div>
				<div class="row">
					<div class="col-lg-2">
						
					</div>
					<div class="col-lg-4">
					
					</div>
					<div class="col-lg-2">
						<label>Address </label>
					</div>
					<div class="col-lg-4">
						<select name="address_select" id="address_select" class="ui search form-control"
          onchange="if(this.options[this.selectedIndex].value=='customOption'){
              toggleField1(this,this.nextSibling);
              this.selectedIndex='0';
          }">
          	<option></option>
            <option value="customOption">Click to type a custom address</option>
            @if(!empty($form_address))
            	<!-- @foreach($form_address as $each_form_address)
            		<option value="{{$each_form_address->address_id}}">{{$each_form_address->address_line2}}</option>
            	@endforeach -->
            	@foreach($form_address as $each_form_location)
            	 @if($each_form_location->address_line2==$edit_bootcamp->address_line2)
            		<option value="{{$edit_bootcamp->address_id}}" selected="selected">{{$edit_bootcamp->address_line2}}</option>
            		@else
            		<option value="{{$each_form_location->address_id}}">{{$each_form_location->address_line2}}</option>
            		@endif
            	@endforeach
            @endif
        </select><input name="address" style="display:none;" disabled="disabled" 
            onblur="if(this.value==''){toggleField1(this,this.previousSibling);}" class="ui search form-control" placeholder="Address" id="address">						
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
						<div class="col-lg-10"></div>
							<div class="col-lg-2">
								<button name="bootcamp_session_submit" id="bootcamp_session_submit" class="btn btn-primary pull-right" style="width: 100px;">Edit</button>
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
  $(document).ready(function(){
  	$('#session_st_time').timepicki();
    $("#session_end_time").timepicki();
  });
</script>

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
	$(document).ready(function() {

		                                                     
    $("#submit_bootcamp_session").validate({
        submitHandler: function(form) {
            // see if selectone is even being used
            var boxes = $('.day_flg:checkbox');
            if(boxes.length > 0) {
                if( $('.day_flg:checkbox:checked').length < 1) {
                    alertify.alert('Please select at least one boot camp plan day');
                    boxes[0].focus();
                    return false;
                }
            }
            if($('#session_st_time').val()=='')
            {
            	alertify.alert('Session start time is required');
            	// $('#session_st_time').focus();
              return false;
            }
						if($('#session_end_time').val()=='')
            {
            	alertify.alert('Session end time is required');
            	// $('#session_end_time').focus();
              return false;
            }

            var startTime = moment($('#session_st_time').val(), ["h:mm A"]).format("HH:mm");

    				var endTime = moment($('#session_end_time').val(), ["h:mm A"]).format("HH:mm");

            if(startTime>=endTime)
            {
            	alertify.alert('Session end time is always upper than session start time');
            	$('#session_end_time').focus();
              return false;
            }

            if($('#plan_st_date').val()=='')
            {
            	alertify.alert('Plan start date is required');
            	$('#plan_st_date').focus();
              return false;
            }

            if($('#plan_end_date').val()!='' && $('#plan_st_date').val()>=$('#plan_end_date').val())
            {
            	alertify.alert('Plan end date always upper than plan start date');
            	$('#plan_end_date').focus();
              return false;
            }

						if($('#plan_end_date').val()=='' && !$('#never_expire').is(':checked'))
            {
            	alertify.alert('Plan end date or never ending is required');
            	$('#plan_end_date').focus();
              return false;
            }

            if($('#plan_end_date').val()!='' && $('#never_expire').is(':checked'))
            {
            	alertify.alert('Either plan end date or never ending is required');
            	$('#plan_end_date').focus();
              return false;
            }

            if($('#max_allowed').val()=='')
            {
            	alertify.alert('Maximum Allowed Booking');
            	$('#max_allowed').focus();
              return false;
            }

            if($('#location').val()=='' && $('#address').val()=='' && $('#location_select').val()=='' && $('#address_select').val()=='')
            {
            	alertify.alert('Location or address is required');
            	$('#location').focus();
              return false;
            }

            if(($('#location').val()!='' || $('#location_select').val()!='') && ($('#address').val()!=''  || $('#address_select').val()!=''))
            {
            	alertify.alert('Either location or address is required');
            	$('#location').focus();
              return false;
            }

           form.submit();
        }
    }); 

   
  });
</script>

<!-- <script>
	$(document).ready(function(){ 
		$('#add_new_session').on('click', function (e) {
			e.preventDefault();
			$('.add_bootcamp_div').show();
		});
	});
</script>
 -->

<script>

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
</script>

<script>
$(document).ready(function() {
  var autocomplete;
    initAutocomplete();
  function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical location types.
    autocomplete = new google.maps.places.Autocomplete( (document.getElementById('address')),
    {types: ['geocode'], componentRestrictions: {country: 'uk'}});
    autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();


      if(place.geometry.location)
      {
      	console.log(place.geometry.location);
        // $("#lat").val(place.geometry.location.lat());
        // $("#lng").val(place.geometry.location.lng());
      }
    });
  }
  // $("#address").on('submit',function(e){
  //   if($('#autolocation').val() && !$('#lat').val() && !$('#lng').val())
  //   {
  //     alert("Please enter a valid location");
  //     return false;
  //   }
  // });

  // $('#search_form input').on('keypress', function(e)
  // {
  //   return e.which !== 13;
   });

</script>



@endif
@endsection

