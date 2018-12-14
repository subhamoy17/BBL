
<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')


@section('content')
<script>
    // for shortin ,pagination,searching data using datatable concept
 $(document).ready(function() { 
$('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
        
        // disable shorting from slno,image and action columns
        "columnDefs": [ { "orderable": false, "targets": [0,7] } ],
        
    });
 } );

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
    <div class="col-sm-8">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Customer Purchased History</h1>
            </div>
        </div>
    </div>
    
</div>
<div id="success-msg" class="alert alert-success alert-dismissible" style="display: none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="icon fa fa-check"></i>Hi! One bank payment has been approved successfully.
</div>
<div id="decline-msg" class="alert alert-success alert-dismissible" style="display: none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="icon fa fa-info-circle"></i>Hi! One bank payment has been declined successfully.
</div>
<div class="content mt-3" style="margin-top: 0px !important;">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div id="loading-img"></div>
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
                      
                      <th>Payment Status</th>
                      <th>Action</th>
                        
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
                      <td>
                         @if($order_history->total_sessions=="Unlimited")
                          --
                          @else
                          {{$order_history->remaining_sessions}}
                          @endif
                      </td>
                      <td>
                        @if($order_history->total_price>0)
                          @if($order_history->status=='1')
                            Success
                          @elseif($order_history->status=='0' && $order_history->payment_status == 'Inprogress')
                            Inprogress
                          @elseif($order_history->status=='0' && $order_history->payment_status == 'Decline')
                            Decline
                          @elseif($order_history->status=='0' && $order_history->payment_status == 'Failed' && $order_history->payment_option == 'Stripe')
                          Failed
                          @endif
                        @else
                        --
                        @endif
                        </td>
                        <td align="center" class="td-btn5">

        @if($order_history->payment_option == 'Bank Transfer' && $order_history->status =='0' && $order_history->payment_status != 'Decline')

        <button type="button" class="btn btn-success status-all" title="Approve" data-msg="Approve" id="{{$order_history->order_details_id}}"><i class="fa fa-thumbs-up"></i></button>

         <button type="button"  title="Decline" class="btn btn-danger status-all" data-msg="Decline" id="{{$order_history->order_details_id}}"><i class="fa fa-thumbs-down"></i></button>

         <a class="detail-orders-modal-btn1 btn btn-info btn-sm order-show-icon" id="{{$order_history->order_details_id}}" href="#"   data-payment-option="{{$order_history->payment_option}}"  data-plan-price="{{$order_history->total_price}}" data-payment-type-name="{{$order_history->payment_type}}" data-purchased-on="{{date('d F Y', strtotime($order_history->order_purchase_date))}}" data-validity-date="{{$order_history->order_validity_date? date('d F Y', strtotime($order_history->order_validity_date)) : 'N/A'}}" data-payment-id="{{$order_history->payment_id}}" data-payment-description="{{$order_history->description? $order_history->description : 'N/A'}}" data-payment-image="{{asset('backend/bankpay_images')}}/{{$order_history->image}}" data-noimage="{{$order_history->image}}">
                              <i class="fa fa-eye" title="view details" aria-hidden="true" style="width: 13px; height: 18px;"></i></a>

          @else
          <a class="detail-orders-modal-btn1 btn btn-info btn-sm" id="{{$order_history->order_details_id}}" href="#"   data-payment-option="{{$order_history->payment_option}}"  data-plan-price="{{$order_history->total_price}}" data-payment-type-name="{{$order_history->payment_type}}" data-purchased-on="{{date('d F Y', strtotime($order_history->order_purchase_date))}}" data-validity-date="{{$order_history->order_validity_date? date('d F Y', strtotime($order_history->order_validity_date)) : 'N/A'}}" data-payment-id="{{$order_history->payment_id}}" data-payment-description="{{$order_history->description? $order_history->description : 'N/A'}}" data-payment-image="{{asset('backend/bankpay_images')}}/{{$order_history->image}}" data-noimage="{{$order_history->image}}">
                              <i class="fa fa-eye" title="view details" aria-hidden="true" style="width: 13px; height: 18px;"></i></a>

        @endif
                            
                  </td>
                         

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
            <div class="row" style="text-align: center;">
        
           
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
                        <div class="col-lg-4 col-xs-12">
                                <label>Order Ref Id</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> 
                                         <span id="payment_id"></span>
                                                                            
                                         
                                    </p>                             
                                </div>
                            </div> 
                            <div class="col-lg-4 col-xs-12">
                                <label>Plan Price</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> 
                                     <i class="fa fa-gbp"></i>     <span id="plan_price"></span>
                                                                            
                                         
                                    </p>                             
                                </div>
                            </div>              
              </div>
            </div>
          </div>
                <div id="payment" style="display: none;" class="col-sm-12 col-xs-12" >
                  <div class="form-group">
                    <div class="row" style="text-align: center;">
                            <div id="pay_des" class="col-lg-4 col-xs-12" style="display: none;">
                                <label>Bank Payment Description</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> 
                                         <span id="description"></span>
                                                                            
                                         
                                    </p>                             
                                </div>
                            </div> 

                           <div class="col-lg-4 col-xs-12" id="pay_img" style="display: none;">
                                <label>Bank Payment Image</label>
                                <div class="dispClass">
                                    <p class="detail-txt2"> 
                                         <a class="payment_image btn" target="_blank" style="color: #fff; background-color: #FF6347;   border-color: #FF6347;">Click to show</a>                                  
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


  $("#bootstrap-slot-data-table").on("click",".detail-orders-modal-btn1", function(){ 
    // alert('ddd');
    
    var payment_option = $(this).data("payment-option");
    var payment_type_name = $(this).data("payment-type-name");
   var purchased_on= $(this).data("purchased-on");
    var validity_date= $(this).data("validity-date");
    var payment_id= $(this).data("payment-id");
     var plan_price= $(this).data("plan-price");
    var description= $(this).data("payment-description");
    var payment_image= $(this).data("payment-image");
    var noimage= $(this).data("noimage");
    $('#payment_option').text(payment_option);
    $('#payment_type_name').text(payment_type_name);
    
     
    $('#purchased_on').text(purchased_on);
    $('#validity_date').text(validity_date);
    $('#payment_id').text(payment_id);
    $('#plan_price').text(plan_price);

    if($(this).data('noimage')!= ''){
      
            $('#pay_img').show();
            $('a.payment_image').attr('href',payment_image); 

          }

          else 
          {
            
            $("#pay_img").css({"display": "block"});
            $('#pay_img').hide();
            $('a.payment_image').attr('src','');
             
          }

          if($(this).data('payment-description')!= ''){
            
            $('#pay_des').show();
            $('#description').text(description);
          }

          else{
            $('#pay_des').hide();

          }

          if($(this).data('payment-option')=='Bank Transfer'){
            $('#payment').show();
            
          }

          else{
            $('#payment').hide();
          }


    $('#reason_modal').modal('show');
    });
  
});
</script>

