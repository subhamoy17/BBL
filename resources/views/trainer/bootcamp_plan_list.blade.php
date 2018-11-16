<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')
@section('content')

<script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
    $('.alert-success').hide();
    }, 3000);
  });
</script>

<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
    $('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],

// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,1,6] } ],

});
});

</script>

@if(Auth::user()->master_trainer==1)
<div class="breadcrumbs">
    <div class="col-sm-9">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>All Bootcamp Plan</h1>
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
            @if (session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
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
              function delete_gym_type(id){ 
                alertify.confirm("Are you sure you want to delete this exercise?", function (e) {
                if (e) {
                  // alertify.success("You've clicked OK");
                  window.location.href="{{url('trainer/gymdelete')}}/"+id;
                } else {
                  // alertify.error("You've clicked Cancel");
                  }                                       
                });
              }
            </script>
            <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
              <thead>
                <tr>
                  <th>Sl. No.</th>
                  <th>Day</th>
                  <th>Session Start Time</th>
                  <th>Session End Time</th>
                  <th>Location/ Address</th>
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
                        @if($each_bootcamp->monday==1) Monday, @endif
                        @if($each_bootcamp->tuesday==1) Tuesday, @endif
                        @if($each_bootcamp->wednesday==1) Wednesday, @endif
                        @if($each_bootcamp->thursday==1) Thursday, @endif
                        @if($each_bootcamp->friday==1) Friday, @endif
                        @if($each_bootcamp->saturday==1) Saturday, @endif
                        @if($each_bootcamp->sunday==1) Sunday @endif
                      </td>
                      <td>{{date("h:i A", strtotime($each_bootcamp->session_st_time))}}</td>
                      <td>{{date("h:i A", strtotime($each_bootcamp->session_end_time))}}</td>
                      <td>
                        @if($each_bootcamp->location!='')
                        {{$each_bootcamp->location}}
                        @else
                        {{$each_bootcamp->address}}
                        @endif
                      </td>
                      <td>
                        @if($each_bootcamp->status==1)
                        Active
                        @else
                        Inactive
                        @endif
                      </td>
                      
                      <td style="width: 73px">
                          <a href="{{url('trainer/editexercise')}}/{{$each_bootcamp->bootcamp_id}}" title="Edit Exercise"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                          <button type="button" class="btn btn-danger btn-sm" onclick="delete_gym_type({!!$each_bootcamp->bootcamp_id!!})" style="width: 32px;" title="Delete Exercise"><i class="fa fa-trash-o"></i></button>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    } );
</script>
@endsection
