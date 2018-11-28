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

range: [1, 99999]
},

"sub_price": {
required: true,
number: true,

range: [1, 99999]
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
            <div class="col-12 col-md-8"><input type="text" id="no_session" name="no_session" placeholder="No. of Available Session" class="form-control" >
              
            </div>
          
            
          </div>

          <div class="row form-group">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label"> Price (<i class="fa fa-gbp"></i>)/Session<span class="required_field_color">*</span></label></div>
            <div class="col-12 col-md-8"><input type="text" id="price" name="price" placeholder="Price" class="form-control" onkeyup="total_price_cal();">
              
            </div>
           
          </div>

          <div class="row form-group" id="total_price_div" style="display: none;">
            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Total Package Price (<i class="fa fa-gbp"></i>)</label></div>
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
							<select name="validity_2" id="validity_2" class="form-control" onchange="valid_cal2()">
		            <option value="0">Select Any One</option>
            		<option value="7">Week</option>
            	  <option value="30">Month</option>   
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
            <div class="col-12 col-md-8"><label for="text-input" class="total_price_2"></label>
            <input type="hidden" name="anual_total_price" id="anual_total_price">
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
                <option value="7">Week</option>
                <option value="30">Month</option>  
              </select>
          </div>
        </div>

</div>

				
			
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
						<div class="col-lg-10"></div>
							<div class="col-lg-2">
								<button name="submit" id="product_submit_btn" class="btn btn-primary pull-right" style="width: 100px;">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
  
  $(document).ready(function(){
   
    $('#submit_product').bind('submit', function (e) {
    var button = $('#product_submit_btn');

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

      });

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
    
    else
    {
      $("#total_price_div").hide();
      $("#final_total_price").val('');
    }
  }

  function valid_cal()
  {
    // alert('ss');
    if($("#submit_product").valid()){
      // alert('11ss');
       $('.btn-primary').removeAttr('disabled');
    }
  }

  function valid_cal2()
  {
    // alert('ss');
    if($("#submit_product").valid()){
      // alert('11ss');
       $('.btn-primary').removeAttr('disabled');
    }
  }
</script>

<script>
  function total_price_cal_2()
  {
    if($('#sub_price').val()!='')
    {
      var total_price_2=12*parseInt($('#sub_price').val());
      $("#total_price_div_2").show();
      $('.total_price_2').html(total_price_2);
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
    // alert('jhhj');
    $("#pay_as_you_go").show();
    $("#subscription").hide();
     $('.btn-primary').attr('disabled','disabled');
  }   
  else if($( "#payment_type" ).val()==2)
  {
    // alert('jjj');
    $("#pay_as_you_go").hide();
    $("#subscription").show();
    $("#no_session-error").val('');
     $('.btn-primary').attr('disabled','disabled');
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

