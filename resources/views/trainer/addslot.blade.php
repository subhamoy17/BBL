<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')


@section('content')
<script>
    // for shortin ,pagination,searching data using datatable concept
 $(document).ready(function() { 
$('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
        
        // disable shorting from slno and action columns
        "columnDefs": [ { "orderable": false, "targets": [0,5] } ],
        
    });
 } );

</script>

<style>
    /* disable shorting arrow from slno and action columns*/
     table.dataTable thead>tr>th[id='slno'].sorting_asc::before{display: none}
     table.dataTable thead>tr>th[id='slno'].sorting_asc::after{display: none}

     table.dataTable thead>tr>th[id='action'].sorting_asc::before{display: none}
     table.dataTable thead>tr>th[id='action'].sorting_asc::after{display: none}

     /*for delete buton*/
     .button-primary {
    background: #d16879;
    color: #FFF;
    padding: 10px 20px;
    font-weight: bold;
    border:1px solid #FFC0CB;
}
</style>
<script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
                          $('.alert-success').hide();
                      }, 5000);
});
</script>
@if(Auth::user()->master_trainer==1)

<div class="breadcrumbs">
    <div class="col-sm-9">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>All Packages</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="page-header float-left add-pck" style="padding-top: 2%;">
            <a href="{{route('addslotrecord')}}">
                <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Add New Package</button>
            </a>
        </div>
    </div>
</div>
<div class="content mt-3" style="margin-top: 0px !important;">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @if(count($data)>0)
                        <div class="card-header" style="padding:0px;">
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
                            function delete_slots(id){ 
                            alertify.confirm("Are you sure you want to delete this package?", function (e) {
                                    if (e) {
                                                // alertify.success("You've clicked OK");
                                                window.location.href="{{url('trainer/deleteslots')}}/"+id;
                                                
                                            }                                      
                                        });
                                    }
                        </script>
                        <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th id="slno">Sl. No.</th>
                                    <th>Name of Slot</th>
                                    <th>Number of Slot</th>
                                    <th>Slot's Price </th>
                                    <th>Slot's Validity (In Days)</th>
                                    <th id="action" style="width: 70px;">Action</th>
                                </tr>
                            </thead>
                        <tbody>
                                @php ($i = 1)
                            @foreach($data as $mydata)
                                <tr>
                                    <td align="center">{{$i++}}</td>
                                      <td>{{$mydata->slots_name}}</td>
                                    <td>{{$mydata->slots_number}}</td>
                                    <td> <i class="fa fa-gbp"></i> {{$mydata->slots_price}}</td>
                                    <td>{{$mydata->slots_validity}}</td>
                                    <td>
                                        <a href="{{url('trainer/editslots')}}/{{$mydata->id}}" title="Edit Package"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_slots({!!$mydata->id!!})" style="width: 32px;" title="Delete Package"><i class="fa fa-trash-o"></i></button>
                                        
                                    </td>
                                </tr>
                                 
                            @endforeach
                        </tbody>
                        </table>


                    </div>
                    @else
                    <div class="card-header">
                        <strong class="card-title">No record found &nbsp;&nbsp; 
                            <a href="{{route('addslotrecord')}}">
                                <button><i class="fa fa-plus"></i> Add New Record</button>
                            </a></strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

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
