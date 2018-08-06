@extends('frontend.submain') 
@section('content')






 
      <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab2">Tab 2</h3>
          <div id="tab2" class="tab_content">
            <div class="table-responsive table-bordered">
              <table class="table">
                <thead>
                  <tr>
                   
                    <th>Package Name</th>
                    <th>Package Price</th>
                    <th>Package validity</th>
                     <th>Purchases Date</th>
                     <!-- <th>Payment Mode</th> -->
                     <th>Total Slots </th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @if(count($data)>0)
                   @foreach($data as $key=>$mydata)
                  <tr>
                    
                    <td>{{$mydata->slots_name}}</td>
                    <td>{{$mydata->slots_price}}</td>
                    <td>{{$mydata->slots_validity}}</td>
                    <td>{{$mydata->purchases_date}}</td>
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
                </tbody>
              </table>
              @endif
              {{$data->links()}}
            </div>
          </div>
          <!-- #tab2 -->
        
   
        
      </div>
      </div>
      <!-- .tab_container -->
    </div>
  </div>
  
@endsection