@extends('frontend.main') 
@section('content')






 
      <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab2">Tab 2</h3>
          <div id="tab2" class="tab_content">
            <div class="table-responsive table-bordered">
              <table class="table">
                <thead>
                  <tr>
                    <th>Customer Name</th>
                    <th>Slots Name</th>
                    <th>Slots Price</th>
                    <th>Slots validity</th>
                    <th>Trainer Name</th>
                     <th>Slots Starting Date</th>
                     <th>Slots Ending Date</th>
                      <th>Remaining Time</th>
                      <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                   @if(count($data)>0)
                   @foreach($data as $key=>$mydata)
                  <tr>
                    <td>{{$mydata->name}}</td>
                    <td>{{$mydata->slots_name}}</td>
                    <td>{{$mydata->slots_price}}</td>
                    <td>{{$mydata->slots_validity}}</td>
                    <td>{{$mydata->users_name}}</td>
                    <td>{{$mydata->purchases_start_date}}</td>
                    <td>{{$mydata->purchases_end_date}}</td>
                  <td>{{$mydata->timeremaining}}</td>
                     <td>
                            @if($mydata->timeremaining < $mydata->slots_validity)
                          <a href="{{url('customer/booking_slot')}}/{{$mydata->slot_purchases_id}}"class="btn btn-success">change</a>
                     @else
                        N/A
                        @endif

                   </td>


                  </tr>
                @endforeach
                </tbody>
              </table>
              @endif
            </div>
          </div>
          <!-- #tab2 -->
        
   
        
      </div>
      </div>
      <!-- .tab_container -->
    </div>
  </div>
  
@endsection