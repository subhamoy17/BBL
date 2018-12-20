<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')
@section('content')

<script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
    $('.alert-success').hide();
    }, 30000);
  });
</script>

<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
    $('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],

// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,5] } ],

});
});

</script>

<style>

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
    top: 50%;
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

.order-show-icon
{
  display: inline-block;
    float: left;
    margin-left: 2px;
    margin-top: 2px;
}

</style>


@if(Auth::user()->master_trainer==1)
<div class="breadcrumbs">
    <div class="col-sm-12">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>All Clients of Choosen Bootcamp Schedule</h1>
                <h1>{{$shedule_details->address_line1}}; {{$shedule_details->shedule_date}}; {{$shedule_details->plan_day}}; {{date("h:i A", strtotime($shedule_details->plan_st_time))}} to {{date("h:i A", strtotime($shedule_details->plan_end_time))}}</h1>
            </div>
        </div>
    </div>
</div>
<div class="content mt-3" style="margin-top: 0px !important;">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div id="loading-img"></div>
        <div class="card">
          <div class="card-header" style="padding-left: 0px;padding-right: 0px;padding-bottom: 0px;padding-top: 10px;">
            
         @if (session()->has('bootcamp_session_cancelled'))
              <div class="alert alert-success">
                {{ session()->get('bootcamp_session_cancelled') }}
              </div>
            @endif
          <div class="card-body">
             <form id="canncele_form" method="post">
              <input type="hidden" name="cancelled_reason" id="cancelled_reason">
           <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
              <thead>
                          <tr>
                   <th  colspan="5"></th>
                    <th style="float: center;">
                       
  
 <button class="btn btn-danger" id="cancelled_button" title="Cancel"><i class="fa fa-trash-o" ></i></button>

                    </th>
                  
                  </tr>
                <tr>
                  <th>Sl. No.</th>
                  <th>Customer Name</th>
                  <th>Customer Email</th>
                  <th>Customer Phone</th>
                  <th>Status</th>
                  <th style="width: 100px;">Select to Cancel
                    <input type="checkbox" id="all_cutomers_schedule_cancel" class="selectall" style="margin-left: 21px">
                    <!-- <button class="btn btn-danger btn-sm" id="cancelled_button" title="Cancel"><i class="fa fa-trash-o" ></i></button> -->
                  </th>
                </tr>
              </thead>
              <tbody class="tbdy1"> 
               @if(count($allcustomer)>0)
                  @foreach($allcustomer as $key=>$each_customer)
                    <tr>
                      <td>{{++$key}}</td>
                      <td>{{$each_customer->customer_name}}</td>
                      <td>{{$each_customer->customer_email}}</td>
                      <td>{{$each_customer->customer_phone}}</td>
                      <td align="center">
                        @if($each_customer->deleted_at=='')
                        
                        <i class="fa fa-check-circle btn-act"  title="Booked">
                        @else
                        <i class="fa fa-ban btn-del" title="Cancelled"></i>
                        @endif
                      </td>
                      <td align="center">
                        @if($each_customer->deleted_at=='')
                        <?php $cancelled_details=$each_customer->schedule_id."_".$each_customer->customer_id;?>
                      <input type="checkbox" name="cancele_schedule[]" id="cancele_schedule" value="{{$cancelled_details}}" class="cancele_check abc" style="margin-left: -42px"> 
                        @else
                         --
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </form>
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

<script type="text/javascript">
  $("#bootstrap-slot-data-table").on("click", ".selectall", function() {
    $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
});

       $("#bootstrap-slot-data-table").on("change", ".abc", function() {
        $('.abc:checked').length == $('.abc').length;
    if ($('.abc:checked').length == $('.abc').length) {
       
       $("#all_cutomers_schedule_cancel"). prop("checked", true);
    }
    else{
      $("#all_cutomers_schedule_cancel"). prop("checked", false);
    }
});

</script>

<script>
$(document).ready(function (){
   var table = $('#bootstrap-data-table-export').DataTable({

   });

   // Handle form submission event
   $('#canncele_form').on('submit', function(event){ 
      // Prevent actual form submission
      event.preventDefault();
      var cancele_check = $('.cancele_check:checkbox');
            if(cancele_check.length > 0) { ;
                if( $('.cancele_check:checkbox:checked').length < 1) {
                    alertify.alert('Please select at least one to cancelled');
                    cancele_check[0].focus();
                    return false;
                }
            }
            else if($('.cancele_check:checkbox:checked').length==0 && $('.selectall:checkbox:checked').length==1)
                {
                   alertify.alert('Please select at least one to cancelled');
                    cancele_check[0].focus();
                    return false;
                }

      alertify.confirm("Are you sure you want to cancelled all selected booking?", function (e) {
          if (e) {
                  
                  $.ajax({
            url: '{{url("trainer/individual_bootcamp_cancele")}}',
            data: $('#canncele_form').serialize(),
            success: function(data){
            alertify.alert("Your selected booking cancellation is done");
            location.reload();
         }
      });
          }
          else
          {
            return false;
          }
        });
   });
});

</script>

@endsection
