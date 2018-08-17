@extends('frontend.dashboard_submain') 
@section('content')

<div class="tab_container">
  <h3 class="d_active tab_drawer_heading" rel="tab2">Tab 2</h3>

  <div id="tab2" class="tab_content">

    <div class="table-responsive table-bordered">
        @if($remaining_session_request>0)
        <a href="{{url('customer/booking_slot')}}/{{Auth::guard('customer')->user()->id}}" class="btn btn-success bk-slt-btn">Send Slot Request</a>
        @else
        <a href="{{url('customer/booking_slot')}}/{{0}}"class="btn btn-success bk-slt-btn">Send Slot Request</a>
        @endif
     <h3 align="center">All Purchase History</h3>
		<div class="tbl-srch tbl-srch2">
			 <form id="frm_purchase_search">
         <!--  <input type="text" name="daterange"  value="2018-08-06 - 2018-09-12"/> -->

          <input id="datepicker3" type="text" name="start_date" value="<?php 
  if(isset($_GET['start_date']) && !empty($_GET['start_date'])){ 
    echo $_GET['start_date']; }?>"/>
  <input id="datepicker4" type="text" name="end_date" value="<?php if(isset($_GET['end_date']) && !empty($_GET['end_date'])){ echo $_GET['end_date']; }?>"/>
          <button type="submit" id="booking" class="btn btn-success" >Submit</button>
        </form>
        
		</div>

      <table class="table">
        <thead>
          <tr>
            <th>Package Name</th>
            <th>Package Price</th>
            <th>Package validity</th>
            <th>Purchases Date</th>
            <th>Purchases End Date</th>
            <!-- <th>Payment Mode</th> -->
            <th>Total Slots </th>
            <th>Remaining Slot(s)</th>
            <th>Status</th>
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
            <td>@if($mydata->package_remaining>$mydata->slots_number)
              <?php $others=$mydata->package_remaining-$mydata->slots_number;?>
              {{$mydata->slots_number}} + {{$others}}
              <div id="extra_session">Sample</div>
              <div class="modal-body extra_session_div" style="display: none;">
                    <h5 class="profile_modal_body" id="exampleModalLabel">This is the sample of video link ---> https://www.youtube.com/embed/93nnzrYffVo or https://www.youtube.com/watch?v=93nnzrYffVo</h5>
                </div>
              @else
              {{$mydata->package_remaining}}
              @endif
            </td>
            <td> 

              @if ($mydata->active_package==1 && $mydata->package_remaining>0 && ($mydata->package_validity_date >= $remaining_session_request_now))
              Active
              @else
              Inactive
              @endif
            </td>
          </tr>
          @endforeach
          @else
           <tr><td colspan='8' align='center'>
                No post available
              </td>
              </tr>

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