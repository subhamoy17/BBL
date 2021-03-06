@extends('frontend.dashboard_submain') 
@section('content')                              

<div class="tab_container">
  <h3 class="d_active tab_drawer_heading" rel="tab1">Tab 1</h3>
  <div id="tab1" class="tab_content">
    <div class="table-responsive table-bordered">
      <div class="my-bkng-btn">
        <a href="{{url('customer/booking-bootcamp')}}" class="btn btn-success">Book Bootcamp Session</a><a href="{{url('customer/booking-personal-training')}}" class="btn btn-success">Book PT Session</a>
      </div>

      @if (session('bootcamp_session_cancelled'))
      <div class="alert alert-success">
        {{ session('bootcamp_session_cancelled') }}
      </div>
      @endif

      @if (session('pt_session_cancelled'))
      <div class="alert alert-success">
        {{ session('pt_session_cancelled') }}
      </div>
      @endif
      
      <h3 align="center">Booking history</h3>
      <table class="table">
        <thead>
          <tr>
            <th>Package type</th>
            <th>Total number of session remaining</th>
            <th>Past booking</th>
            <th>Future booking</th>
            <th>Declined booking</th>
            <th>Cancelled booking</th>
          </tr>
        </thead>
        <tbody>


          <tr>
            <td>Bootcamp</td>
            <td>{{$no_of_sessions_bc}}</td>
            <td>{{$total_past_booking_bc}}</td>
            <td>{{$total_future_booking_bc}}</td>
            <td>{{$total_declined_booking_bc}}</td>
            <td>{{$total_cancelled_booking_bc}}</td>
          </tr>

          <tr>
            <td>Personal Training</td>
            <td>{{$total_sessions_pt}}</td>
            <td>{{$total_past_booking_pt}}</td>
            <td>{{$total_future_booking_pt}}</td>
            <td>{{$total_declined_booking_pt}}</td>
            <td>{{$total_cancelled_booking_pt}}</td>
          </tr>

        </tbody>
      </table>
      <div class="tbl-srch">
        <form id="frm_search" method="get">
          <select align ="right" id="session" name="session" >
            <option value="bootcamp" {{Request::get('option')=='bootcamp' || Request::get('session')==''?'selected':''}} >Bootcamp</option>
            <option value="pt_session" {{Request::get('session')=='pt_session'?'selected':''}} >Personal Training </option>
          </select>

          <select align ="right" id="feature" name="option" >
            <option value="future_booking" {{Request::get('option')=='future_booking' || Request::get('option')==''?'selected':''}} >Future Booking</option>
            <option value="declined_booking" {{Request::get('option')=='declined_booking'?'selected':''}} >Declined Booking</option>
            <option value="cancelled_booking" {{Request::get('option')=='cancelled_booking'?'selected':''}} >Cancelled Booking</option>
            <option value="past_booking" {{Request::get('option')=='past_booking'?'selected':''}} >Past Booking</option>        
          </select>
          <input id="datepicker" type="text" name="start_date" value="{{Request::get('start_date')? Request::get('start_date') : \Carbon\Carbon::now()->toDateString()}}" readonly="true" />
          <input id="datepicker2" type="text" name="end_date" value="{{Request::get('end_date')? Request::get('end_date') : \Carbon\Carbon::now()->addDays(30)->toDateString()}}"  readonly="true"/>
          <button type="submit" id="booking" class="btn btn-success"><i class="fa fa-search"></i></button>
        </form>
      </div>

      <table class="table">

        <thead>

          @if(Request::get('option')=='cancelled_booking')
          <h3 align="left" id="booking_title">Cancelled Booking</h3>
          @elseif(Request::get('option')=='declined_booking')
          <h3 align="left" id="booking_title">Declined Booking</h3>
          @elseif(Request::get('option')=='past_booking')
          <h3 align="left" id="booking_title">Past Booking</h3>
          @else
          <h3 align="left" id="booking_title">Future booking</h3>
          @endif
          <tr>
            <th>Booking date</th>
            <th>Booking time</th>
            <th>Address</th>
            @if(Request::get('session')=='pt_session')
            <th>Trainer Name</th>
            @endif
            <th>Booked On</th>                                   
            <!-- <th>Status</th> -->
            @if(Request::get('option')=='future_booking' || Request::get('option')=='')
            <th>Action</th>
            @endif
          </tr>
        </thead>
        <tbody id="tbody_empty">
          @if(count($all_booking)>0)
          @foreach($all_booking as $key=>$eachbooking)

          <tr >

            <td> {{date('d F Y', strtotime($eachbooking->plan_date))}}  </td>
            <td>{{date('h:i A', strtotime($eachbooking->plan_st_time))}} To {{date('h:i A', strtotime($eachbooking->plan_end_time))}}</td>
            <td>{{$eachbooking->address_line1}}</td>
            <td>{{date('d F Y h:i A', strtotime($eachbooking->created_at))}}</td>

            @if(Request::get('option')=='future_booking' ||  Request::get('option')=='')

            <?php
            $current_time = date("Y-m-d H:i:s");
            $bootcamp_cancel_time=$eachbooking->plan_date.' '.$eachbooking->plan_st_time;
            $bootcamp_cancel_time = date("Y-m-d H:i:s", strtotime('-24 hours', strtotime($bootcamp_cancel_time)));
            ?>
            <td > @if($current_time<$bootcamp_cancel_time)
              <a style="margin-left: 9px;" href="{{route('bootcamp_booking_cancele_customer',['id'=>$eachbooking->booking_id])}}"  
                class="btn btn-danger asd"  onclick="return confirm('Are you sure you want to cancel this bootcamp session?');">
                <i class="fa fa-trash-o" ></i></a>
                @else
                <a style="margin-left: 9px;" href="#"  
                class="btn btn-danger asd"  onclick="return confirm('Automatic cancelation is not allowed any more, please contact admin');">
                <i class="fa fa-trash-o" ></i></a>

                @endif
              </td>
              @endif

            </tr>
            @endforeach
 

            @elseif(Request::get('session')=='pt_session' && count($all_pt_booking)>0)
        
            
            @foreach($all_pt_booking as $key=>$eachbooking1)

            <tr >

              <td> {{date('d F Y', strtotime($eachbooking1->plan_date))}}  </td>
              <td>{{date('h:i A', strtotime($eachbooking1->start_time))}} To {{date('h:i A', strtotime($eachbooking1->end_time))}}</td>
              <td>{{$eachbooking1->address_line1}}</td>
               <td>{{$eachbooking1->trainer_name}}</td>
              <td>{{date('d F Y h:i A', strtotime($eachbooking1->created_at))}}</td>
              @if(Request::get('option')=='future_booking' ||  Request::get('option')=='')

              <?php
              $current_time = date("Y-m-d H:i:s");
              $pt_cancel_time=$eachbooking1->plan_date.' '.$eachbooking1->plan_st_time;
              $pt_cancel_time = date("Y-m-d H:i:s", strtotime('-24 hours', strtotime($pt_cancel_time)));
              ?>
              <td > @if($current_time<$pt_cancel_time)
                <a style="margin-left: 9px;" href="{{route('pt_booking_cancele_customer',['id'=>$eachbooking1->booking_id])}}"  
                  class="btn btn-danger asd"  onclick="return confirm('Are you sure you want to cancel this personal training session?');">
                  <i class="fa fa-trash-o" ></i></a>
                  @else
                  <a style="margin-left: 9px;" href="#"  
                  class="btn btn-danger asd"  onclick="return confirm('Automatic cancelation is not allowed any more, please contact admin');">
                  <i class="fa fa-trash-o" ></i></a>

                  @endif
                </td>
                @endif



              </tr>
              @endforeach
          

              @else
              @if(Request::get('session')=='pt_session')
              <tr><td colspan='6' align='center'>
                No record found
              </td>
              </tr>
             @else
             <tr><td colspan='5' align='center'>
                No record found
              </td>
            </tr>
             @endif
             @endif
          </tbody>
        </table>
       
      </div>
    </div>
     @if(Request::segment(1) == 'mybooking')
 <div id="book_history">{{$all_booking->links()}}</div>

  @elseif(Request::get('session')=='bootcamp' || Request::get('session')=='')
  
  <div id="book_history">{{$all_booking->links()}}</div>
  @elseif(Request::get('session')=='pt_session')
 <div id="book_history">{{$all_pt_booking->links()}}</div>
 @else
 <div id="book_history">{{$all_booking->links()}}</div>
 @endif
  </div>
 


  @endsection