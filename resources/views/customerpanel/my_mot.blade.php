@extends('frontend.dashboard_submain') 
@section('content')

<div id="reason_modal" class="modal fade common mot-mod" role="dialog" >
  <div class="modal-dialog">
    
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">My MOT</h4>
      <div> <select class="form-control mot_convert" id="mot_option">
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

              <div class="col-lg-2"><div class="wrp2"><div class="rl">Right Arm / </div><small>Inch</small><div class="right_arm rv" ></div></div></div>
             <div class="col-lg-2"> <div class="wrp2"><div class="rl">Left Arm / </div><small>Inch</small><div class="left_arm rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Chest / </div><small>Inch</small><div class="chest rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Waist / </div><small>Inch</small><div class="waist rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Hips / </div><small>Inch</small><div class="hips rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Right thigh / </div><small>Inch</small><div class="right_thigh rv" ></div></div></div><div class="clearfix"></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Left thigh / </div><small>Inch</small><div class="left_thigh rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Right calf / </div><small>Inch</small><div class="right_calf rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Left calf / </div><small>Inch</small><div class="left_calf rv" ></div></div></div>
            	<div class="col-lg-2"><div class="wrp2"><div class="rl">Starting weight / </div><small>Inch</small><div class="starting_weight rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Ending weight / </div><small>Inch</small><div class="ending_weight rv" ></div></div></div>
              <div class="col-lg-2"><div class="wrp2"><div class="rl">Heart beat / </div><small>Inch</small><div class="heart_beat rv" ></div></div></div>
               <div class="col-lg-6"><div class="wrp"><div class="rl">Blood pressure / </div><small>Inch</small><div class="blood_pressure rv" ></div></div></div>
               
                 <div class="col-lg-6"><div class="wrp"><div class="rl">Height / </div><small>Inch</small><div class="height rv" ></div></div></div>
				<div class="col-lg-12">
					<div id="mot_des" class="mot-text">
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
 
      <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab2">Tab 2</h3>
          <div id="tab2" class="tab_content">
            <div class="table-responsive table-bordered">
              <table class="table">
                <thead>
                  <tr>
                    <th>Trainer Name</th>
                    <th>Date</th>
                    <th>view More</th>
                    
                  </tr>
                </thead>
                <tbody>
                   @if(count($data)>0)
                   @foreach($data as $key=>$mydata)
                  <tr>
                    <td>{{$mydata->users_name}}</td>
                    <td>{{$mydata->date}}</td>
                     <td>
                         
                    <a href="#" id="asd" class="common_mot btn btn-info btn-sm" data-right_arm="{{$mydata->right_arm}}"  data-left_arm="{{$mydata->left_arm}}" data-chest="{{$mydata->chest}}"
                      data-waist="{{$mydata->waist}}" data-hips="{{$mydata->hips}}"
                      data-right_thigh="{{$mydata->right_thigh}}" data-right_calf="{{$mydata->right_calf}}" 
                      data-left_calf="{{$mydata->left_calf}}" data-weight="{{$mydata->weight}}"
                      data-left_thigh="{{$mydata->left_thigh}}" data-starting_weight="{{$mydata->starting_weight}}"  data-ending_weight="{{$mydata->ending_weight}}"  data-heart_beat="{{$mydata->heart_beat}}"  data-blood_pressure="{{$mydata->blood_pressure}}"
                      data-height="{{$mydata->height}}" data-description="{{$mydata->description}}" class="btn btn-success">
                    Click Here</a>
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


<!-- 
<script src="{{asset('backend/assets/js/lib/data-table/datatables.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/jszip.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/pdfmake.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/vfs_fonts.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/buttons.html5.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/buttons.print.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/buttons.colVis.min.js')}}"></script>
<script src="{{asset('backend/assets/js/lib/data-table/datatables-init.js')}}"></script> -->












@endsection