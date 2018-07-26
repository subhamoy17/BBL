
<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')


@section('content')
<script>
    // for shortin ,pagination,searching data using datatable concept
 $(document).ready(function() { 
$('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
        
        // disable shorting from slno,image and action columns
        "columnDefs": [ { "orderable": false, "targets": [0,3] } ],
        
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
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Customer MOT List</h1>
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
                    
                        <div class="card-header">
                            <strong class="card-title">
                               <a href="{{route('motinsertshow_page')}}">
                                    <button><i class="fa fa-plus"></i> Add New Customer MOT</button>
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
                           
                            function delete_mot(id){ 
                            alertify.confirm("Are you sure you want to delete this MOT?", function (e) {
                                    if (e) {
                                                alertify.success("You've clicked OK");
                                                window.location.href="{{url('trainer/motdelete')}}/"+id;
                                                
                                            } else {
                                                alertify.error("You've clicked Cancel");
                                                
                                            }                                       
                                        });
                                    }
                            </script>
                        </script>
                        <table id="bootstrap-slot-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th id="slno">Sl. No.</th>
                                        <th>Weight</th>
                                    <th>Right arm</th>
                                    <th>Left arm</th>
                                    <th>Chest</th>
                                    <th>Waist</th>
                                     <th>Hips</th>
                                     <th>Right_thigh</th>
                                    <th>Left_thigh</th>
                                    <th>Right_calf</th>
                                    <th>Left_calf</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                                  
                                         
                                   </tr> 
                            </thead>
                        <tbody>
                                
                            @foreach($data as $key=>$mydata)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$mydata->weight}}</td>
                                    <td>{{$mydata->right_arm}}</td>
                                    <td>{{$mydata->left_arm}}</td>
                                   <td>{{$mydata->chest}}</td>
                                    <td>{{$mydata->waist}}</td>
                                    <td>{{$mydata->hips}}</td>
                                    <td>{{$mydata->right_thigh}}</td>
                                    <td>{{$mydata->left_thigh}}</td>
                                    <td>{{$mydata->right_calf}}</td>
                                   <td>{{$mydata->left_calf}}</td>
                                   <td>{{$mydata->date}}</td>


                                   <td> <a href="{{url('trainer/moteditshow')}}/{{$mydata->id}}" ><button class="button-primary">Edit</button></a>

                                         <button class="button-primary" onclick="delete_mot({!!$mydata->id!!})">Delete</button>


                                </tr>
                            @endforeach
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


    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>

    

@endsection
