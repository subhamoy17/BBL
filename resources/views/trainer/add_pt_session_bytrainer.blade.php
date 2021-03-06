<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<script type="text/javascript">
  $(document).ready(function()
  { 
  setTimeout(function(){ 
                          $('.alert-success').hide();
                      }, 5000);
  setTimeout(function(){ 
                          $('.alert-danger').hide();
                      }, 5000);
});
</script>
<script>
  
   $(document).ready(function() {
    src = "{{ route('search_customer_pt') }}";
     $("#search_customer_pt").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                response( $.map( data, function( item ) {
                    return {
                        value: item.value,
                        id:item.id,
                        email:item.email,
                        ph_no:item.ph_no,
                    }
                }));
                $('#customer_name').val('');
                $('#customer_email').val('');
                $('#customer_ph').val('');
                $('#customer_id').val('');
              $('#cutomer_details').hide();
                }
            });
        },
        minLength: 3,
        select: function(event, ui) {
        $("#cutomer_details").show();
        
        $("#cus_det").text(ui.item.value + ", " + ui.item.email + ", " + ui.item.ph_no);

        $('#customer_name').val(ui.item.value);
        $('#customer_email').val(ui.item.email);
        $('#customer_ph').val(ui.item.ph_no);
        $('#customer_id').val(ui.item.id);
        
        var Data = 
        {
          'id': ui.item.id,
          'schedule_id': $('#schedule_id').val()
        }
    $.ajax({
          url: "{{route('check_customer_pt_session')}}",
          json_enc: Data,
          type: "GET",
          dataType: "json",
          data:
          {
            'data': Data,
          },
          success: function (data)
          {
            //console.log(data);
           if(data>0)
         {
          $("#remaining_session").text("Remaining Session(s) " + data);
          $('#add_availability').show();
         }
         else if(data=='not_booked')
         {
          $("#remaining_session").text("Remaining Session(s) " + 0);
          $('#add_availability').hide();
         }
         else
         {
          $("#remaining_session").text("Remaining Session(s) " + data);
          $('#add_availability').show();
         }
       
          }
        });

    }



    });
});

</script>

<style>
.ptbtn-rmv{
    color: #fff;
    background-color: #db2828;
    border-color: #db2828;
  }
</style>



  <div class="breadcrumbs">
    <div class="col-sm-12">
      <div class="page-header float-left">
        <div class="page-title">
          <h1>Add Customer's to Personal Training Session</h1>
          <h1>Schedule Details->{{$schedule_details->plan_date}}, {{$schedule_details->plan_day}}, {{date("h:i A", strtotime($schedule_details->start_time))}} to {{date("h:i A", strtotime($schedule_details->end_time))}}, {{$schedule_details->trainer_name}}</h1>
        </div>
      </div>
    </div>    
  </div>
                    @if (session('booking_success'))
                        <div class="alert alert-success">
                            {{ session('booking_success') }}
                        </div>
                        @endif
                    @if (session('booking_unsuccess'))
                        <div class="alert alert-danger">
                            {{ session('booking_unsuccess') }}
                        </div>
                        @endif
  <div class="breadcrumbs opacity_div">
    <div class="col-sm-12">
      <div class="page-header float-left">
        <div class="page-title ttl-wrp">
          <label>Search Customer</label>
    <input type="text" id="search_customer_pt" name="search_customer_pt" placeholder="Search Customer" class="form-control apply2 required" style="    display: inline-block;
    width: 420px;
    margin-top: 6px;" >
        </div>
      </div>
    </div>    
  </div>

  <div class="breadcrumbs opacity_div">
    <div class="col-sm-12">
      <div class="page-header float-left">
        <div class="page-title ttl-wrp"  id="cutomer_details" style="display: none;">
          <label>Customer Details</label>
          <div  id="cus_det"></div>
          <input type="hidden" id="customer_name" name="customer_name">
          <input type="hidden" id="customer_email" name="customer_email">
          <input type="hidden" id="customer_ph" name="customer_ph">
          <input type="hidden" id="customer_id" name="customer_id">
          <input type="hidden" id="no_of_uses" value="0">
          <input type="hidden" id="schedule_id" name="schedule_id" value="{{$schedule_details->id}}">
          <div  id="remaining_session"></div>
          <div>
          <button id="add_availability" class="btn btn-success btn-theme-colored btn-flat"><i class="fa fa-plus-square"></i></button>
        </div>
        </div>
      </div>
    </div>    
  </div>

  <div class="breadcrumbs opacity_div">
    <div class="col-sm-12">
      <div class="page-header float-left">
        <div class="page-title ttl-wrp">
          <form  action="{{route('book_pt_session_trainer')}}" class="slct-margin" id="pt_plan_form" method="post" autocomplete="off">
            <input type="hidden" id="schedule_id" name="schedule_id" value="{{$schedule_details->id}}">
          {{ csrf_field() }}
          <div id="add_availability_div"></div>
          <button name="pt_session_submit" id="pt_session_submit" class="btn btn-primary  pull-right" style="display: none; width: 100px;">Submit</button>
        </form>
        </div>
        </div>
      </div>
    </div>    
  </div>


