@extends('frontend.dashboard_submain') 
@section('content')

<div class="tab_container">
  <h3 class="d_active tab_drawer_heading" rel="tab2">Tab 2</h3>

  <div id="tab2" class="tab_content">

    <div class="table-responsive table-bordered">
        <!-- <a href="{{url('customer/booking_slot')}}" class="btn btn-success bk-slt-btn">Book PT Session</a> -->
     <h3 align="center">My Common Diet Plan History</h3>
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
            <th>Plan Name</th>
            <th>Plan Price</th>
            
            <th>Plan Purchases Date</th>
            <th>Payment Reference Id</th>
            <th>Status</th>
            <!-- <th>Payment Mode</th> -->
           
            
          </tr>
        </thead>
        <tbody>
         
@if(count($common_diet_plan)>0)
          @foreach($common_diet_plan as $key=>$mydietplan)
          <tr>
            <!--  -->
            <td>{{$mydietplan->plan_name}}</td>
            <td> <i class="fa fa-gbp"></i> {{$mydietplan->plan_price}}</td>
           
          <td>{{date('d F Y', strtotime($mydietplan->purchase_date))}}</td>
          <td>{{$mydietplan->payment_reference_id}}</td>
            <td>{{$mydietplan->status}}</td>
           
           
           
          </tr>
         
            @endforeach
          @else
           <tr><td colspan='8' align='center'>
                No diet plan available
              </td>
              </tr>

        @endif

       

        

        </tbody> 
      </table>
    </div>

     <div id="diet_plan_link">{{$common_diet_plan->links()}}</div>
  </div>

</div>

</div>
<!-- .tab_container -->
</div>
</div>




@endsection