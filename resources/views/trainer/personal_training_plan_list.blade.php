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
"columnDefs": [ { "orderable": false, "targets": [0] } ],

});
});

</script>


<div class="breadcrumbs">
    <div class="col-sm-9">
        <div class="page-header float-left">
            <div class="page-title">
              <h1>
              @if(Auth::user()->master_trainer==1)
                Personal Training Plans
              @else
                Your Personal Training Plans
              @endif
              </h1>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="page-header float-left ex3" style="padding-top: 2%;">
          @if(Auth::user()->master_trainer==1)
            <a href="{{route('add_pt_plan')}}">
                <button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add New Personal Training Plan</button>
            </a>
          @endif
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
                  @if(Auth::user()->master_trainer==1)
                  <th>Trainer Name</th>
                  @endif
                  <th>Session Time</th>
                  <th style="width: 116px;">Address</th>
                  <th>Validity</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody class="tbdy1"> 
               @if(count($pt_plan_details)>0)
                  @foreach($pt_plan_details as $key=>$each_pt)
                    <tr>
                      <td>{{++$key}}</td>
                      <td>
                        @if($each_pt->mon_session_flg==1) Monday  @endif
                        @if($each_pt->tue_session_flg==1) Tuesday  @endif
                        @if($each_pt->wed_session_flg==1) Wednesday  @endif
                        @if($each_pt->thu_session_flg==1) Thursday  @endif
                        @if($each_pt->fri_session_flg==1) Friday  @endif
                        @if($each_pt->sat_session_flg==1) Saturday @endif
                        @if($each_pt->sun_session_flg==1) Sunday @endif
                      </td>
                      @if(Auth::user()->master_trainer==1)
                      <td>{{$each_pt->trainer_name}}</td>
                      @endif
                      <td>{{$each_pt->start_time}} To {{$each_pt->end_time}}</td>
                      <td>
                        {{$each_pt->address}}
                      </td>
                      <td>
                        {{$each_pt->plan_st_date}} To {{$each_pt->plan_end_date}}
                      </td>
                      <td align="center">
                        @if($each_pt->deleted_at=='')
                        <i class="fa fa-check-circle btn-act"  title="Active"> </i>
                        @else
                        <i class="fa fa-times-circle btn-ina" title="Inactive"></i>
                        @endif
                      </td>
                      <!-- @if(Auth::user()->master_trainer==1)
                      <td style="width: 73px" align="center">

                        @if($each_pt->deleted_at=='')

                         <a href="{{route('bootcamp_plan_edit',['plan_id' => Crypt::encrypt($each_pt->pt_plan_id) ])}}" title="Edit Exercise"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                          <button type="button" onclick="delete_bootcamp({!!$each_pt->pt_plan_id!!})" class="btn btn-danger btn-sm" style="width: 32px;" title="Delete Exercise"><i class="fa fa-trash-o"></i></button>
                          <a href="#" class="payment btn btn-info btn-sm" style="padding: 4px 7px;position: relative; right: -1.5px; top: 0px;"><i class="fa fa-eye" title="view details"  aria-hidden="true"></i></a> 
                        @else
                        --
                        @endif 
                      </td>
                      @endif-->
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
