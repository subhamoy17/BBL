<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<script>

  $(document).ready(function() {

    $.validator.addMethod("alpha", function(value, element){
      return this.optional(element) || value == value.match(/^[a-zA-Z, '']+$/);
    }, "Alphabetic characters only please");

// mobile number can contant only numeric
$.validator.addMethod('numericOnly', function (value) {
  return /^[0-9]+$/.test(value);
}, 'Please enter only numeric values');
$.validator.addMethod('blood', function (value) {
  return /^[0-9]*[/]?[0-9]*$/.test(value);
}, 'Please enter only numeric values');


$.validator.addMethod("alphanumeric", function(value, element) {
  return this.optional(element) || /^[\w.]+$/i.test(value);
}, "Letters, numbers, and underscores only please");

$.validator.addMethod("dollarsscents", function(value, element) {
  return this.optional(element) || /^\d{0,4}(\.\d{0,1})?$/i.test(value);
}, "Please enter value betwwen 1 to 999.9");

$('.convert').on('change', function()
{
  
  if($(this).val()=='imperial')
    converted_value=$(this).prev('input').val()*0.39370;
  else
    converted_value=$(this).prev('input').val()/0.39370;
  $(this).prev('input').val(converted_value);
});

$('.weightconvert').on('change', function()
{ 
  
  if($(this).val()=='imperial'){
// alert('ddddd');
    converted_value2=$(this).prev('input').val()* 2.2046;
  }
  else{
    // alert('ddd545d');
    converted_value2=$(this).prev('input').val()/2.2046;
  }
  $(this).prev('input').val(converted_value2);
});


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

    number: true,
    range: [1, 999.9]
  },

  "left_arm": {

    number: true,
    range: [1, 999.9]
  },
  "chest": {

    number: true,
    range: [1, 999.9]
  },
  "waist": {
    number: true,
    range: [1, 999.9]
  },
  "hips": {
    number: true,
    range: [1, 999.9]
  },
  "right_thigh": {
    number: true,
    range: [1, 999.9]
  },
  "left_thigh": {
    number: true,
    range: [1, 999.9]
  },
  "right_calf": {
    number: true,
    range: [1, 999.9]
  },
  "left_calf": {
    number: true,
    range: [1, 999.9]
  },
  "height": {
    number: true,
    range: [1, 999.9]
  },
  "starting_weight": {
    number: true,
    required: true,
    range: [1, 999.9]

  },

  "ending_weight": {
    number: true,
    required: true,
    range: [1, 999.9]
  },

  "blood_pressure": {
    blood: true
   
  
  },
  "heart_beat": {
    number: true,
    digits: true
    
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
range: "Please enter value betwwen 1 to  999.9"
},

"left_arm":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to  999.9"
},

"chest":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to  999.9"
},

"waist":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to  999.9"
},

"hips":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to  999.9"
},

"right_thigh":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to  999.9"
},

"left_thigh":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 999.9"
},

"right_calf":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to  9999.9"
},
"left_calf":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to  9999.9"
},

"height":{
// required: 'Please enter the this value',
number: 'Please enter decimal only',
range: "Please enter value betwwen 1 to 9999.9"
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
  blood:'Please enter approppriate value'
 
  

},
"heart_beat":{
  
  digits: 'Please enter only number of digits',
  number: 'Please enter number only'
}
}
});



});
</script>

<script>

  $(function () {
    $( "#mot_date" ).datepicker({
  dateFormat: "yy-mm-dd",
  beforeShowDay: NotAfterToday
});
  } );

  function NotAfterToday(date)
{
    var now = new Date();//this gets the current date and time
    if (date.getFullYear() == now.getFullYear() && date.getMonth() == now.getMonth() && date.getDate() <= now.getDate())
        return [true];
    if (date.getFullYear() <= now.getFullYear() && date.getMonth() < now.getMonth())
       return [true];
     if (date.getFullYear() < now.getFullYear())
       return [true];
    return [false];
}


  </script>

@if(Auth::user()->master_trainer==1)
<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Edit {{$data->current_customer_name}}'s MOT</h1>
      </div>
    </div>
  </div>    
</div>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body card-block">
      <form action="{{route('motedit')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="motaddform">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" id="id" value="{{$data->mot_id}}">             
        <div class="row form-group">
          <div class="col col-md-3"><label for="text-input" class="form-control-label">Customer Name<span class="required_field_color">*</span></label></div>
          <div class="col-12 col-md-9"><input type="text" id="customer-name" placeholder="Customer Name" class="form-control" value="{{$data->current_customer_name}}" readonly>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-md-3"><label for="text-input" class="form-control-label">Right Arm</label></div>
          <div class="col-md-9"><div class="row"><div class="col-lg-12"><input type="text" id="right_arm" name="right_arm" placeholder="Right Arm" class="form-control" value="{{$data->right_arm}}">
            <select class="form-control convert" name="right_arm_credential">
              <option id="metric" value="metric">Metric (cm.)</option>
              <option id="imperial" value="imperial">Imperial (inch.)</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-3"><label for="text-input" class="form-control-label">Left Arm</label></div>
      <div class="col-md-9"><div class="row"><div class="col-lg-12"><input type="text" id="left_arm" name="left_arm" placeholder="Left Arm" class="form-control" value="{{$data->left_arm}}">
       <select class="form-control convert" name="left_arm_credential">
        <option id="metric" value="metric">Metric (cm.)</option>
        <option id="imperial" value="imperial">Imperial (inch.)</option>
      </select>
    </div>
  </div>
