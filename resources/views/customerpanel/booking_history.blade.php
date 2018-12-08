@extends('frontend.dashboard_submain') 
@section('content')


                                      

      <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab1">Tab 1</h3>
          <div id="tab1" class="tab_content">
            <div class="table-responsive table-bordered">
           <a href="{{url('customer/booking-bootcamp')}}" class="btn btn-success bk-slt-btn">Book Bootcamp Session</a>   
        <!-- <a href="{{url('customer/booking_slot')}}" class="btn btn-success bk-slt-btn">Book PT Session</a> -->
              <h3 align="center">Booking history</h3>
              <table class="table">
                <thead>
                  <tr>
                    <th>Total number of session reamaining</th>
                     <th>Future booking</th>
                     <th>Declined booking</th>
                     <th>Past booking</th>
                  </tr>
                </thead>
                <tbody>
                  
                 
                  <tr>
                    <td>{{$no_of_sessions}}</td>
                    <td>{{$total_future_booking}}</td>
                    <td>{{$total_cancelled_booking}}</td>
                    <td>{{$total_past_booking}}</td>
                  </tr>
              
                </tbody>
              </table>
              <div class="tbl-srch">
              	 <form id="frm_search" method="get">
					<select align ="right" id="feature" name="option" >
            <option value="future_booking" {{Request::get('option')=='future_booking' || Request::get('option')==''?'selected':''}} >Future booking</option>
  					<option value="cancelled_booking" {{Request::get('option')=='cancelled_booking'?'selected':''}} >Declined Booking</option>
  					<option value="past_booking" {{Request::get('option')=='past_booking'?'selected':''}} >Past Booking</option>
 					
  					</select>
  					<input id="datepicker" type="text" name="start_date" value="{{Request::get('start_date')? Request::get('start_date') : \Carbon\Carbon::now()->toDateString()}}" readonly="true" />
  					<input id="datepicker2" type="text" name="end_date" value="{{Request::get('end_date')? Request::get('end_date') : \Carbon\Carbon::now()->addDays(30)->toDateString()}}"  readonly="true"/>
  					<button type="submit"   id="booking" class="btn btn-success" >Search</button>
				</form>
              </div>
              
            	<table class="table">
 
                <thead>
                    @if(Request::get('option')=='cancelled_booking')
                    <h3 align="left" id="booking_title">Cancelled Booking</h3>
                    @elseif(Request::get('option')=='past_booking')
                    <h3 align="left" id="booking_title">Past Booking</h3>
                    @else
                   <h3 align="left" id="booking_title">Future booking</h3>
                    @endif
                  <tr>
                    <th>Address</th>
                    <th>Booked On</th>
                    <th>Booking date</th>
                    <th>Booking time</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="tbody_empty">
                   @if(count($all_booking)>0)
                   @foreach($all_booking as $key=>$eachbooking)

                  <tr >
                    <td>{{$eachbooking->address_line1}}</td>
                    <td>{{date('d F Y', strtotime($eachbooking->created_at))}}</td>
                     <td>               
                      {{date('d F Y', strtotime($eachbooking->plan_date))}}
                      </td>
                    <td>{{date('h:i A', strtotime($eachbooking->plan_st_time))}} To {{date('h:i A', strtotime($eachbooking->plan_end_time))}}</td>
                    <td>
                      @if(Request::get('option')=='cancelled_booking')
                        Declined by trainer
                      @elseif(Request::get('option')=='past_booking')
                        Past booking
                      @elseif(Request::get('option')=='future_booking' || Request::segment(2)=='mybooking')
                        Upcoming sessions
                      @endif
                    </td>
                     
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

   <div id="book_history">{{$all_booking->links()}}</div>
     



@endsection