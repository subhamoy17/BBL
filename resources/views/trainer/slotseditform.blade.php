<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<script type="text/javascript">
$(document).ready(function() {    
$('#editslotsform').validate({ 
/// rules of error 
  rules: {
    "slots_number": {
      required: true,
      digits: true,
      min:1
    },
     "slots_name": {
      required: true
      
      
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
    "slots_number":{
    required:'Please Enter number of slots',
    digits: 'Please enter only number of digits',
    min: "Minimum value 1 is required"
    },
    "slots_name":{
    required:'Please Enter a package name'
    
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
                        <h1>Edit Package</h1>
                    </div>
                </div>
            </div>    
</div>
                @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                @endif

        <div class="col-lg-12">
        <div class="card">
                      <div class="card-body card-block">
                        <form action="{{route('editslots')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="editslotsform">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="id" id="id" value="{{$data->id}}">



              <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"> Package Name<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9">
                              <input type="text" id="slots_name" name="slots_name" placeholder="Package Name" class="form-control{{ $errors->has('slots_name') ? ' is-invalid' : '' }}" value="{{$data->slots_name}}">
                              @if ($errors->has('slots_name'))
                                <span class="invalid-feedback">
                                  <strong>{{ $errors->first('slots_name') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>





                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">No. of Slots<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9">
                              <input type="text" id="slots_number" name="slots_number" placeholder="No. of Slots" class="form-control{{ $errors->has('slots_number') ? ' is-invalid' : '' }}" value="{{$data->slots_number}}">
                              @if ($errors->has('slots_number'))
                                <span class="invalid-feedback">
                                  <strong>{{ $errors->first('slots_number') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>


                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Price<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9">
                              <input type="text" id="slots_price" name="slots_price" placeholder="Price" class="form-control{{ $errors->has('slots_price') ? ' is-invalid' : '' }}"  value="{{$data->slots_price}}">
                              @if ($errors->has('slots_price'))
                                <span class="invalid-feedback">
                                  <strong>{{ $errors->first('slots_price') }}</strong>
                                </span>
                              @endif
                            </div>
                            
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Validity (In Days)<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9">
                              <input type="text" id="slots_validity" name="slots_validity" placeholder="Validity" class="form-control{{ $errors->has('slots_validity') ? ' is-invalid' : '' }}"  value="{{$data->slots_validity}}">
                              @if ($errors->has('slots_validity'))
                                <span class="invalid-feedback">
                                  <strong>{{ $errors->first('slots_validity') }}</strong>
                                </span>
                              @endif
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
@endsection