</div>
</div>
<div class="row form-group">
  <div class="col-md-3"><label for="text-input" class="form-control-label">Chest</label></div>
  <div class="col-md-9"><div class="row"><div class="col-lg-12"><input type="text" id="chest" name="chest" placeholder="Chest" class="form-control" value="{{$data->chest}}">
   <select class="form-control convert" name="chest_credential">
    <option id="metric" value="metric">Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>
</div>
</div>
</div>
<div class="row form-group">
  <div class="col-md-3"><label for="text-input" class="form-control-label">Waist</label></div>
  <div class="col-md-9"><div class="row"><div class="col-lg-12"><input type="text" id="waist" name="waist" placeholder="Waist" class="form-control" value="{{$data->waist}}">
   <select class="form-control convert" name="waist_credential">
    <option id="metric" value="metric">Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>
</div>
</div>
</div>
<div class="row form-group">
  <div class="col-md-3"><label for="text-input" class="form-control-label">Hips</label></div>
  <div class="col-md-9"><div class="row"><div class="col-lg-12"><input type="text" id="hips" name="hips" placeholder="Hips" class="form-control" value="{{$data->hips}}">
   <select class="form-control convert" name="hips_credential">
    <option id="metric" value="metric">Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>
</div>
</div>
</div>

<div class="row form-group">
  <div class="col-md-3"><label for="text-input" class="form-control-label">Right thigh</label></div>
  <div class="col-md-9"><div class="row"><div class="col-lg-12"><input type="text" id="right_thigh" name="right_thigh" placeholder="Right thigh" class="form-control" value="{{$data->right_thigh}}">
   <select class="form-control convert" name="right_thigh_credential">
    <option id="metric" value="metric" >Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>
</div>
</div>
</div>
<div class="row form-group">
  <div class="col-md-3"><label for="text-input" class="form-control-label">Left thigh</label></div>
  <div class="col-md-9"><div class="row"><div class="col-lg-12"><input type="text" id="left_thigh" name="left_thigh" placeholder="Left thigh" class="form-control" value="{{$data->left_thigh}}">
    <select class="form-control convert" name="left_thigh_credential">
      <option id="metric" value="metric">Metric (cm.)</option>
      <option id="imperial" value="imperial">Imperial (inch.)</option>
    </select>
  </div>
</div>
</div>
</div>
<div class="row form-group">
  <div class="col-md-3"><label for="text-input" class="form-control-label">Right Calf</label></div>
  <div class="col-md-9"><div class="row"><div class="col-lg-12"><input type="text" id="right_calf" name="right_calf" placeholder="Right Calf" class="form-control" value="{{$data->right_calf}}">
    <select class="form-control convert" name="right_calf_credential">
      <option id="metric" value="metric">Metric (cm.)</option>
      <option id="imperial" value="imperial">Imperial (inch.)</option>
    </select>
  </div>
</div>
</div>
</div>
<div class="row form-group">
  <div class="col-md-3"><label for="text-input" class="form-control-label">Left Calf</label></div>
  <div class="col-md-9"><div class="row"><div class="col-lg-12"><input type="text" id="left_calf" name="left_calf" placeholder="Left Calf" class="form-control" value="{{$data->left_calf}}">
   <select class="form-control convert" name="left_calf_credential">
    
    <option id="metric" value="metric">Metric (cm.)</option>
    <option id="imperial" value="imperial">Imperial (inch.)</option>
  </select>
</div>
</div>
</div>
</div>

<div class="row form-group">
  <div class="col-md-3"><label for="text-input" class="form-control-label">Height</label></div>
  <div class="col-md-9"><div class="row"><div class="col-lg-12"><input type="text" id="height" name="height" placeholder="Height" class="form-control" value="{{$data->height}}">
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
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="starting_weight" name="starting_weight" placeholder="Starting Weight" class="form-control" value="{{$data->starting_weight}}"><!-- </div>
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
  <div class="col-lg-9"><div class="row"><div class="col-lg-12"><input type="text" id="ending_weight" name="ending_weight" placeholder="Ending Weight" class="form-control" value="{{$data->ending_weight}}"><!-- </div>
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
  <div class="col col-md-3"><label for="text-input" class="form-control-label">Blood Pressure (mmHg)<span class="required_field_color">*</span></label></div>
  <div class="col-12 col-md-9"><input type="text" id="blood_pressure" name="blood_pressure" placeholder="Blood Pressure" class="form-control" value="{{$data->blood_pressure}}">
  </div>
</div>
<div class="row form-group">
  <div class="col col-md-3"><label for="text-input" class="form-control-label">Heart Beat (bpm)<span class="required_field_color">*</span></label></div>
  <div class="col-12 col-md-9"><input type="text" id="heart_beat" name="heart_beat" placeholder="Heart Beat" class="form-control" value="{{$data->heart_beat}}">
  </div>
</div>
<div class="row form-group">
  <div class="col col-md-3"><label for="text-input" class="form-control-label">Description</div>
    <div class="col-12 col-md-9"><textarea type="text" id="description" name="description" placeholder="Description" class="form-control" >{{$data->description}}</textarea>
    </div>
  </div>

  <div class="row form-group">
    <div class="col col-md-3"><label for="text-input" class="form-control-label">Measured On<span class="required_field_color">*</span></label></div>
    <div class="col-12 col-md-9"><input type="text" id="mot_date" name="date" class="form-control" placeholder="Date" value="{{$data->date}}" readonly="true">
    </div>
  </div>
  <div class="row form-group">
    <div class="col col-md-10">
    </div>
    <div class="col col-md-2">
      <button type="submit"  name="submit" class="btn btn-primary" style="width: 65%;">Update</button>
    </div>
  </div>
</form>

</div>
</div>
</div>

 @endif

@endsection