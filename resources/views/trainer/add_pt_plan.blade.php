<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')
<style>
.ptbtn-rmv{
    color: #fff;
    background-color: #db2828;
    border-color: #db2828;
  }
</style>

@if(Auth::user()->master_trainer==1)
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


  <div class="breadcrumbs">
    <div class="col-sm-4">
      <div class="page-header float-left">
        <div class="page-title">
          <h1>Add Personal Training Plan</h1>
        </div>
      </div>
    </div>    
  </div>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body card-block">
			<div class="add_bootcamp_div col-lg-12">
				<form  action="{{route('insert_pt_plan')}}" class="slct-margin" id="pt_plan_form" method="post" autocomplete="off">
					{{ csrf_field() }}
				<div class="row cxz">
          <div class="col-lg-3">
            <label>Choose Day of a week <span class="required_field_color">*</span></label>
          </div>
					<div class="col-lg-1">
						<label>Mon <input type="checkbox" id="mon_session_flg" class="day_flg" name="mon_session_flg"></label>
					</div>
					<div class="col-lg-1">
						<label>Tue <input type="checkbox" id="tue_session_flg" class="day_flg" name="tue_session_flg"></label>
					</div>
					<div class="col-lg-1">
						<label>Wed <input type="checkbox" id="wed_session_flg" class="day_flg" name="wed_session_flg"></label>
					</div>
					<div class="col-lg-1">
						<label>Thu <input type="checkbox" id="thu_session_flg" class="day_flg" name="thu_session_flg"></label>
					</div>
					<div class="col-lg-1">
						<label>Fri <input type="checkbox" id="fri_session_flg" class="day_flg" name="fri_session_flg"></label>
					</div>
					<div class="col-lg-1">
						<label>Sat <input type="checkbox" id="sat_session_flg" class="day_flg" name="sat_session_flg"></label>
					</div>
					<div class="col-lg-1">
						<label>Sun <input type="checkbox" id="sun_session_flg" class="day_flg" name="sun_session_flg"></label>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-lg-3">
						<label>Plan Start Date <span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-3">
						<input type="text" id="plan_st_date" name="plan_st_date" class="form-control" readonly="true">
					</div>
					<div class="col-lg-3">
						<label>Plan End Date </label>
					</div>
					<div class="col-lg-3">
            <input type="text" id="plan_end_date" name="plan_end_date" class="form-control" readonly="true">
						<input type="hidden" id="dynamic_plan_end_date" class="form-control" readonly="true">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						<label>Address <span class="required_field_color">*</span></label>
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
            		<option value="{{$each_form_address->id}}">{{$each_form_address->address_line1}}</option>
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
          <div class="col-lg-3">
            <label>Plan Never End</label>
          </div>
          <div class="col-lg-3">
            <input type="checkbox" name="never_expire" id="never_expire" onclick="never_expire_check();">
          </div>
				</div>
        <div class="row form-group">
          <div class="col-lg-3">
            Available Trainer <span class="required_field_color">*</span>
          </div>
          <div class="col-lg-3">
            @if(count($available_trainer)>0)
              <select id="trainer_id" class="form-control">
                <option value="-">Choose Trainer Name</option>
                @foreach($available_trainer as $all_trainer)
                <option value="{{$all_trainer->id}}">{{$all_trainer->name}}</option>
                @endforeach
              </select>
            @else
              <select id="trainer_id" class="form-control" disabled="disabled">
                <option value="-">No Trainer Are Available</option>
              </select>
            @endif
          </div>
          <div class="col-lg-2">
            @if(count($available_time)>0)
              <select id="st_time_id" class="form-control">
                <option value="-">Start Time</option>
                @foreach($available_time as $all_time)
                <option value="{{$all_time->id}}">{{date('h:i A', strtotime($all_time->time))}}</option>
                @endforeach
              </select>
            @else
              <select id="st_time_id" name="st_time_id" class="form-control" disabled="disabled">
                <option value="-">No Time Are Available</option>
              </select>
            @endif
          </div>
          <div class="col-lg-2">
            @if(count($available_time)>0)
              <select id="end_time_id" class="form-control">
                <option value="-">End Time</option>
                @foreach($available_time as $all_time)
                <option value="{{$all_time->id}}">{{date('h:i A', strtotime($all_time->time))}}</option>
                @endforeach
              </select>
            @else
              <select id="end_time_id" name="end_time_id" class="form-control" disabled="disabled">
                <option value="-">No Time Are Available</option>
              </select>
            @endif
          </div>
            <div class="col-lg-2" align="right">
              <button id="add_availability" class="btn btn-success btn-theme-colored btn-flat"><i class="fa fa-plus-square"></i></button>
            </div>                            
          </div>


          <div id="add_availability_div"></div>


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
  function never_expire_check()
  {
    if($('#never_expire').is(':checked'))
    {
      $('#plan_end_date').val('');
    }
    else
    {
      $('#plan_end_date').val($('#dynamic_plan_end_date').val());
    }
  }
