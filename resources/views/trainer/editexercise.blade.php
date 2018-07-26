<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')
<!--  -->



<!-- validation of all form data -->
<script>
  $(document).ready(function() {
    $.validator.addMethod('numericOnly', function (value) {
      return /^[0-9]+$/.test(value);
    }, 'Please enter only numeric values');
    $('#exerciseeditform').validate({  
/// rules of error 
rules: {
  "title": {
    required: true
  },
  "description": {
    required: true
  },
  "duration": {
    numericOnly: true
  },
},
////for show error message
messages: {
  "title":{
    required: 'Please enter your title'
  },
  "description":{
    required: 'Please enter your description' 
  },
  "duration": {
    required: 'Please enter your duration time'

  }, 
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
if (fileSize > 100) /// not more than 30 kb
{
alertify.alert("Please Upload maximum 100KB file size of image");// if Maxsize from Model > real file size
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
        <h1>Edit Exercise Details</h1>
      </div>
    </div>
  </div>    
</div>
<div class="col-lg-6">
  <div class="card">
    <div class="card-body card-block">
      <form action="{{route('updateexercise')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="exerciseeditform">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" id="id" value="{{$data->id}}">
        <input type="hidden" name="trainer_id" value="{{Auth::user()->id}}">
        <div class="row form-group">
          <div class="col col-md-3"><label for="text-input" class=" form-control-label">Title<span class="required_field_color">*</span></label></div>
          <div class="col-12 col-md-9"><input type="text" id="title" name="title" placeholder="Title" class="form-control" value="{{$data->title}}">
          </div> 
        </div>
        <div class="row form-group">
          <div class="col col-md-3">
            <label for="text-input" class=" form-control-label">Description<span class="required_field_color">*</span></label></div>
            <div class="col-12 col-md-9">
              <textarea id="description" name="description" placeholder="Description" class="form-control">{{$data->description}}</textarea>
            </div>
          </div>
          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Duration (in Day)<span class="required_field_color">*</span></label></div>
            <div class="col-12 col-md-9"><input type="text" id="duration" name="duration" placeholder="Duration" class="form-control" value="{{$data->duration}}">
            </div> 
          </div>
          <div class="row form-group">
            <div class="col col-md-3"><label for="file-input" class=" form-control-label">Profile Image<span class="required_field_color">*</span></label></label></div>
            <div class="col-12 col-md-9">                         
              <input type="file" id="image" name="image" class="form-control-file" >
              <input type="hidden" id="oldimage" name="oldimage" class="form-control-file" value="{{$data->image}}">
            </div>
            <div class="pic-case-upload">
              <img id="profile_thumbnail" src="{{asset('backend/images')}}/{{$data->image}}" alt="profile image" width="100"/>
            </div>
          </div>
          <div>
            <button type="submit" name="submit" class="btn btn-primary btn-sm">
              <i class="fa fa-dot-circle-o"></i> Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>




  @endsection