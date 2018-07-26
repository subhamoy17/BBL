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

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Add Slots</h1>
            </div>
        </div>
    </div>
</div>
<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                  @if (session('delete'))
                                    <div class="alert alert-danger">
                                        {{ session('delete') }}
                                    </div>
                                @endif
                <div class="card">
                    @if(count($data)>0)
                        <div class="card-header">
                            <strong class="card-title">Total Data Are Here&nbsp;&nbsp; 
                                <a href="{{route('addslotrecord')}}">
                                    <button><i class="fa fa-plus"></i> Add New Record</button>
                                </a>
                                <br>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </strong>
                        </div>
                    <div class="card-body">
                        <script type="text/javascript">
                            function delete_slots(id){ 
                            alertify.confirm("Are you sure you want to delete this slot?", function (e) {
                                    if (e) {
                                                alertify.success("You've clicked OK");
                                                window.location.href="{{url('trainer/deleteslots')}}/"+id;
                                                
                                            } else {
                                                alertify.error("You've clicked Cancel");
                                                
                                            }                                       
                                        });
                                    }
                        </script>
                        <table id="bootstrap-slot-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th id="slno">Sl. No.</th>
                                    <th>Name of Slot</th>
                                    <th>Number of Slot</th>
                                    <th>Slot's Price (Rs.)</th>
                                    <th>Slot's Validity (In Days)</th>
                                    <th id="action">Action</th>
                                </tr>
                            </thead>
                        <tbody>
                                @php ($i = 1)
                            @foreach($data as $mydata)
                                <tr>
                                    <td>{{$i++}}</td>
                                      <td>{{$mydata->slots_name}}</td>
                                    <td>{{$mydata->slots_number}}</td>
                                    <td>{{$mydata->slots_price}}</td>
                                    <td>{{$mydata->slots_validity}}</td>
                                    <td>
                                        <a href="{{url('trainer/editslots')}}/{{$mydata->id}}" ><button class="button-primary">Edit</button></a>
                    
                                        <button class="button-primary" onclick="delete_slots({!!$mydata->id!!})">Delete</button>
                                        
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


    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>

   

@endsection
