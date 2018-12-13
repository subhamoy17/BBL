@extends('frontend.dashboard_submain') 
@section('content')

<div class="tab_container">
  <h3 class="d_active tab_drawer_heading" rel="tab2">Tab 2</h3>

  <div id="tab2" class="tab_content">

    <div class="table-responsive table-bordered">
        <!-- <a href="{{url('customer/booking_slot')}}" class="btn btn-success bk-slt-btn">Book PT Session</a> -->

        <a href="{{url('customer/booking-bootcamp')}}" class="btn btn-success bk-slt-btn">Book Bootcamp Session</a> 
     <h3 align="center">Purchased History</h3>
    <div class="tbl-srch tbl-srch2">
       <form id="frm_purchase_search">
        

          <input id="datepicker3" type="text" placeholder="Please select a date" name="start_date" readonly="true" value="<?php 
  if(isset($_GET['start_date']) && !empty($_GET['start_date'])){ 
    echo $_GET['start_date']; }?>"/>
  <input id="datepicker4" type="text" readonly="true" name="end_date" placeholder="Please select a date" value="<?php if(isset($_GET['end_date']) && !empty($_GET['end_date'])){ echo $_GET['end_date']; }?>" />
          <button type="submit" id="booking" class="btn btn-success" >Submit</button>
        </form>
        
    </div>

      <table class="table">
        <thead>
          <tr>
            <th>Plan Type</th>
            <th>Plan Price</th>
            
            <th>Purchased On</th>
            <th>Validity Date</th>
            <th>No of Session</th>
            <th>Remaining Session</th>
            <th>Payment Mode</th>
            <th>Plan Scheme</th>
            <th>Status</th>
            <!-- <th>Payment Mode</th> -->
           
            
          </tr>
        </thead>
        <tbody>
         
@if(count($my_order_history)>0)
          @foreach($my_order_history as $key=>$myorder)
          <tr>
            <!--  -->
            <td>{{$myorder->training_type}}</td>
            <td> <i class="fa fa-gbp"></i> {{$myorder->total_price}}</td>
           
          <td>{{date('d F Y', strtotime($myorder->order_purchase_date))}}</td>
          @if($myorder->order_validity_date < "2050-12-30")
          <td>
            
            {{date('d F Y', strtotime($myorder->order_validity_date))}}
          </td>
           @else
           <td> Unlimited</td>
          @endif
          
          <td>{{$myorder->total_sessions}}</td>
          @if($myorder->total_sessions=="Unlimited")
          <td>--</td>
          @else
          <td>{{$myorder->remaining_sessions}}</td>
          @endif
          <td>{{$myorder->payment_option}}</td>
          <td>{{$myorder->payment_type}}</td>
          <td>
            @if($myorder->status=='1')
              Payment Success
            @elseif($myorder->status=='0' && $myorder->payment_status == 'Inprogress')
              Payment Inprogress
            @elseif($myorder->status=='0' && $myorder->payment_status == 'Decline')
              Payment Decline
            @elseif($myorder->status=='0' && $myorder->payment_status == 'Failed' && $myorder->payment_option == 'Stripe')
              Payment Failed
            @endif
          </td>
          </tr>
         
            @endforeach
          @else
           <tr><td colspan='9' align='center'>
                No purchased history available
              </td>
              </tr>

        @endif

       

        

        </tbody> 
      </table>
    </div>

     <div id="diet_plan_link">{{$my_order_history->links()}}</div>
  </div>

</div>

</div>
<!-- .tab_container -->
</div>
</div>




@endsection