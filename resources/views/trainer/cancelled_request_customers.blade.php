
@extends('trainerlayouts.trainer_template')
@section('content')
<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
  $('#bootstrap-slot-data-table').DataTable({
    lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,6] } ],
});
} );
</script>

<style>
/* disable shorting arrow from slno,image and action columns*/
table.dataTable thead>tr>th[id='slno'].sorting_asc::before{display: none}
table.dataTable thead>tr>th[id='slno'].sorting_asc::after{display: none}
table.dataTable thead>tr>th[id='image'].sorting_asc::before{display: none}
table.dataTable thead>tr>th[id='image'].sorting_asc::after{display: none}
/*for delete buton*/
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
    top: 33%;
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

</style>
<div id="reason_modal" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body" id="hall_details_edit">
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <p class="pull-left">Decline Request</p>
            <br class="clear" />
          </div>
          <div class="col-xs-12 divi-line">
          </div><br/>
          <div class="col-sm-9 col-xs-12">
            <input type="hidden" id="reason_id"></input>
            <input type="hidden" id="reason_action"></input>
            <div class="form-group">
              <label>Comment your reason:</label>
              <textarea class="form-control" rows="3" id="comment"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" id="reason">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Cancellation Request List</h1>
      </div>
    </div>
  </div>
</div>
<div class="content mt-3">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
           <div class="group">
            <div id="loading-img"></div>
          <div class="card-body">
            <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
              <thead>
                <tr>
                  <th id='slno'>Sl. No.</th>
                  <th> Customer Name</th>
                  <th>Customer Phone</th>
                   @if(Auth::user()->master_trainer==1)
                  <th>Trainer Name</th>
                  @endif
                  <th>Status</th>
                  <th>Booking Date & Time</th>
                  <th id='image'>Image</th>
                </tr>
              </thead>
              <tbody>
                 @if(count($data)>0)
                @foreach($data as $key=>$mydata)
                <tr>
                  <td align="center">{{++$key}}</td>
                  <td>{{$mydata->name}}</td>
                  <td align="center">{{$mydata->ph_no}}</td>               
                    @if(Auth::user()->master_trainer==1)
                   <td>{{$mydata->trainer_name}}</td>
                   @endif           
                  <td>{{$mydata->status}}</td>
                  <td>{{date('d F Y', strtotime($mydata->slot_date))}} {{date('h:i A', strtotime($mydata->slot_time))}}</td>
                  @if($mydata->image) 
                  <td><img src="{{asset('backend/images')}}/{{$mydata->image}}" height="50" width="50"></td>
                 
                     @else
                     <td>N/A</td>
                     @endif
                </tr>
                @endforeach
                </tbody>
              </table>
             </div>
            @endif
          </div>                   
        </div>
        </div>
      </div>
    </div>
  </div><!-- .animated -->


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

@endsection
