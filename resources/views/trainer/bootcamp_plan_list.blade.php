<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')
@section('content')

<script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
    $('.alert-success').hide();
    }, 3000);
  setTimeout(function(){ 
    $('.alert-danger').hide();
    }, 3000);
  });
</script>

<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
    $('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],

// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,1,7] } ],

});
});

</script>
@if (session('last_schedule_date'))
    <script>
      $(document).ready(function(){ 
        // var last_schedule_date = $(this).data("personal-contract");
       $('#reason_modal').modal('show');
      });
    </script>

<?php Session::forget('last_schedule_date'); ?>

  @endif

<script type="text/javascript">
              function delete_bootcamp(){ 
                var bootcamp_id = $(this).data('bootcamp_id');
console.log(bootcamp_id);
        $.ajax({
            
            
             url: "",
            type: "GET",
            data: {'bootcamp_id': bootcamp_id},
            success: function (result) {
                
            }
        });
                
              }
            </script>

           <div id="reason_modal" class="modal fade mot-mod" role="dialog" >
  <div class="modal-dialog success_modal">
    
    <div class="modal-content">
      <div class="modal-body" id="hall_details_edit">
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <h3 class="pull-left customer-mot">Last Bootcamp Date</h3>
            <br class="clear" />
        </div>
        
        <div class="col-sm-12 col-xs-12">
            
            <div class="form-group">
            <div class="row" >
        
           <div class="col-lg-4 col-xs-12">
                                <!-- <label>Last Date</label> -->
                                <div class="dispClass">
                                    <p class="detail-txt2"> <span id="new_p"></span>      
                                    </p>                                
                                </div>
                            </div> 
                          
                            <!--  <label id="new_p"></label>
                           <input type="text" name="new_package_price" id="new_package_price"> -->
                            
                           <!--  <div id="new_price" >
                                      <label id="new_p">Last Date</label>
                                      </div> -->
      
        </div>
            </div>
      </div>
  </div>
</div>
<button type="button" class="btn btn-default success-close" id="bootcamp_date"  onClick="delete_bootcamp()" >Submit</button>

</div>
</div>
</div>

@if(Auth::user()->master_trainer==1)
<div class="breadcrumbs">
    <div class="col-sm-9">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Bootcamp Plans</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="page-header float-left ex3" style="padding-top: 2%;">
            <a href="{{route('bootcamp_plan')}}">
                <button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add New Bootcamp Plan</button>
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
            @if (session()->has('success'))
              <div class="alert alert-success">
                {{ session()->get('success') }}
              </div>
            @endif

            @if (session('delete'))
              <div class="alert alert-success">
                {{ session('delete') }}
              </div>
            @endif

            @if (session('cancele_delete'))
              <div class="alert alert-danger">
                {{ session('cancele_delete') }} 
              </div>
            @endif
            @if (session('last_schedule_date'))
              <div class="alert alert-danger">
                {{ session('last_schedule_date') }} 

   

              </div>

 
            @endif
          </div>
          <div class="card-body">
           


            <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
              <thead>
                <tr>
                  <th style="width: 3px;">Sl. No.</th>
                  <th>Day</th>
                  <th>Session Start Time</th>
                  <th>Session End Time</th>
                  <th style="width: 116px;">Address</th>
                  <th>Validity</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="tbdy1"> 
               @if(count($bootcamp_details)>0)
                  @foreach($bootcamp_details as $key=>$each_bootcamp)
                    <tr>
                      <td align="center">{{++$key}}</td>
                      <td>
                        @if($each_bootcamp->monday==1) Monday  @endif
                        @if($each_bootcamp->tuesday==1) Tuesday  @endif
                        @if($each_bootcamp->wednesday==1) Wednesday  @endif
                        @if($each_bootcamp->thursday==1) Thursday  @endif
                        @if($each_bootcamp->friday==1) Friday  @endif
                        @if($each_bootcamp->saturday==1) Saturday @endif
                        @if($each_bootcamp->sunday==1) Sunday @endif
                      </td>
                      <td>{{date("h:i A", strtotime($each_bootcamp->session_st_time))}}</td>
                      <td>{{date("h:i A", strtotime($each_bootcamp->session_end_time))}}</td>
                      <td>
                        {{$each_bootcamp->address}}
                      </td>
                      <td>
                        {{$each_bootcamp->plan_st_date}} To {{$each_bootcamp->plan_end_date}}
                      </td>
                      <td>
                        @if($each_bootcamp->status==1)
                        Active
                        @else
                        Inactive
                        @endif
                      </td>
                      <!-- <input type="hidden" name="bootcamp_id" id="bootcamp_id" value="{{$each_bootcamp->bootcamp_id}}">  -->
                      <td style="width: 73px">

                        

                         <a href="{{route('bootcamp_plan_edit',['plan_id' => Crypt::encrypt($each_bootcamp->bootcamp_id) ])}}" title="Edit Exercise"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>

                          <button type="button"  class="btn btn-danger btn-sm" style="width: 32px;" title="Delete Exercise" id="delete_bootcamp" data-bootcamp_id="{{$each_bootcamp->bootcamp_id}}"><i class="fa fa-trash-o"  ></i></button>
                          <!-- <a href="#" class="payment btn btn-info btn-sm" style="padding: 4px 7px;position: relative; right: -1.5px; top: 0px;"><i class="fa fa-eye" title="view details"  aria-hidden="true"></i></a> -->
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

<script>

 $(document).ready(function() {
 $("#delete_bootcamp").on('click',function(event){

  // alert('assretd');
  // event.preventDefault();
  var bootcamp_id = $(this).data('bootcamp_id');
console.log(bootcamp_id);
$.ajax({
          type: "GET",
          url: "{{route('checked_bootcamp_plan_date')}}",
          data: {'bootcamp_id': bootcamp_id},
           dataType: "json",

           success: function(data){
    if(data.last_schedule_date)
            { 
              $('#reason_modal').modal('show');
$('#new_price').show();
$('#new_p').html("Are you sure you went to delete after this <h6>"+data.last_schedule_date+" ? </h6>");
 $('#new_package_price').val(data.last_schedule_date);
 $('#bootcamp_id').val(data.bootcamp_id);
console.log(data.bootcamp_id);

 

            }

            else{
alert('asyjhgd');
            }

           }
            });


      

        
    }); 
  
  });



</script>



@endsection
