<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')
@section('content')

<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
    $('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],

// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,8] } ],

});
});

</script>

@if(Auth::user()->master_trainer==1)
<div class="breadcrumbs">
    <div class="col-sm-9">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>All Bootcamp Plan Schedule</h1>
            </div>
        </div>
    </div>
</div>
<div class="content mt-3" style="margin-top: 0px !important;">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header" style="padding-left: 0px;padding-right: 0px;padding-bottom: 0px;padding-top: 10px;">
            
          </div>
          <div class="card-body">
             <form id="canncele_form" method="post">
              <input type="hidden" name="cancelled_reason" id="cancelled_reason">
           <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
              <thead>
                <tr>
                  <th>Sl. No.</th>
                  <th>Date</th>
                  <th>Day</th>
                  <th>Time</th>
                  <th style="width: 116px;">Address</th>
                  <th>Maximum Allowed</th>
                  <th>No. of Uses</th>
                  <th>Status</th>
                  <th style="width: 181px;">Select to cancelled 
                    <input type="checkbox" id="all_schedule_cancel" class="selectall">
                    <button class="btn btn-success" id="cancelled_button">Cancelled</button>
                  </th>
                </tr>
              </thead>
              <tbody class="tbdy1"> 
               @if(count($all_schedules)>0)
                  @foreach($all_schedules as $key=>$each_schedule)
                    <tr>
                      <td>{{++$key}}</td>
                      <td>{{$each_schedule->plan_date}}</td>
                      <td>{{$each_schedule->plan_day}}</td>
                      <td>{{date("h:i A", strtotime($each_schedule->plan_st_time))}} to {{date("h:i A", strtotime($each_schedule->plan_end_time))}}</td>
                      <td>{{$each_schedule->address_line1}}</td>
                      <td>{{$each_schedule->max_allowed}}</td>
                      <td>{{$each_schedule->no_of_uses}}</td>
                      <td align="center">
                        @if($each_schedule->deleted_at!='')
                        <i class="fa fa-ban btn-del" title="Cancelled Schedule"></i>
                        @else
                        <i class="fa fa-check-circle btn-act"  title="Active Schedule"> 
                        @endif
                      </td>
                      
                      <td align="center">
                        @if($each_schedule->deleted_at=='')
                        <input type="checkbox" name="cancele_schedule[]" id="cancele_schedule" value="{{$each_schedule->schedule_id}}">
                         @else
                          ---
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
    
    <div class="modal-content">
    <div class="modal-header">
      <h2 style="font-size: 20px;text-align: center;">Comment your reason</h2>
      
    </div>
      <div class="modal-body" id="hall_details_edit">
<div class="row clearfix">
          <div class="col-xs-12 divi-line">
          </div><br/>
          <div class="col-sm-9 col-xs-12">
            <div class="form-group" align="center">
              <textarea class="form-control" rows="3" id="comment"></textarea>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    } );
</script>

<script type="text/javascript">
  $("#bootstrap-slot-data-table").on("click", ".selectall", function() {
    $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
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

      alertify.confirm("Are you sure you want to cancelled all selected shedule?", function (e) {
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
        alertify.alert("Reason is required for cancellation schedule");
        $('#reason_modal').modal('show');
        return false; 
      }
      else
      {
        
        var cancelled_reason=$('#cancelled_reason').val($('#comment').val());
      // Submit form data via Ajax

      $.ajax({
         url: '{{url("trainer/bootcamp-schedule-cancelled")}}',
         data: $('#canncele_form').serialize(),
         success: function(data){
            alertify.alert("Your selecting schedule cancellation is done");
            $("#canncele_form")[0].reset();
         }
      });
    }
});
   });
});

</script>
@endsection
