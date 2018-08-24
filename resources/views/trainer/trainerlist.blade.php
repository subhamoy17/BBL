<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')


@section('content')
<script>
    // for shortin ,pagination,searching data using datatable concept
 $(document).ready(function() { 
$('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
        
        // disable shorting from slno,image and action columns
        "columnDefs": [ { "orderable": false, "targets": [0,5,6,7] } ],
        
    });
 } );

</script>

<style>
    /* disable shorting arrow from slno,image and action columns*/
     table.dataTable thead>tr>th[id='slno'].sorting_asc::before{display: none}
     table.dataTable thead>tr>th[id='slno'].sorting_asc::after{display: none}

      table.dataTable thead>tr>th[id='image'].sorting_asc::before{display: none}
     table.dataTable thead>tr>th[id='image'].sorting_asc::after{display: none}

   
     

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
@if(Auth::user()->master_trainer==1)
<div id="success-msg" class="alert alert-success alert-dismissible" style="display: none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="icon fa fa-check"></i>Hi!
 One request has been active successfully.
</div>
<div id="decline-msg" class="alert alert-warning alert-dismissible" style="display: none;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="icon fa fa-info-circle"></i>Hi!
 One request has been deactive successfully.
</div>

<div class="breadcrumbs">
    <div class="col-sm-9">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>All Trainers</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="page-header float-left" style="padding-top: 2%;padding-left: 21%;">
            <a href="{{route('addtrainer')}}">
                <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Add New Trainer</button>
            </a>
        </div>
    </div>
</div>
<div class="content mt-3" style="margin-top: 0px !important;">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
              <div class="group">
         
                    <div class="card-header" style="padding-left: 0px;padding-right: 0px;padding-bottom: 0px;padding-top: 10px;">
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if (session('delete'))
                            <div class="alert alert-danger">
                                {{ session('delete') }}
                            </div>
                        @endif
                    </div>
                    <div id="loading-img"></div>
                    
                    
                        <script type="text/javascript">
                           
                            function delete_trainer(id){ 
                            alertify.confirm("Are you sure you want to delete this trainer?", function (e) {
                                    if (e) {
                                                // alertify.success("You've clicked OK");
                                                window.location.href="{{url('trainer/trainerdelete')}}/"+id;
                                                
                                            }                                      
                                        });
                                    }
                            </script>
                      <div class="card-body">
                        <table id="bootstrap-slot-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th id="slno">Sl. No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact No</th>
                                    <th>Addess</th>
                                    <th id="image">Image</th>
                                    <th id="action">Action</th>
                                    <th>Avaliable </th>
                                </tr>
                            </thead>
                        <tbody class="tbdy1">
                                @if(count($data)>0)
                            @foreach($data as $key=>$mydata)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$mydata->name}}</td>
                                    <td>{{$mydata->email}}</td>
                                    <td>{{$mydata->contact_no}}</td>
                                    <td>{{$mydata->address}}</td>
                                    @if($mydata->image)
                                    <td><img src="{{asset('backend/images')}}/{{$mydata->image}}" height="50" width="50"></td>
                                     @else
                                  <td>N/A</td>
                                  @endif

                                            <td style="width: 70px">
                                    @if($mydata->master_trainer == 1)
                            
                                    <a href="{{url('trainer/edittrainer')}}/{{$mydata->id}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>


                                    @else
                                 
                                        <a href="{{url('trainer/edittrainer')}}/{{$mydata->id}}" title="Edit Trainer"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>

                                        <button class="btn btn-danger btn-sm" title="Delete Trainer" onclick="delete_trainer({!!$mydata->id!!})"><i class="fa fa-trash-o"></i></button>

                                    @endif
                                      </td>
                                    <td>
                                         @if($mydata->is_active == 1)
                                    <button type="button" title="Deactive Trainer"  class="btn btn-danger btn-sm status-all" id="{{$mydata->id}}" data-msg="Deactive"><i class="fa fa-times"></i></button>
                                    @else
                                    <button type="button"  title="Active Trainer" class="btn btn-success btn-sm status-all" id="{{$mydata->id}}" data-msg="Active"><i class="fa fa-check"></i></button>
                                    @endif

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    
                    @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div><!-- .animated -->
</div>
    <!-- .content -->

    @endif
  <script type="text/javascript">
      $(document).ready(function(){
        
        $("#bootstrap-slot-data-table").on("click", ".status-all", function(e) {
          var action = $(this).data("msg");
          console.log(action);
          var row = this.closest('tr');
          console.log(row);
      console.log(action);
if (action == "Deactive"){
  var Data =
  {
    'id': this.id,
   
    'action': action
  }

  alertify.confirm("Are you sure you want to deactive this trainer?", function (e) {
     if (e) { 
 
  

  $.ajax({
    url: "{{route('trainer_active_deactive')}}",

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
         

        console.log("Approve response");
      console.log(data);
       
       $(".card-body").css("opacity", .2);
   $("#loading-img").css({"display": "block"});
      $('#success-msg').show();
      setTimeout(function(){
        $('#success-msg').hide();
 location.reload();
      }, 4000);
      }
      else
      {
        console.log("Deactive");
      console.log(data);
   $(".card-body").css("opacity", .2);
    $("#loading-img").css({"display": "block"});
      $('#decline-msg').show();
      setTimeout(function(){
        $('#decline-msg').hide();
        location.reload();
      }, 4000);


      }
      
    }
  });
       }
        else
        {

        }

        });

}

else if (action == "Active"){
  var Data =
  {
    'id': this.id,
   
    'action': action
  }


alertify.confirm("Are you sure you will be approve this trainer?", function (e) {
 if (e) {
   
  $.ajax({
    url: "{{route('trainer_active_deactive')}}",

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
        console.log("Approve response");
      console.log(data);
      $(".card-body").css("opacity", .2);
         $("#loading-img").css({"display": "block"});

      $('#success-msg').show();
      setTimeout(function(){
        $('#success-msg').hide();
 window.location.reload();
      }, 5000);
      }
      else{
        console.log("Decline decline");
      console.log(data);
   $(".card-body").css("opacity", .2);
                  $("#loading-img").css({"display": "block"});
      $('#decline-msg').show();
      setTimeout(function(){
        $('#decline-msg').hide();
         window.location.reload();
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
    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>

    

@endsection
