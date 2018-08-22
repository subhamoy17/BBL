
@extends('trainerlayouts.trainer_template')
@section('content')
<script>
// for shortin ,pagination,searching data using datatable concept
$(document).ready(function() { 
  $('#bootstrap-slot-data-table').DataTable({
    lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
// disable shorting from slno,image and action columns
"columnDefs": [ { "orderable": false, "targets": [0,5,6] } ],
});
} );
</script>

<style>
/* disable shorting arrow from slno,image and action columns*/
table.dataTable thead>tr>th[id='slno'].sorting_asc::before{display: none}
table.dataTable thead>tr>th[id='slno'].sorting_asc::after{display: none}
table.dataTable thead>tr>th[id='image'].sorting_asc::before{display: none}
table.dataTable thead>tr>th[id='image'].sorting_asc::after{display: none}
table.dataTable thead>tr>th[id='action'].sorting_asc::before{display: none}
table.dataTable thead>tr>th[id='action'].sorting_asc::after{display: none}
/*for delete buton*/
.button-primary {
  background: #d16879;
  color: #FFF;
  padding: 10px 20px;
  font-weight: bold;
  border:1px solid #FFC0CB;
  
}

.div {
    height:200px;
    background-color:red;
}

#loading-img {
  background: url(../backend/images/loader-gif-transparent-background-4.gif) center no-repeat / cover;
    display: none;
    height: 100px;
    width: 100px;
    position: absolute;
    top: 50%;
    left: 1%;
    right: 1%;
    margin: 0 auto;
    z-index: 99999;
}

.group {
    position: relative;
    width: 100%;
}
.card-body{
  
}

</style>
<div id="reason_modal" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body" id="hall_details_edit">
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <p class="pull-left">Decline Request</p>
            <br class="clear" />
          </div>
          <div class="col-xs-12 divi-line">
          </div><br/>
          <div class="col-sm-9 col-xs-12">
            <input type="hidden" id="reason_id"></input>
            <input type="hidden" id="reason_action"></input>
            <div class="form-group">
              <label>Comment your reason:</label>
              <textarea class="form-control" rows="3" id="comment"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" id="reason">Submit</button>
      </div>
    </div>
  </div>
</div>

<div id="success-msg" class="alert alert-success alert-dismissible" style="display: none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="icon fa fa-check"></i>Hi!
 One request has been approved successfully.
</div>
<div id="decline-msg" class="alert alert-warning alert-dismissible" style="display: none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="icon fa fa-info-circle"></i>Hi!
 One request has been declined successfully.
</div>
<div class="breadcrumbs">
  <div class="col-sm-12">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Future Pending Request Customer List</h1>
      </div>
    </div>
  </div>
</div>
<div class="content mt-3">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
           <div class="group">
            <div id="loading-img"></div>
          <div class="card-body">
            <table id="bootstrap-slot-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th id='slno'>Sl. No.</th>
                  <th> Customer Name</th>
                  <th>Customer Phone</th>
                  <th>Status</th>
                  <th>Request On</th>
                  <th id='image'>Image</th>
                  <th id='action'>Action</th>
                </tr>
              </thead>
              <tbody>
                 @if(count($data)>0)
                @foreach($data as $key=>$mydata)
                <tr>
                  <td>{{++$key}}</td>
                  <td>{{$mydata->name}}</td>
                  <td>{{$mydata->ph_no}}</td>
                  <td>{{$mydata->status}}</td>
                  <td>{{date('d F Y', strtotime($mydata->slot_date))}} {{date('h:i A', strtotime($mydata->slot_time))}}</td> 
                   @if($mydata->image)
                  <td><img src="{{asset('backend/images')}}/{{$mydata->image}}" height="50" width="50"></td>
                  <td>
                     @else
                     <td>N/A</td>
                     @endif
                    <td class="td-btn4" style="position: relative;">
                    @if($mydata->approval_id != 3 && $mydata->approval_id != 2) 

                    <button type="button" title="Approve" class="btn btn-success status-all" id="{{$mydata->id}}" data-msg="Approve"><i class="fa fa-thumbs-up"></i></button>
                    @endif
                    @if($mydata->approval_id != 4 && $mydata->approval_id != 2)
                    <button type="button" title="Decline" class="btn btn-danger status-all" id="{{$mydata->id}}" data-msg="Decline"><i class="fa fa-thumbs-down"></i></button>
                    @endif
                  </td>
                </tr>
                @endforeach
                </tbody>
              </table>   
          </div>
            @endif
          </div>                   
        </div>
        </div>
      </div>
    </div>
  </div><!-- .animated -->



<script type="text/javascript">
  $(document).ready(function(){
    $("#bootstrap-slot-data-table").on("click", ".status-all", function(e) {
      var action = $(this).data("msg");
      console.log(action);
      var row = this.closest('tr');
      if (action == "Decline"){
        $('#reason_id').val('');
        $('#reason_id').val(this.id);
        $('#reason_action').val(action);
        $('#comment').val('');
        alertify.confirm("Are you sure you want to decline this request?", function (e) {
          if (e) {
            $('#reason_modal').modal('show');
          }
          else
          {
          }
        });
      }
      else if (action == "Approve"){
        var Data =
        {
          'id': this.id,
          'action': action
        }
        alertify.confirm("Are you sure you will be avaliable on this slot?", function (e) {
          if (e) {
            $.ajax({
              url: "{{route('approvePendingRequest')}}",
              json_enc: Data,
              type: "GET",
              dataType: "json",
              data:
              {
                'data': Data,
              },
              success: function (data)
              {
                if(data==1){
                    $(".card-body").css("opacity", .2);
                  $("#loading-img").css({"display": "block"});
                  console.log("Approve response");
                  console.log(data);
                  $('#success-msg').show();
                   $('.status-all').attr('disabled','disabled');
                $('.status-all').text('Please wait...');
                  setTimeout(function(){
                    $('#success-msg').hide();
                    location.reload();
                  }, 5000);
                }
              }
            });                                                                                             
          }
          else 
          {           
          }                                       
        });
      }
    });
    $("#reason").on('click',function(e)
    {
      var id=$('#reason_id').val();
      var comment=$('#comment').val();
      var row=$('#'+id).closest('tr');
      if(comment.trim()=="")
      {
        alertify.alert("Reason for decline for this request");
        $('#reason_modal').modal('show');
        return false; 
      }
      else
      {
        var action=$('#reason_action').val();
        var Data =
        {
          'id': id,
          'action': action,
          'comment':comment
        }
        console.log(Data);
        $.ajax({
          url: "{{route('approvePendingRequest')}}",
          json_enc: Data,
          type: "GET",
          dataType: "json",
          data:
          {
            'data': Data,
          },
          success: function (data)
          {
            if(data==2){
               $(".card-body").css("opacity", .2);
                  $("#loading-img").css({"display": "block"});
              console.log("Decline decline");
              console.log(data);
              $('#decline-msg').show();
               $('.status-all').attr('disabled','disabled');
                $('.status-all').text('Please wait...');
              setTimeout(function(){
                $('#decline-msg').hide();
                location.reload();
              }, 5000);
            }
          }
        });
      }
    });
  });

</script>
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


@endsection
