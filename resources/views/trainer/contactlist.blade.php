<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')


@section('content')
<script>
    // for shortin ,pagination,searching data using datatable concept
 $(document).ready(function() { 
$('#bootstrap-slot-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
        
        // disable shorting from slno,image and action columns
        "columnDefs": [ { "orderable": false, "targets": [0,5] } ],
        
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
</style>
<div id="reason_modal" class="modal fade common" role="dialog" >
  <div class="modal-dialog">
    
    <div class="modal-content">
      <div class="modal-body" id="hall_details_edit">
        <div class="row clearfix">
          <div class="col-sm-12 col-xs-12">
            <p class="pull-left">Message</p>
            <br class="clear" />
          </div>
          <div class="col-xs-12 divi-line">
          </div><br/>
          <div class="col-sm-9 col-xs-12">
            <input type="hidden" id="reason_id"></input>
            <input type="hidden" id="reason_action"></input>
            <div class="form-group">
              <div class="total-msg" id="msg"></div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>All Customer's Enquiry</h1>
            </div>
        </div>
    </div>
</div>
<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">    
                    <div class="card-body">
                        <script type="text/javascript">
                            function delete_trainer(id){ 
                            alertify.confirm("Are you sure you want to delete this trainer?", function (e) {
                                    if (e) {
                                                alertify.success("You've clicked OK");
                                                window.location.href="{{url('trainer/trainerdelete')}}/"+id;
                                                
                                            } else {
                                                alertify.error("You've clicked Cancel");
                                                
                                            }                                       
                                        });
                                    }
                            </script>
                        </script>
                        <table id="bootstrap-slot-data-table" class="table table-striped table-bordered table-body">
                            <thead>
                                <tr>
                                    <th id="slno">Sl. No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Ph.no.</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                        <tbody>
                                 @if(count($data)>0)
                            @foreach($data as $key=>$mydata)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$mydata->user_name}}</td>
                                    <td>{{$mydata->user_email}}</td>
                                    <td>{{$mydata->user_subject}}</td>
                                    <td>{{$mydata->user_phone}}</td>
                                    <td>
                                        @if(!empty($mydata->message))
                                            @if(strlen($mydata->message) > 50) 
                                                {{substr($mydata->message,0,50)}}<a href="#" class="commons"  data-msg="{{$mydata->message}}">...</a>
                                            @else
                                                {{$mydata->message}}
                                            @endif
                                        @else
                                            N/A
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
    </div><!-- .animated -->
</div><!-- .content -->
            
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
            $("#bootstrap-slot-data-table").on("click", ".commons", function(){
                var value = $(this).data("msg");
                $('div.total-msg').text(value);
                $('#reason_modal').modal('show');
            });
            $('#bootstrap-data-table-export').DataTable();
        });
    </script>

    

@endsection
