<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')
<!--  -->



<!-- validation of all form data -->

<script>

  // validation for valid video link upload and duplicate category namechecking
  function  add_exercise_fun(){ alert();
    if($('#video').val()!='')
    {
    
   var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = $("#video").val().match(regExp);
            if (match && match[2].length == 11) { 
                 $('#video').val('https://www.youtube.com/embed/' + match[2] + '?autoplay=0');
                 $("#video_add_error").hide();
                 $('.btn-primary').removeAttr('disabled');
              }
            else
            {
              $('.btn-primary').attr('disabled','disabled');
              $("#video_add_error").show();
              $("#video_add_error").html("Please follow video link sample and enter specific video link");
            }
          }

    if($('#title').val()!='') 
    { 

      $.post("{{url('trainer/cheeckexercisecategory_edit')}}",$('#exerciseeditform').serialize(), function(data){
            if(data==1)
            { 
              $('.btn-primary').attr('disabled','disabled');
              $("#duplicate_category").show();
              $("#duplicate_category").html("Duplicate category name is not allow");
            }
            else
            { 
              $('.btn-primary').removeAttr('disabled');
              $("#duplicate_category").hide();
            }
  });
      }          
  }


  $(document).ready(function() {

    $.validator.addMethod("multipeFieldValidator", function(value) {  
    if($("#image").val() && $("#video").val()) { 
        
      return false;
    }
    return true; 
}, 'Either image or video is required');


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
  
  "image": {
              required: 
              function() {
                  //returns true if video & previous image is empty   
                  if(!$("#video").val() && !$("#oldimage").val() && !$("#image").val()){
                    return true;
                  }else{
                    return false;
                  }
              },
              multipeFieldValidator:true
            },
  "video": {
              required: 
              function() {
                  //returns true if video is empty   
                  if(!$("#video").val() && !$("#oldimage").val() && !$("#image").val()){
                    return true;
                  }else{
                    return false;
                  }
              },
              multipeFieldValidator:true
            }
},

////for show error message
messages: {
  "title":{
    required: 'Please enter category'
  },
  "description":{
    required: 'Please enter description' 
  },
  "image": "Image is required if no video is given",
  "video": "Video is required if no image is given"
  
}
});

  
});
</script>




<script>
  $(document).ready(function(){
    $("#image").change(function(){ 
      /// check the extension of image
      var ext = $('#image').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
        alertify.alert('Only accept gif/png/jpg/jpeg extension formats of image');
        $("#image").val('');
        return false;
      }

      /// check the size of image

      var fileSize = (this.files[0].size / 1024); //size in KB
      if (fileSize > 250) /// not more than 30 kb
      {
         alertify.alert("Please Upload maximum 250KB file size of image");// if Maxsize from Model > real file size
          $("#image").val('');
          return false;
      }

      // show image after upload
      if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#profile_thumbnail').attr('src', e.target.result);
          $('#recently_uploaded_image').val(true);
          $('#video').val('');
          }
          $("#profile_thumbnail").show();
          reader.readAsDataURL(this.files[0]);
        }
    });
  });
</script>

@if(Auth::user()->master_trainer==1)

<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Edit Exercise Details</h1>
      </div>
    </div>
  </div>    
</div>

 


<div class="col-lg-12">
  <div class="card">
    <div class="card-body card-block">
      <form action="{{route('updateexercise')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="exerciseeditform">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" id="id" value="{{$data->id}}">
        <input type="hidden" name="trainer_id" value="{{Auth::user()->id}}">
        <div class="row form-group">
          <div class="col col-md-3"><label for="text-input" class=" form-control-label">Category<span class="required_field_color">*</span></label></div>
          
          <div class="col-12 col-md-9"><input type="text" id="title" name="title" placeholder="Category" class="form-control" value="{{$data->title}}" onkeyup=" return add_exercise_fun()">
             
            <div id="duplicate_category">     
            
            </div>
            
            <level>Note: Personal Trainer ,Boot camp trainer, Yoga, Gymnastic, Cycling, Boxing etc.</level>
          </div> 
        </div>
        <div class="row form-group">
          <div class="col col-md-3">
            <label for="text-input" class=" form-control-label">Description<span class="required_field_color">*</span></label></div>
            <div class="col-12 col-md-9">
              <textarea id="description" name="description" placeholder="Description" class="form-control" style="height: 105px;resize: none;">{{$data->description}}</textarea>
            </div>
          </div>
          <div class="row form-group">
              <div class="col col-md-3"><label for="text-input" class="form-control-label"> Video Link<span class="required_field_color">*</span></label></div>
              <div class="col-12 col-md-9"><input type="text" id="video" name="video" placeholder="Video Link" class="form-control" value="{{$data->video}}"  onkeyup=" return add_exercise_fun()">
                <div id="video_add_error"></div>
              <level>Video Link Sample:-https://www.youtube.com/embed/P_SZpxUx3xw or https://youtube.com/watch?v=WOsXayVmnoc</level></div>
          </div>
          <div class="row form-group">
            <div class="col col-md-3">
              <label for="file-input" class=" form-control-label">Image<span class="required_field_color">*</span>
              </label>
            </div>
            <div class="col-12 col-md-4">                         
              <input type="file" id="image" name="image" class="form-control-file" >
              <input type="hidden" id="oldimage" name="oldimage" class="form-control-file" value="{{$data->image}}">
            </div>
            <div class="col-12 col-md-5">
              @if(isset($data->image) && !empty($data->image))                         
                <img id="profile_thumbnail" src="{{asset('backend/images')}}/{{$data->image}}" alt="Excersise Image" width="100"/>
              @else
                <img id="profile_thumbnail" src="" alt="Excersise Image" width="100" style="display: none;"/>
                @endif
                <input type="hidden" id="recently_uploaded_image" name="recently_uploaded_image" value="false">
            </div>
            <!-- <div class="pic-case-upload">
              <img id="profile_thumbnail" src="{{asset('backend/images')}}/{{$data->image}}" alt="profile image" width="100"/>
            </div> -->
          </div>
          <div class="row form-group">
            <div class="col col-md-10">
            </div>
            <div class="col col-md-2">
              <button type="submit" name="submit" class="btn btn-primary" data-loading-text="Please wait...">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endif


  @endsection