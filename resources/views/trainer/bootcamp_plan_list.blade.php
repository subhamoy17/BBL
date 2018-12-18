<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')
@section('content')
<script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
    $('.alert-success').hide();
    }, 3000);
  setTimeout(function(){ 
    $('.alert-danger').hide();
    }, 3000);
  });
</script>

<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
    $('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],

// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,1,7] } ],

});
});

</script>


@if(Auth::user()->master_trainer==1)
<div class="breadcrumbs">
    <div class="col-sm-9">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Bootcamp Plans</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="page-header float-left ex3" style="padding-top: 2%;">
            <a href="{{route('bootcamp_plan')}}">
                <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Add New Bootcamp Plan</button>
            </a>
        </div>
    </div>
</div>
<div class="content mt-3" style="margin-top: 0px !important;">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header" style="padding-left: 0px;padding-right: 0px;padding-bottom: 0px;padding-top: 10px;">
            @if (session()->has('success'))
              <div class="alert alert-success">
                {{ session()->get('success') }}
              </div>
            @endif

            @if (session('delete'))
              <div class="alert alert-success">
                {{ session('delete') }}
              </div>
            @endif
          </div>
          <div class="card-body">
            <script type="text/javascript">
              function delete_bootcamp(id){ 
                alertify.confirm("Are you sure you want to delete this bootcamp plan?", function (e) {
                if (e) {
                  // alertify.success("You've clicked OK");
                  window.location.href="{{url('trainer/bootcamp_plan_delete')}}/"+id;
                } else {
                  // alertify.error("You've clicked Cancel");
                  }                                       
                });
              }
            </script>


            <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
              <thead>
                <tr>
                  <th style="width: 6%;">Sl. No.</th>
                  <th>Day</th>
                  <th>Session Start Time</th>
                  <th>Session End Time</th>
                  <th style="width: 116px;">Address</th>
                  <th>Validity</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="tbdy1"> 
               @if(count($bootcamp_details)>0)
                  @foreach($bootcamp_details as $key=>$each_bootcamp)
                    <tr>
                      <td>{{++$key}}</td>
                      <td>
                        @if($each_bootcamp->monday==1) Monday  @endif
                        @if($each_bootcamp->tuesday==1) Tuesday  @endif
                        @if($each_bootcamp->wednesday==1) Wednesday  @endif
                        @if($each_bootcamp->thursday==1) Thursday  @endif
                        @if($each_bootcamp->friday==1) Friday  @endif
                        @if($each_bootcamp->saturday==1) Saturday @endif
                        @if($each_bootcamp->sunday==1) Sunday @endif
                      </td>
                      <td>{{date("h:i A", strtotime($each_bootcamp->session_st_time))}}</td>
                      <td>{{date("h:i A", strtotime($each_bootcamp->session_end_time))}}</td>
                      <td>
                        {{$each_bootcamp->address}}
                      </td>
                      <td>
                        {{$each_bootcamp->plan_st_date}} To {{$each_bootcamp->plan_end_date}}
                      </td>
                      <td align="center">
                        @if($each_bootcamp->deleted_at=='')
                        <i class="fa fa-check-circle btn-act"  title="Active"> </i>
                        @else
                        <i class="fa fa-times-circle btn-ina" title="Inactive"></i>
                        @endif
                      </td>
                      
                      <td style="width: 73px" align="center">

                        @if($each_bootcamp->deleted_at=='')

                         <a href="{{route('bootcamp_plan_edit',['plan_id' => Crypt::encrypt($each_bootcamp->bootcamp_id) ])}}" title="Edit Exercise"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                          <button type="button" onclick="delete_bootcamp({!!$each_bootcamp->bootcamp_id!!})" class="btn btn-danger btn-sm" style="width: 32px;" title="Delete Exercise"><i class="fa fa-trash-o"></i></button>
                          <!-- <a href="#" class="payment btn btn-info btn-sm" style="padding: 4px 7px;position: relative; right: -1.5px; top: 0px;"><i class="fa fa-eye" title="view details"  aria-hidden="true"></i></a> -->
                        @else
                        --
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>      
        </div>
      </div>
    </div>
  </div><!-- .animated -->
</div>
<!-- .content -->

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

<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    } );
</script>
@endsection
