<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<script>
  //// Check diet plan is duplicate or not ////
  function  dietplan_name_check()
  {  
   
    if($('#diet_plan_name').val()!='') 
    { 

      $.post("{{url('trainer/checkDietPlan_duplicate')}}",$('#dietPlanAddform').serialize(), function(diet){
            if(diet==1)
            { 
              $('.btn-primary').attr('disabled','disabled');
              $("#duplicate_dietPlanName").show();
              $("#duplicate_dietPlanName").html("Duplicate diet plan name is not allow");
            }
            else
            { 
              $('.btn-primary').removeAttr('disabled');
              $("#duplicate_dietPlanName").hide();
            }
      });
    }      
  }
</script>

<script>

  //// Validation for valid video link upload ////
  function  add_videoLink_fun()
  { 
    if($('#video').val()!='')
    {
      var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
              var match = $("#video").val().match(regExp);
              if (match && match[2].length == 11) 
              { 
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
  }
</script>
  
<script>

//// Image validation ////
$(document).ready(function(){
  $("#common_diet_image").change(function(){ 

    // check the extension of image
    var ext = $('#common_diet_image').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    alertify.alert('Only accept gif/png/jpg/jpeg extension formate of image');
    $("#common_diet_image").val('');
    $("#profile_thumbnail").hide();
    return false;
    }

    // check the size of image
    var fileSize = (this.files[0].size / 1024); //size in KB
    if (fileSize >200) /// not more than 200 kb
    {
        alertify.alert("Please Upload maximum 200KB file size of image");// if Max size from Model > real file size
        $("#common_diet_image").val('');
        $("#profile_thumbnail").hide();
        return false;
    }
    
    // check height and width of author image 
    var _URL = window.URL || window.webkitURL;  
      var file, img;
      if ((file = this.files[0])){
          img = new Image();
          img.onload = function () {
              var height = this.height;
              var width = this.width;
              if( height >200 && width >300){
                alertify.alert("Height and Width must not exceed 200px and 300px");
                $("#common_diet_image").val('');
                $("#profile_thumbnail").hide();
                return false;
              }
          };
           img.src = _URL.createObjectURL(file);
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

    
  $("#video").change(function(){
  // for blank image if video insert
        $('#recently_uploaded_video').val(true);
        $('#common_diet_image').val('');
        $("#profile_thumbnail").hide();
  });

});
</script>

<script>

  //// Author image validation ////
  $(document).ready(function(){
  $("#author_image").change(function(){ 

    // check the extension of author image
    var ext = $('#author_image').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    alertify.alert('Only accept gif/png/jpg/jpeg extension formate of image');
    $("#author_image").val('');
    // $("#profile2_thumbnail").hide();
    return false;
    }

    // check the size of author image
    var fileSize = (this.files[0].size / 1024); //size in KB
    if (fileSize >200) /// not more than 200 kb
    {
        alertify.alert("Please Upload maximum 200KB file size of image");// if Maxsize from Model > real file size
        $("#author_image").val('');
        // $("#profile2_thumbnail").hide();
        return false;
    }

    // check height and width of author image
    var _URL = window.URL || window.webkitURL;  
      var file, img;
      if ((file = this.files[0])){
          img = new Image();
          img.onload = function () {
              var height = this.height;
              var width = this.width;
              if( height >200 && width >300){
                alertify.alert("Height and Width must not exceed 200px and 300px");
                $("#author_image").val('');
                // $("#profile2_thumbnail").hide();
                return false;
              }
          };
           img.src = _URL.createObjectURL(file);
      }

    // show author image after upload
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#profile2_thumbnail').attr('src', e.target.result);
        $('#recently_uploaded2_image').val(true);
        }
        $("#profile2_thumbnail").show();
        reader.readAsDataURL(this.files[0]);
      }
  }); 

});
</script>

<script>

  //// PDF validation ////
  $(document).ready(function(){
  $("#diet_plan_pdf").change(function(){ 

      // check the extension of pdf
      var ext = $('#diet_plan_pdf').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['pdf']) == -1) {
      alertify.alert('Only accept file with pdf extension');
      $("#diet_plan_pdf").val('');
      $("#Pdf_button").hide();
      return false;
      }
      else{
        $("#Pdf_button").show();
      }

      // check the size of pdf

      var fileSize = (this.files[0].size / 1024); //size in KB
      if (fileSize >7024) /// not more than 1 mb
      {
          alertify.alert("Please Upload maximum 6 MB file size of image");// if Maxsize from Model > real file size
          $("#diet_plan_pdf").val('');
          $("#Pdf_button").hide();
          return false;
      }
      else{
        $("#Pdf_button").show();
      }

    });

  });
