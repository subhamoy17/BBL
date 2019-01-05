<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<style type="text/css">
  #customer_id-error {
    color: #dc3545;
    font-weight: 700;
    text-transform: none;
    font-size: 13px;
  }
</style>

<script>

  $(document).ready(function(){
    
    $("#is_generic_yes").click(function(){
        $(".specific-coupon-block").hide();
        $("#customer_id").attr('name', 'customer_id_not_required');
    });
    $("#is_generic_no").click(function(){
        $(".specific-coupon-block").show();
        $("#customer_id").attr('name', 'customer_id[]');
    });
    // $("#coupon_code").keyup(function(){
    //   var Data = 
    //     {
    //       'product_id': $("#product_id").val(),
    //       'coupon_code': $('#coupon_code').val(),
    //       'package_discount_coupon_id': $('#package_discount_coupon_id').val()
    //     }
    //   $.ajax({
    //       url: "{{route('duplicatecoupon')}}",
    //       json_enc: Data,
    //       type: "GET",
    //       dataType: "json",
    //       data:
    //       {
    //         'data': Data,
    //       },
    //       success: function (response_data)
    //       {
    //         if(response_data == 1){
    //           $("#duplicate_coupon").html("Coupon code is already exists.");
    //         }else{
    //           $("#duplicate_coupon").html("");
    //         }
    //       }
    //     });
    // });


$.validator.addMethod("coupon_code_validity", function(value, element) {
  var Data = {
    'product_id': $("#product_id").val(),
    'coupon_code': value,
    'package_discount_coupon_id': $('#package_discount_coupon_id').val()
  }
  $.ajax({
    url: "{{route('duplicatecoupon')}}",
    json_enc: Data,
    type: "GET",
    dataType: "json",
    data:{
      'data': Data,
    },
    success: function (response_data){
      if(response_data == "1"){
        return false;
      }else if(response_data == "0"){
        return true;
      }
    }
  });
}, "");
$.validator.addMethod("discount_price_validity", function(value, element) {
  var actual_price = $("#actual_price").val();
  actual_price = parseFloat(actual_price);
  var discounted_price = parseFloat(value);
  if(discounted_price < actual_price){
    return true;
  }else{
    return false;
  }
}, "");


$('#couponaddform').validate({  
  /// rules of error 
  rules: {

    "validity": {
      required: true,
    },

    "coupon_code": {
      required: true,
      coupon_code_validity: true,
    },

    "discount_price": {
      required: true,
      number: true,
      discount_price_validity: true,
    },

    "customer_id[]": {
      required: true,
    }
  },

  messages: {

    "validity": {
      required: "Please select coupon validity start date & end date.",
    },

    "coupon_code": {
      required: "Please enter a coupon code.",
      coupon_code_validity: "Coupon code is already exists.",
    },

    "discount_price": {
      required: "Please enter discounted price.",
      number: "Please enter a valid discounted price.",
      discount_price_validity: "Please enter a valid discounted price.",
    },

    "customer_id[]": {
      required: "Please select at least one customer.",
    }
  }
});


});

</script>

<script>

  $(function () {
    $( "#valid_from" ).datepicker({
  dateFormat: "yy-mm-dd",
  beforeShowDay: NotAfterToday1
});
  } );

  function NotAfterToday1(date)
{
    var now = new Date();//this gets the current date and time
    if (date.getFullYear() == now.getFullYear() && date.getMonth() == now.getMonth() && date.getDate() >= now.getDate())
        return [true];
    if (date.getFullYear() >= now.getFullYear() && date.getMonth() > now.getMonth())
       return [true];
     if (date.getFullYear() > now.getFullYear())
       return [true];
    return [false];
}


  </script>

  <script>

  $(function () {
    $( "#valid_to" ).datepicker({
  dateFormat: "yy-mm-dd",
  beforeShowDay: NotAfterToday2
});
  } );

  function NotAfterToday2(date)
{
    var now = new Date();//this gets the current date and time
    if (date.getFullYear() == now.getFullYear() && date.getMonth() == now.getMonth() && date.getDate() > now.getDate())
        return [true];
    if (date.getFullYear() >= now.getFullYear() && date.getMonth() > now.getMonth())
       return [true];
     if (date.getFullYear() > now.getFullYear())
       return [true];
    return [false];
}


  </script>

    <div class="card-header" style="padding-left: 0px;padding-right: 0px;padding-bottom: 0px;padding-top: 10px;">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('delete'))
                            <div class="alert alert-danger">
                                {{ session('delete') }}
                            </div>
                        @endif
                    </div>

@if(Auth::user()->master_trainer==1)
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Add Discount Coupon</h1>
                    </div>
                </div>
            </div>    
