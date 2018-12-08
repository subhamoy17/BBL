<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

@if(Auth::user()->master_trainer==1)

<script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
    $('.alert-success').hide();
    }, 5000);

  setTimeout(function(){ 
    $('.alert-danger').hide();
    }, 5000);
  });
</script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <div class="breadcrumbs">
    <div class="col-sm-4">
      <div class="page-header float-left">
        <div class="page-title">
          <h1>Edit Bootcamp Plan</h1>
        </div>
      </div>
    </div>    
  </div>

   @if (session('address_change'))
              <div class="alert alert-danger">
                {{ session('address_change') }}
              </div>
            @endif
            @if (session('enddate_decrement'))
              <div class="alert alert-danger">
                {{ session('enddate_decrement') }}
              </div>
            @endif
<div class="col-lg-12">
	<div class="card">
		<div class="card-body card-block">
			<div class="add_bootcamp_div col-lg-12">
				<form  action="{{route('bootcamp_plan_edit_insert')}}" class="slct-margin" id="edit_bootcamp_session" enctype="multipart/form-data" method="post" autocomplete="off">
					{{ csrf_field() }}
					 <input type="hidden" name="id" id="id" value="{{$edit_bootcamp->bootcamp_plan_id}}">
				<div class="row cxz">
          <div class="col-lg-3">
            <label>Choose Day of a week <span class="required_field_color">*</span></label>
          </div>
					<div class="col-lg-1">
						<label>Monday 
							@if($edit_bootcamp->mon_session_flg==1)
              <input type="checkbox" id="mon_session_flg" class="day_flg" name="mon_session_flg" checked="checked" disabled="disabled">
							<input type="hidden" id="mon_session_flg" class="day_flg" name="mon_session_flg" checked="checked">
							@else
							<input type="checkbox" id="mon_session_flg" class="day_flg" name="mon_session_flg"  disabled="disabled">
							@endif
						</label>
					</div>
					<div class="col-lg-1">
						<label>Tuesday 
							@if($edit_bootcamp->tue_session_flg==1)
              <input type="checkbox" id="tue_session_flg" class="day_flg" name="tue_session_flg" checked="checked"  disabled="disabled">
							<input type="hidden" id="tue_session_flg" class="day_flg" name="tue_session_flg" checked="checked">
							@else
							<input type="checkbox" id="tue_session_flg" class="day_flg" name="tue_session_flg"  disabled="disabled">
							@endif
						</label>
					</div>
					<div class="col-lg-1">
						<label>Wednesday 
							@if($edit_bootcamp->wed_session_flg==1)
              <input type="checkbox" id="wed_session_flg" class="day_flg" name="wed_session_flg" checked="checked"  disabled="disabled">
							<input type="hidden" id="wed_session_flg" class="day_flg" name="wed_session_flg" checked="checked">
							@else
							<input type="checkbox" id="wed_session_flg" class="day_flg" name="wed_session_flg" disabled="disabled">
							@endif
						</label>
					</div>
					<div class="col-lg-1">
						<label>Thursday 
							@if($edit_bootcamp->thu_session_flg==1)
              <input type="checkbox" id="thu_session_flg" class="day_flg" name="thu_session_flg" checked="checked" disabled="disabled" >
							<input type="hidden" id="thu_session_flg" class="day_flg" name="thu_session_flg" checked="checked">
								@else
							<input type="checkbox" id="thu_session_flg" class="day_flg" name="thu_session_flg" disabled="disabled" >
							@endif
						</label>
					</div>
					<div class="col-lg-1">
						<label>Friday 
							@if($edit_bootcamp->fri_session_flg==1)
              <input type="checkbox" id="fri_session_flg" class="day_flg" name="fri_session_flg" checked="checked" disabled="disabled" >
							<input type="hidden" id="fri_session_flg" class="day_flg" name="fri_session_flg" checked="checked">
							@else
							<input type="checkbox" id="fri_session_flg" class="day_flg" name="fri_session_flg" disabled="disabled" >
							@endif
						</label>
					</div>
					<div class="col-lg-1">
						<label>Saturday 
							@if($edit_bootcamp->sat_session_flg==1)
              <input type="checkbox" id="sat_session_flg" class="day_flg" name="sat_session_flg" checked="checked" disabled="disabled">
							<input type="hidden" id="sat_session_flg" class="day_flg" name="sat_session_flg" checked="checked">
							@else
							<input type="checkbox" id="sat_session_flg" class="day_flg" name="sat_session_flg" disabled="disabled" >
							@endif
						</label>
					</div>
					<div class="col-lg-1">
						<label>Sunday
							@if($edit_bootcamp->sun_session_flg==1) 
              <input type="checkbox" id="sun_session_flg" class="day_flg" name="sun_session_flg" checked="checked" disabled="disabled">
							<input type="hidden" id="sun_session_flg" class="day_flg" name="sun_session_flg" checked="checked">
							@else
							<input type="checkbox" id="sun_session_flg" class="day_flg" name="sun_session_flg" disabled="disabled" >
							@endif
						</label>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-lg-3">
						<label>Session Start Time <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-3">
						<input type="text" id="session_st_time" name="session_st_time" class="form-control" value="{{date('h:i A', strtotime($edit_bootcamp->session_st_time))}}" disabled="disabled">

            <input type="hidden" id="session_st_time" name="session_st_time" class="form-control" value="{{date('h:i A', strtotime($edit_bootcamp->session_st_time))}}">
					</div>
					<div class="col-lg-3">
						<label>Session End Time <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-3">
            <input type="text" id="session_end_time" name="session_end_time" class="form-control" value="{{date('h:i A', strtotime($edit_bootcamp->session_end_time))}}" disabled="disabled">
						<input type="hidden" id="session_end_time" name="session_end_time" class="form-control" value="{{date('h:i A', strtotime($edit_bootcamp->session_end_time))}}">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-lg-3">
						<label>Plan Start Date <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-3">
            <input type="text" class="form-control" readonly="true" value="{{$edit_bootcamp->plan_st_date}}"  disabled="disabled">
						<input type="hidden" id="plan_st_date" name="plan_st_date" class="form-control" readonly="true" value="{{$edit_bootcamp->plan_st_date}}">
					</div>
					<div class="col-lg-3">
						<label>Plan End Date </label>
					</div>
					<div class="col-lg-3">
						@if($edit_bootcamp->never_expire==0)
							<?php $plan_end_date=$edit_bootcamp->plan_end_date;?>
						@else
							<?php $plan_end_date='';?>
						@endif
						<input type="text" id="plan_end_date" name="plan_end_date" class="form-control" readonly="true" value="{{$plan_end_date}}">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						
					</div>
					<div class="col-lg-3">
						
					</div>
					<div class="col-lg-3">
						<label>Plan Never End</label>
					</div>
					<div class="col-lg-3">
						@if($edit_bootcamp->never_expire==1)
						<input type="checkbox" name="never_expire" id="never_expire" checked="checked" >
						@else
						<input type="checkbox" name="never_expire" id="never_expire" >
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						<label>Maximum Allowed Booking <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-3">
            <input type="text" id="max_allowed" name="max_allowed" class="form-control"  onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="{{$edit_bootcamp->max_allowed}}"  disabled="disabled">
						<input type="hidden" id="max_allowed" name="max_allowed" class="form-control"  onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="{{$edit_bootcamp->max_allowed}}">
					</div>
					<div class="col-lg-3">
						<label>Address </label>
					</div>
					<div class="col-lg-3">
						<select name="address_select" id="address_select" class="ui search form-control"
          onchange="if(this.options[this.selectedIndex].value=='customOption'){
              toggleField1(this,this.nextSibling);
              this.selectedIndex='0';
          }">
            <option></option>
            <option value="customOption">Click to type a custom address</option>
            @if(!empty($form_address))
              @foreach($form_address as $each_form_address)
               @if($each_form_address->address_line1==$edit_bootcamp->address_line1)
                <option value="{{$edit_bootcamp->address_id}}" selected="selected">{{$edit_bootcamp->address_line1}}</option>
                @else
                <option value="{{$each_form_address->id}}">{{$each_form_address->address_line1}}</option>
                @endif
              @endforeach
            @endif
        </select><input name="address" style="display:none;" disabled="disabled" 
            onblur="if(this.value==''){toggleField1(this,this.previousSibling);}" class="ui search form-control" placeholder="Address" id="address">  
						
					</div>
					<input type="hidden" id="street_number" name="street_number" placeholder="Street number">
					<input type="hidden" id="route" name="route" placeholder="Route">
					<input type="hidden" id="locality" name="city" placeholder="City">
					<input type="hidden" id="administrative_area_level_1" name="state" placeholder="State">
					<input type="hidden" id="postal_code" name="postal_code" placeholder="Postal code">
					<input type="hidden" id="country" name="country" placeholder="Country">
					<input type="hidden" id="lat" name="lat" placeholder="Latitude">
					<input type="hidden" id="lng" name="lng" placeholder="Longitude">
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
						<div class="col-lg-10"></div>
							<div class="col-lg-2">
								<button name="bootcamp_session_submit" id="bootcamp_session_submit" class="btn btn-primary pull-right" style="width: 100px;">Update</button>
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
<script src="{{asset('backend/assets/js/moment.min.js')}}"></script>
<script src="{{asset('backend/assets/js/daterangepicker.min.js')}}"></script>
 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDDK5MydVx-HkNyQcPTBdDyIyrqbwVPST0&&libraries=places&callback=initAutocomplete" async defer></script>