</script>

<script>

  //// Validation for either image or video is require ////
  $(document).ready(function(){
  $.validator.addMethod("multipleFieldValidator", function(value) {  
    if($("#common_diet_image").val() && $("#video").val()) { 
        
      return false;
    }
    return true; 
  }, 'Either image or video is required');

});
</script>

<script>
$(document).ready(function(){
  $('#dietPlanAddform').validate({
  rules: {

    "diet_plan_name": {
      required: true,
      minlength:4
    },

    "description": {
      required: true
    },
    
    "common_diet_image": {
                required: 
                function() {
                    // returns true if video & previous image is empty   
                    if(!$("#common_diet_image").val() && $("#recently_uploaded_video").val() == "false")
                    {
                      return true;
                    }
                    else{
                      return false;
                    }
                },
                multipleFieldValidator:true
    },

    "video": {
                required: 
                function() {
                    //returns true if previous video & image is empty   
                    if(!$("#video").val() && $("#recently_uploaded_image").val() == "false"){
                      return true;
                    }
                    else{
                      return false;
                    }
                },
                multipleFieldValidator:true
              },

  "diet_plan_pdf": {
      required: true
    }, 
             
  "price": {
      required: true,
      number: true,
      range: [1, 99999.99]
    },

    "author_designation": {
      required: true
    }
  },  

  //for show error message
  messages: {
    "diet_plan_name":{
      required: 'Please enter diet plan name',
      minlength:'Minimum length 4 is required'
    },
    "description":{
      required: 'Please enter description' 
    },
    "common_diet_image": "Image is required if no video is given",
    "video": "Video is required if no image is given",
    "diet_plan_pdf":{
      required: 'Please enter diet plan pdf' 
    },
    "price":{
      required: 'Please enter price',
      number: 'Please enter only point and number of digits',
      range: "Please enter price between 1 to 99999.99"
    },
    "author_designation":{
      required: 'Please enter author designation'
    }
  }
});

});
</script>

<script>
  //// Create pdf button before insert value ////
    function PreviewPdf() {
        pdffile=document.getElementById("diet_plan_pdf").files[0];
        pdffile_url=URL.createObjectURL(pdffile);     
        window.open(pdffile_url);
    }
</script>

<script>

//// Add button disable ////
$(document).ready(function(){
  $('#dietPlanAddform').bind('submit', function (e) {
    var button = $('#deit_Add');

    // Disable the submit button while evaluating if the form should be submitted
    button.prop('disabled', true);

    var valid = true;    

    // Do stuff (validations, etc) here and set
    // "valid" to false if the validation fails

    if (!valid) { 
        // Prevent form from submitting if validation failed
        e.preventDefault();

        // Reactivate the button if the form was not submitted
        button.prop('disabled', false);
    }
});
});
</script>

<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Add Common Diet Plan</h1>
      </div>
    </div>
  </div>    
</div>

