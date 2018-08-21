
@extends('trainerlayouts.trainer_template')
@section('content')

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
    top: 33%;
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

</style>


@if(Auth::user()->master_trainer==1)



<div id="reason_modal" class="modal fade payment" role="dialog" >
  <div class="modal-dialog pay">
    
    <div class="modal-content">
      <div class="modal-body" id="hall_details_edit">
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <h3 class="pull-left customer-mot">Customers Payment</h3>
            <br class="clear" />
        </div>
        <div class="col-xs-12 divi-line">
        </div><br/>
        <div class="col-sm-12 col-xs-12">
            <input type="hidden" id="reason_id"></input>
            <input type="hidden" id="reason_action"></input>
            <div class="form-group">
				<div class="row">
              <div class="col-lg-4"><strong class="cus">Customer Name:</strong></div><div class="col-lg-8 name"></div>
               <div class="col-lg-4"><strong class="cus">Purchases Date:</strong></div><div class="col-lg-8 purchases_date" ></div>
                <div class="col-lg-4"><strong class="cus">Packege Name:</strong></div><div class="col-lg-8 slots_name" ></div>
              <div class="col-lg-4"><strong class="cus">Payment Id:</strong></div><div class="col-lg-8 payment_id" ></div>
            <div class="col-lg-4" id="pay_des"  style="display: none;"><strong class="cus">Description:</strong></div><div class="col-lg-8 description" ></div>
            
             <div class="col-lg-4" id="pay_img"  style="display: none;"><strong class="cus">Images:</strong></div><div><img class="col-lg-8 modal_image" width="100"> </div>
            
          </div>
			</div>
      </div>
  </div>
</div>

</div>
</div>
</div>
              
   

<div id="success-msg" class="alert alert-success alert-dismissible" style="display: none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="icon fa fa-check"></i>Hi!
 One request has been approved successfully.
</div>
<div id="decline-msg" class="alert alert-warning alert-dismissible" style="display: none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="icon fa fa-info-circle"></i>Hi!
 One request has been declined successfully.
</div>
<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Payment History</h1>
      </div>
    </div>
  </div>
</div>
<div class="content mt-3">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
           <div class="group">
            <div id="loading-img"></div>
          <div class="card-body">
            <table id="bootstrap-slot-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th id='slno'>Sl. No.</th>
                    <th>Customers </th>
                  <th> Package</th>
                  <th> Price</th>
                  <th>Payment Mode</th>
                  <th>Purchases Date</th>
                  <th>Status</th>
                  <th>Action </th>
                </tr>
              </thead>
              <tbody>
                 @if(count($data)>0)
                @foreach($data as $key=>$mydata)
                <tr>
                  <td>{{++$key}}</td>
                      <td>{{$mydata->name}}</td>
                  <td>{{$mydata->slots_name}}</td>
                  <td><i class="fa fa-gbp"></i>{{$mydata->slots_price}}</td>
                  <td>{{$mydata->payment_options}}</td>
                  <td>{{$mydata->purchases_date}}</td>
                 <td> 
                  @if($mydata->payment_options == 'Paypal' && $mydata->active_package == 0) 
                  Payment Not Success
                       @endif


                @if($mydata->payment_options == 'Paypal' && $mydata->active_package == 1)
                    Payment Success
                          @endif
                  @if($mydata->payment_options == 'Bank Transfer' && $mydata->status =='Inprogress' && $mydata->active_package == 0)
                          Payment Inprogress
                              @endif 
                        @if($mydata->payment_options == 'Bank Transfer' && $mydata->status =='Decline' && $mydata->active_package == 0 ) 
                              Payment Not Success
                           @endif
                  @if($mydata->payment_options == 'Bank Transfer' && $mydata->status =='Success' && $mydata->active_package == 1)
                            Payment Success
                              @endif 

                 </td>
              <td align="center" class="td-btn5">
                @if($mydata->payment_options == 'Bank Transfer' && $mydata->status =='Inprogress' && $mydata->active_package == 0)
               <button type="button" class="btn btn-success status-all" id="{{$mydata->id}}"><i class="fa fa-check"></i></button>
                 <button type="button" class="btn btn-danger status-all" id="{{$mydata->id}}"><i class="fa fa-times"></i></button>
                @endif
         
            <a href="#" class="payment btn btn-info btn-sm"  data-name="{{$mydata->name}}"   data-purchases_date="{{$mydata->purchases_date}}"  data-slots_name="{{$mydata->slots_name}}" data-payment_id="{{$mydata->payment_id}}" data-description="{{$mydata->description}}"   data-image="{{asset('backend/bankpay_images')}}/{{$mydata->image}}" data-noimage="{{$mydata->image}}"><i class="fa fa-eye" title="view details"  aria-hidden="true"></i></button>

                

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
      </div>
    </div>
  </div><!-- .animated -->
  

  @endif
<script type="text/javascript">
      $(document).ready(function(){
        
        $('.status-all').on('click',function(e) {
          var action = $.trim($(this).text());
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
 
  

  $.ajax({
    url: "{{route('payment_history_backend_request')}}",

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
      else
      {
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
else if (action == "Approve"){
  var Data =
  {
    'id': this.id,
   
    'action': action
  }


alertify.confirm("Are you sure you will be approve this payment?", function (e) {
 if (e) {
   
  $.ajax({
    url: "{{route('payment_history_backend_request')}}",

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

        $(".payment").click(function() {

          var name = $(this).data("name");
          var purchases_date=$(this).data("purchases_date");
          var slots_name=$(this).data("slots_name");
          var payment_id=$(this).data("payment_id");
          var description=$(this).data("description");
          var myimage=$(this).data('image');

         

            $('div.name').text(name); $('div.name').text(name);
            $('div.purchases_date').text(purchases_date); $('div.purchases_date').text(purchases_date);
           $('div.slots_name').text(slots_name); $('div.slots_name').text(slots_name);
        $('div.payment_id').text(payment_id); $('div.payment_id').text(payment_id);
        // $('div.description').text(description); $('div.description').text(description);
        
        // $('img.modal_image').attr('src',myimage); 
    
           if($(this).data('noimage')!=''){
            $('#pay_img').show();
            $('img.modal_image').attr('src',myimage); 
          }
          else{
            $("#pay_img").css({"display": "block"});
            $('#pay_img').hide();
            $('img.modal_image').attr('src','');
          }
           
             
          if(description!=''){
            $('#pay_des').show();
            $('div.description').text(description); 
          }
          else{
            $('#pay_des').hide();
             $('div.description').text(''); 
          }

            $('#reason_modal').modal('show');
        });
        $('#bootstrap-data-table-export').DataTable();
    } );
</script>









@endsection
