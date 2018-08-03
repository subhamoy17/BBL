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
      range: [1, 999999.99]
    },
    
    "left_arm": {
     // required: true,
      number: true,
      range: [1, 999999.99]
    },
    "chest": {
     // required: true,
      number: true,
      range: [1, 999999.99]
    },
    "waist": {
     // required: true,
      number: true,
      range: [1, 999999.99]
    },
    "hips": {
     // required: true,
      number: true,
      range: [1, 999999.99]
    },
    "right_thigh": {
     // required: true,
      number: true,
      range: [1, 999999.99]
    },
    "left_thigh": {
     // required: true,
      number: true,
      range: [1, 999999.99]
    },
    "right_calf": {
     // required: true,
      number: true,
      range: [1, 999999.99]
    },
    "left_calf": {
     // required: true,
      number: true,
      range: [1, 999999.99]
    },
    "weight": {
     // required: true,
      number: true,
      range: [1, 999999.99]
    },
    "height": {
     // required: true,
      number: true,
      range: [1, 999999.99]
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
      range: "Please enter value betwwen 1 to 999999.99"
  },
  
   "left_arm":{
    // required: 'Please enter the this value',
      number: 'Please enter decimal only',
      range: "Please enter value betwwen 1 to 999999.99"
  },
  
  "chest":{
    required: 'Please enter the this value',
      number: 'Please enter decimal only',
      range: "Please enter value betwwen 1 to 999999.99"
  },

  "waist":{
    // required: 'Please enter the this value',
      number: 'Please enter decimal only',
      range: "Please enter value betwwen 1 to 999999.99"
  },

  "hips":{
    // required: 'Please enter the this value',
      number: 'Please enter decimal only',
      range: "Please enter value betwwen 1 to 999999.99"
  },

  "right_thigh":{
    // required: 'Please enter the this value',
      number: 'Please enter decimal only',
      range: "Please enter value betwwen 1 to 999999.99"
  },

  "left_thigh":{
    // required: 'Please enter the this value',
      number: 'Please enter decimal only',
      range: "Please enter value betwwen 1 to 999999.99"
  },

  "right_calf":{
    // required: 'Please enter the this value',
      number: 'Please enter decimal only',
      range: "Please enter value betwwen 1 to 999999.99"
  },
  "left_calf":{
    // required: 'Please enter the this value',
      number: 'Please enter decimal only',
      range: "Please enter value betwwen 1 to 999999.99"
  },

  "weight":{
    // required: 'Please enter the this value',
      number: 'Please enter decimal only',
      range: "Please enter value betwwen 1 to 999999.99"
  },

  "height":{
    // required: 'Please enter the this value',
      number: 'Please enter decimal only',
      range: "Please enter value betwwen 1 to 999999.99"
  }

}
});
  

});
</script>



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
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Right Arm</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="right_arm" name="right_arm" placeholder="Right Arm" class="form-control" value="">
                            </div>
                          </div>



   <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Left Arm</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="left_arm" name="left_arm" placeholder="Left Arm" class="form-control" value="">
                            </div>
                          </div>


  



   <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Chest</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="chest" name="chest" placeholder="Chest" class="form-control" value="">
                            </div>
                          </div>




   <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Waist</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="waist" name="waist" placeholder="Waist" class="form-control" value="">
                            </div>
                          </div>



   <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Hips</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="hips" name="hips" placeholder="Hips" class="form-control" value="">
                            </div>
                          </div>


   <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Right Thigh</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="right_thigh" name="right_thigh" placeholder="Right Thigh" class="form-control" value="">
                            </div>
                          </div>



   <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Left Thigh</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="left_thigh" name="left_thigh" placeholder="Left Thigh" class="form-control" value="">
                            </div>
                          </div>

  
   <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Right Calf</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="right_calf" name="right_calf" placeholder="Right Calf" class="form-control" value="">
                            </div>
                          </div>





   <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Left Calf</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="left_calf" name="left_calf" placeholder="Left Calf" class="form-control" value="">
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Height</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="height" name="height" placeholder="Height" class="form-control" value="">
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Weight</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="weight" name="weight" placeholder="Weight" class="form-control" value="">
                            </div>
                          </div>

                             <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Measured On<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="mot_date" name="date" class="form-control" placeholder="Date">
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








@endsection