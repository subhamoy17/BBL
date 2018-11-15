<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')
@section('content')

<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
    $('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],

// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,2,3,7,8] } ],

});
});

</script>

<style>

/*for delete buton*/
.button-primary 
{
    background: #d16879;
    color: #FFF;
    padding: 10px 20px;
    font-weight: bold;
    border:1px solid #FFC0CB;
}

table,th,tr,td
{
    padding: 5px;
    margin: 3px;
    font-size: 15px;
    text-align: left;
}

th
{
    text-align: center;
}

</style>

<script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
                          $('.alert-success').hide();
                      }, 3000);
});
</script>

<div class="breadcrumbs">
    <div class="col-sm-9">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Common Diet Plan List</h1>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="page-header float-left ex3" style="padding-top: 2%;">
            <a href="{{route('add_common_diet_plan')}}">
                <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Add New Diet Plan</button>
            </a>
        </div>
    </div>
</div>
<div class="col-md-12">
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

    @if (session('editsuccess'))
        <div class="alert alert-success">
            {{ session('editsuccess') }}
        </div>
    @endif

    
</div>

<div class="card-body">
    <script type="text/javascript">
   
    function delete_client(id){ 
    alertify.confirm("Are you sure you want to delete this diet plan?", function (e) {
            if (e) {
                        // alertify.success("You've clicked OK");
                      window.location.href="{{url('trainer/delete-common-diet-plan')}}"+"/"+id;
                        
                    }                                     
                });
            }
    </script>
    <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
        <thead>
            <tr>
                <th id="slno">Sl. No.</th>
                <th>Diet plan name</th>
                <th id="image">Image/Video</th>
                <th>Diet Plan PDF</th>
                <th>Price (<i class="fa fa-gbp"></i>)</th>
                <th>Auther Name</th>
                <th>Auther Designation</th>
                <th id="autherImage" style="width: 100px;">Auther Image</th>
                <th id="action" style="width: 70px;">Action</th>
            </tr>
        </thead>
        <tbody class="tbdy1"> 
             @if(count($diet)>0)
                @foreach($diet as $key=>$mydiet)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$mydiet->diet_plan_name}}</td>
                    <td style="width: 30px;">
                        @if(isset($mydiet->video) && !empty($mydiet->video))
                            <iframe src="{{$mydiet->video}}" frameborder="0" allow="autoplay; encrypted-media" width="200px" height="130px"></iframe>
                        @elseif(isset($mydiet->image) && !empty($mydiet->image))
                            <img src="{{asset('backend/common_diet_plan_images')}}/{{$mydiet->image}}" width="200px" height="130px">
                        @else
                            N/A
                        @endif
                    </td>

                    <td><button style="background: #F9E79F; font-size: 12px;"><a href="{{url('backend/common_diet_plan_images')}}/{{$mydiet->diet_plan_pdf}}" target="_blank"><b>View PDF</b></a></button></td>
                    <td>{{$mydiet->price}}</td>
                    <td>{{$mydiet->author_name}}</td>
                    <td>{{$mydiet->author_designation}}</td>
                    <td>
                        @if($mydiet->author_image)
                        <img src="{{url('backend/common_diet_plan_images')}}/{{$mydiet->author_image}}" width="70px" height="70px">
                        @else
                        N/A
                        @endif
                    </td>
                    
                    <td style="width: 80px">
                        <a href="{{url('trainer/edit-common-diet-plan')}}/{{$mydiet->id}}" title="Edit Common diet plan">
                            <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                        </a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="delete_client({!!$mydiet->id!!})" style="width: 32px;" title="Delete Exercise"><i class="fa fa-trash-o"></i>
                            </button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
</div>


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
