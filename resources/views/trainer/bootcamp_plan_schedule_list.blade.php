<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')
@section('content')

<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
    $('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],

// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,1,8,9] } ],

});
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


@if(Auth::user()->master_trainer==1)
<div class="breadcrumbs">
    <div class="col-md-8">
        <div class="page-header float-left">
            
                <h1>All Bootcamp Plan Calender Schedule</h1>

        </div>
    </div>
    <div class="col-md-4">
        <div class="page-header float-right">
            
                <h1>

                 <form id="feature_form_id" method="get">
                      <select id="feature" name="option" class="form-control">
                        <option value="all_schedule" {{Request::segment(2)=='bootcamp-plan-schedule'?'selected':''}} >All Schedules</option>
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
            
          <!-- </div>  onsubmit="return checkTheBox();" -->
          <div class="card-body">
             <form id="canncele_form" method="post">

              <input type="hidden" name="cancelled_reason" id="cancelled_reason">
           <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">



              <thead>
                  <tr>
                   <th  colspan="9"></th>
                    <th style="float: center;">
                       
  
  <button class="btn btn-danger" id="cancelled_button" title="Delete Schedule"><i class="fa fa-trash-o" ></i></button>

                    </th>
                  
                  </tr>
                <tr>
                 
                  <th style="width: 3%;">Sl. No.</th>
                  <th>Date</th>
                  <th>Day</th>
                  <th>Time</th>
                  <th style="width: 116px;">Address</th>
                  <th>Maximum Allowed</th>
                  <th>Booking Seats</th>
                  <th>Status</th>
                   <th style="width: 114px;">Action</th> 
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
                      <td>{{date("H:i", strtotime($each_schedule->plan_st_time))}} to {{date("H:i", strtotime($each_schedule->plan_end_time))}}</td>
                      <td>{{$each_schedule->address_line1}}</td>
                      <td align="center">{{$each_schedule->max_allowed}}</td>
                      <td align="center">
                        @if($each_schedule->deleted_at=='' && $each_schedule->no_of_uses>0)
                        
                          <a href="{{route('bootcamp_booking_individual_cancelled',['plan_id' => Crypt::encrypt($each_schedule->schedule_id) ])}}" title="Veiw all booking" class="btn-del" style="color: #fff; background-color: #FF6347;   border-color: #FF6347;">{{$each_schedule->no_of_uses}}</a>
                        @else
                        {{$each_schedule->no_of_uses}}
                        @endif
                      </td>
                      <td align="center">
                        @if($each_schedule->deleted_at!='')
                        <i class="fa fa-ban btn-del" title="Cancelled Schedule"></i>
                        @else
                        <i class="fa fa-check-circle btn-act"  title="Active Schedule"> 
                        @endif
                      </td>
                      
                      <td class="td-btn5" align="center">
                       
                         @if($now <= $each_schedule->plan_date && $each_schedule->deleted_at=='')
                        
                       <a href="{{route('bootcamp_schedule_edit_view',['id' => Crypt::encrypt($each_schedule->schedule_id) ])}}" class="btn btn-primary btn-sm" title="Edit Schedule"><i class="fa fa-edit" title="Edit Schedule"></i></a>

                        <a href="{{route('add_bc_session_from_schedule',['id' => Crypt::encrypt($each_schedule->schedule_id) ])}}" class="btn btn-booking-seat btn-sm"><i class="fa fa-ticket" title="Booking Schedule"></i></a>

                      <button type="button" title="Delete Schedule" class="btn btn-danger status-all btn-sm"  id="{{$each_schedule->schedule_id}}" data-msg="Decline"><i class="fa fa-trash-o"></i></button>

                       
                         @else
                          ---
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
@endif

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

<!-- <script type="text/javascript">
  function checkTheBox() {
    var flag = 0;
    for (var i = 0; i< 5; i++) {
      if(document.myform["cancele_schedule[]"][i].checked){
        flag ++;
      }
    }
    if (flag != 1) {
      alert ("You must check one and only one checkbox!");
      return false;
    }
    return true;
  }
</script> -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    } );
</script>

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
         url: '{{url("trainer/bootcamp-schedule-cancelled")}}',
         data: $('#canncele_form').serialize(),
         success: function(data){
            alertify.alert("Your selecting schedule cancellation is done");
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
    $("#bootstrap-slot-data-table").on("click", ".status-all", function(e) {
      var action = $(this).data("msg");
      console.log(action);
      var row = this.closest('tr');
      if (action == "Decline"){
        $('#reason_id').val('');
        $('#reason_id').val(this.id);
        $('#reason_action').val(action);
        $('#comment').val('');
        alertify.confirm("Are you sure you want to delete this shedule?", function (e) {
          if (e) {
            $('#reason_modal').modal('show');
          }
          else
          {
          }
        });
      }
      
    });
  $("#reason").on('click',function()
    {   
      var id=$('#reason_id').val();
       console.log(id);
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

     var Data =
        {
          'id': id,
          
          'comment':comment
        }
        console.log(Data);

      $.ajax({
         url: '{{url("trainer/bootcamp-schedule-cancelled2")}}',
        
          data:
          {
            'data': Data,
          },
         success: function(data){
            alertify.alert("Your selecting schedule cancellation is done");
            location.reload();
         }
      });
    }
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
