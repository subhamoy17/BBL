<!-- for extends all i.e. header,footer,sidebar -->

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
<script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
                          $('.alert-success').hide();
                      }, 3000);
});
</script>

@if(Auth::user()->master_trainer==1)

<div class="breadcrumbs">
    <div class="col-sm-9">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Discount Coupon List</h1>
            </div>             
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                                @if (session('delete'))
                                    <div class="alert alert-success">
                                        {{ session('delete') }}
                                    </div>
                                @endif
                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                 @endif
                <div class="card">
                    
                        <div class="card-header">
                           
                        </div>

                    <div class="card-body">
                        <script type="text/javascript">
                           
                            function delete_client(id){ 
                            alertify.confirm("Are you sure you want to delete this coupon?", function (e) {
                                    if (e) {
                                               
                                           window.location.href="{{url('trainer/coupon_delete')}}/"+id;     
                                            }                                     
                                        });
                                    }
                            </script>
                       
                        <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th id="slno" >Sl. No.</th>
                                    <th>Package Type</th>
                                    <th>Coupon Code</th>
                                    <th>Price (<i class="fa fa-gbp"></i>)</th>
                                    <th>Validity</th>
                                    <th>Status</th>
                                    <th id="action">Action</th>
                                </tr>
                            </thead>
                        <tbody class="tbdy1">
                                @if(count($all_cupon_data)>0)
                            @foreach($all_cupon_data as $key=>$mydata)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$mydata->training_name}}</td>
                                     <td>{{$mydata->coupon_code}}</td>
                                    <td>{{$mydata->discount_price}}</td>
                                    <td>{{$mydata->valid_from}} to {{$mydata->valid_to}}</td>                                 
                                    <td align="center">@if($mydata->is_active==1)
                                        <i class="fa fa-check-circle btn-act"  title="Active"> 
                                        @else
                                        <i class="fa fa-times-circle btn-ina" title="Inactive"></i> @endif</td>
                                   
                                        
                                        <td style="width: 70px"">
                                        <a href="{{url('trainer/our_coupon_edit_view')}}/{{$mydata->coupon_id}}" title="Edit Exercise"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_client({!!$mydata->coupon_id!!})" style="width: 32px;" title="Delete Exercise"><i class="fa fa-trash-o"></i></button>
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
