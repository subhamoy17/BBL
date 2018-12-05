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
          <h1>Edit Product</h1>
        </div>
      </div>
    </div>    
  </div>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body card-block">
			
			<div class="add_bootcamp_div col-lg-12">
				<form  action="{{route('update_product')}}" class="slct-margin" id="submit_product" method="post" autocomplete="off">
					{{ csrf_field() }}
          <input type="hidden" name="product_id" value="{{$product_details->product_id}}">
				  <div class="row form-group">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Training Type <span class="required_field_color">*</span></label></div>
              <div class="col-12 col-md-8">
                
                <input type="text" id="training_name" name="training_name" placeholder="No. of Available Session" class="form-control" value="{{$product_details->training_name}}" readonly="readonly">
                 <input type="hidden" id="training_type" name="training_type"  class="form-control" value="{{$product_details->training_type_id}}" readonly="readonly">
                <div id="err" class="err"></div>
              </div>
          </div>

          <div class="row form-group">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Payment Type<span class="required_field_color">*</span></label></div>
              <div class="col-12 col-md-8">
                

                <input type="text" id="payment_type_name" name="payment_type_name" placeholder="No. of Available Session" class="form-control" value="{{$product_details->payment_type_name}}" readonly="readonly">
                 <input type="hidden" id="payment_type" name="payment_type"  class="form-control" value="{{$product_details->payment_type_id}}">
                <div id="err1" class="err1"></div>
              </div>
          </div>

          <div class="row form-group">

            @if($product_details->payment_type_id==1)
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> No. of Available Session<span class="required_field_color">*</span></label></div>
            <div class="col-12 col-md-6"><input type="text" id="no_session" name="no_session" placeholder="No. of Available Session" class="form-control" value="{{$product_details->total_sessions}}" onkeyup="total_price_cal();">
            </div>
            <!-- <div class="col-12 col-md-2"><input type="checkbox" name="session_unlimited" id="session_unlimited" class="unlimited" onchange="valueUnlimited(); total_price_cal();" onkeyup="">&nbsp; &nbsp;<label for="text-input" class="form-control-label">Unlimited</label>
            </div> -->
            @else
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> No. of Session/Month<span class="required_field_color">*</span></label></div>
             @if($product_details->total_sessions=='Unlimited')
            <div class="col-12 col-md-6"><input type="text" id="no_session" name="no_session" placeholder="No. of Session/Month" class="form-control" onkeyup="total_price_cal();" disabled="disabled">
            </div>
            <div class="col-12 col-md-2"><input type="checkbox" name="session_unlimited" id="session_unlimited" class="unlimited" onchange="valueUnlimited(); total_price_cal();" checked="checked">&nbsp; &nbsp;<label for="text-input" class="form-control-label">Unlimited</label>
            </div>
            @else
            <div class="col-12 col-md-6"><input type="text" id="no_session" name="no_session" placeholder="No. of Session/Month" class="form-control" onkeyup="total_price_cal();" value="{{$product_details->total_sessions}}">
            </div>
            <div class="col-12 col-md-2"><input type="checkbox" name="session_unlimited" id="session_unlimited" class="unlimited" onchange="valueUnlimited(); total_price_cal();" >&nbsp; &nbsp;<label for="text-input" class="form-control-label">Unlimited</label>
            </div>
            @endif
            
            @endif

            
            
          </div>

          <div class="row form-group">
            @if($product_details->payment_type_id==1)
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Price/Session (<i class="fa fa-gbp"></i>)<span class="required_field_color">*</span></label></div>
            @else
             <div class="col col-md-4"><label for="text-input" class=" form-control-label">Subscription Price/Month (<i class="fa fa-gbp"></i>)<span class="required_field_color">*</span></label></div>
             @endif
            <div class="col-12 col-md-6"><input type="text" id="price" name="price" placeholder="Price" class="form-control" onkeyup="total_price_cal();" value="{{$product_details->price_session_or_month}}">
              
            </div>
            @if($product_details->total_sessions!='Unlimited')
              <div class="col-12 col-md-2 ses" id="session"><label for="text-input" class=" form-control-label">/Session</label>
              </div>
              <div class="col-12 col-md-2 mon" id="month" style="display: none;"><label for="text-input" class=" form-control-label">/Month</label>
              </div>
            @else
              <div class="col-12 col-md-2 ses" id="session" style="display: none;"><label for="text-input" class=" form-control-label">/Session</label>
              </div>
              <div class="col-12 col-md-2 mon" id="month"><label for="text-input" class=" form-control-label">/Month</label>
              </div>
            @endif
          </div>

          <div class="row form-group" id="total_price_div">
            @if($product_details->payment_type_id==1)
            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Total Package Price (<i class="fa fa-gbp"></i>)</label></div>
            @else
            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Anual Subscription Price (<i class="fa fa-gbp"></i>)</label></div>
            @endif
            <div class="col-12 col-md-8"><label for="text-input" class="total_price" style="padding-left: 12px;">{{$product_details->total_price}}</label>
            <input type="hidden" name="final_total_price" id="final_total_price" value="{{$product_details->total_price}}">
            </div>
          </div>