<script type="text/javascript">
      $(document).ready(function(){
        
       $("#bootstrap-slot-data-table").on("click", ".status-all", function(e) {
          var action = $(this).data("msg");
          console.log(action);
          var row = this.closest('tr');
          console.log(row);
      console.log(action);
if (action == "Decline"){
  var Data =
  {
    'id': this.id,
   
    'action': action
  }

  alertify.confirm("Are you sure you want to decline this payment?", function (e) {
     if (e) { 
 $(".card-body").css("opacity", .2);
  $("#loading-img").css({"display": "block"});

  $.ajax({
    url: "{{route('order_history_backend_request')}}",

    json_enc: Data,
    type: "GET",
    dataType: "json",
    data:
    {
      'data': Data,
    },
    success: function (data)
    {
      if(data==1){
        //console.log("Approve response");
      //console.log(data);
      $(".card-body").css("opacity", .2);
         $("#loading-img").css({"display": "block"});

      $('#success-msg').show();
      setTimeout(function(){
        $('#success-msg').hide();
 window.location.reload();
      }, 5000);
      }
      else
      {
        //console.log("Decline decline");
      //console.log(data);
   $(".card-body").css("opacity", .2);
   $("#loading-img").css({"display": "block"});
      $('#decline-msg').show();
      setTimeout(function(){
        $('#decline-msg').hide();
         window.location.reload();
      }, 5000);


      }
      
    }
  });
       }
        else
        {

        }

        });
}
else if (action == "Approve"){
  var Data =
  {
    'id': this.id,
   
    'action': action
  }


alertify.confirm("Are you sure you will be approve this payment?", function (e) {
 if (e) {
  $(".card-body").css("opacity", .2);
  $("#loading-img").css({"display": "block"});
   
  $.ajax({
    url: "{{route('order_history_backend_request')}}",

    json_enc: Data,
    type: "GET",
    dataType: "json",
    data:
    {
      'data': Data,
    },
    success: function (data)
    {
      if(data==1){
        console.log("Approve response");
      console.log(data);
      $(".card-body").css("opacity", .2);
         $("#loading-img").css({"display": "block"});

      $('#success-msg').show();
      setTimeout(function(){
        $('#success-msg').hide();
 window.location.reload();
      }, 5000);
      }
      else{
        console.log("Decline decline");
      console.log(data);
   $(".card-body").css("opacity", .2);
      $("#loading-img").css({"display": "block"});
      $('#decline-msg').show();
      setTimeout(function(){
        $('#decline-msg').hide();
         window.location.reload();
      }, 5000);


      }
      
    }
  });
}
  else 
 
  {           


   }   
 });
}
});


      });
    </script>
    

@endsection
