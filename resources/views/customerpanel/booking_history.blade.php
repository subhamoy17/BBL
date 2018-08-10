@extends('frontend.dashboard_submain') 
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
                    <td>{{($sum_slots)}}</td>
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
  <option value="future_confirm" {{Request::get('option')=='future_confirm' || Request::get('option')==''?'selected':''}} >Future confirm</option>
  <option value="future_pending" {{Request::get('option')=='future_pending'?'selected':''}} >Future pending</option>
  <option value="delete_request" {{Request::get('option')=='delete_request'?'selected':''}} >Delete request</option>
  <option value="declined_request" {{Request::get('option')=='declined_request'?'selected':''}} >Declined request</option>
  <option value="past_request" {{Request::get('option')=='past_request'?'selected':''}} >Past request</option>
 
  </select>
  <input type="text" name="start_date" value="{{Request::get('start_date')? Request::get('start_date') : \Carbon\Carbon::now()->toDateString()}}"/>
  <input type="text" name="end_date" value="{{Request::get('end_date')? Request::get('end_date') : \Carbon\Carbon::now()->addDays(30)->toDateString()}}"/>
  <button type="submit"   id="booking" class="btn btn-success" >Search</button>
</form>
                <thead>
                   @if(Request::get('option')=='past_request')
                   <h3 align="left" id="booking_title">Past booking request</h3>
                    @elseif(Request::get('option')=='future_pending')
                    <h3 align="left" id="booking_title">Future pending booking</h3>
                    @elseif(Request::get('option')=='delete_request')
                    <h3 align="left" id="booking_title">Deleted booking request</h3>
                      @elseif(Request::get('option')=='declined_request')
                      <h3 align="left" id="booking_title">Declined booking request</h3>
                       
                        @else
                        <h3 align="left" id="booking_title">Future accepted booking</h3>
                         @endif
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
                  <tr >
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
                    
                     @if(Request::get('option')=='past_request')
@if(count($mydata->past_mot))
<td> <a href="#" class="convert btn btn-info btn-sm"
  data-right_arm="{{$mydata->past_mot->right_arm}}"  data-left_arm="{{$mydata->past_mot->left_arm}}" data-chest="{{$mydata->past_mot->chest}}"
                      data-waist="{{$mydata->past_mot->waist}}" data-hips="{{$mydata->past_mot->hips}}"
                      data-right_thigh="{{$mydata->past_mot->right_thigh}}" data-right_calf="{{$mydata->past_mot->right_calf}}" 
                      data-left_calf="{{$mydata->past_mot->left_calf}}" data-weight="{{$mydata->past_mot->weight}}"
                      data-left_thigh="{{$mydata->past_mot->left_thigh}}" data-right_calf="{{$mydata->past_mot->right_calf}}"
                      data-left_calf="{{$mydata->past_mot->left_calf}}" data-starting_weight="{{$mydata->past_mot->starting_weight}}"  data-ending_weight="{{$mydata->past_mot->ending_weight}}"  data-heart_beat="{{$mydata->past_mot->heart_beat}}"  data-blood_pressure="{{$mydata->past_mot->blood_pressure}}"
                      data-height="{{$mydata->past_mot->height}}" class="btn btn-success">
                    View</a></td> 
                     @else
                     <td>N/A</td>
                     @endif
                
                     @else
                  <td>N/A</td>
                  @endif
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
     

<div id="convert_modal" class="modal fade common" role="dialog" >
  <div class="modal-dialog">
    <input type="hidden" id="this_row">
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Customers MOT</h4>
     <div> <select class="form-control unit_convert" id="convert_option">
        <option  id="metric" value="metric">Metric (cm.)</option>
        <option id="imperial" value="imperial">Imperial (inch.)</option>
      </select></div>
    </div>
      <div class="modal-body" id="hall_details_edit">
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <br class="clear" />
        </div>
        <div class="col-sm-12 col-xs-12">
            <input type="hidden" id="reason_id"></input>
            <input type="hidden" id="reason_action"></input>
            <div class="form-group">

              <div class="col-lg-4"><div class="rl">Right Arm / </div><div class="right_arm rv" ></div></div>
             <div class="col-lg-4"> <div class="rl">Left Arm / </div><div class="left_arm rv" ></div></div>
              <div class="col-lg-4"><div class="rl">Chest / </div><div class="chest rv" ></div></div><div class="clearfix"></div>
              <div class="col-lg-4"><div class="rl">Waist / </div><div class="waist rv" ></div></div>
              <div class="col-lg-4"><div class="rl">Hips / </div><div class="hips rv" ></div></div>
              <div class="col-lg-4"><div class="rl">Right thigh / </div><div class="right_thigh rv" ></div></div><div class="clearfix"></div>
              <div class="col-lg-4"><div class="rl">Left thigh / </div><div class="left_thigh rv" ></div></div>
              <div class="col-lg-4"><div class="rl">Right calf / </div><div class="right_calf rv" ></div></div>
              <div class="col-lg-4"><div class="rl">Left calf / </div><div class="left_calf rv" ></div></div>
               <div class="col-lg-4"><div class="rl">Starting weight / </div><div class="starting_weight rv" ></div></div>
              <div class="col-lg-4"><div class="rl">Ending weight / </div><div class="ending_weight rv" ></div></div>
              <div class="col-lg-4"><div class="rl">Heart beat / </div><div class="heart_beat rv" ></div></div>
               <div class="col-lg-4"><div class="rl">Blood pressure / </div><div class="blood_pressure rv" ></div></div>
               
                 <div class="col-lg-4"><div class="rl">Height / </div><div class="height rv" ></div></div>
                 
              
          </div>

      </div>
  </div>
</div>

</div>
</div>
</div>


<!-- <script type="text/javascript">
    $(document).ready(function() {

       
        
    } );
</script> -->


@endsection