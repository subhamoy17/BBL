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


  $('#trainereditform').validate({  
    /// rules of error 
    rules: {
      "name": {
        alpha:true,
        minlength:4,
        required: true
      },
      "designation": {
        required: true
      },
      "description": {
        required: true
      },
      
    },
     ////for show error message
    messages: {
      "name":{
        required: 'Please enter name',
        minlength:'Minimum length 4 is required'
      },
   
      "description":{
        required: 'Please enter testimonial'
      },
    
      "designation":{
        required: 'Please enter designation' 
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

  //validation for duplicate name

  $('#name').keyup(function(){ 

      $.post("{{url('trainer/cheecktestimonialname_edit')}}",$('#trainereditform').serialize(), function(data){
            if(data==1)
            { 
              $("#duplicate_name").show();
              $("#duplicate_name").html("Duplicate testimonial name is not allow");
              $('.btn-primary').attr('disabled','disabled');
              return false;
            }
            else
            { 
              $("#duplicate_name").hide();
              $('.btn-primary').removeAttr('disabled');
              return true;
            }
        
        });
   
  });

});
</script>


@if(Auth::user()->master_trainer==1)
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Edit Testimonial</h1>
                    </div>
                </div>
            </div>    
</div>
    
        <div class="col-lg-12">
        <div class="card">
                      <div class="card-body card-block">
                        <form action="{{route('testimonialupdate')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="trainereditform">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                              <input type="hidden" name="id" id="id" value="{{$data->id}}">
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Name<span class="required_field_color">*</span></label></div>

                            <div class="col-12 col-md-9"><input type="text" id="name" name="name" placeholder="Name" class="form-control" value="{{$data->name}}">
                              
                              <div id="duplicate_name">                             
                              </div>
                              
                            </div>
                          </div>

                              <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"> Designation<span class="required_field_color">*</span></label></div>

                            <div class="col-12 col-md-9"><input type="text" id="designation" name="designation" placeholder="designation" class="form-control" value="{{$data->designation}}">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3">
                              <label for="text-input" class=" form-control-label">Testimonial<span class="required_field_color">*</span></div>
                            <div class="col-12 col-md-9">
                              <textarea id="description" name="description" placeholder="Testimonial" class="form-control" >{{$data->description}}</textarea>
                            </div>
                          </div>
                               


                            <div class="row form-group">
                            <div class="col col-md-3"><label for="file-input" class=" form-control-label">Image<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-4">                         
                              <input type="file" id="image" name="image" class="form-control-file">
                              <input type="hidden" id="oldimage" name="oldimage" class="form-control-file" value="{{$data->image}}">
                            </div>
                            <div class="col-12 col-md-5">                         
                              <img id="profile_thumbnail" src="{{asset('backend/images')}}/{{$data->image}}" alt="profile image" height="150"  width="200"/>
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