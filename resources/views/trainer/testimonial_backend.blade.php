
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


$('#traineraddform').validate({  
  /// rules of error 
  rules: {
    "name": {
      alpha:true,
      minlength:6,
      required: true
    },
   "designation": {
      required: true
    },
   
   "description": {
      required: true
    }



  },

  messages: {
    "name":{
    required: 'Please enter your name',
    minlength:'Minimum length 6 is required'
  },
 
  "description":{
    required: 'Please enter your description' 
  },
  
"designation":{
    required: 'Please enter your designation' 
  }


}
  });
  
  //show uploading image and check validation of image

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
    if (fileSize >50) /// not more than 30 kb
    {
        alertify.alert("Please Upload maximum 50KB file size of image");// if Maxsize from Model > real file size
        $("#image").val('');
        return false;
    }

    //show image after upload
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
                        <h1>Add New Testimonial</h1>
                    </div>
                </div>
            </div>    
</div>
        <div class="col-lg-6">
        <div class="card">
        	   @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                      <div class="card-body card-block">
                        <form action="{{route('testimonial_insert')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="traineraddform">

                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label"> Name<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="name" name="name" placeholder="Name" class="form-control" value="">
                            </div>
                          </div>
                          
                          	  <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Designation<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input type="text" id="designation" name="designation" placeholder="Designation" class="form-control" value="">
                            </div>
                          </div>



                          <div class="row form-group">
                            <div class="col col-md-3">
                              <label for="text-input" class=" form-control-label">Description<span class="required_field_color">*</span></div>
                            <div class="col-12 col-md-9">
                              <textarea id="description" name="description" placeholder=" Description" class="form-control"></textarea>
                            </div>
                          </div>
                          

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="file-input" class=" form-control-label">Profile Image</label></div>
                            <div class="col-12 col-md-9">
                              <input type="file" id="image" name="image" class="form-control" >
                              <img id="profile_thumbnail" height="150"  width="200">
                            </div>
                          </div>
                            <div>
                                <button type="submit"  name="submit" class="btn btn-primary btn-sm">
                                  <i class="fa fa-dot-circle-o"></i> Submit
                                </button>
                            </div>
                        </form>
                      </div>
                    </div>
                    </div>


  <?php  ?>
      @if(!empty($table_data))
      <div class="card-body card-block">
        <table>
          <thead>
            <tr>
              <th><strong>Name</strong></th>
              <th><strong>Designation</strong></th>
               <th><strong>Description</strong></th>
              <th><strong>Image</strong></th>
            </tr>
          </thead>
          <tbody>
            @foreach($table_data as $key=>$single_data)
            <tr>
              <td>{{ $single_data->name }}</td>
              <td>{{ $single_data->designation }}</td>
              <td>{{ $single_data->description }}</td>
               <td><img src="{{url($single_data->image)}}" width="100%" ></td>
            </tr>
            @endforeach 
          </tbody>
        </table>
      </div>
      @endif   







@endsection