<div class="col-lg-12">
  <div class="card">
    <div class="card-body card-block">
      <form action="{{route('insert_common_diet_plan')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="dietPlanAddform" autocomplete="off">
        {{ csrf_field() }}
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="trainer_id" value="{{Auth::user()->id}}">
        
        <div class="row form-group">
          <div class="col col-md-3">
            <label for="text-input" class=" form-control-label">Diet plan name<span class="required_field_color">*</span></label>
          </div>
          <div class="col-12 col-md-9">
            <input type="text" id="diet_plan_name" name="diet_plan_name" placeholder="Diet plan name" class="form-control" onkeyup="return dietplan_name_check();">
            <div id="duplicate_dietPlanName"></div>
          </div>
        </div>

        <div class="row form-group">
          <div class="col col-md-3">
            <label for="text-input" class=" form-control-label">Description<span class="required_field_color">*</span></label>
          </div>
          <div class="col-12 col-md-9">
            <textarea id="description" name="description" placeholder="Description" class="form-control"  style="height: 105px;resize: none;"></textarea>            
          </div>
        </div>

        <div class="row form-group">
          <div class="col col-md-3">
            <label for="file-input" class=" form-control-label">Image<span class="required_field_color">*</span> </label>
          </div>
          <div class="col-12 col-md-4">
            <input type="file" id="common_diet_image" name="common_diet_image" class="form-control">
          </div>
          <div class="col-12 col-md-4">
            <img id="profile_thumbnail" height="100" width="150" style="display: none;" />
            <input type="hidden" id="recently_uploaded_image" name="recently_uploaded_image" value="false">
          </div>
        </div>
      
        <div class="row form-group">
          <div class="col col-md-3">
            <label for="text-input" class="form-control-label">Video Link<span class="required_field_color">*</span></label>
          </div>
          <div class="col-12 col-md-9">
            <input type="text" id="video" name="video" placeholder="Video Link" class="form-control" onkeyup="return add_videoLink_fun()">
            <div id="video_add_error"></div>
          </div>
          <div>
            <input type="hidden" id="recently_uploaded_video" name="recently_uploaded_video" value="false">
          </div>
        </div>

        <div class="row form-group">
            <div class="col col-md-3">
              <label for="file-input" class="form-control-label">Diet Plan PDF<span class="required_field_color">*</span></label>
            </div>
            <div class="col-12 col-md-4">
              <input type="file" id="diet_plan_pdf" name="diet_plan_pdf" class="form-control">
            </div>
            <div class="col-12 col-md-4">
              <button type="button" id="Pdf_button" onclick="PreviewPdf();" style="height: 100%; width: 30%; background: #FCF3CF; color: #5D6D7E; display: none;"><b> View PDF </b></button>
            </div>
        </div>

        <div class="row form-group">
          <div class="col col-md-3">
            <label for="text-input" class=" form-control-label">Price  (<i class="fa fa-gbp"></i>)<span class="required_field_color">*</span></label>
          </div>
          <div class="col-12 col-md-9">
            <input type="text" id="price" name="price" placeholder="Price" class="form-control" >
          </div>
        </div>

        <div class="row form-group">
          <div class="col col-md-3">
            <label for="text-input" class=" form-control-label">Author Name</label>
          </div>
          <div class="col-12 col-md-9">
            <input type="text" id="author_name" name="author_name" value="{{Auth::user()->name}}" readonly class="form-control">
          </div>
        </div>
     
        <div class="row form-group">
            <div class="col col-md-3">
              <label for="file-input" class=" form-control-label">Author Image
              </label>
            </div>
            <div class="col-12 col-md-4">                         
              <input type="file" id="author_image" name="author_image" class="form-control-file" >
              <input type="hidden" id="oldimage" name="oldimage" class="form-control-file" value="{{Auth::user()->image}}">
            </div>
            <div class="col-12 col-md-5">
              @if( isset(Auth::user()->image) && !empty(Auth::user()->image))                         
                <img id="profile2_thumbnail" src="{{asset('backend/images')}}/{{Auth::user()->image}}" alt="Author Image" width="100"/>
              @else
                <img id="profile2_thumbnail" src="" alt="Author Image" width="100" style="display: none;"/>
                @endif
                <input type="hidden" id="recently_uploaded2_image" name="recently_uploaded2_image" value="false">
            </div>
           
          </div>

        <div class="row form-group">
          <div class="col col-md-10">
          </div>
          <div class="col col-md-2">
            <button type="submit" id="deit_Add" name="submit" class="btn btn-primary" style="width: 100%;">Add Diet Plan</button>
          </div>
        </div>
          </form>
        </div>
      </div>
    </div>

<script src="{{url('js/parsley.js')}}"></script>
<script src="{{url('js/parsley.min.js')}}"></script>

@endsection