@extends('frontend.submain') 
@section('content')







<div class="tab_container">
  <h3 class="d_active tab_drawer_heading" rel="tab2">Tab 2</h3>
  <div id="tab2" class="tab_content">
    <div class="table-responsive table-bordered">
      <table class="table">
        <form id="frm_purchase_search">
         <!--  <input type="text" name="daterange"  value="2018-08-06 - 2018-09-12"/> -->

          <input type="text" name="start_date" value="<?php 
  if(isset($_GET['start_date']) && !empty($_GET['start_date'])){ 
    echo $_GET['start_date']; }?>"/>
  <input type="text" name="end_date" value="<?php if(isset($_GET['end_date']) && !empty($_GET['end_date'])){ echo $_GET['end_date']; }?>"/>
          <button type="submit" id="booking" class="btn btn-success" >Submit</button>
        </form>
        <thead>
          <tr>
            <th>Package Name</th>
            <th>Package Price</th>
            <th>Package validity</th>
            <th>Purchases Date</th>
            <th>Purchases End Date</th>
            <!-- <th>Payment Mode</th> -->
            <th>Total Slots </th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if(count($purchases_data)>0)
          @foreach($purchases_data as $key=>$mydata)
          <tr>
            <!--  -->
            <td>{{$mydata->slots_name}}</td>
            <td>{{$mydata->slots_price}}</td>
            <td>{{$mydata->slots_validity}}</td>
            <td>{{$mydata->purchases_date}}</td>
            <td>{{$mydata->package_validity_date}}</td>
            <td>{{$mydata->slots_number}}</td>
            <td>Status</td>
            <td>
              @if ((isset($mydata->slots_number) && !empty($mydata->slots_number)) &&($mydata->timeremaining < $mydata->slots_validity))
              <a href="{{url('customer/booking_slot')}}/{{$mydata->id}}"class="btn btn-success">Active</a>
              @else
              Inactive
              @endif
            </td>
          </tr>
          @endforeach
          @else
          <tr>No Data Found.</tr>
        @endif
        </tbody> 
      </table>
    </div>
     <div id="purchase_link">{{$purchases_data->links()}}</div>
  </div>

</div>

</div>
<!-- .tab_container -->
</div>
</div>

@endsection