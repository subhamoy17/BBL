<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')
@section('content')
@if(Auth::user()->master_trainer==1)
<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
    $('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],

// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,6,7,8] } ],

});
});

</script>

@else
<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
    $('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],

// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,5,6,7] } ],

});
});

</script>

@endif
<script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
                          $('.alert-success').hide();
                      }, 5000);
  setTimeout(function(){ 
                          $('.alert-danger').hide();
                      }, 50000);
});
</script>
<style>

.button-primary {
  background: #d16879;
  color: #FFF;
  padding: 10px 20px;
  font-weight: bold;
  border:1px solid #FFC0CB; 
}

.div {
    height:200px;
    background-color:red;
}
#loading-img {
  background: url(../backend/images/loader-gif-transparent-background-4.gif) center no-repeat / cover;
    display: none;
    height: 100px;
    width: 100px;
    position: absolute;
    top: 50%;
    left: 1%;
    right: 1%;
    margin: 0 auto;
    z-index: 99999;
}

.group {
    position: relative;
    width: 100%;
}
.card-body{
  
}

.order-show-icon
{
  display: inline-block;
    float: left;
    margin-left: 2px;
    margin-top: 2px;
}

.btn-booking-seat
{
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;

  }

</style>

<style>
.ptbtn-rmv{
    color: #fff;
    background-color: #db2828;
    border-color: #db2828;
  }
</style>

<script>
  function cancel_customer_booking(id){ 
      alertify.confirm("Are you sure you want to cancel booking for this schedule?", function (e) {
          if (e) {
              // alertify.success("You've clicked OK");
              window.location.href="{{url('trainer/personal-training-booking-cancel')}}/"+id;
          } else {
              // alertify.error("You've clicked Cancel");
          }                                       
      });
  }
</script>

<div class="breadcrumbs">
    <div class="col-md-8">
        <div class="page-header float-left">
            
                <h1>
                  @if(Auth::user()->master_trainer==1)
                    All Personal Training Plan Calender Schedule
                  @else
                    Your Personal Training Plan Calender Schedule
                  @endif
                  </h1>
          </div>  
    </div>
    <div class="col-md-4">
        <div class="page-header float-right">
          <h1>
                    <form id="feature_form_id" method="get">
                      <select id="feature" name="option" class="form-control">
                        <option value="all_schedule" {{Request::segment(2)=='personal-training-plan-schedule'?'selected':''}} >All Schedules</option>
                        <option value="future_schedule" {{Request::get('option')=='future_schedule'?'selected':''}} >Future Schedules</option>
                        <option value="past_schedule" {{Request::get('option')=='past_schedule'?'selected':''}} >Past Schedules</option>
                        <option value="cancelled_schedule" {{Request::get('option')=='cancelled_schedule'?'selected':''}} >Cancelled Schedules</option> 
                        <option value="future_booking" {{Request::get('option')=='future_booking'?'selected':''}} >Future Booking</option> 
                        <option value="past_booking" {{Request::get('option')=='past_booking'?'selected':''}} >Past Booking</option>
                        <option value="cancelled_booking" {{Request::get('option')=='cancelled_booking'?'selected':''}} >Cancelled Booking</option>
                        <option value="declined_booking" {{Request::get('option')=='declined_booking'?'selected':''}} >Declined Booking</option>         
                      </select>
                    </form>
            </h1>
          </div>  
    </div>
</div>

