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
                <h1>All Packages List</h1>
            </div>
       
                            
        </div>
    </div>
    <div class="col-sm-3">
       
         <strong class="card-title add-n-cl cl-list">
                              <a href="{{route('add_product')}}">
                                    <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Package</button>
                                </a>
                                <br>

                            </strong>
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
                        <!-- <script type="text/javascript">
                           
                            function delete_client(id){ 
                            alertify.confirm("Are you sure you want to delete this product?", function (e) {
                                    if (e) {
                                               
                                           window.location.href=""+id;     
                                            }                                     
                                        });
                                    }
                            </script> -->
                       
                        <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th id="slno" style="width: 6%;">Sl. No.</th>
                                    <th>Training Type</th>
                                    <th>Payment Type</th>
                                    <th>Total Session</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                    <th>Package Validity</th>
                                    <th>Status</th>
                                    
                                    <th id="action">Action</th>
                                </tr>
                            </thead>
                        <tbody class="tbdy1">
                                @if(count($all_products_data)>0)
                            @foreach($all_products_data as $key=>$my_productdata)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$my_productdata->training_name}}</td>
                                     <td>{{$my_productdata->payment_type_name}}</td>
                                     <td align="center">{{$my_productdata->total_sessions}}</td>
                                   
                                     @if($my_productdata->payment_type_id=='2')
                                    <td align="center"><i class="fa fa-gbp">{{$my_productdata->price_session_or_month}}/Month</td>
                                    @else
                                     <td align="center"><i class="fa fa-gbp">{{$my_productdata->price_session_or_month}}/Session</td>
                                     @endif
                                    <td align="center"><i class="fa fa-gbp">{{$my_productdata->total_price}}</td>
                                     <td align="center">{{$my_productdata->validity? $my_productdata->validity.' Days' :'N/A'}} </td>
                                     @if($my_productdata->deleted_at != '')
                                     <td align="center"><i class="fa fa-ban btn-del" title="Deleted"></i></td>
                                     @elseif($my_productdata->status =='0')
                                    <td align="center"><i class="fa fa-times-circle btn-ina" title="Inactive"></i></td>
                                        @elseif($my_productdata->status =='1')
                                         <td align="center"><i class="fa fa-check-circle btn-act"  title="Active"> </i></td>
                                    @endif
                                   
                                        
                                        <td align="center" class="td-btn5">
                                             @if($my_productdata->deleted_at == '')
                                        <a href="{{route('edit_product',['product_id' => Crypt::encrypt($my_productdata->product_id)])}}"><button class="btn btn-primary btn-sm"><i class="fa fa-edit" title="Edit product"></i></button></a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_client({!!$my_productdata->product_id!!})" style="width: 32px;" title="Delete product"><i class="fa fa-trash-o"></i></button>

                                        <a href="{{route('add_package_coupon',['product_id' => Crypt::encrypt($my_productdata->product_id)])}}"><button class="btn btn-primary btn-sm"><i class="fa fa-plus" title="Add Coupon"></i></button></a>
                                        @endif
                                        <a class="detail-products-modal-btn1 btn btn-info btn-sm" id="{{$my_productdata->product_id}}" href="#"   data-personal-contract="{{$my_productdata->contract? $my_productdata->contract : 'N/A'}}" data-personal-notice-period="{{$my_productdata->notice_period? $my_productdata->notice_period.' Days' : 'N/A'}}" data-personal-training-name="{{$my_productdata->training_name}}" data-personal-price-session-or-month="{{$my_productdata->price_session_or_month}}" data-personal-total-price="{{$my_productdata->total_price}}" data-personal-total-sessions="{{$my_productdata->total_sessions}}" data-personal-notice-period-value="{{$my_productdata->notice_period_value}}" data-personal-payment-type-name="{{$my_productdata->payment_type_name}}"><i class="fa fa-eye" title="view details"  aria-hidden="true"></i></a>
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
  

