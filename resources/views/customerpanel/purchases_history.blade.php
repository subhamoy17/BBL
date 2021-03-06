@extends('frontend.dashboard_submain') 
@section('content')

<div class="tab_container">
  <h3 class="d_active tab_drawer_heading" rel="tab2">Tab 2</h3>

  <div id="tab2" class="tab_content">

    <div class="table-responsive table-bordered">
        <a href="{{url('customer/booking-personal-training')}}" class="btn btn-success bk-slt-btn">Book PT Session</a>
     <h3 align="center">All Purchase History</h3>
    <div class="tbl-srch tbl-srch2">
       <form id="frm_purchase_search">
         <!--  <input type="text" name="daterange"  value="2018-08-06 - 2018-09-12"/> -->

          <input id="datepicker3" type="text" placeholder="Please select a date" name="start_date" readonly="true" value="<?php 
  if(isset($_GET['start_date']) && !empty($_GET['start_date'])){ 
    echo $_GET['start_date']; }?>"/>
  <input id="datepicker4" type="text" readonly="true" name="end_date" placeholder="Please select a date" value="<?php if(isset($_GET['end_date']) && !empty($_GET['end_date'])){ echo $_GET['end_date']; }?>" />
          <button type="submit" id="booking" class="btn btn-success" ><i class="fa fa-search" aria-hidden="false" ></i></button>
        </form>
        
    </div>

      <table class="table">
        <thead>
          <tr>
            <th>Purchases Name</th>
            <th>Purchases Price</th>
            <!-- <th>Your Purchases Price</th> -->
            <!-- <th>Purchases validity</th> -->
            <th>Purchases On</th>
            <th>Purchases Validity</th>
            <!-- <th>Payment Mode</th> -->
            <th>Total Slots </th>
            <th>Remaining Slot(s)</th>
            <th>Payment Mode</th>
            <th>Status</th>
            
          </tr>
        </thead>
        <tbody>
          @if(count($purchases_data)>0)
          @foreach($purchases_data as $key=>$mydata)

          <tr>
            <!--  -->
            <td>{{$mydata->slots_name}}</td>
            @if($mydata->price > $mydata->slots_price)
            <td><span class="line_t2"> <i class="fa fa-gbp"></i> {{$mydata->price}}</span> <br>
             <i class="fa fa-gbp"></i> {{$mydata->slots_price}}</td>
             @else
             <td> <i class="fa fa-gbp"></i> {{$mydata->price}} </td>
             @endif
            <!-- <td>{{$mydata->slots_validity}} Days</td> -->
            <td>{{date('d F Y', strtotime($mydata->purchases_date))}}</td>
            <td>{{date('d F Y', strtotime($mydata->package_validity_date))}}</td>
            <td>{{$mydata->slots_number}}</td>
            <td>

              @if ($mydata->active_package==1 && $mydata->package_remaining>0 && $mydata->package_validity_date >= $remaining_session_request_now )
              
              <?php 
              $total_package_remaining=$mydata->package_remaining+$mydata->extra_package_remaining;
              ?>

              @else
              <?php
              $total_package_remaining=$mydata->extra_package_remaining;
              ?>

              @endif

              @if($total_package_remaining>$mydata->slots_number)
              
              <?php $others=$total_package_remaining-$mydata->slots_number;?>

              {{$total_package_remaining}}
               <!-- <font style="color: #ffa461;">aa</font> -->
              <span id="gg" class="toolclip" data-tooltipster='{"side":"left","animation":"fade"}' data-tooltip-content="#tooltip_content"><i class="fa fa-info-circle" style="margin-left: 5px;font-size: 15px;"></i></span>
              <div class="tooltip_templates">


          <span id="tooltip_content">
              <strong>{{$mydata->slots_number}}  + {{$others}} = {{$total_package_remaining}}</strong>
              <strong>{{$mydata->slots_number}} is remainig slot</strong>
              <strong>For extra {{$others}} slot read the below details</strong>
              <strong>a) If any slot was cancelled/declined from any previous active package.</strong>
              <strong>b) If any slot request from any previous active package is not entertained by any trainer.</strong>
              
          </span>
      </div>
              @else
              {{$total_package_remaining}}
              @if (($mydata->active_package==0 || $mydata->package_validity_date < $remaining_session_request_now) && $mydata->extra_package_remaining>0)

              
              @endif
              @endif
            </td>
             <td>{{$mydata->payment_options}}</td>
            <td> 

              @if (($mydata->active_package==1 && $mydata->package_remaining>0 && ($mydata->package_validity_date >= $remaining_session_request_now) ) || $mydata->extra_package_remaining>0)
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