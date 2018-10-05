<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<script type="text/javascript">

  $(document).ready(function(){
    $('#add_slot').validate({  
/// rules of error 
rules: {

  "apply2":
  {
    required: true,
     // email:true
  },

  "trainer_id":
  {
    required: true,
  },

  "slots_datepicker":
  {
    required: true,
  },
  "slot_time":
  {
    required: true,
  } 

},

messages: {

  "apply2":
  {
    required: "Please select a customer name",
     // email: "Please enter valid email id"
  },

  "trainer_id":
  {
    required: "Please select a trainer name"
  },
  "slots_datepicker":
  {
    required: "Please select a date"
  },
  "slot_time":
  {
    required: "Please select a time"
  }



}
});

  });
</script>


@if(Auth::user()->master_trainer==1)

<div class="tab_container">
  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  <?php Session::forget('success'); ?>
  @endif
  @if (session('danger'))
  <div class="alert alert-danger">
    {{ session('danger') }}
  </div>

  <?php Session::forget('danger'); ?>
  @endif


  <div class="breadcrumbs">
    <div class="col-sm-4">
      <div class="page-header float-left">
        <div class="page-title">
          <h1>Add Customer's Session Request</h1>
        </div>
      </div>
    </div>    
  </div>

  <div class="form-box">

<!--  <form  method="get" enctype="multipart/form-data" class="form-horizontal" id="cus_search">
<div class="col-md-6 col-sm-12 col-xs-12">
<input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="form-group" >
<label>Customer Email<small>*</small></label>
<input type="text" name="cust_email"  id="cust_email" value="">
</div> 
<button type="submit" name="submit" class="btn btn-dark btn-theme-colored btn-flat btn-drk2 save_button"  id="search_cus">Search</button>
</div>
</form> -->



  <form action="{{route('trainer_slotinsert')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="add_slot">
    <div class="col-md-12 col-sm-12 col-xs-12" style="width:100%" >
      <input type="hidden" name="_token" value="{{csrf_token()}}">

      <div class="col-md-6 col-sm-12 col-xs-12" >
        <div class="form-group">
          <label>Location<small class="required_field_color">*</small></label>
          <select class="form-control" >
            <option value="Basingstoke">Basingstoke</option>

          </select>



        </div>
      </div>


<div class="col-md-6 col-sm-12 col-xs-12">
  <div class="form-group">
    <label>Customer Name<small class="required_field_color">*</small></label>


    <input type="text" id="apply2" name="apply2" placeholder="Please select customer name" class="form-control apply2 required" >

    <input type="hidden" id="apply3" name="apply3" >

  </div>
</div>
<div class="col-md-6 col-sm-12 col-xs-12">
  <div class="form-group">


    <label>Trainer Name <small class="required_field_color">*</small></label>
    <select class="form-control" name="trainer_id" id="trainer_id" onchange="jsfunction()">
      <option value=""> Please select a name</option>
      @foreach($data as $mydata)
      <option value="{{$mydata->id}}"> {{$mydata->name}}</option>
      @endforeach
    </select>



  </div>
</div>
<div class="col-md-6 col-sm-12 col-xs-12">
<div class="row"  id="mail" style="display: none;">
        
          <div class=" col-lg-12">
              <div  id="cus_e" name="cus_e" class="col-lg-12 asd">
           
           </div>
          </div>
        </div>
      </div>

<div class="col-md-6 col-sm-12 col-xs-12 datepicker_trainer">
  <label>Date <small class="required_field_color">*</small></label>
  <input type="text" id="slots_datepicker" name="slots_datepicker" class="form-control slots_date_trainer" onchange="jsfunction()" readonly="true">
</div>
<div class="clearfix"></div>
<div class="col-md-6 col-sm-12 col-xs-12">
  <div class="form-group" >
    <label>Available Time <small class="required_field_color">*</small></label>
    <select class="form-control" name="slot_time" id="slot_time">

    </select>
  </div>

</div>

<div  class="col-md-6 col-sm-12 col-xs-12" id='loadingimg' style='display:none'>
  <div class="form-group" >
    <img src="{{asset('backend/images/loader-gif-time.gif')}}" style="width: 70px;margin-top: 10px;margin-left: -8px;"/>
  </div>
</div>


<div id="old_session_data">
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <input name="form_botcheck" class="form-control" value="" type="hidden">
    <input type="hidden" id="session_no" name="session_no" value="1">
    <button type="submit" name="submit" class="btn btn-dark btn-theme-colored btn-flat btn-drk2 save_button"  id="save_btn">Book Session</button>
  </div>

</div>

</div>
</form>
 
</div>

</div>
@endif

@endsection

