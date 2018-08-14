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
                <h1>Our Trainer List</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <!--<div class="page-header float-left" style="padding-top: 2%;padding-left: 17%;">
            <a href="{{route('add_exercise_trainer')}}">
                <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Add New Exercise</button>
            </a>
        </div>-->
         <strong class="card-title add-n-cl">
                              <a href="{{route('client_insert_view')}}">
                                    <button class="btn btn-success"><i class="fa fa-plus"></i> Add New Trainer</button>
                                </a>
                                <br>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </strong>
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
                    
                        <div class="card-header">
                           
                        </div>

                    <div class="card-body">
                        <script type="text/javascript">
                           
                            function delete_client(id){ 
                            alertify.confirm("Are you sure you want to delete this client?", function (e) {
                                    if (e) {
                                                // alertify.success("You've clicked OK");
                                                window.location.href="{{url('trainer/client_delete')}}/"+id;
                                                
                                            }                                     
                                        });
                                    }
                            </script>
                        </script>
                        <table id="bootstrap-slot-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th id="slno">Sl. No.</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Description</th>
                                    <!-- <th>Facebook</th>
                                    <th>Twitter</th>
                                    <th>Instagram</th> -->
                                    <th id="image">Image</th>
                                    <th id="action">Action</th>
                                </tr>
                            </thead>
                        <tbody class="tbdy1">
                                @if(count($data)>0)
                            @foreach($data as $key=>$mydata)
                                <tr>
                                    <td>{{++$key}}</td>
                                     <td>{{$mydata->title}}</td>
                                    <td>{{$mydata->name}}</td>
                                    <td>{{$mydata->designation}}</td>
                                    <td>{{$mydata->description}}</td>
                                    <!-- <td>
                                         @if($mydata->facebook !='') 
                                           {{$mydata->facebook}}
                                         @else  
                                        N/A
                                        @endif
                                    </td>
                                        <td>
                                         @if($mydata->twitter !='') 
                                           {{$mydata->twitter}}
                                         @else  
                                        N/A
                                        @endif
                                    </td>
                                    
                                        <td>
                                         @if($mydata->instagram !='') 
                                           {{$mydata->instagram}}
                                         @else  
                                        N/A
                                        @endif
                                    </td> -->
                                      <td><img src="{{asset('backend/images')}}/{{$mydata->image}}" height="50" width="50"></td>



                                   <td>
                                       <!-- <a href="{{url('trainer/client_edit_view')}}/{{$mydata->id}}" ><button class="button-primary">Edit</button></a>
                                        <button class="button-primary" onclick="delete_client({!!$mydata->id!!})">Delete</button>-->
                                        
                                        
                                        <a href="{{url('trainer/client_edit_view')}}/{{$mydata->id}}" title="Edit Exercise" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_client({!!$mydata->id!!})" style="width: 32px;" title="Delete Exercise"><i class="fa fa-trash-o"></i></button>
                                    </td>



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
