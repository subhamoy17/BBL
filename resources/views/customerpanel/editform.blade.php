<!-- for extends all i.e. header,footer,sidebar -->

@extends('adminlayouts.adminpanel_template')

@section('content')

<!-- validation of all form data -->
<script>

$(document).ready(function() {
  // name can contant only alphabetic
  $.validator.addMethod("alpha", function(value, element){
    return this.optional(element) || value == value.match(/^[a-zA-Z, '']+$/);
    }, "Alphabetic characters only please");

  // mobile number can contant only numeric
  $.validator.addMethod('numericOnly', function (value) {
       return /^[0-9]+$/.test(value);
    }, 'Please enter only numeric values');


$('#myeditform').validate({  
  /// rules of error 
  rules: {
    "name": {
      alpha:true,
      minlength:6,
      required: true
    },
    "address": {
      required: true
    },
    "phone": {
      required: true,
      minlength: 10,
      maxlength: 10,
      numericOnly: true
    }
  },
   ////for show error message
  messages: {
    "name":{
    required: 'Please enter your name',
    minlength:'Minimum length 6 is required'
  },
  "address":{
    required: 'Please enter your address' 
  },
  "phone": {
      required: 'Please enter your mobile number',
      minlength: 'Minimum 10 digits mobile number is required',
      maxlength: 'Maximum 10 digits mobile number is required'
  }
  }
  });
  
  ///show uploading image and check validation of image

  $("#image").change(function(){ 

    /// check the extension of image

    var ext = $('#image').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    alertify.alert('Only accept gif/png/jpg/jpeg extension formate of image');
    $("#image").val('');
    return false;
    }

    /// check the size of image

    var fileSize = (this.files[0].size / 1024); //size in KB
    if (fileSize > 30) /// not more than 30 kb
    {
        alertify.alert("Please Upload maximum 30KB file size of image");// if Maxsize from Model > real file size
        $("#image").val('');
        return false;
    }

    // show image after upload
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#profile_thumbnail').attr('src', e.target.result);
        }
        $("#profile_thumbnail").show();
        reader.readAsDataURL(this.files[0]);
      }
});



});
</script>



<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Edit Profile</h1>
                    </div>
                </div>
            </div>    
</div>

        <div class="col-lg-6">
        <div class="card">
                      <div class="card-header">
                        <!-- <strong>Edit Profile</strong> -->

                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                      </div>
                      <div class="card-body card-block">
                        <form action="{{route('admin.profileupdate')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="myeditform">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="id" id="id" value="{{$data->id}}">
                          <div class="row form-group">

                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Name<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="name" name="name" placeholder="Name" class="form-control" value="{{$data->name}}"></div>
                          </div>


                          
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Email</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="email" name="email" placeholder="Email" class="form-control" value="{{$data->email}}" readonly></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Mobile<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="phone" name="phone" placeholder="Mobile" class="form-control"  value="{{$data->phone}}"></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Address<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><textarea name="address" id="address" placeholder="Address" class="form-control"> {{$data->address}}</textarea></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="file-input" class=" form-control-label">Profile Image</label></div>
                            
                            <div class="col-12 col-md-9">
                              @if ($errors->any())
                                      <div class="alert alert-danger">
                                        <ul>
                                          @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                          @endforeach
                                        </ul>
                                      </div>
                              @endif
                              <input type="file" id="image" name="image" class="form-control-file">

                              <input type="hidden" id="oldimage" name="oldimage" class="form-control-file" value="{{$data->image}}">
                            </div>
                            <div class="pic-case-upload">
                                <img id="profile_thumbnail" src="{{asset('backend/images')}}/{{$data->image}}" alt="profile image" />
                              </div>
                          </div>
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                  <i class="fa fa-dot-circle-o"></i> Submit
                                </button>
                            </div>
                        </form>
                      </div>
                    </div>
                    </div>   

    @endsection