<script>
   $(document).ready(function() {
    $('body').on('click','#add_availability',function(e) {
      e.preventDefault();
            
        var customer_name=$("#customer_name").val();
        var customer_email=$("#customer_email").val();
        var customer_ph=$("#customer_ph").val();
        var customer_id=$("#customer_id").val();
        var no_of_uses=$("#no_of_uses").val();
        no_of_uses=parseInt(no_of_uses)+1;

        var all_previous_id = $(".all_previous_data");

        var duplicate_flag=0;

        for(var k = 0; k < all_previous_id.length; k++)
        {
          if($(all_previous_id[k]).val()==customer_id)
          {
            duplicate_flag=1;
          }
        }

        if(duplicate_flag==1)
        {
          alertify.alert("This customer's booking is already done for this schedule");
        }
        else if(no_of_uses>1)
        {
          alertify.alert("Allow only one person to book this schedule");
        }
        else
        {

      alertify.confirm("Are you sure you want to book this schedule for this customer?", function (event) {
          if (event) {
            $("#add_availability_div").append('<div class="row form-group" id = "removeid"><div class="col-lg-4"><input readonly class="form-control" type="text" value="' + customer_name + '" /></div>' + '<div class="col-lg-4"><input readonly class="form-control" type="text" value="' + customer_email + '"/></div>' + '<div class="col-lg-3"><input readonly class="form-control" type="text" value="' + customer_ph + '"/></div>' + '<input readonly type="hidden" name="customer_name[]" value="' + customer_name + '"/>'  + '<input readonly type="hidden" name="customer_email[]" value="' + customer_email + '"/>' + '<input readonly type="hidden" name="customer_ph[]" value="' + customer_ph + '"/>' + '<input readonly type="hidden" class="all_previous_data" name="customer_id[]" value="' + customer_id + '"/>' + '<div class="col-lg-1" align="right"> <button id="btnRemove" class="btn btn-theme-colored ptbtn-rmv"><i class="fa fa-remove"></i></button></div></div>'); 
            $('#cutomer_details').hide();
            $('#search_customer_pt').val('');
            $('#pt_session_submit').show();
            $('#no_of_uses').val(no_of_uses);

          }
          else
          {
            return false;
          } 
      });
      }

  });

  $('body').on('click','#btnRemove',function(ecan) { 
   ecan.preventDefault();
    alertify.confirm("Are you sure you want to remove this customer's booking?", function (event) {
          if (event) {
            $('#btnRemove').closest('div#removeid').remove();
            var all_previous_id = $(".all_previous_data");
            var no_of_uses=$("#no_of_uses").val();
            no_of_uses=parseInt(no_of_uses)-1;
            $('#no_of_uses').val(no_of_uses);

            if(all_previous_id.length==0)
              { 
                $('#pt_session_submit').hide();
              }
            return true;
          }
          else
          {
            return false;
          }
    });


  });
});
  
</script>



@endsection

