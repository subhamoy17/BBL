@extends('frontend.submain') 
@section('content')

     
      <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab1">Tab 1</h3>
          <div id="tab1" class="tab_content">
            <div class="table-responsive table-bordered">
              <table class="table">
                <thead>
                  <tr>
                    <th>Trainer Name</th>
                     <th>Status</th>
                     <th>Booked On</th>
                     <th>Slot date & time</th>
                       <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                   @if(count($data)>0)
                   @foreach($data as $key=>$mydata)
                  <tr>
                    <td>{{$mydata->users_name}}</td>
                    <td>{{$mydata->status}}</td>
                    <td>{{$mydata->created_at}}</td>
                      <td>
                     <?php  $date=$mydata->slot_date;
                      $time =$mydata->slot_time;
                      $merge =$date.' '.$time;
                       ?>
                      {{$merge}}
                      </td>
                  <td>{{$mydata->timeremaining}}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
              @endif
            </div>
          </div>
          <!-- #tab1 -->
        
   
        
      </div>
      </div>
      <!-- .tab_container -->
    </div>
  </div>


  
@endsection