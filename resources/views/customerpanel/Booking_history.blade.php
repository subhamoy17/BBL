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
              <h3 align="center">Feature confirm booking</h3>
              <table class="table">
                <thead>
                  <tr>
                    <th>Trainer Name</th>
                     
                     <th>Booked On</th>
                     <th>Booking date & time</th>
                       <th> Booking status</th>
                       <th>MOT</th>
                  </tr>
                </thead>
                <tbody>
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
                </tbody>
              </table>
              @endif
         <!--    </div>
          </div>
         
        
   
        
      </div> -->
      


  
@endsection