<div class="content mt-3" style="margin-top: 0px !important;">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div id="loading-img"></div>
        <div class="card">
          <div class="card-header" style="padding-left: 0px;padding-right: 0px;padding-bottom: 0px;padding-top: 10px;">
            @if (session('cancelled_by_trainer_success'))
              <div class="alert alert-success">
                  {{ session('cancelled_by_trainer_success') }}
              </div>
            @endif
            @if (session('cancelled_by_trainer_unsuccess'))
              <div class="alert alert-danger">
                  {{ session('cancelled_by_trainer_unsuccess') }}
              </div>
            @endif

            @if (session('trainer_change_success'))
              <div class="alert alert-success">
                  {{ session('trainer_change_success') }}
              </div>
            @endif

            
          <div class="card-body">
             <form id="canncele_form" method="post">

              <input type="hidden" name="cancelled_reason" id="cancelled_reason">
           <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">



              <thead>
                  <tr>
                    @if(Auth::user()->master_trainer==1)
                   <th  colspan="8"></th>
                   @else
                   <th  colspan="7"></th>
                   @endif
                    <th style="float: center;">
                       
  
  <button class="btn btn-danger" id="cancelled_button" title="Delete Schedule"><i class="fa fa-trash-o" ></i></button>

                    </th>
                  
                  </tr>
                <tr>
                 
                  <th style="width: 3%;">Sl. No.</th>
                  <th>Date</th>
                  <th>Day</th>
                  @if(Auth::user()->master_trainer==1)
                  <th>Trainer Name</th>
                  @endif
                  <th>Time</th>
                  <th style="width: 116px;">Address</th>
                  <th>Status</th>
                   <th style="width: 130px;">Action</th> 
                    <th style="width: 100px;">Select to Declined 
                    <input type="checkbox" id="all_schedule_cancel" class="selectall" style="margin-left: 21px">
                  </th>
                </tr>
              </thead>
              <tbody class="tbdy1"> 
               @if(count($all_schedules)>0)
                  @foreach($all_schedules as $key=>$each_schedule)
                    <tr>
                   
                      <td align="center">{{++$key}}</td>
                      <td>{{$each_schedule->plan_date}}</td>
                      <td>{{substr($each_schedule->plan_day,0,3)}}</td>
                      @if(Auth::user()->master_trainer==1)
                      <td>{{$each_schedule->trainer_name}}</td>
                      @endif
                      <td>{{date("h:i A", strtotime($each_schedule->start_time))}} to {{date("h:i A", strtotime($each_schedule->end_time))}}</td>
                      <td>{{$each_schedule->address_line1}}</td>
                      <td align="center">
                        @if($each_schedule->deleted_at!='')
                        <i class="fa fa-ban btn-del" title="Cancelled Schedule"></i>
                        @else
                        <i class="fa fa-check-circle btn-act"  title="Active Schedule"> 
                        @endif
                      </td>
                      
                      <td class="td-btn5" align="center">

                        
                        @if($each_schedule->customer_name!='')
                        <button type="button" class="btn btn-danger status-all btn-sm" onclick="cancel_customer_booking({!!$each_schedule->schedule_id!!})" style="width: 32px;" title="Cancel Booking"><i class="fa fa-remove"></i></button>
                        @endif
                       
                         @if($now <= $each_schedule->plan_date && $each_schedule->deleted_at=='' && Auth::user()->master_trainer==1)
                        
                       <a href="{{route('pt_schedule_trainer_edit',['id' => Crypt::encrypt($each_schedule->schedule_id) ])}}" class="btn btn-primary btn-sm" title="Change Trainer"><i class="fa fa-edit" title="Change Trainer"></i></a>
                        @endif
                        @if($now <= $each_schedule->plan_date && $each_schedule->deleted_at=='' && $each_schedule->customer_name=='')
                          <a href="{{route('add_pt_session_from_schedule',['id' => Crypt::encrypt($each_schedule->schedule_id) ])}}" class="btn btn-booking-seat btn-sm"><i class="fa fa-ticket" title="Booking Schedule"></i></a>
                          @endif
                        @if($each_schedule->deleted_at=='' && $each_schedule->customer_name!='')
                          <a class="detail-orders-modal-btn1 btn btn-info btn-sm" href="javascript:void(0);">
                          <i class="fa fa-eye" title="{{$each_schedule->customer_name}}, {{$each_schedule->customer_email}}, {{$each_schedule->customer_ph_no}}" aria-hidden="true" style="width: 14px; height: 14px;"></i></a>
                        @endif
                        @if($now <= $each_schedule->plan_date && $each_schedule->deleted_at=='')
                      <button type="button" title="Delete Schedule" class="btn btn-danger status-all btn-sm single-pt-schedule"   id="{!!$each_schedule->schedule_id!!}" data-msg="Decline"><i class="fa fa-trash-o"></i></button>
                        @endif
                      </td>
                         <td>
                        @if($now <= $each_schedule->plan_date && $each_schedule->deleted_at=='')
                        <input type="checkbox" name="cancele_schedule[]" id="cancele_schedule" value="{{$each_schedule->schedule_id}}" class="cancele_check abc" style="margin-left: 27px">                    
                         @else
                          &nbsp;&nbsp;&nbsp;&nbsp;---
                        @endif
                      </td> 
                    
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </form>
          </div>      
        </div>
      </div>
    </div>
  </div><!-- .animated -->