<div id="reason_modal" class="modal fade mot-mod" role="dialog" >
  <div class="modal-dialog success_modal">
    
    <div class="modal-content">
      <div class="modal-body" id="hall_details_edit">
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <h3 class="pull-left customer-mot">Package's Details</h3>
            <br class="clear" />
        </div>
        
        <div class="col-sm-12 col-xs-12">
            
            <div class="form-group">
            <div class="row" >
        
           
                          <div class="col-lg-4 col-xs-12">
                                <label>Training Type</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> <span id="training_name"></span>      
                                    </p>                                
                                </div>
                            </div> 
                            
                             
                            <div class="col-lg-4 col-xs-12">
                                <label>Payment Type Name</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> <span id="payment_type_name"></span>      
                                    </p>                                
                                </div>
                            </div> 
                            
                            <div class="col-lg-4 col-xs-12">
                                <label>Total Session</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> <span id="total_sessions"></span>      
                                    </p>                                
                                </div>
                            </div> 
                            <div></div>
                           
                            <div class="col-lg-4 col-xs-12">
                                <label>Price</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> <i class="fa fa-gbp"></i> 
                                         <span id="price_session_or_month"></span>
                                                                            
                                         
                                    </p>                             
                                </div>
                            </div> 
                        
                           <div class="col-lg-4 col-xs-12">
                                <label>Total Price</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"><i class="fa fa-gbp"></i>  <span id="total_price"></span>      
                                    </p>                                
                                </div>
                            </div> 
                            <div class="col-lg-4 col-xs-12">
                                <label>Notice Period</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> <span id="notice_period"></span> 

                                    </p>                                
                                </div>
                            </div> 
                             
                            <div></div>
                            <div class="col-lg-4 col-xs-12">
                                <label>Contract</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> <span id="contract"></span>      
                                    </p>                                
                                </div>
                            </div> 

                            
                          
                            
                            
      
        </div>
            </div>
      </div>
  </div>
</div>
<button type="button" class="btn btn-default success-close" data-dismiss="modal" >Close</button>

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


  $("#bootstrap-slot-data-table").on("click",".detail-products-modal-btn1", function(){ 
    // alert('ddd');
    
    var contract = $(this).data("personal-contract");
    var product_days = $(this).data("personal-training-day");
   var notice_period_value= $(this).data("personal-notice-period-value");
    var notice_period= $(this).data("personal-notice-period");
    var training_name = $(this).data("personal-training-name");
    var payment_type_name = $(this).data("personal-payment-type-name");
    var total_sessions = $(this).data("personal-total-sessions");
    var price_session_or_month = $(this).data("personal-price-session-or-month");
    var total_price = $(this).data("personal-total-price");
    
    $('#contract').text(contract);
    $('#product_days').text(product_days);
    
     
    $('#training_name').text(training_name);
    $('#payment_type_name').text(payment_type_name);
    $('#total_sessions').text(total_sessions);
  if($(this).data("personal-total-sessions")=='Unlimited')
  {
   
   $('#price_session_or_month').text(price_session_or_month+'/Month');
  }
else{
    $('#price_session_or_month').text(price_session_or_month+'/Session');
    }

     if($(this).data("personal-notice-period-value")=='NA')
  {
   $('#notice_period').text(notice_period_value);
   
  }
else{
    $('#notice_period').text(notice_period);
    }
    
    $('#total_price').text(total_price);
    $('#reason_modal').modal('show');
    });
  
});
</script>

<script type="text/javascript">
              function delete_client(id){ 
                alertify.confirm("Are you sure you want to delete this product?", function (e) {
                if (e) {
                  // alertify.success("You've clicked OK");
                  window.location.href="{{url('trainer/product-delete')}}/"+id;
                } else {
                  // alertify.error("You've clicked Cancel");
                  }                                       
                });
              }
            </script>
    

@endsection
