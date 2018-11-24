<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<script>

  $(document).ready(function(){

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
range: [1, 99999]
},
"no_session": {
required: true,
digits: true,
maxlength: 50
},
"validity": {
greaterThanZero: true,

},
"validity_2": {
greaterThanZero: true,

},
"contract": {
greaterThanZero: true,

},

"notice_period": {
greaterThanZero: true,

},

"notice_period_2": {
greaterThanZero: 
                    function() {
                        //returns true if video & previous image is empty   

                        if($("#notice_period").val()!='NA'){
                          return true;
                        }else{
                          return false;
                        }
                    },

}

},

messages: {

  "training_type":
  {
    greaterThanZero: "Please select training type"
  },

  "payment_type":
  {
    greaterThanZero: "Please select payment type"
  },

  "price":{
 required: 'Please enter price',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 99999.99"
},

"no_session":{
required: "Please enter number of session",
digits: 'Please enter only digits',
maxlength: 'Please enter number less than 50 numbers.'
},

"validity":{
 greaterThanZero: "Please select validity value",
 
},
"validity_2":{
 greaterThanZero: "Please select validity value",
 
},
"contract":{
 greaterThanZero: "Please select contract",
 
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
				<form  action="{{route('insert_product')}}" class="slct-margin" id="submit_product" method="post" autocomplete="off">
					{{ csrf_field() }}
				  <div class="row form-group">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Training Type <span class="required_field_color">*</span></label></div>
              <div class="col-12 col-md-8">
                <select name="training_type" id="training_type" class="form-control" placeholder="Training Type">
		              <option value="0">Select Training Type</option>
		                @if(!empty($all_traning_type))
		            	    @foreach($all_traning_type as $each_traning_type)
            		        <option value="{{$each_traning_type->id}}">{{$each_traning_type->training_name}}
                        </option>
            	        @endforeach
			              @endif
			          </select>
                <div id="err" class="err"></div>
              </div>
          </div>

          <div class="row form-group">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Payment Type<span class="required_field_color">*</span></label></div>
              <div class="col-12 col-md-8">
                <select name="payment_type" id="payment_type" class="form-control">
		              <option value="0">Select Payment Type</option>
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
            <div class="col-12 col-md-6"><input type="text" id="no_session" name="no_session" placeholder="No. of Available Session" class="form-control" onkeyup="total_price_cal();">
              
            </div>
            <div class="col-12 col-md-2"><input type="checkbox" name="session_unlimited" id="session_unlimited" class="unlimited" onchange="valueUnlimited(); total_price_cal();">&nbsp; &nbsp;<label for="text-input" class="form-control-label">Unlimited</label>
              
            </div>
            
          </div>

          <div class="row form-group">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Price (<i class="fa fa-gbp"></i>)<span class="required_field_color">*</span></label></div>
            <div class="col-12 col-md-6"><input type="text" id="price" name="price" placeholder="Price" class="form-control" onkeyup="total_price_cal();">
              
            </div>
            <div class="col-12 col-md-2 ses" id="session"><label for="text-input" class=" form-control-label">/Session</label>
              
            </div>
            <div class="col-12 col-md-2 mon" id="month" style="display: none;"><label for="text-input" class=" form-control-label">/Month</label>
              
            </div>
          </div>

          <div class="row form-group" id="total_price_div" style="display: none;">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Total Price (<i class="fa fa-gbp"></i>)</label></div>
            <div class="col-12 col-md-8"><label for="text-input" class="total_price"></label>
            <input type="hidden" name="final_total_price" id="final_total_price">
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
          <div class="col col-md-4">
            <label for="text-input" class=" form-control-label">Contract<span class="required_field_color">*</span></label></div>
          <div class="col-12 col-md-8">
          	<select name="contract" id="contract" class="form-control">
              <option value="0">Select Any One</option>
              <option value="Monthly">Monthly</option>
              <option value="Annually">Annually</option>
              <option value="NA">N/A</option>
            </select>
          </div>
        </div>
        <div></div>

        <div class="row form-group">
					<div class="col-lg-4">
						<label>Notice Period<span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-4">
						<select name="notice_period" id="notice_period" class="form-control" onchange="notice_period_duration();">
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
        	    <option value="NA">N/A</option>
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
            <div class="col col-md-4">
              <select id="mon_st_time" class="form-control">
		            <option value="-">Choose Start Time</option>
		            @foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			        </select>
            </div>
            <div class="col col-md-4">
              <select id="mon_end_time" class="form-control">
		            <option value="-">Choose End Time</option>
		            @foreach($all_slot_time as $each_slot_time)
            		<option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	  @endforeach 
			        </select>
            </div>

            <div class="col col-md-4">
              <button id="add_monday_time_button" class="btn btn-dark btn-theme-colored btn-flat">Add Monday Time</button>
            </div>                            
          </div>
        </div>

        <div class="row form-group"  id="add_monday_time_div">
          
          
        </div> 
        <div class="row form-group">
          <div class="col col-md-1"><label for="text-input" class="form-control-label">Tuesday</label></div>
          <div class="col-12 col-md-3"><input type="checkbox" name="tuesday" id="tuesday" class="tuesday" onchange="valueChanged1()"></div>
            <div class="col col-md-8 tuesday_show_time" style="display: none">
              <div class="col col-md-4">
                <select id="tue_st_time" class="form-control">
		              <option value="-">Choose Start Time</option>
		            	@foreach($all_slot_time as $each_slot_time)
            		  <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			          </select>
              </div>
              <div class="col col-md-4">
                <select id="tue_end_time" class="form-control">
		              <option value="-">Choose End Time</option>
		            	@foreach($all_slot_time as $each_slot_time)
            		  <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	    @endforeach
			          </select>
              </div>
              <div class="col col-md-4">
              <button id="add_tuesday_time_button" class="btn btn-dark btn-theme-colored btn-flat">Add Tuesday Time</button>
              </div>
            </div>
          </div>
          <div class="row form-group"  id="add_tuesday_time_div">
            
          </div> 
          <div class="row form-group">
            <div class="col col-md-1"><label for="text-input" class="form-control-label">Wednesday</label></div>
              <div class="col-12 col-md-3"><input type="checkbox" name="wednesday" id="wednesday" class="wednesday" onchange="valueChanged2()"></div>
                <div class="col col-md-8 wednesday_show_time" style="display: none">
                  <div class="col col-md-4">
                    <select id="wed_st_time" class="form-control">
		                  <option value="-">Choose Start Time</option>
		            	    @foreach($all_slot_time as $each_slot_time)
            		      <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	       @endforeach
			              </select>
                  </div>
                <div class="col col-md-4">
                  <select id="wed_end_time" class="form-control">
		                <option value="-">Choose End Time</option>
		            	  @foreach($all_slot_time as $each_slot_time)
            		    <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	      @endforeach 
			            </select>
                </div>
                <div class="col col-md-4">
                  <button id="add_wednesday_time_button" class="btn btn-dark btn-theme-colored btn-flat">Add Wednesday Time</button>
                </div>
              </div>
            </div>
            <div class="row form-group"  id="add_wednesday_time_div">
              
            </div> 
            <div class="row form-group">
              <div class="col col-md-1"><label for="text-input" class="form-control-label">Thursday</label></div>
                <div class="col-12 col-md-3"><input type="checkbox" name="thursday" id="thursday" class="thursday" onchange="valueChanged3()"></div>
                  <div class="col col-md-8 thursday_show_time" style="display: none">
                    <div class="col col-md-4">
                      <select id="thu_st_time" class="form-control">
		                    <option value="-">Choose Start Time</option>
		            	      @foreach($all_slot_time as $each_slot_time)
            		        <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	          @endforeach 
			                </select>
                    </div>
                  <div class="col col-md-4">
                    <select id="thu_end_time" class="form-control">
		                  <option value="-">Choose End Time</option>
		            	    @foreach($all_slot_time as $each_slot_time)
            		      <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	        @endforeach
			              </select>
                  </div>

                  <div class="col col-md-4">
                    <button id="add_thursday_time_button" class="btn btn-dark btn-theme-colored btn-flat">Add Thursday Time</button>
                  </div>
              </div>
            </div>
            <div class="row form-group"  id="add_thursday_time_div">
              
            </div> 
            <div class="row form-group">
              <div class="col col-md-1"><label for="text-input" class="form-control-label">Friday</label></div>
                <div class="col-12 col-md-3"><input type="checkbox" name="friday" id="friday" class="friday" onchange="valueChanged4()"></div>
                  <div class="col col-md-8 friday_show_time" style="display: none">
                    <div class="col col-md-4">
                      <select id="fri_st_time" class="form-control">
		                    <option value="-">Choose Start Time</option>
		            	      @foreach($all_slot_time as $each_slot_time)
            		        <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	          @endforeach
			                </select>
                    </div>
                  <div class="col col-md-4">
                    <select id="fri_end_time" class="form-control">
		                  <option value="-">Choose End Time</option>
		            	    @foreach($all_slot_time as $each_slot_time)
            		      <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	        @endforeach
			              </select>
                  </div>
                  <div class="col col-md-4">
                    <button id="add_friday_time_button" class="btn btn-dark btn-theme-colored btn-flat">Add Friday Time</button>
                  </div>
              </div>
            </div>
            <div class="row form-group"  id="add_friday_time_div">
              
            </div>
            <div class="row form-group">
              <div class="col col-md-1"><label for="text-input" class="form-control-label">Saturday</label></div>
                <div class="col-12 col-md-3"><input type="checkbox" name="saturday" id="saturday" class="saturday" onchange="valueChanged5()"></div>
                  <div class="col col-md-8 saturday_show_time" style="display: none">
                    <div class="col col-md-4">
                      <select id="sat_st_time" class="form-control">
		                    <option value="-">Choose Start Time</option>
		            	      @foreach($all_slot_time as $each_slot_time)
            		        <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	          @endforeach
			                </select>
                    </div>
                    <div class="col col-md-4">
                      <select id="sat_end_time" class="form-control">
		                    <option value="-">Choose End Time</option>
		            	      @foreach($all_slot_time as $each_slot_time)
            		        <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	          @endforeach
			                </select>  
                    </div>
                    <div class="col col-md-4">
                      <button id="add_saturday_time_button" class="btn btn-dark btn-theme-colored btn-flat">Add Saturday Time</button>
                    </div>
                  </div>
                </div>
                <div class="row form-group"  id="add_saturday_time_div">
                  
                </div>
                <div class="row form-group">
                  <div class="col col-md-1"><label for="text-input" class="form-control-label">Sunday</label></div>
                    <div class="col col-md-3"><input type="checkbox" name="sunday" id="sunday" class="sunday" onchange="valueChanged6()"></div>
                      <div class="col col-md-8 sunday_show_time" style="display: none">
                        <div class="col col-md-4">
                          <select id="sun_st_time" class="form-control">
		                        <option value="-">Choose Start Time</option>
		            	          @foreach($all_slot_time as $each_slot_time)
            		            <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	              @endforeach
			                    </select>
                        </div>
                        <div class="col col-md-4">
                          <select id="sun_end_time" class="form-control">
		                        <option value="-">Choose End Time</option>
		            	          @foreach($all_slot_time as $each_slot_time)
            		            <option value="{{$each_slot_time->id}}">{{date('h:i A', strtotime($each_slot_time->time))}}</option>
            	              @endforeach
			                    </select> 
                        </div>
                        <div class="col col-md-4">
                          <button id="add_sunday_time_button" class="btn btn-dark btn-theme-colored btn-flat">Add Sunday Time</button>
                        </div>
                    </div>
                  </div>
                  <div class="row form-group"  id="add_sunday_time_div">
                    
                  </div>
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
						<div class="col-lg-10"></div>
							<div class="col-lg-2">
								<button name="product_submit_btn" id="product_submit_btn" class="btn btn-primary pull-right" style="width: 100px;">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>


<script>
   $(document).ready(function() {
    $('body').on('click','#add_monday_time_button',function(e) {
      e.preventDefault();
    var mon_st_time_text=$("#mon_st_time option:selected").text();
    var mon_end_time_text=$("#mon_end_time option:selected").text();

    var mon_st_time_id=$("#mon_st_time").val();
    var mon_end_time_id=$("#mon_end_time").val();

    if(mon_st_time_id=='-' || mon_end_time_id=='-')
    {
      alertify.alert('Please select monday start time and end time');
    }
    else
    {
      $("#add_monday_time_div").append('<div class="conMon col col-md-12"><div class="col col-md-4"></div><div class="col col-md-8"><div class="col col-md-4"><input readonly type="text" value="' + mon_st_time_text + '" /></div>' + '<div class="col col-md-4"><input readonly type="text" value="' + mon_end_time_text + '"/></div>' + '<input readonly type="hidden" name="monday_start_time[]" value="' + mon_st_time_id + '"/>'  + '<input readonly type="hidden" name="monday_end_time[]" value="' + mon_end_time_id + '"/>' + '<div class="col col-md-4"><input type="button" class="btnRemoveMon btn-dark btn-theme-colored btn-flat" value="Delete Monday Time"/></div></div></div><br>');
      $("#add_monday_time_div").append('<br>');
      $("#mon_st_time").val('-'); $("#mon_end_time").val('-');
    }
  });
  $('body').on('click','.btnRemoveMon',function() { 
    $(this).closest('div.conMon').remove();
  });
});
  
</script>

<script>
   $(document).ready(function() {
    $('body').on('click','#add_tuesday_time_button',function(e) {
      e.preventDefault();

    var tue_st_time_text=$("#tue_st_time option:selected").text();
    var tue_end_time_text=$("#tue_end_time option:selected").text();

    var tue_st_time_id=$("#tue_st_time").val();
    var tue_end_time_id=$("#tue_end_time").val();

    if(tue_st_time_id=='-' || tue_end_time_id=='-')
    {
      alertify.alert('Please select tuesday start time and end time');
    }
    else
    {
    $("#add_tuesday_time_div").append('<div class="conTue col col-md-12"><div class="col col-md-4"></div><div class="col col-md-8"><div class="col col-md-4"><input readonly type="text" value="' + tue_st_time_text + '" /></div>' + '<div class="col col-md-4"><input readonly type="text" value="' + tue_end_time_text + '"/></div>'  + '<input readonly type="hidden" name="tuesday_start_time[]" value="' + tue_st_time_id + '"/>'  + '<input readonly type="hidden" name="tuesday_end_time[]" value="' + tue_end_time_id + '"/>' + '<div class="col col-md-4"><input type="button" class="btnRemoveTue btn-dark btn-theme-colored btn-flat" value="Delete Tuesday Time"/></div></div></div><br>');
    $("#add_tuesday_time_div").append('<br>');
    $("#tue_st_time").val('-');$("#tue_end_time").val('-');
    }
  });
  $('body').on('click','.btnRemoveTue',function() {
    $(this).closest('div.conTue').remove()

  });
});
  
</script>

<script>
   $(document).ready(function() {
    $('body').on('click','#add_wednesday_time_button',function(e) {
      e.preventDefault();

    var wed_st_time_text=$("#wed_st_time option:selected").text();
    var wed_end_time_text=$("#wed_end_time option:selected").text();

    var wed_st_time_id=$("#wed_st_time").val();
    var wed_end_time_id=$("#wed_end_time").val();

    if(wed_st_time_id=='-' || wed_end_time_id=='-')
    {
      alertify.alert('Please select wednesday start time and end time');
    }
    else
    {
    $("#add_wednesday_time_div").append('<div class="conWed col col-md-12"><div class="col col-md-4"></div><div class="col col-md-8"><div class="col col-md-4"><input readonly type="text" value="' + wed_st_time_text + '" /></div>' + '<div class="col col-md-4"><input readonly type="text" value="' + wed_end_time_text + '"/></div>'  + '<input readonly type="hidden" name="wednesday_start_time[]" value="' + wed_st_time_id + '"/>'  + '<input readonly type="hidden" name="wednesday_end_time[]" value="' + wed_end_time_id + '"/>' + '<div class="col col-md-4"><input type="button" class="btnRemoveWed btn-dark btn-theme-colored btn-flat" value="Delete Wednesday Time"/></div></div></div><br>');
    $("#add_wednesday_time_div").append('<br>');
    $("#wed_st_time").val('-');$("#wed_end_time").val('-');
  }
  });
  $('body').on('click','.btnRemoveWed',function() {
    $(this).closest('div.conWed').remove()

  });
});
  
</script>

<script>
   $(document).ready(function() {
    $('body').on('click','#add_thursday_time_button',function(e) {
      e.preventDefault();

    var thu_st_time_text=$("#thu_st_time option:selected").text();
    var thu_end_time_text=$("#thu_end_time option:selected").text();

    var thu_st_time_id=$("#thu_st_time").val();
    var thu_end_time_id=$("#thu_end_time").val();

    if(thu_st_time_id=='-' || thu_end_time_id=='-')
    {
      alertify.alert('Please select thursday start time and end time');
    }
    else
    {
    $("#add_thursday_time_div").append('<div class="conThu col col-md-12"><div class="col col-md-4"></div><div class="col col-md-8"><div class="col col-md-4"><input readonly type="text" value="' + thu_st_time_text + '" /></div>' + '<div class="col col-md-4"><input readonly type="text" value="' + thu_end_time_text + '"/></div>' + '<input readonly type="hidden" name="thursday_start_time[]" value="' + thu_st_time_id + '"/>'  + '<input readonly type="hidden" name="thursday_end_time[]" value="' + thu_end_time_id + '"/>' + '<div class="col col-md-4"><input type="button" class="btnRemoveThu btn-dark btn-theme-colored btn-flat" value="Delete Wednesday Time"/></div></div></div><br>');
    $("#add_thursday_time_div").append('<br>');
    $("#thu_st_time").val('-');$("#thu_end_time").val('-');
  }
  });
  $('body').on('click','.btnRemoveThu',function() {
    $(this).closest('div.conThu').remove()

  });
});
  
</script>

<script>
   $(document).ready(function() {
    $('body').on('click','#add_friday_time_button',function(e) {
      e.preventDefault();

    var fri_st_time_text=$("#fri_st_time option:selected").text();
    var fri_end_time_text=$("#fri_end_time option:selected").text();

    var fri_st_time_id=$("#fri_st_time").val();
    var fri_end_time_id=$("#fri_end_time").val();

    if(fri_st_time_id=='-' || fri_end_time_id=='-')
    {
      alertify.alert('Please select friday start time and end time');
    }
    else
    {
    $("#add_friday_time_div").append('<div class="conFri col col-md-12"><div class="col col-md-4"></div><div class="col col-md-8"><div class="col col-md-4"><input readonly type="text" value="' + fri_st_time_text + '" /></div>' + '<div class="col col-md-4"><input readonly type="text" value="' + fri_end_time_text + '"/></div>' + '<input readonly type="hidden" name="friday_start_time[]" value="' + fri_st_time_id + '"/>'  + '<input readonly type="hidden" name="friday_end_time[]" value="' + fri_end_time_id + '"/>' + '<div class="col col-md-4"><input type="button" class="btnRemoveFri btn-dark btn-theme-colored btn-flat" value="Delete Friday Time"/></div></div></div><br>');
    $("#add_friday_time_div").append('<br>');
    $("#fri_st_time").val('-');$("#fri_end_time").val('-');
  }
  });
  $('body').on('click','.btnRemoveFri',function() {
    $(this).closest('div.conFri').remove()

  });
});
  
</script>

<script>
   $(document).ready(function() {
    $('body').on('click','#add_saturday_time_button',function(e) {
      e.preventDefault();

    var sat_st_time_text=$("#sat_st_time option:selected").text();
    var sat_end_time_text=$("#sat_end_time option:selected").text();

    var sat_st_time_id=$("#sat_st_time").val();
    var sat_end_time_id=$("#sat_end_time").val();

     if(sat_st_time_id=='-' || sat_end_time_id=='-')
    {
      alertify.alert('Please select saturday start time and end time');
    }
    else
    {
    $("#add_saturday_time_div").append('<div class="conSat col col-md-12"><div class="col col-md-4"></div><div class="col col-md-8"><div class="col col-md-4"><input readonly type="text" value="' + sat_st_time_text + '" /></div>' + '<div class="col col-md-4"><input readonly type="text" value="' + sat_end_time_text + '"/></div>' + '<input readonly type="hidden" name="saturday_start_time[]" value="' + sat_st_time_id + '"/>'  + '<input readonly type="hidden" name="saturday_end_time[]" value="' + sat_end_time_id + '"/>' + '<div class="col col-md-4"><input type="button" class="btnRemoveSat btn-dark btn-theme-colored btn-flat" value="Delete Saturday Time"/></div></div></div><br>');
    $("#add_saturday_time_div").append('<br>');
    $("#sat_st_time").val('-');$("#sat_end_time").val('-');
  }
  });
  $('body').on('click','.btnRemoveSat',function() {
    $(this).closest('div.conSat').remove()

  });
});
  
</script>

<script>
   $(document).ready(function() {
    $('body').on('click','#add_sunday_time_button',function(e) {
      e.preventDefault();

    var sun_st_time_text=$("#sun_st_time option:selected").text();
    var sun_end_time_text=$("#sun_end_time option:selected").text();

    var sun_st_time_id=$("#sun_st_time").val();
    var sun_end_time_id=$("#sun_end_time").val();

    if(sun_st_time_id=='-' || sun_end_time_id=='-')
    {
      alertify.alert('Please select sunday start time and end time');
    }
    else
    {

    $("#add_sunday_time_div").append('<div class="conSun col col-md-12"><div class="col col-md-4"></div><div class="col col-md-8"><div class="col col-md-4"><input readonly type="text" value="' + sun_st_time_text + '" /></div>' + '<div class="col col-md-4"><input readonly type="text" value="' + sun_end_time_text + '"/></div>' + '<input readonly type="hidden" name="sunday_start_time[]" value="' + sun_st_time_id + '"/>'  + '<input readonly type="hidden" name="sunday_end_time[]" value="' + sun_end_time_id + '"/>' + '<div class="col col-md-4"><input type="button" class="btnRemoveSun btn-dark btn-theme-colored btn-flat" value="Delete Saturday Time"/></div></div></div><br>');
    $("#add_sunday_time_div").append('<br>');
    $("#sun_st_time").val('-');$("#sun_end_time").val('-');
  }
  });
  $('body').on('click','.btnRemoveSun',function() {
    $(this).closest('div.conSun').remove()

  });
});
  
</script>

<script>		                                                     
function valueChanged()
{
	
  if($('.monday').is(":checked"))
  {
    $(".monday_show_time").show();
    $(".conMon").show();
  }   
  else
  {
    $(".monday_show_time").hide();
    $(".conMon").hide();
  }
      
}
  function valueChanged1()
{
	if($('.tuesday').is(":checked"))
  {
    $(".tuesday_show_time").show();
    $(".conTue").show();
  }   
  else
  {
    $(".tuesday_show_time").hide();
    $(".conTue").hide();
  }
}
function valueChanged2()
{
	if($('.wednesday').is(":checked"))
  {
    $(".wednesday_show_time").show();
    $(".conWed").show();
  }   
  else
  {
    $(".wednesday_show_time").hide();
    $(".conWed").hide();
  }
}
function valueChanged3()
{
	if($('.thursday').is(":checked"))
  {
    $(".thursday_show_time").show();
    $(".conThu").show();
  }   
  else
  {
    $(".thursday_show_time").hide();
    $(".conThu").hide();
  }
}
function valueChanged4()
{
	if($('.friday').is(":checked"))
  {
    $(".friday_show_time").show();
    $(".conFri").show();
  }   
  else
  {
    $(".friday_show_time").hide();
    $(".conFri").hide();
  }
}
function valueChanged5()
{
	if($('.saturday').is(":checked"))
  {
    $(".saturday_show_time").show();
    $(".conSat").show();
  }   
  else
  {
    $(".saturday_show_time").hide();
    $(".conSat").hide();
  }
}
function valueChanged6()
{
	if($('.sunday').is(":checked"))
  {
    $(".sunday_show_time").show();
    $(".conSun").show();
  }   
  else
  {
    $(".sunday_show_time").hide();
    $(".conSun").hide();
  }
}
function valueUnlimited()
{
	   if($('.unlimited').is(":checked"))  {

      $('#no_session').attr('disabled',true);
      $('#no_session').val('');
      $(".mon").show();
    	$(".ses").hide();
		}
    else {
      $('#no_session').removeAttr('disabled');
    	 $(".mon").hide();
    	 $(".ses").show();
       $("#total_price_div").hide();
       $("#price").val('');
       $("#final_total_price").val('');

   		 }
        
}
</script>

<script>
  function total_price_cal()
  {
    if($('#no_session').val()!='' && $('#price').val()!='')
    {
      var total_price=parseInt($('#no_session').val())*parseInt($('#price').val());
      $("#total_price_div").show();
      $('.total_price').html(total_price);
      $("#final_total_price").val(total_price);
    } 
    else if($('.unlimited').is(":checked") && $('#price').val()!='')
    {
      var total_price=12*parseInt($('#price').val());
      $('.total_price').html(total_price);
      $("#total_price_div").show();
      $("#final_total_price").val(total_price);
    } 
    else
    {
      $("#total_price_div").hide();
      $("#final_total_price").val('');
    }
  }
</script>


<script>
  function notice_period_duration()
  {
    if($('#notice_period').val()=='NA')
    {
      $('#notice_period_2').val('0');
      $('#notice_period_2').attr('disabled',true);
    }
    else
    {
      $('#notice_period_2').removeAttr('disabled');
    }
  }
</script>




@endif
@endsection

