@extends('frontend.dashboard_submain') 
@section('content')


                                      

      <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab1">Tab 1</h3>
          <div id="tab1" class="tab_content">
            <div class="table-responsive table-bordered">
              @if($remaining_session_request>0)
        <a href="{{url('customer/booking_slot')}}/{{Auth::guard('customer')->user()->id}}" class="btn btn-success bk-slt-btn">Send Slot Request</a>
        @else
        <a href="{{url('customer/booking_slot')}}/{{0}}"class="btn btn-success bk-slt-btn">Send Slot Request</a>
        @endif
         @if (session('session_delete'))
                                <div class="alert alert-danger">
                                    {{ session('session_delete') }}
                                </div>
                            @endif
              <h3 align="center">Booking history</h3>
              <table class="table">
                <thead>
                  <tr>
                    <th>Total number of session reamaining</th>
                     <th>Future pending booking</th>
                     <th>Future accepted booking</th>
                     
                  </tr>
                </thead>
                <tbody>
                   @if($data )
                 
                  <tr>
                    <td>
                      
                      {{($sum_slots)}}
                      
                    </td>
                    <td>{{$future_pending_count}}</td>
                    <td>{{$accepted_count}}</td>
                      
                  </tr>
              @endif
                </tbody>
              </table>
              <div class="tbl-srch">
              	 <form id="frm_search" method="get">
					<select align ="right" id="feature" name="option" >
  					<option value="future_confirm" {{Request::get('option')=='future_confirm' || Request::get('option')==''?'selected':''}} >Future accepted</option>
  					<option value="future_pending" {{Request::get('option')=='future_pending'?'selected':''}} >Future pending</option>
  					<option value="delete_request" {{Request::get('option')=='delete_request'?'selected':''}} >Delete request</option>
  					<option value="declined_request" {{Request::get('option')=='declined_request'?'selected':''}} >Declined request</option>
  					<option value="past_request" {{Request::get('option')=='past_request'?'selected':''}} >Past request</option>
 					
  					</select>
  					<input id="datepicker" type="text" name="start_date" value="{{Request::get('start_date')? Request::get('start_date') : \Carbon\Carbon::now()->toDateString()}}" readonly="true" />
  					<input id="datepicker2" type="text" name="end_date" value="{{Request::get('end_date')? Request::get('end_date') : \Carbon\Carbon::now()->addDays(30)->toDateString()}}"  readonly="true"/>
  					<button type="submit"   id="booking" class="btn btn-success" >Search</button>
				</form>
              </div>
              
            	<table class="table">
 
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
                        <h3 align="left" id="booking_title">Future confirm booking</h3>
                         @endif
                  <tr>
                    <th>Trainer Name</th>
                     
                     <th>Booked On</th>
                     <th>Booking date & time</th>
                       <th>Booking status</th>
                       <th>MOT</th>
                       @if(Request::get('option')=='future_pending' || Request::get('option')=='future_confirm' || Request::get('option')=='')
                       <th>Action</th>
                       @endif
                  </tr>
                </thead>
                <tbody id="tbody_empty">
                   @if(count($data)>0)
                   @foreach($data as $key=>$mydata)
                  <tr >
                    <td>{{$mydata->users_name}}</td>
                    <td>{{date('d F Y', strtotime($mydata->created_at))}}</td>
                     <td>
                     <?php  $date=$mydata->slot_date;
                      $time =$mydata->slot_time;
                      $merge =date('d F Y', strtotime($date)).' '.date('h:i A', strtotime($time));
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
                      data-height="{{$mydata->past_mot->height}}" data-description="{{$mydata->past_mot->description}}" class="btn btn-success">
                    View</a></td> 
                     @else
                     <td>N/A</td>
                     @endif
                
                     @else
                  <td>N/A</td>
                  @endif

                  
                  <td><a href="{{route('customer_session_delete',['id'=>$mydata->slot_id])}}"  
                 class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this session?');">
                    Delete</a></td>
                   
                    
                     
                  </tr>
                @endforeach
                @else
                <tr><td colspan='6' align='center'>
                No record found
              </td>
              </tr>
                </tbody>
              </table>
              @endif
            </div>
          </div>
        </div>

   <div id="book_history">{{$data->links()}}</div>
     

<div id="convert_modal" class="modal fade common mot-mod" role="dialog" >
  <div class="modal-dialog">
    <input type="hidden" id="this_row">
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">My MOT</h4>
     <div class="mdl-optn"> <select class="form-control unit_convert" id="convert_option">
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
                 <div class="col-lg-2"><div class="wrp2"><div class="rl">Right Arm </div>&nbsp;<small class="inch" style="display: none;">(Inch)</small><small class="cm">(cm)</small><div class="right_arm rv" ></div></div></div>
             <div class="col-lg-2"> <div class="wrp2"><div class="rl">Left Arm</div>&nbsp;<small class="inch" style="display: none;">(Inch)</small><small class="cm">(cm)</small><div class="left_arm rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Chest</div>&nbsp;<small class="inch" style="display: none;">(Inch)</small><small class="cm">(cm)</small><div class="chest rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Waist</div>&nbsp;<small class="inch" style="display: none;">(Inch)</small><small class="cm">(cm)</small><div class="waist rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Hips</div>&nbsp;<small class="inch" style="display: none;">(Inch)</small><small class="cm">(cm)</small><div class="hips rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Right thigh</div>&nbsp;<small class="inch" style="display: none;">(Inch)</small><small class="cm">(cm)</small><div class="right_thigh rv" ></div></div></div><div class="clearfix"></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Left thigh</div>&nbsp;<small class="inch" style="display: none;">(Inch)</small><small class="cm">(cm)</small><div class="left_thigh rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Right calf</div>&nbsp;<small class="inch" style="display: none;">(Inch)</small><small class="cm">(cm)</small><div class="right_calf rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Left calf</div>&nbsp;<small class="inch" style="display: none;">(Inch)</small><small class="cm">(cm)</small><div class="left_calf rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Starting weight</div>&nbsp;<small class="inch" style="display: none;">(pound)</small><small class="cm">(kg)</small><div class="starting_weight rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Ending weight</div>&nbsp;<small class="inch" style="display: none;">(pound)</small><small class="cm">(kg)</small><div class="ending_weight rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Heart beat</div>&nbsp;<small>(bpm)</small><div class="heart_beat rv" ></div></div></div>
               <div class="col-lg-6"><div class="wrp"><div class="rl">Blood pressure</div>&nbsp;<small>(mmHg)</small><div class="blood_pressure rv" ></div></div></div>
               
                 <div class="col-lg-6"><div class="wrp"><div class="rl">Height</div>&nbsp;<small class="inch" style="display: none;">(Inch)</small><small class="cm">(cm)</small><div class="height rv" ></div></div></div>
                 <div class="col-lg-12">
          <div id="des" class="mot-text" style="display: none;">
            <h6>Description</h6>
            <textarea class="description"></textarea>
          </div>
            </div>
              
          </div>

      </div>
  </div>
</div>

</div>
</div>
</div>

@endsection