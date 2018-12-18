<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

@if(Auth::user()->master_trainer==1)
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


  <div class="breadcrumbs">
    <div class="col-sm-4">
      <div class="page-header float-left">
        <div class="page-title">
          <h1>Bootcamp Plan Schedule Edit</h1>
        </div>
      </div>
    </div>    
  </div>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body card-block">
			<div class="add_bootcamp_div col-lg-12">
				<form  action="{{route('update_bootcamp_plan_schedules')}}" class="slct-margin" id="submit_bootcamp_session" method="post" autocomplete="off">
					{{ csrf_field() }}
				 <input type="hidden" name="schedule_id" value="{{$all_schedules->schedule_id}}">
				<div class="row form-group">
					<div class="col-lg-3">
						<label>Session Start Time <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-3">
						<input type="text" id="session_st_time" name="session_st_time" class="form-control" readonly value="{{$all_schedules->plan_st_time}}">
					</div>
					<div class="col-lg-3">
						<label>Session End Time <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-3">
						<input type="text" id="session_end_time" name="session_end_time" class="form-control" value="{{$all_schedules->plan_end_time}}" readonly>
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
<script src="{{asset('backend/assets/js/moment.min.js')}}"></script>
<script src="{{asset('backend/assets/js/daterangepicker.min.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDDK5MydVx-HkNyQcPTBdDyIyrqbwVPST0&&libraries=places&callback=initAutocomplete" async defer></script>


<script>
$(function () { 
	$("#session_st_time").daterangepicker({
		"singleDatePicker": true, 
		"showDropdowns": true, 
		"timePicker": true,  
		"autoApply": false,
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
	"autoApply": false,
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
  $(function () {
    $( "#plan_st_date" ).datepicker({
  		dateFormat: "yy-mm-dd",
  		beforeShowDay: NotBeforeToday,
  		onSelect: function(selectedDate){
  			var nextDay = new Date(selectedDate);
				nextDay.setDate(nextDay.getDate() + 6);
				$("#plan_end_date").datepicker("option","minDate", nextDay);
  		}
		});

		$( "#plan_end_date" ).datepicker({
  		dateFormat: "yy-mm-dd",
  		beforeShowDay: NotBeforeToday
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

