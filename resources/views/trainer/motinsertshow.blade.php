<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<script>

  $(document).ready(function(){



    $.validator.addMethod("alpha", function(value, element){
      return this.optional(element) || value == value.match(/^[a-zA-Z, '']+$/);
    }, "Alphabetic characters only please");

// mobile number can contant only numeric
$.validator.addMethod('numericO	nly', function (value) {
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
}, "Please enter value betwwen 1 to 999.99");


$('#motaddform').validate({  
/// rules of error 
rules: {

  "apply":
  {
    required: true,
  },

  "date":
  {
    required: true,
  }, 

  "right_arm": {
// required: true,
number: true,
range: [1, 999.9]
},

"left_arm": {
// required: true,
number: true,
range: [1, 999.9]
},
"chest": {
// required: true,
number: true,
range: [1, 999.9]
},
"waist": {
// required: true,
number: true,
range: [1, 999.9]
},
"hips": {
// required: true,
number: true,
range: [1, 999.9]
},
"right_thigh": {
// required: true,
number: true,
range: [1, 999.9]
},
"left_thigh": {
// required: true,
number: true,
range: [1, 999.9]
},
"right_calf": {
// required: true,
number: true,
range: [1, 999.9]
},
"left_calf": {
// required: true,
number: true,
range: [1,999.9]
},
"height": {
// required: true,
number: true,
range: [1, 999.9]
},

"starting_weight": {

  required: true,
    number: true,
  range: [1, 999.9]
  
},

"ending_weight": {
  number: true,
  required: true,
  range: [1, 999.9]

},

"blood_pressure": {
 
  blood: true,
  required: true
},

"heart_beat": {
  number: true,
  digits: true,
  required: true
}


},

messages: {

  "apply":
  {
    required: "Please select a customer name"
  },

  "date":
  {
    required: "Please select a date"
  },

  "right_arm":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 999.9"
},

"left_arm":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 999.9"
},

"chest":{
  required: 'Please enter the value',
  number: 'Please enter decimal only',
  range: "Please enter value betwwen 1 to 999.9"
},

"waist":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 999.9"
},

"hips":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 999.9"
},

"right_thigh":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 999.9"
},

"left_thigh":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 999.9"
},

"right_calf":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 999.9"
},
"left_calf":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 999.9"
},

"starting_weight":{
  required: 'Please enter the value',
number: 'Please enter decimal only',
  range: "Please enter value betwwen 1 to 999.9"
},

"ending_weight":{
  required: 'Please enter the value',
  number: 'Please enter decimal only',
  range: "Please enter value betwwen 1 to 999.9"

},

"blood_pressure":{
 
  required: 'Please enter the value',
  blood: 'Please enter approppriate value'

},

"heart_beat":{
  required: 'Please enter the value',
  digits: 'Please enter only number of digits',
  number: 'Please enter number only'
},

"height":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to  999.9"
}

}
});


    $('.convert').on('change', function()
{
  if($(this).val()=='imperial')
    converted_value=$(this).prev('input').val()*0.39370;
  else
    converted_value=$(this).prev('input').val()/0.39370;
  $(this).prev('input').val(converted_value);
});





$('.weightconvert').on('change', function(){ 

  if($(this).val()=='imperial')
    converted_value=$(this).prev('input').val()* 2.2046;
  
  else
    converted_value=$(this).prev('input').val()/2.2046;
  $(this).prev('input').val(converted_value);

});

});

</script>



<script type="text/javascript">
  $(document).ready(function(){
    $('.required').on('change',function(e) {
      var customerID = $.trim($(this).val()); 
      console.log(customerID);
 if(customerID){
  var Data =
  {
    'id': customerID
 
  }
 $.ajax({
          url: "{{route('mot_customer_request')}}",
          json_enc: Data,
          type: "GET",
          dataType: "json",
          data:
          {
            'data': Data,
          },
          success: function (data)
          {
            
           $('#right_arm').val(data.right_arm);
             $('#left_arm').val(data.left_arm);
              $('#chest').val(data.chest);
 $('#waist').val(data.waist);
  $('#hips').val(data.hips);
   $('#right_thigh').val(data.right_thigh);
    $('#left_thigh').val(data.left_thigh);
     $('#right_calf').val(data.right_calf);
      $('#left_calf').val(data.left_calf);
       $('#height').val(data.height);
       $('#starting_weight').val(data.starting_weight);
       $('#ending_weight').val(data.ending_weight);
       $('#heart_beat').val(data.heart_beat);
        $('#blood_pressure').val(data.blood_pressure);
       $('#description').val(data.description);
       $('#mot_date').val(data.date);
       
          }
        });
    }
     
    });
  });
</script>

@if(Auth::user()->master_trainer==1)

<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Add New Customer's MOT</h1>
      </div>
    </div>
  </div>    
