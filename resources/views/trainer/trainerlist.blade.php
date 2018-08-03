<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')


@section('content')
<script>
    // for shortin ,pagination,searching data using datatable concept
 $(document).ready(function() { 
$('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
        
        // disable shorting from slno,image and action columns
        "columnDefs": [ { "orderable": false, "targets": [0,5,6] } ],
        
    });
 } );

</script>

<style>
    /* disable shorting arrow from slno,image and action columns*/
     table.dataTable thead>tr>th[id='slno'].sorting_asc::before{display: none}
     table.dataTable thead>tr>th[id='slno'].sorting_asc::after{display: none}

      table.dataTable thead>tr>th[id='image'].sorting_asc::before{display: none}
     table.dataTable thead>tr>th[id='image'].sorting_asc::after{display: none}

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
    <div class="col-sm-9">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>All Trainers</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="page-header float-left" style="padding-top: 2%;padding-left: 21%;">
            <a href="{{route('addtrainer')}}">
                <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Add New Trainer</button>
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
                            <div class="alert alert-danger">
                                {{ session('delete') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <script type="text/javascript">
                           
                            function delete_trainer(id){ 
                            alertify.confirm("Are you sure you want to delete this trainer?", function (e) {
                                    if (e) {
                                                // alertify.success("You've clicked OK");
                                                window.location.href="{{url('trainer/trainerdelete')}}/"+id;
                                                
                                            }                                      
                                        });
                                    }
                            </script>
                        </script>
                        <table id="bootstrap-slot-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th id="slno">Sl. No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact No</th>
                                    <th>Addess</th>
                                    <th id="image">Image</th>
                                    <th id="action">Action</th>
                                </tr>
                            </thead>
                        <tbody>
                                @if(count($data)>0)
                            @foreach($data as $key=>$mydata)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$mydata->name}}</td>
                                    <td>{{$mydata->email}}</td>
                                    <td>{{$mydata->contact_no}}</td>
                                    <td>{{$mydata->address}}</td>
                                    <td><img src="{{asset('backend/images')}}/{{$mydata->image}}" height="50" width="50"></td>
                                    @if($mydata->master_trainer == 1)
                                    <td>
                                        <a href="{{url('trainer/edittrainer')}}/{{$mydata->id}}" ><button class="button-primary">Edit</button></a>
                                    @else
                                    <td>
                                        <a href="{{url('trainer/edittrainer')}}/{{$mydata->id}}" ><button class="button-primary">Edit</button></a>
                                        <button class="button-primary" onclick="delete_trainer({!!$mydata->id!!})">Delete</button>
                                    </td>
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


    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>

    

@endsection
