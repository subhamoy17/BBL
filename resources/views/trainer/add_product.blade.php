<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<script>

  $(document).ready(function(){

$.validator.addMethod("greaterThanZero", function(value, element) {
    return this.optional(element) || (parseFloat(value) != '');
}, "Amount must be greater than zero");
   
  $.validator.addMethod("dollarsscents", function(value, element) {
  return this.optional(element) || /^\d{0,5}(\.\d{0,3})?$/i.test(value);
}, "Please enter value betwwen 1 to 99999.99");
 

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
"anual_total_price": {
required: true,
number: true,
range: [1, 99999.99]
},
"sub_price": {
required: true,
number: true,

range: [1, 99999.99]
},
"no_session": {
required: true,
digits: true,
maxlength: 50
},
"no_session_mon": {
required: true,
digits: true,
maxlength: 50
},
"validity": {
greaterThanZero: true,

},
"contract": {
greaterThanZero: true,

},
"notice_period": {
greaterThanZero: true,

},
"notice_period_2": {
greaterThanZero: true,

},
"validity_2": {
greaterThanZero: true,

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
"anual_total_price":{
 required: 'Please enter total price',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 99999.99"
},

 "sub_price":{
 required: 'Please enter subscription price',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 99999.99"
},

"no_session":{
required: "Please enter number of session",
digits: 'Please enter only digits',
maxlength: 'Please enter number less than 50 numbers.'
},

"no_session_mon":{
required: "Please enter available number of session",
digits: 'Please enter only digits',
maxlength: 'Please enter number less than 50 numbers.'
},

"validity":{
 greaterThanZero: "Please select validity value",
 
},
"contract":{
 greaterThanZero: "Please select contract value",
 
},
"notice_period":{
 greaterThanZero: "Please select notice period value",
 
},
"notice_period_2":{
 greaterThanZero: "Please select notice period value",
 
},
"validity_2":{
 greaterThanZero: "Please select validity value",
 
}

}
});


});

</script>

<script>

//// Add button disable ////
$(document).ready(function(){
  $('#submit_product').bind('submit', function (e) {
    var button = $('#product_submit_btn');
    // var button1 = $('#save_btn');
    // Disable the submit button while evaluating if the form should be submitted
    button.prop('disabled', true);
     // button1.prop('disabled', true);
    var valid = true;    

    // Do stuff (validations, etc) here and set
    // "valid" to false if the validation fails

    if (!valid) { 
        // Prevent form from submitting if validation failed
        e.preventDefault();

        // Reactivate the button if the form was not submitted
        button.prop('disabled', false);
        // button1.prop('disabled', false);
    }
});
});
</script>

<!-- <script>

//// Add button disable ////
$(document).ready(function(){
  $('#submit_product').bind('submit', function (e) {
    
     var button1 = $('#save_btn');
    // Disable the submit button while evaluating if the form should be submitted
   
      button1.prop('disabled', true);
    var valid = true;    

    // Do stuff (validations, etc) here and set
    // "valid" to false if the validation fails

    if (!valid) { 
        // Prevent form from submitting if validation failed
        e.preventDefault();

        // Reactivate the button if the form was not submitted
       
         button1.prop('disabled', false);
    }
});
});
</script> -->

<script type="text/javascript">

  
$(document).ready(function(){ 

$('#product_submit_btn').on('click',function(e){ 
    
    $('#save_btn').attr('disabled','disabled');
    

  });

$('#save_btn').on('click',function(e){ 
    
    $('#product_submit_btn').attr('disabled','disabled');
    if($("#submit_product").valid()){
     $('#save_btn').hide();
     $('#dub_sub').show();
}
  });
});



// $(document).ready(function(){


// $('#save_btn2').on('click',function(e){
  
//     $('#add_sess2').hide();
//    $('.save_button').attr('disabled','disabled');
//     $('.save_button').text('Please wait...');
//     $('ul.tabs li').removeAttr('rel');
//     $("ul.tabs").hide();
//     $('#add_session_form2').submit();

//   });

//  });
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
                <select name="payment_type" id="payment_type" class="form-control" onchange="paymentType()">
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
         
<div id=pay_as_you_go style="display: none">
          <div class="row form-group">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> No. of Available Session<span class="required_field_color">*</span></label></div>
            <div class="col-12 col-md-8"><input type="text" id="no_session" name="no_session" placeholder="No. of Available Session" class="form-control" onkeyup="total_price_cal();">
              
            </div>
          
            
          </div>

          <div class="row form-group">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Price (<i class="fa fa-gbp"></i>)/Session<span class="required_field_color">*</span></label></div>
            <div class="col-12 col-md-8"><input type="text" id="price" name="price" placeholder="Price" class="form-control" onkeyup="total_price_cal();">
              
            </div>
           
          </div>

          <div class="row form-group" id="total_price_div" style="display: none;">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Total Package Price (<i class="fa fa-gbp"></i>)</label></div>
            <div class="col-12 col-md-8"><label for="text-input" class="total_price" style="padding-left: 12px;"></label>
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
							<select name="validity_2" id="validity_2" class="form-control" onchange="valid_cal2()">
		            <option value="0">Select Any One</option>
            		<option value="7">Week(s)</option>
            	  <option value="30">Month(s)</option>   
			        </select>
					</div>
				</div>

      </div>
				

        <!-- Subscription -->

