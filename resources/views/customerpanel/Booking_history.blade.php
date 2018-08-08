@extends('frontend.submain') 
@section('content')

      <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab1">Tab 1</h3>
          <div id="tab1" class="tab_content">
            <div class="table-responsive table-bordered">
              <h3 align="center">Over all booking history</h3>
              <table class="table">
                <thead>
                  <tr>
                    <th>Total number of session reaming</th>
                     <th>Future pennding booking</th>
                     <th>Future accepted booking</th>
                     
                  </tr>
                </thead>
                <tbody>
                   @if($data )
                 
                  <tr>
                    <td>{{($sum_slots)-$count}}</td>
                    <td>{{$future_pending_count}}</td>
                    <td>{{$accepted_count}}</td>
                      
                  </tr>
              
                </tbody>
              </table>
            @endif
            </div>
          </div>
        </div>
<!-- <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab1">Tab 1</h3>
          <div id="tab1" class="tab_content">
            <div class="table-responsive table-bordered"> -->
              



              <table class="table">
              <form id="frm_search" method="get">
  <select align ="right" id="feature" name="option" >
  <option value="feature_confirm" <?php if($_GET['option'] == 'feature_confirm'){?> selected <?php } ?> >Future confirm</option>
  <option value="feature_pending" <?php if($_GET['option'] == 'feature_pending'){?> selected <?php } ?> >Future pending</option>
  <option value="delete_request" <?php if($_GET['option'] == 'delete_request'){?> selected <?php } ?> >Delete Request</option>
  <option value="declined_request" <?php if($_GET['option'] == 'declined_request'){?> selected <?php } ?> >Declined Request</option>
  </select>
  <input type="text" name="start_date" value="<?php 
  if(isset($_GET['start_date']) && !empty($_GET['start_date'])){ 
    echo $_GET['start_date']; }?>"/>
  <input type="text" name="end_date" value="<?php if(isset($_GET['end_date']) && !empty($_GET['end_date'])){ echo $_GET['end_date']; }?>"/>
  <button type="submit"   id="booking" class="btn btn-success" >Submit</button>
</form>
                <thead>
                   <h3 align="left" id="booking_title">Future confirm booking</h3>
                  <tr>
                    <th>Trainer Name</th>
                     
                     <th>Booked On</th>
                     <th>Booking date & time</th>
                       <th> Booking status</th>
                       <th>MOT</th>
                  </tr>
                </thead>
                <tbody id="tbody_empty">
                   @if(count($data)>0)
                   @foreach($data as $key=>$mydata)
                  <tr>
                    <td>{{$mydata->users_name}}</td>
                    <td>{{$mydata->created_at}}</td>
                     <td>
                     <?php  $date=$mydata->slot_date;
                      $time =$mydata->slot_time;
                      $merge =$date.' '.$time;
                       ?>
                      {{$merge}}
                      </td>
                    <td>{{$mydata->status}}</td>
                    
                     
                  <td>N/A</td>
                  </tr>
                @endforeach
                @else
                <tr><td colspan='5' align='center'>
                No post available
              </td>
              </tr>
                </tbody>
              </table>
              @endif
           


   <div id="book_history">{{$data->links()}}</div>
      <!-- <div id="book_history">{!! $data->render() !!}</div> -->



  
@endsection