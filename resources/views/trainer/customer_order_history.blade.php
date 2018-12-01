
<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')


@section('content')
<script>
    // for shortin ,pagination,searching data using datatable concept
 $(document).ready(function() { 
$('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
        
        // disable shorting from slno,image and action columns
        "columnDefs": [ { "orderable": false, "targets": [0] } ],
        
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
                <h1>Customer Purchased History</h1>
            </div>
        </div>
    </div>
    
</div>
<div class="content mt-3" style="margin-top: 0px !important;">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                   
                    <div class="card-body">
                       
                        
                        <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th id="slno">Sl. No.</th>
                                    <th>Customer Name</th>
                                     <th>Plan Type</th>
                                      <th>Plan Price</th>
                                    
                                    <th>No of Session</th>
                                    <th>Remaining Session</th>
                                    <th>Purchased Details</th>
                                    <th>Status</th>
                                    
                                      
                                   </tr> 
                            </thead>
                        <tbody>
                                
                            @foreach($all_order_history as $key=>$order_history)
                                <tr>
                                    <td>{{++$key}}</td>
                                   <td>{{$order_history->customer_name}}</td>
                                   <td>{{$order_history->training_type}}</td>
                                   
                                  <td> <i class="fa fa-gbp"></i> {{$order_history->total_price}}</td>
                                  
                                   <td>{{$order_history->total_sessions}}</td>
                                   @if($order_history->total_sessions=="Unlimited")
                                    <td>--</td>
                                    @else
                                    <td>{{$order_history->remaining_sessions}}</td>
                                    @endif
                                   
                                   <td><a class="detail-orders-modal-btn1" id="{{$order_history->order_details_id}}" href="#"   data-payment-option="{{$order_history->payment_option}}" data-payment-type-name="{{$order_history->payment_type}}" data-purchased-on="{{date('d F Y', strtotime($order_history->order_purchase_date))}}" data-validity-date="{{$order_history->order_validity_date? date('d F Y', strtotime($order_history->order_validity_date)) : 'N/A'}}">Click here</a></td>
                                   @if(\Carbon\Carbon::now()->toDateString() < $order_history->order_validity_date)
                                    <td>Active</td>
                                    @else
                                    <td>Inactive</td>
                                    @endif

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
<div id="reason_modal" class="modal fade mot-mod" role="dialog" >
  <div class="modal-dialog success_modal">
    
    <div class="modal-content">
      <div class="modal-body" id="hall_details_edit">
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <h3 class="pull-left customer-mot">Purchased Details</h3>
            <br class="clear" />
        </div>
        
        <div class="col-sm-12 col-xs-12">
            
            <div class="form-group">
            <div class="row">
        
           
                          <div class="col-lg-4 col-xs-12">
                                <label>Payment Mode</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> <span id="payment_option"></span>      
                                    </p>                                
                                </div>
                            </div> 
                            
                             
                            <div class="col-lg-4 col-xs-12">
                                <label>Plan Scheme</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> <span id="payment_type_name"></span>      
                                    </p>                                
                                </div>
                            </div> 
                            
                            <div class="col-lg-4 col-xs-12">
                                <label>Purchased On</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> <span id="purchased_on"></span>      
                                    </p>                                
                                </div>
                            </div> 
                            <div></div>
                           
                            <div class="col-lg-4 col-xs-12">
                                <label>Product Validity</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> 
                                         <span id="validity_date"></span>
                                                                            
                                         
                                    </p>                             
                                </div>
                            </div> 
                        
                           

                            
                          
                            
                            
      
        </div>
            </div>
      </div>
  </div>
</div>


</div>
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
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>
<script>
  $(document).ready(function()
{


  $("#bootstrap-slot-data-table").on("click",".detail-orders-modal-btn1", function(){ 
    // alert('ddd');
    
    var payment_option = $(this).data("payment-option");
    var payment_type_name = $(this).data("payment-type-name");
   var purchased_on= $(this).data("purchased-on");
    var validity_date= $(this).data("validity-date");
    
    
    $('#payment_option').text(payment_option);
    $('#payment_type_name').text(payment_type_name);
    
     
    $('#purchased_on').text(purchased_on);
    $('#validity_date').text(validity_date);
    // 
    $('#reason_modal').modal('show');
    });
  
});
</script>
    

@endsection
