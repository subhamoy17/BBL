@extends('frontend.submain') 
@section('content')





<div id="reason_modal" class="modal fade common" role="dialog" >
  <div class="modal-dialog">
    
    <div class="modal-content">
      <div class="modal-body" id="hall_details_edit">
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <p class="pull-left">Customers MOT</p>
            <br class="clear" />
        </div>
        <div class="col-xs-12 divi-line">
        </div><br/>
        <div class="col-sm-9 col-xs-12">
            <input type="hidden" id="reason_id"></input>
            <input type="hidden" id="reason_action"></input>
            <div class="form-group">

              <div>Right Arm:</div><div class="right_arm" ></div>
              <div>Left Arm:</div><div class="left_arm" ></div>
              <div>Chest:</div><div class="chest" ></div>
              <div>Waist:</div><div class="waist" ></div>
              <div>Hips:</div><div class="hips" ></div>
              <div>Right thigh:</div><div class="right_thigh" ></div>
              <div>Left thigh:</div><div class="left_thigh" ></div>
              <div>Right calf:</div><div class="right_calf" ></div>
              <div>Left calf:</div><div class="left_calf" ></div>
            
              
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
                         
                    <a href="#" class="common btn btn-info btn-sm" data-right_arm="{{$mydata->right_arm}}"  data-left_arm="{{$mydata->left_arm}}" data-chest="{{$mydata->chest}}"
                      data-waist="{{$mydata->waist}}" data-hips="{{$mydata->hips}}"
                      data-right_thigh="{{$mydata->right_thigh}}" data-right_calf="{{$mydata->right_calf}}" 
                      data-left_calf="{{$mydata->left_calf}}" data-weight="{{$mydata->weight}}"
                      data-left_thigh="{{$mydata->left_thigh}}" class="btn btn-success">

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
<script src="{{asset('backend/assets/js/lib/data-table/datatables-init.js')}}"></script>




<script type="text/javascript">
    $(document).ready(function() {

        $(".common").click(function() {
            var right_arm = $(this).data("right_arm");
            var left_arm = $(this).data("left_arm");
            var chest = $(this).data("chest");
            var waist = $(this).data("waist");
            var hips = $(this).data("hips");
            var right_thigh = $(this).data("right_thigh");
            var left_thigh = $(this).data("left_thigh");
            var right_calf = $(this).data("right_calf");
            var left_calf = $(this).data("left_calf");
            var weight = $(this).data("weight");
            



            $('div.right_arm').text(right_arm); $('div.left_arm').text(left_arm);
           

            $('div.chest').text(chest);
            $('div.waist').text(waist);
            $('div.hips').text(hips);
            $('div.right_thigh').text(right_thigh);

            $('div.left_thigh').text(left_thigh);
            $('div.right_calf').text(right_calf);

            $('div.left_calf').text(left_calf);
            $('div.weight').text(weight);
            








            $('#reason_modal').modal('show');
        });
        $('#bootstrap-data-table-export').DataTable();
    } );
</script>







@endsection