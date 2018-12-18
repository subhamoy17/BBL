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
@if(Auth::user()->master_trainer==1)

  <div class="breadcrumbs">
    <div class="col-sm-8">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Customer's Order</h1>
            </div>
        </div>
    </div>
    
</div>

<div class="content mt-3" style="margin-top: 0px !important;">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          @if (session()->has('success'))
              <div class="alert alert-success">
                {{ session()->get('success') }}
              </div>
            @endif
          <div id="loading-img"></div>
            <div class="card-body">
            
              <table id="bootstrap-slot-data-table" class="display responsive table-striped table-bordered" width="100%">
                <thead>
                  <tr>
                      <th>Customer Name</th>
                       <th>Plan Type</th>
                        <th>Plan Price</th>
                      
                      <th>No of Session</th>
                      <th>Remaining Session</th>
                      
                      <th>Payment Status</th>
                     
                        
                     </tr> 
                </thead>
                <tbody>
                                
                    <tr>
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
                        </tr>
                    
                        </tbody>
                        </table>
          <div class="breadcrumbs">
    <div class="col-sm-8">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Choose date to active order</h1>
            </div>
        </div>
    </div>
    
</div>
      <form  action="{{route('active_order_success')}}" class="slct-margin" id="submit_bootcamp_session" method="post" autocomplete="off">
          {{ csrf_field() }}

          <input type="hidden" name="order_id" value="{{$order_history->order_details_id}}">
        
        <div class="row form-group">
          <div class="col-lg-3">
            <input type="text" id="order_validity_date" name="order_validity_date" class="form-control" readonly="true" placeholder="Date">
          </div>
          <div class="col-lg-3">
            <button  id="active_order_submit" class="btn btn-primary pull-right" style="width: 100px;">Active</button>
          </div>
        </div>
      </form>



                    </div>
                 
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div>
    <!-- .content -->


<script>
  $(function () {
    $( "#order_validity_date" ).datepicker({
      dateFormat: "yy-mm-dd",
      beforeShowDay: NotBeforeToday
    });
  } );

  function NotBeforeToday(date)
  {
    var now = new Date();//this gets the current date and time
    if (date.getFullYear() == now.getFullYear() && date.getMonth() == now.getMonth() && date.getDate() >= now.getDate())
        return [true];
    if (date.getFullYear() >= now.getFullYear() && date.getMonth() > now.getMonth())
       return [true];
     if (date.getFullYear() > now.getFullYear())
       return [true];
    return [false];
  }


</script>

@endif
@endsection

