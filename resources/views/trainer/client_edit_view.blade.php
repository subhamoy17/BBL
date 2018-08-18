<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')
<!--  -->



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


$('#clienteditform').validate({  
  /// rules of error 
  rules: {

 "title": {
      required: true
    },

    "name": {
      alpha:true,
      minlength:6,
      required: true
    },
    "designation": {
      required: true
    },
    "description": {
      required: true,
    maxlength:120
     
    }

  },

  messages: {

'title': {
      required: 'Please enter your title'
      
  },

    "name":{
    required: 'Please enter your name',
    minlength:'Minimum length 6 is required'
  },
  "designation":{
    required: 'Please enter your designation' 
  },
  "description": {
      required: 'Please enter your description',
       maxlength:'Maximum length 120 is required'
      
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
    if (fileSize > 200) /// not more than 30 kb
    {
        alertify.alert("Please Upload maximum 200KB file size of image");// if Maxsize from Model > real file size
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
                        <h1>Edit Trainer</h1>
                    </div>
                </div>
            </div>    
</div>
        <div class="col-lg-12">
        <div class="card">
                      <div class="card-body card-block">
                        <form action="{{route('client_update')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="clienteditform">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                              <input type="hidden" name="id" id="id" value="{{$data->id}}">

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Title<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="title" name="title" placeholder="Title" class="form-control" value="{{$data->title}}">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Name<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="name" name="name" placeholder="Name" class="form-control" value="{{$data->name}}">
                            </div>
                          </div>


                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Designation<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="designation" name="designation" placeholder="Designation" class="form-control" value="{{$data->designation}}">
                            </div>
                          </div>

                           <div class="row form-group">
                            <div class="col col-md-3">
                              <label for="text-input" class=" form-control-label">Description<span class="required_field_color">*</span></div>
                            <div class="col-12 col-md-9">
                              <textarea id="description" name="description" placeholder="Description" class="form-control">{{$data->description}} </textarea>
                            </div>
                          </div> 



                             <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Facebook</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="facebook" name="facebook" placeholder="Facebook" class="form-control" value="{{$data->facebook}}">
                            </div>
                          </div>

                            <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Twitter</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="twitter" name="twitter" placeholder="Twitter" class="form-control" value="{{$data->twitter}}">
                            </div>
                          </div>


                           <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Instagram</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="instagram" name=instagram" placeholder="Instagram" class="form-control" value="{{$data->instagram}}">
                            </div>
                          </div>


                            <div class="row form-group">
                            <div class="col col-md-3"><label for="file-input" class=" form-control-label">Profile Image</label></div>
                            <div class="col-12 col-md-9">                         
                              <input type="file" id="image" name="image" class="form-control-file" >
                              <input type="hidden" id="oldimage" name="oldimage" class="form-control-file" value="{{$data->image}}">
                            </div>
                            @if($data->image)
                            <div class="pic-case-upload">
                                <img id="profile_thumbnail" src="{{asset('backend/images')}}/{{$data->image}}" alt="profile image" height="150"  width="200"/>
                              </div>
                               @endif

                          </div>




                             <div style="float: right">
                                <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                  <i class="fa fa-dot-circle-o"></i> Submit
                                </button>
                            </div>
                        </form>
                      </div>
                    </div>
                    </div>



@endsection