<div id="subscription" style="display: none">

        <div class="row form-group">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> No. of Available Session/Month<span class="required_field_color">*</span></label></div>
            <div class="col-12 col-md-6"><input type="text" id="no_session_mon" name="no_session_mon" placeholder="No. of Available Session" class="form-control" >
              
            </div>
            <div class="col-12 col-md-2"><input type="checkbox" name="session_unlimited" id="session_unlimited" class="unlimited" onchange="valueUnlimited()">&nbsp; &nbsp;<label for="text-input" class="form-control-label" >Unlimited</label>
              
            </div>
            
          </div>

          <div class="row form-group">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Subscription Price (<i class="fa fa-gbp"></i>)/Month<span class="required_field_color">*</span></label></div>
            <div class="col-12 col-md-8"><input type="text" id="sub_price" name="sub_price" placeholder="Subscription Price" class="form-control" onkeyup="total_price_cal_2();">
              
            </div>
            
          </div>

          <div class="row form-group" id="total_price_div_2" style="display: none;">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Annual Subscription Price (<i class="fa fa-gbp"></i>)</label></div>
            <div class="col-12 col-md-8"></label>
            <input type="text" class="total_price_2 form-control" name="anual_total_price" id="anual_total_price">
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
            <select name="notice_period" id="notice_period" class="form-control" >
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
            <select name="notice_period_2" id="notice_period_2" class="form-control" onchange="valid_cal();">
                <option value="0">Select Any One</option>
                <option value="7">Week(s)</option>
                <option value="30">Month(s)</option>  
              </select>
          </div>
        </div>

</div>

				
			
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
						<div class="col-lg-8"></div>
							<div class="col-lg-4">
                <input type="submit" name="submit" id="save_btn" class="btn btn-primary add-pro-save" value="Save">

								<input  class="btn btn-primary add-pro-save" id="dub_sub" readonly value="Save" style="display: none; width: 100px;">
                <input type="submit" name="submit" id="product_submit_btn" class="btn btn-primary add-pro-sub" style="width: 100px;" value="Submit">
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
  function total_price_cal()
  {
    if($('#no_session').val()!='' && $('#price').val()!='')
    {
      var total_price_cal=parseFloat($('#no_session').val())*parseFloat($('#price').val());
      var total_price =parseFloat(total_price_cal).toFixed(2);
     
    
      $("#total_price_div").show();
      $('.total_price').html(total_price);
      $("#final_total_price").val(total_price);
     
    } 
    
    else
    {
      $("#total_price_div").hide();
      $("#final_total_price").val('');
    }
  }

  function valid_cal()
  {
   
    if($("#submit_product").valid()){
      
       $('.btn-primary').removeAttr('disabled');
       $('#save_btn').show();
    $('#dub_sub').hide();
    }
  }

  function valid_cal2()
  {
    
    if($("#submit_product").valid()){
      
       $('.btn-primary').removeAttr('disabled');
         $('#save_btn').show();
        $('#dub_sub').hide();
    }
  }
</script>

<script>
  function total_price_cal_2()
  {
    if($('#sub_price').val()!='')
    {
      var total_price_2_cal=12*parseFloat($('#sub_price').val());
      var total_price_2 =parseFloat(total_price_2_cal).toFixed(2);
      $("#total_price_div_2").show();
      $('.total_price_2').html(total_price_2);
      $('.total_price_2').val(total_price_2);
      $("#anual_total_price").val(total_price_2);

    } 
    
    else
    {
      $("#total_price_div_2").hide();
      $("#anual_total_price").val('');
    }
  }
</script>

<script>		                                                     
function paymentType()
{
	// $( "#myselect option:selected" ).text();
  if($( "#payment_type" ).val()==1)
  {
    
    
    $("#pay_as_you_go").show();
    $("#subscription").hide();

    $("#no_session_mon").val('');
    $("#sub_price").val('');
   
    $('#contract').prop('selectedIndex',0);
    $('#notice_period').prop('selectedIndex',0);
    $('#notice_period_2').prop('selectedIndex',0);
    $('.unlimited').attr('checked', false);
    $('#no_session_mon').removeAttr('disabled');
    $("#total_price_div_2").hide();
      $("#anual_total_price").val('');
      // $('#no_session_mon').rules('remove');
      // $('#sub_price').rules('remove');
      // $('#contract').rules('remove');
      // $('#notice_period').rules('remove');
      // $('#notice_period_2').rules('remove');
     $('.btn-primary').removeAttr('disabled');
  }   
  else if($( "#payment_type" ).val()==2)
  {
    
    $("#pay_as_you_go").hide();
    $("#subscription").show();
    $("#no_session").val('');
    $("#price").val('');
    $('#validity').prop('selectedIndex',0);
    $('#validity_2').prop('selectedIndex',0);
   
    
    $("#no_session-error").val('');
    $("#total_price_div").hide();
      $("#final_total_price").val('');
      $('.btn-primary').removeAttr('disabled');
  }
  else{
     $("#pay_as_you_go").hide();
    $("#subscription").hide();
  }
      
}



function valueUnlimited()
{
     if($('.unlimited').is(":checked"))  {

      $('#no_session_mon').attr('disabled',true);
      $('#no_session_mon').val('');
      // $(".mon").show();
      // $(".ses").hide();
    }
    else {
      $('#no_session_mon').removeAttr('disabled');
       // $(".mon").hide();
       // $(".ses").show();
       $("#total_price_div").hide();
       $("#price").val('');
       $("#final_total_price").val('');

       }
        
}



</script>





@endif
@endsection

