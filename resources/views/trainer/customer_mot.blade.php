
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

@if(Auth::user()->master_trainer==1)

<div class="breadcrumbs">
    <div class="col-sm-8">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>All Customer's MOT</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="page-header float-left nw-mot" style="padding-top: 2%;">
            <a href="{{route('motinsertshow_page')}}">
                <button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i>Add New Customer's MOT</button>
            </a>
        </div>
    </div>
</div>
<div class="content mt-3" style="margin-top: 0px !important;">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="padding:0">
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
                           
                            function delete_mot(id){ 
                            alertify.confirm("Are you sure you want to delete this Customer's MOT?", function (e) {
                                    if (e) {
                                                window.location.href="{{url('trainer/motdelete')}}/"+id;
                                                
                                            }                                      
                                        });
                                    }
                            </script>
                        </script>
                        <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th id="slno">Sl. No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Height</th>
                                    <th>Chest</th>
                                    <th>Waist</th>
                                    <th>Hips</th>
                                    <th>Measured On</th>
                                    <th style="width: 70px;">Action</th>    
                                   </tr> 
                            </thead>
                        <tbody>
                                
                            @foreach($data as $key=>$mydata)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>@if(!empty($mydata->name)) {{$mydata->name}} @else N/A @endif</td>
                                    <td>@if(!empty($mydata->email)) {{$mydata->email}} @else N/A @endif</td>
                                    <td>@if(!empty($mydata->height)){{$mydata->height}} @else N/A @endif</td>
                                   <td>@if(!empty($mydata->chest)){{$mydata->chest}} @else N/A @endif</td>
                                    <td>@if(!empty($mydata->waist)) {{$mydata->waist}} @else N/A @endif</td>
                                    <td>@if(!empty($mydata->hips)) {{$mydata->hips}} @else N/A @endif</td>
                                   <td>{{date('d F Y', strtotime($mydata->date))}}</td>


                                   <td> <a href="{{url('trainer/moteditshow')}}/{{$mydata->id}}" title="Edit MOT"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>

                                         <button class="btn btn-danger btn-sm" title="Delete MOT" onclick="delete_mot({!!$mydata->id!!})" style="width: 32px;"><i class="fa fa-trash-o"></i></button>


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