</div>
<!-- .content -->
<!-- cancelled reason modal start-->

<div id="reason_modal" class="modal fade mot-mod" role="dialog" >
  <div class="modal-dialog success_modal">
    <input type="hidden"  id="reason_id"></input>
    <div class="modal-content">
    <div class="modal-header">
      <h2 style="font-size: 20px;text-align: center;">Comment your decline reason</h2>
      
    </div>
      <div class="modal-body" id="hall_details_edit">
<div class="row clearfix">
          <div class="col-xs-12 divi-line">
          </div><br/>
          <div class="col-sm-9 col-xs-12">
            <div class="form-group" align="center">
              <textarea class="form-control" rows="3"   id="comment"></textarea>
            </div>
          </div>
        </div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-success" data-dismiss="modal" id="reason">Comment Submit</button>
</div>
</div>
</div>
</div>

<!-- cancelled reason modal end-->

<script src="{{asset('backend/assets/js/lib/data-table/datatables.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/jszip.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/pdfmake.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/vfs_fonts.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/buttons.html5.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/buttons.print.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/buttons.colVis.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/datatables-init.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>


<script type="text/javascript">
  $("#bootstrap-slot-data-table").on("click", ".selectall", function() {
    $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
});
 
 
      $("#bootstrap-slot-data-table").on("change", ".abc", function() {
        $('.abc:checked').length == $('.abc').length;
    if ($('.abc:checked').length == $('.abc').length) {
       
       $("#all_schedule_cancel"). prop("checked", true);
    }
    else{
      $("#all_schedule_cancel"). prop("checked", false);
    }
});
</script>
<script>
$(document).ready(function (){
   var table = $('#bootstrap-data-table-export').DataTable({

   });

   // Handle form submission event
   $('#canncele_form').on('submit', function(event){ 
      // Prevent actual form submission
      event.preventDefault();
      var cancele_check = $('.cancele_check:checkbox');
            if(cancele_check.length > 0) { ;
                if( $('.cancele_check:checkbox:checked').length < 1) {
                    alertify.alert('Please select at least one schedule to declined');
                    cancele_check[0].focus();
                    return false;
                }
            }
            else if($('.cancele_check:checkbox:checked').length==0 && $('.selectall:checkbox:checked').length==1)
                {
                   alertify.alert('Please select at least one schedule to declined');
                    cancele_check[0].focus();
                    return false;
                }

      alertify.confirm("Are you sure you want to declined all selected shedule?", function (e) {
          if (e) {
            $('#reason_modal').modal('show');
          }
          else
          {
          }
        });

      $("#reason").on('click',function()
    {   
      var comment=$('#comment').val();
      if(comment.trim()=="")
      {
        alertify.alert("Reason is required for decline schedule");
        $('#reason_modal').modal('show');
        return false; 
      }
      else
      {
        $(".card-body").css("opacity", .2);
        $("#loading-img").css({"display": "block"});
        var cancelled_reason=$('#cancelled_reason').val($('#comment').val());
      // Submit form data via Ajax

      $.ajax({
         url: '{{url("trainer/personal-training-delete-multiple-schedule")}}',
         data: $('#canncele_form').serialize(),
         success: function(data){
          if(data=='success')
          {
            alertify.alert("Your selecting schedule cancellation is done");
          }
          else
          {
            alertify.alert("Something went wrong!");
          }
            location.reload();
         }
      });
    }
});
   });
});

</script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#bootstrap-slot-data-table").on("click", ".single-pt-schedule", function(e) {
        alertify.confirm("Are you sure you want to cancel this shedule?", function (e) {
          if (e) {
            var Data =
        {
          'id': id,
        }
      $.ajax({
         url: '{{url("trainer/personal-training-delete-single-schedule")}}',
        
          data:
          {
            'data': Data,
          },
         success: function(data){
          if(data=='success')
          {
            alertify.alert("Your selecting schedule cancellation is done");
          }
          else if(data=='unsuccess')
          {
            alertify.alert("Your selecting schedule cancellation is already done by another trainer");
          }
          else
          {
            alertify.alert("Something went wrong! Please try again");
          }
          location.reload();
         }
      });
          }
          else
          {
          }
        });
      
    });
  });

</script>

<script>

$(document).ready(function(){
   $('#feature').change(function(){
       $('#feature_form_id').submit();
    });
});
</script>
@endsection
