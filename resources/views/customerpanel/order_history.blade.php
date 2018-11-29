@extends('frontend.dashboard_submain') 
@section('content')

<div class="tab_container">
  <h3 class="d_active tab_drawer_heading" rel="tab2">Tab 2</h3>

  <div id="tab2" class="tab_content">

    <div class="table-responsive table-bordered">
        <!-- <a href="{{url('customer/booking_slot')}}" class="btn btn-success bk-slt-btn">Book PT Session</a> -->
     <h3 align="center">My Order History</h3>
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
            <th>Product Name</th>
            <th>Product Price</th>
            
            <th>Purchased On</th>
            <th>Validity Date</th>
            <th>No of Session</th>
            <th>Remaining Session</th>
            <th>Payment Mode</th>
            <th>Payment Type</th>
            <th>Status</th>
            <!-- <th>Payment Mode</th> -->
           
            
          </tr>
        </thead>
        <tbody>
         
@if(count($my_order_history)>0)
          @foreach($my_order_history as $key=>$myorder)
          <tr>
            <!--  -->
            <td>{{$myorder->training_name}}</td>
            <td> <i class="fa fa-gbp"></i> {{$myorder->total_price}}</td>
           
          <td>{{date('d F Y', strtotime($myorder->order_purchase_date))}}</td>
          <td>{{date('d F Y', strtotime($myorder->order_validity_date))}}</td>
          <td>{{$myorder->total_sessions}}</td>
          <td>0</td>
          <td>{{$myorder->payment_option}}</td>
          <td>{{$myorder->payment_type_name}}</td>
          <td>{{$myorder->status? 'Active' : 'Inactive'}}</td>
           
           
           
           
          </tr>
         
            @endforeach
          @else
           <tr><td colspan='9' align='center'>
                No order history available
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