@if($product_details->payment_type_id==1)
				<div class="row form-group">
					<div class="col-lg-4">
						<label>Validity<span class="required_field_color">*</span></label>
					</div>
					<div class="col-lg-4">
						<select name="validity" id="validity" class="form-control">
	            <option value="0">Select Any One</option>
          		<option value="1" @if($product_details->validity_value==1) selected @endif>1</option>
        	    <option value="2" @if($product_details->validity_value==2) selected @endif>2</option>
        	    <option value="3" @if($product_details->validity_value==3) selected @endif>3</option>
        	    <option value="4" @if($product_details->validity_value==4) selected @endif>4</option>
        	    <option value="5" @if($product_details->validity_value==5) selected @endif>5</option>
        	    <option value="6" @if($product_details->validity_value==6) selected @endif>6</option>
        	    <option value="7" @if($product_details->validity_value==7) selected @endif>7</option>
        	    <option value="8" @if($product_details->validity_value==8) selected @endif>8</option>
        	    <option value="9" @if($product_details->validity_value==9) selected @endif>9</option>
        	    <option value="10" @if($product_details->validity_value==10) selected @endif>10</option>
        	    <option value="11" @if($product_details->validity_value==11) selected @endif>11</option>
        	    <option value="12" @if($product_details->validity_value==12) selected @endif>12</option>
			      </select>
					</div>
					<div class="col-lg-4">
							<select name="validity_2" id="validity_2" class="form-control">
		            <option value="0">Select Any One</option>
              		<option value="7" @if($product_details->validity_duration==7) selected @endif>Week</option>
                  <option value="30" @if($product_details->validity_duration==30) selected @endif>Month</option> 
			        </select>
					</div>
				</div>
        @endif
        @if($product_details->payment_type_id==2)
				<div class="row form-group">
          <div class="col col-md-4">
            <label for="text-input" class=" form-control-label">Contract<span class="required_field_color">*</span></label></div>
          <div class="col-12 col-md-8">
          	<select name="contract" id="contract" class="form-control">
              <option value="0">Select Any One</option>
              <option value="Monthly" @if($product_details->contract=='Monthly') selected @endif>Monthly</option>
              <option value="Annually" @if($product_details->contract=="Annually") selected @endif>Annually</option>
              <option value="NA" @if($product_details->contract=="NA") selected @endif>N/A</option>
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
          		<option value="1" @if($product_details->notice_period_value==1) selected @endif>1</option>
        	    <option value="2" @if($product_details->notice_period_value==2) selected @endif>2</option>
        	    <option value="3" @if($product_details->notice_period_value==3) selected @endif>3</option>
        	    <option value="4" @if($product_details->notice_period_value==4) selected @endif>4</option>
        	    <option value="5" @if($product_details->notice_period_value==5) selected @endif>5</option>
        	    <option value="6" @if($product_details->notice_period_value==6) selected @endif>6</option>
        	    <option value="7" @if($product_details->notice_period_value==7) selected @endif>7</option>
        	    <option value="8" @if($product_details->notice_period_value==8) selected @endif>8</option>
        	    <option value="9" @if($product_details->notice_period_value==9) selected @endif>9</option>
        	    <option value="10" @if($product_details->notice_period_value==10) selected @endif>10</option>
        	    <option value="11" @if($product_details->notice_period_value==11) selected @endif>11</option>
              <option value="12" @if($product_details->notice_period_value==12) selected @endif>12</option>
        	    <option value="NA" @if($product_details->notice_period_value=='NA') selected @endif>N/A</option>
			      </select>
					</div>
					<div class="col-lg-4">
						<select name="notice_period_2" id="notice_period_2" class="form-control">
		            <option value="0">Select Any One</option>
                  <option value="7" @if($product_details->notice_period_duration==7) selected @endif>Week</option>
                  <option value="30" @if($product_details->notice_period_duration==30) selected @endif>Month</option>
			        </select>
					</div>
				</div>
        @endif

       

       
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
						<div class="col-lg-8"></div>
							
              <div class="col-lg-2">
                <input type="submit" name="save" id="save_btn" class="btn btn-primary pull-right"  value="Save">
                
              </div>
              <div class="col-lg-2">
                <input type="submit" name="submit" id="product_submit_btn" class="btn btn-primary pull-right" style="width: 100px;" value="Submit">
              </div>
						</div>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>




<!-- <script>

//// Add button disable ////
$(document).ready(function(){
  $('#submit_product').bind('submit', function (e) {
    var button = $('#product_submit_btn');
    var button1 = $('#save_btn');
    // Disable the submit button while evaluating if the form should be submitted
    button.prop('disabled', true);
     button1.prop('disabled', true);
    var valid = true;    

    // Do stuff (validations, etc) here and set
    // "valid" to false if the validation fails

    if (!valid) { 
        // Prevent form from submitting if validation failed
        e.preventDefault();

        // Reactivate the button if the form was not submitted
        button.prop('disabled', false);
        button1.prop('disabled', false);
    }
});
});
</script> -->

<script>
  function total_price_cal()
  {
    if($('#payment_type').val()==1)
    {
      var total_price_cal=parseInt($('#no_session').val())*parseInt($('#price').val());
      var total_price =parseFloat(total_price_cal).toFixed(2);
      $("#total_price_div").show();
      $('.total_price').html(total_price);
      $("#final_total_price").val(total_price);
    } 
    else if($('#payment_type').val()==2)
    {
      var total_price_cal=12*parseInt($('#price').val());
       var total_price =parseFloat(total_price_cal).toFixed(2);
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

  function valueUnlimited()
{
     if($('.unlimited').is(":checked"))  {

      $('#no_session').attr('disabled',true);
      $('#no_session').val('');
      
    }
    else {
      $('#no_session').removeAttr('disabled');
      
       // $("#total_price_div").hide();
       // $("#price").val('');
       // $("#final_total_price").val('');

       }
        
}
</script>


@endif
@endsection

