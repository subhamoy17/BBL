<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<script type="text/javascript">
$(document).ready(function() {  

  $.validator.addMethod("alpha", function(value, element){
    return this.optional(element) || value == value.match(/^[a-zA-Z, '']+$/);
    }, "Alphabetic characters only please");

$('#storeform').validate({ 
/// rules of error 
  rules: {

"slots_name": {
       alpha:true,
      required: true
    },


    "slots_number": {
      required: true,
      digits: true,
      min:1
    },
    "slots_price": {
      required: true,
      number: true,
      range: [1, 999999.99]
    },
    "slots_validity": {
      required: true,
      digits: true,
      min:1
    }


  },

  ////for show error message
  messages: {

 "slots_name":{
   required: 'Please enter your name'
    },
    "slots_number":{
    required:'Please Enter number of slots',
    digits: 'Please enter only number of digits',
    min: "Minimum value 1 is required"
    },
    "slots_price": {
      required: 'Please enter the price of slots',
      number: 'Please enter only point and number of digits',
      range: "Please enter price betwwen 1 to 999999.99"
    },
    "slots_validity": {
      required: 'Please enter the validity of slots',
      digits: 'Please enter only number of digits',
      min: "Minimum value 1 is required"
    }

  }
});

});
</script>
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Add New Slot's Record</h1>
                    </div>
                </div>
            </div>    
</div>
        <div class="col-lg-6">
        <div class="card">
                      <div class="card-body card-block">
                        <form action="{{route('storeslots')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="storeform">
                            {{ csrf_field() }}
                            
                          <div class="row form-group">
                              <div class="col col-md-3"><label for="text-input" class="form-control-label"> Name of Slot<span class="required_field_color">*</span></label></div>
                              <div class="col-12 col-md-9"><input type="text" id="slots_name" name="slots_name" placeholder="Name of Slot" class="form-control{{ $errors->has('slots_name') ? ' is-invalid' : '' }}" value="{{old('slots_name')}}">
                              @if ($errors->has('slots_name'))
                                <span class="invalid-feedback">
                                  <strong>{{ $errors->first('slots_name') }}</strong>
                                </span>
                              @endif
                              </div>
                          </div>

                          <div class="row form-group">
                              <div class="col col-md-3"><label for="text-input" class=" form-control-label">Number of Slot<span class="required_field_color">*</span></label></div>
                              <div class="col-12 col-md-9"><input type="text" id="slots_number" name="slots_number" placeholder="Number of Slot" class="form-control{{ $errors->has('slots_number') ? ' is-invalid' : '' }}" value="{{old('slots_number')}}">
                              @if ($errors->has('slots_number'))
                                <span class="invalid-feedback">
                                  <strong>{{ $errors->first('slots_number') }}</strong>
                                </span>
                              @endif
                              </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Slot's Price (Rs.)<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="slots_price" name="slots_price" placeholder="Slot's Price (Rs.)" class="form-control{{ $errors->has('slots_price') ? ' is-invalid' : '' }}"  value="{{old('slots_price')}}">
                             @if ($errors->has('slots_price'))
                                <span class="invalid-feedback">
                                  <strong>{{ $errors->first('slots_price') }}</strong>
                                </span>
                              @endif 
                            </div>
                            
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Slot's Validity (In Days)<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="slots_validity" name="slots_validity" placeholder="Slot's Validity (In Days)" class="form-control{{ $errors->has('slots_validity') ? ' is-invalid' : '' }}" value="{{old('slots_validity')}}">
                              @if ($errors->has('slots_validity'))
                                <span class="invalid-feedback">
                                  <strong>{{ $errors->first('slots_validity') }}</strong>
                                </span>
                              @endif 
                            </div>
                            
                          </div>
                          <div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                  <i class="fa fa-dot-circle-o"></i> ADD
                                </button>
                           </div>
                        </form>
                      </div>
                    </div>
                    </div>
@endsection