</script>

<script>
  var duplicate_trainer_time_id = [];
   $(document).ready(function() {
    
    $('body').on('click','#add_availability',function(e) {
      e.preventDefault();
    var st_time_text=$("#st_time_id option:selected").text();
    var end_time_text=$("#end_time_id option:selected").text();
    var trainer_text=$("#trainer_id option:selected").text();

    var st_time_id=$("#st_time_id").val();
    var end_time_id=$("#end_time_id").val();
    var trainer_id=$("#trainer_id").val();

    var duplicate_time_id=0;
    var duplicate_flag=0;

    var choosable_data=trainer_id + '#' + st_time_id + '#' + end_time_id;
    var choosable_trainer_and_st_time=trainer_id + '#' + st_time_id;
    var choosable_trainer_and_end_time=trainer_id + '#' + end_time_id;

    var all_previous_data = $(".all_previous_data");

    for(var k = 0; k < all_previous_data.length; k++)
    {
      if($(all_previous_data[k]).val()==choosable_data)
      {
        duplicate_flag=1;
      }
    }

      for(var l = 0; l < duplicate_trainer_time_id.length; l++)
      {  
        if(duplicate_trainer_time_id[l]==choosable_trainer_and_st_time || duplicate_trainer_time_id[l]==choosable_trainer_and_end_time)
        {
          duplicate_time_id=1;
        }
      }

    if(trainer_id=='-' || st_time_id=='-' || end_time_id=='-')
    {
      alertify.alert('Please select trainer name, start time and end time');
      return false;
    }
    else if(end_time_id<=parseInt(st_time_id)+3)
    {
      alertify.alert("Start time and end time gap minimum 1 hour is required");
      return false;
    }
    else if(duplicate_flag==1)
    {
      alertify.alert("You can't choose same start time and end time for a same trainer");
      return false;
    }
    else if(duplicate_time_id==1)
    {
      alertify.alert("This time range is alredy used for this trainer");
      return false;
    }
    else
    {
       var m=parseInt(st_time_id);
      for(m;m<parseInt(end_time_id);m++)
      {
        duplicate_trainer_time_id.push(trainer_id + '#' + m);
      }

      $("#add_availability_div").append('<div class="row form-group" id = "removeid"><div class="col-lg-3"></div><div class="col-lg-3"><input readonly class="form-control" type="text" value="' + trainer_text + '" /></div>' + '<div class="col-lg-2"><input readonly class="form-control" type="text" value="' + st_time_text + '"/></div>' + '<div class="col-lg-2 sss"><input readonly class="form-control" type="text" value="' + end_time_text + '"/></div>' + '<input readonly type="hidden" name="trainer_id[]" value="' + trainer_id + '"/>'  + '<input readonly type="hidden" name="st_time_id[]" id="st_time_id_check" value="' + st_time_id + '"/>' + '<input readonly type="hidden" name="end_time_id[]" value="' + end_time_id + '"/>' + '<input readonly type="hidden" class="all_previous_data" name="all_previous_data[]" value="' + choosable_data + '"/>' + '<div class="col-lg-2" align="right"> <button id="btnRemove" class="btn btn-theme-colored ptbtn-rmv"><i class="fa fa-remove"></i></button></div></div>'); 
      $("#st_time_id").val('-'); $("#end_time_id").val('-'); $("#trainer_id").val('-');
    }
  });
  $('body').on('click','#btnRemove',function(e) { 
    e.preventDefault(); 
    
    var del_st_time=$(this).closest('div#removeid').find("input[name='st_time_id[]']").val();
    var del_end_time=$(this).closest('div#removeid').find("input[name='end_time_id[]']").val();
    var del_trainer_id=$(this).closest('div#removeid').find("input[name='trainer_id[]']").val();

    for(var m=parseInt(del_st_time);m<parseInt(del_end_time);m++)
      {
        var index = duplicate_trainer_time_id.indexOf(del_trainer_id + '#' + m);
        if (index > -1) {
            duplicate_trainer_time_id.splice(index, 1);
          }
      }
    $(this).closest('div#removeid').remove();
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

		                                                     
    $("#pt_plan_form").validate({
        submitHandler: function(form) {
            // see if selectone is even being used
            var boxes = $('.day_flg:checkbox');
            if(boxes.length > 0) {
                if( $('.day_flg:checkbox:checked').length < 1) {
                    alertify.alert('Please select at least one personal training plan day');
                    boxes[0].focus();
                    return false;
                }
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

            if($('#address').val()==''  && $('#address_select').val()=='')
            {
            	alertify.alert('Address is required');
            	$('#address').focus();
              return false;
            }

            if($('#removeid').length==0)
            {
              alertify.alert('Please add at least one available trainer name and time');
              return false;
            }
            

           form.submit();
        }
    }); 

   
  });
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
  		beforeShowDay: NotBeforeToday,
      onSelect: function(selectedDate){
        $('#dynamic_plan_end_date').val(selectedDate);
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