</div>
        <div class="col-lg-12">
        <div class="card">
                      <div class="card-body card-block">
                        <form action="{{route('coupon_insert')}}" method="post" enctype="multipart/form-data" class="form-horizontal" id="couponaddform" data-parsley-validate>

                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                    <!--       <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Package Name<span class="required_field_color">*</span></label></div>
                         
                            <div class="col-12 col-md-9"><input type="text" id="slots_name" name="slots_name" placeholder="Enter Package Name" class="form-control slots_name required" onkeyup=" return jsnull()">
                               
                            </div>
                          </div> -->

                          <div   id="slot_details">
                            <div class="row form-group" id="s_d">
          <div class="col col-md-3">
            <label for="text-input" class=" form-control-label">Package Details</label>
          </div>
          
           
            <label class="sl3">Type : </label> {{$product->training_name}}
            
            @if($product->payment_type_id == 1)
            <lable class="sl">Total Package Price : <i class="fa fa-gbp"></i> </lable>
              {{$product->total_price}}
            <input type="hidden" name="actual_price" id="actual_price" value="{{$product->total_price}}">
            @elseif($product->payment_type_id == 2)
            <lable class="sl">Monthly Package Price : <i class="fa fa-gbp"></i> </lable>
              {{$product->price_session_or_month}}
              <input type="hidden" name="actual_price" id="actual_price" value="{{$product->price_session_or_month}}">
            @endif
              <label class="sl">Payment Type : </label>{{$product->payment_type_name}}
                
      </div>

                        <input type="hidden" id="product_id" name="product_id" value="{{$product_id}}">
                        @if(isset($product->package_discount_coupon_id) && !empty($product->package_discount_coupon_id))
                          <input type="hidden" name="package_discount_coupon_id" id="package_discount_coupon_id" value="{{$product->package_discount_coupon_id}}">
                        @else
                          <input type="hidden" name="package_discount_coupon_id" id="package_discount_coupon_id" >
                        @endif
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Coupon Validity<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9"><input class="drange form-control" type="text" name="validity" id="validity" value="" placeholder="Select Date" readonly/>
                            </div>
                          </div>
                           <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Discounted Price (<i class="fa fa-gbp"></i>)<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9">
                              
                              @if(isset($product->discount_price) && !empty($product->discount_price))
                                <input type="text" id="discount_price" name="discount_price" placeholder="Discount Price" class="form-control" value="{{$product->discount_price}}">
                              @else
                                <input type="text" id="discount_price" name="discount_price" placeholder="Discount Price" class="form-control" >
                              @endif
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Coupon Code<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9">
                              @if(isset($product->coupon_code) && !empty($product->coupon_code))
                                <input type="text" id="coupon_code" name="coupon_code" placeholder="Coupon Code" class="form-control" value="{{$product->coupon_code}}">
                              @else
                                <input type="text" id="coupon_code" name="coupon_code" placeholder="Coupon Code" class="form-control" value="">
                              @endif
                              <div id="duplicate_coupon" class="coupon-error2"></div>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Coupon Status<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9">
                              @if(isset($product->is_active) && !empty($product->is_active) || !isset($product->is_active))
                                  <input type="radio"  id="is_active_yes" class="is_active" name="is_active" value="1" checked="checked"> Active &nbsp;
                                  <input type="radio"  id="is_active_no" class="is_active" name="is_active" value="0"> Inactive
                              @else
                                  <input type="radio"  id="is_active_yes" class="is_active" name="is_active" value="1"> Active &nbsp;
                                  <input type="radio"  id="is_active_no" class="is_active" name="is_active" value="0" checked="checked"> Inactive
                              @endif
                              
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Coupon Type<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9">
                              @if(isset($product->is_generic) && $product->is_generic == 1 || !isset($product->is_generic))
                                <input type="radio"  id="is_generic_yes" class="is_generic" name="is_generic" value="1" checked="checked"> Generic &nbsp;
                                <input type="radio"  id="is_generic_no" class="is_generic" name="is_generic" value="0"> Customer Specific
                              @else
                                <input type="radio"  id="is_generic_yes" class="is_generic" name="is_generic" value="1" > Generic &nbsp;
                                <input type="radio"  id="is_generic_no" class="is_generic" name="is_generic" value="0" checked="checked"> Customer Specific
                              @endif
                              
                            </div>
                          </div>
                          @if(isset($product->is_generic) && $product->is_generic == 1 || !isset($product->is_generic))
                            <div class="row form-group specific-coupon-block" style="display: none;">
                          @else
                            <div class="row form-group specific-coupon-block">
                          @endif

                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Customer List<span class="required_field_color">*</span></label></div>
                            <div class="col-12 col-md-9">
                              @if(isset($product->is_generic) && $product->is_generic == 1 || !isset($product->is_generic))
                                <select name="customer_id_not_required[]" id="customer_id" class="form-control" multiple>
                              @else
                                <select name="customer_id[]" id="customer_id" class="form-control" multiple>
                              @endif
                              
                                    @if(count($customer_list))
                                      <option value=" ">Choose Customer</option>
                                      @foreach($customer_list as $single_customer)
                                        @if(isset($selected_customer_list) && in_array($single_customer->id, $selected_customer_list))
                                          <option value="{{$single_customer->id}}" selected="selected">{{$single_customer->name}} - {{$single_customer->email}}</option>
                                        @else
                                          <option value="{{$single_customer->id}}">{{$single_customer->name}} - {{$single_customer->email}}</option>
                                        @endif
                                          
                                      @endforeach 
                                    @else
                                      <option value=" ">No Customer Found</option>
                                    @endif 
                                </select>
                            </div>
                          </div>
                         <div class="row form-group">
                          <div class="col col-md-10">
                          </div>
                            <div class="col col-md-2" >
                                <button  type="submit" id="cupon_sub" name="submit" class="btn btn-primary cupon_sub" style="width: 65%; float: right;">
                                   Submit
                                </button>
                            </div>
                          </div>
                       

                        </form>


    </div>
                                      
                           
                      </div>
                    </div>
                    <!-- </div> -->


@endif
<script src="{{asset('backend/assets/js/moment.min.js')}}"></script>
<script src="{{asset('backend/assets/js/daterangepicker.min.js')}}"></script>







<script>
$(function() {
  var start, end;
  $('input[name="validity"]').daterangepicker({
    opens: 'left',
     minDate:moment().startOf('hour'),
       // end : moment().subtract(29, 'days'),
    locale: {
            format: 'YYYY-MM-DD'
            
        }
  }, 

  function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });




});
</script>


<script src="{{url('js/parsley.js')}}"></script>
<script src="{{url('js/parsley.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection