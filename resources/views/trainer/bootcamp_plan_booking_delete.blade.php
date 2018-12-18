<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')
@section('content')

<script>
  $(document).ready(function(){
  $('#submit_bootcamp_delete').validate({  
      /// rules of error 
      rules: {
        "delete_date": {
          required: true
        }
      },
      ////for show error message
      messages: {
        "delete_date":{
          required: 'Please choose date'
        }
      }
    });

    });
</script>
@if(Auth::user()->master_trainer==1)

  <div class="breadcrumbs">
    <div class="col-sm-8">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Delete Plan Details</h1>
                <h1>{{$plan_details->plan_st_date}} to {{$plan_details->plan_end_date}}</h1>
            </div>
        </div>
    </div>   
</div>

<div class="breadcrumbs">
    <div class="col-sm-12">
        <div class="page-header float-left">
            <div class="page-title alert-danger">
                <h1>There are some bookings for this bootcamp plan upto {{$last_booking_date}} and from {{$first_no_booking_schedule_date}} to {{$last_no_booking_schedule_date}} are no bookings. You choose the date from below and delete schedule as well as cancele bookings.</h1>
            </div>
        </div>
    </div>   
</div>



<div class="content mt-3" style="margin-top: 0px !important;">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          @if (session()->has('success'))
              <div class="alert alert-success">
                {{ session()->get('success') }}
              </div>
            @endif
          <div id="loading-img"></div>
            <div class="card-body">
           <form  action="{{route('bootcamp_plan_final_delete')}}" class="slct-margin" id="submit_bootcamp_delete" method="post" autocomplete="off">
          {{ csrf_field() }}

          <input type="hidden" name="plan_id" value="{{$plan_details->id}}">
        
        <div class="row form-group">
          <div class="col-lg-3">
            <input type="text" id="delete_date" name="delete_date" class="form-control" readonly="true" placeholder="Date">
          </div>
          <div class="col-lg-3">
            <button  id="active_order_submit" class="btn btn-primary pull-right" style="width: 100px;">Delete</button>
          </div>
        </div>
      </form>
        
            </div>
      



                    </div>
                 
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div>
    <!-- .content -->


<script>
  $(function () {
    $( "#delete_date" ).datepicker({
      dateFormat: "yy-mm-dd",
      beforeShowDay: NotBeforeToday
    });
  } );

  function NotBeforeToday(date)
  {
    var now = new Date();//this gets the current date and time
    if (date.getFullYear() == now.getFullYear() && date.getMonth() == now.getMonth() && date.getDate() >= now.getDate())
        return [true];
    if (date.getFullYear() >= now.getFullYear() && date.getMonth() > now.getMonth())
       return [true];
     if (date.getFullYear() > now.getFullYear())
       return [true];
    return [false];
  }


</script>

@endif
@endsection