<script>
  $(function () { 
  $("#session_st_time").daterangepicker({
    "singleDatePicker": true, 
    "showDropdowns": true, 
    "timePicker": true,  
    "autoApply": true,
    locale: { format: "hh:mm A" } }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
            
        });

  $("#session_st_time").on('change',function()
  {
    var session_end_time=moment($('#session_st_time').val(), ["hh:mm A"]).add(1, 'hour').format("hh:mm A");
    $("#session_end_time").val(session_end_time);
  });

  $("#session_end_time").daterangepicker({  
  "singleDatePicker": true, 
  "showDropdowns": true, 
  "timePicker": true,  
  "autoApply": true, 
  locale: { format: "hh:mm A" } }).on('show.daterangepicker', function (ev, picker) {
          picker.container.find(".calendar-table").hide();
          $("#session_st_time").val($("#session_end_time").val());
      });
 });
</script>

<script>
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

		                                                     
    $("#edit_bootcamp_session").validate({
        submitHandler: function(form) {

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

            if($('#address').val()==''  && $('#address_select').val()=='')
            {
            	alertify.alert('Address is required');
            	$('#location').focus();
              return false;
            }

           form.submit();
        }
    }); 

   
  });
</script>

<script>

  $(function () {
 
	$( "#plan_end_date" ).datepicker({
		dateFormat: "yy-mm-dd",
		beforeShowDay: NotBeforeToday,
	});

	var plan_st_date= $('#plan_st_date').val();
	var nextDay = new Date(plan_st_date);
	nextDay.setDate(nextDay.getDate() + 6);
	$("#plan_end_date").datepicker("option","minDate", nextDay);
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
      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      initAutocomplete();

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('address')),
            {types: ['geocode'], componentRestrictions: {country: 'uk'}});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        if(place.geometry.location)
      {
      	
        $("#lat").val(place.geometry.location.lat());
        $("#lng").val(place.geometry.location.lng());
      }

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }

      });
    </script>



@endif
@endsection