</div>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body card-block">
      <form action="{{route('motinsert')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="motaddform">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="trainer_id" value="{{Auth::user()->id}}">
        <div class="row form-group">
          <div class="col col-md-3">
            <label>Customer Name<span class="required_field_color">*</span></label>
          </div>
          <div class=" col-md-9">
            <select class="form-control required" name="apply" id="apply">
              <option value=""> Please select a name</option>
              @foreach($data as $mydata)
              <option value="{{$mydata->id}}"> {{$mydata->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-lg-3"><label for="text-input" class=" form-control-label">Right Arm</label></div>
          <div class="col-lg-9">
            <div class="row">
              <div class="col-lg-12">
                <input type="text" id="right_arm" name="right_arm" placeholder="Right Arm" class="form-control" value="">
          
             <select class="form-control convert" name="right_arm_credential">
              <option id="metric" value="metric">Metric (cm.)</option>
              <option id="imperial" value="imperial">Imperial (inch.)</option>
            </select>
          </div>     
        </div> 
      </div>
    </div>

    <div class="row form-group">
      <div class="col-lg-3"><label for="text-input" class="form-control-label">Left Arm</label></div>
      <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="left_arm" name="left_arm" placeholder="Left Arm" class="form-control" value=""><!-- </div> -->
      <!--  <div class="col-lg-6"> -->
        <select class="form-control convert" name="left_arm_credential">
          <option id="metric" value="metric">Metric (cm.)</option>
          <option id="imperial" value="imperial">Imperial (inch.)</option>
        </select>
      </div>     
    </div> 

  </div>
</div>


<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Chest</label></div>
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="chest" name="chest" placeholder="Chest" class="form-control" value=""><!-- </div>
  <div class="col-lg-6"> -->
   <select class="form-control convert" name="chest_credential">
    <option id="metric" value="metric">Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>     
</div> 
</div>
</div>


<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Waist</label></div>
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="waist" name="waist" placeholder="Waist" class="form-control" value=""><!-- </div>
  <div class="col-lg-6"> -->
   <select class="form-control convert" name="waist_credential">
    <option id="metric" value="metric">Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>     
</div> 
</div>
</div>



<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Hips</label></div>
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="hips" name="hips" placeholder="Hips" class="form-control" value=""><!-- </div>
  <div class="col-lg-6"> -->
   <select class="form-control convert" name="hips_credential">
    <option id="metric" value="metric">Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>     
</div> 

</div>
</div>
<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Right Thigh</label></div>
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="right_thigh" name="right_thigh" placeholder="Right Thigh" class="form-control" value=""><!-- </div>
  <div class="col-lg-6"> -->
    <select class="form-control convert" name="right_thigh_credential">
      <option id="metric" value="metric" >Metric (cm.)</option>
      <option id="imperial" value="imperial">Imperial (inch.)</option>
    </select>
  </div>     
</div> 

</div>
</div>
<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Left Thigh</label></div>
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="left_thigh" name="left_thigh" placeholder="Left Thigh" class="form-control" value=""><!-- </div>
  <div class="col-lg-6"> -->
   <select class="form-control convert" name="left_thigh_credential">
    <option id="metric" value="metric">Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>     
</div> 

</div>
</div>
<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Right Calf</label></div>
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="right_calf" name="right_calf" placeholder="Right Calf" class="form-control" value=""><!-- </div>
  <div class="col-lg-6"> -->
   <select class="form-control convert" name="right_calf_credential">
    <option id="metric" value="metric">Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>     
</div> 

</div>
</div>
<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Left Calf</label></div>
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="left_calf" name="left_calf" placeholder="Left Calf" class="form-control" value=""><!-- </div>
  <div class="col-lg-6"> -->
   <select class="form-control convert" name="left_calf_credential">
    <option id="metric" value="metric">Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>     
</div> 
</div>
</div>
<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Height</label></div>
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="height" name="height" placeholder="Height" class="form-control" value=""><!-- </div>
  <div class="col-lg-6"> -->
    <select class="form-control convert" name="height_credential">
      <option id="metric" value="metric">Metric (cm.)</option>
      <option id="imperial" value="imperial">Imperial (inch.)</option>
    </select>
  </div>     
</div> 
</div>
</div>
<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Starting Weight<span class="required_field_color">*</span></label></div>
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="starting_weight" name="starting_weight" placeholder="Starting Weight" class="form-control" value=""><!-- </div>
  <div class="col-lg-6"> -->
    <select class="form-control weightconvert" name="starting_weight_credential">
      <option id="metric" value="metric">Metric (kg.)</option>
      <option id="imperial" value="imperial">Imperial (lbs.)</option>
    </select>
  </div>     
</div> 
</div>
</div>
<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Ending Weight<span class="required_field_color">*</span></label></div>
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="ending_weight" name="ending_weight" placeholder="Ending Weight" class="form-control" value=""><!-- </div>
  <div class="col-lg-6"> -->
    <select class="form-control weightconvert" name="ending_weight_credential">
      <option id="metric" value="metric">Metric (kg.)</option>
      <option id="imperial" value="imperial">Imperial (lbs.)</option>
    </select>
  </div>     
</div> 
</div>
</div>

<div class="row form-group">
  <div class="col col-md-3"><label for="text-input" class="form-control-label"> Blood Pressure (mmHg)<span class="required_field_color">*</span></label></div>
  <div class="col-12 col-md-9"><input type="text" id="blood_pressure" name="blood_pressure" placeholder="Blood Pressure" class="form-control" value="">
  </div>
</div>



<div class="row form-group">
  <div class="col col-md-3"><label for="text-input" class="form-control-label">Heart Beat (bpm)<span class="required_field_color">*</span></label></div>
  <div class="col-12 col-md-9"><input type="text" id="heart_beat" name="heart_beat" placeholder="Heart Beat" class="form-control" value="">
  </div>
</div>
<div class="row form-group">
  <div class="col-lg-3"><label for="text-input" class="form-control-label">Description</div>
    <div class="col-lg-9"><textarea type="text" id="description" name="description" placeholder="Description" class="form-control" value=""></textarea>
    </div>
  </div>

  <div class="row form-group">
    <div class="col-lg-3"><label for="text-input" class="form-control-label">Measured On<span class="required_field_color">*</span></label></div>
    <div class="col-lg-9"><input type="text" id="mot_date" name="date" class="form-control" placeholder="Date" readonly>
    </div>
  </div>
  
  <div class="row form-group">
    <div class="col col-md-10">
    </div>
    <div class="col col-md-2">
      <button type="submit"  name="submit" class="btn btn-primary" style="width: 65%;">Add</button>
    </div>
  </div>
</form>
</div>
</div>
</div>

@endif
@endsection