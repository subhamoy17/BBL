   <!-- All footer content and all link are here -->


    <script src="{{asset('backend/assets/js/vendor/jquery-2.1.4.min.js')}}"></script>
	
	<script type="text/javascript">
		$(document).ready(function() {
		$(".loader").fadeOut("slow");
	});
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="{{asset('backend/assets/js/plugins.js')}}"></script>
    <script src="{{asset('backend/assets/js/main.js')}}"></script>
    <script src="{{url('frontend/js/jquery-ui.js')}}"></script>



    <script src="{{asset('backend/assets/js/lib/chart-js/Chart.bundle.js')}}"></script>
    <script src="{{asset('backend/assets/js/dashboard.js')}}"></script>
    <script src="{{asset('backend/assets/js/widgets.js')}}"></script>
    <script src="{{asset('backend/assets/js/lib/vector-map/jquery.vmap.js')}}"></script>
    <script src="{{asset('backend/assets/js/lib/vector-map/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/lib/vector-map/jquery.vmap.sampledata.js')}}"></script>
    <script src="{{asset('backend/assets/js/lib/vector-map/country/jquery.vmap.world.js')}}"></script>

    
    
    <script>
        ( function ( $ ) {
            "use strict";

            jQuery( '#vmap' ).vectorMap( {
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: [ '#1de9b6', '#03a9f5' ],
                normalizeFunction: 'polynomial'
            } );
            
})( jQuery );
  
    </script>

    


  



    <script src="{{asset('backend/assets/js/totanjs/alertify.min.js')}}"></script>

<!-- <script src="{{asset('backend/assets/js/jquery.js')}}"></script>
<script src="{{asset('backend/assets/js/jquery-ui.min.js')}}"></script> -->
    <script>

 
   $(document).ready(function() {
    src = "{{ route('searchajax') }}";
     $("#apply1").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) { //alert(data);
                response( $.map( data, function( item ) {
                  
                    
                    return {  
                        value: item.value,
                        id:item.id,
                        email: item.email,
                         ph_no: item.ph_no,
                       
                    }
                }));

                }

            });
        },
        minLength: 3,
        select: function(event, ui) {
          console.log(ui.item);

        $("#apply").val(ui.item.id); 

        // alert($("#b").val(ui.item.ph_no));
        
$("#mail").show();
         $("#cus_e").text(ui.item.email);
         $("#cus_n").text(ui.item.value);
         $("#cus_p").text(ui.item.ph_no);


        //var d= a + + b + + c;
        

        // $("#mail").show();

        // // var a=$("#a").val(ui.item.value); 
        // // var b=$("#b").val(ui.item.ph_no); 
        // // var c=$("#c").val(ui.item.email); 

        // // alert($("#b").val(ui.item.ph_no));
        // // var alldata=ui.item.value +, + ui.item.ph_no +, + ui.item.email;
        // // alert(alldata);
        //  $("#cus_e").text(d);
        

         var Data = 
  {
    'id': ui.item.id
 
  }
  if($("#apply").val())
  {

 $.ajax({
          url: "{{route('mot_customer_request')}}",
          json_enc: Data,
          type: "GET",
          dataType: "json",
          data:
          {
            'data': Data,
          },
          success: function (data)
          {
            
$('#right_arm').val(data.right_arm);
 $('#left_arm').val(data.left_arm);
  $('#chest').val(data.chest);
 $('#waist').val(data.waist);
  $('#hips').val(data.hips);
   $('#right_thigh').val(data.right_thigh);
    $('#left_thigh').val(data.left_thigh);
     $('#right_calf').val(data.right_calf);
      $('#left_calf').val(data.left_calf);
       $('#height').val(data.height);
       $('#starting_weight').val(data.starting_weight);
       $('#ending_weight').val(data.ending_weight);
       $('#heart_beat').val(data.heart_beat);
        $('#blood_pressure').val(data.blood_pressure);
       $('#description').val(data.description);
       $('#mot_date').val(data.date);
       
          }
        });
}

else{
  $("#mail").hide();
      $('#right_arm').val('');
 $('#left_arm').val('');
  $('#chest').val('');
 $('#waist').val('');
  $('#hips').val('');
   $('#right_thigh').val('');
    $('#left_thigh').val('');
     $('#right_calf').val('');
      $('#left_calf').val('');
       $('#height').val('');
       $('#starting_weight').val('');
       $('#ending_weight').val('');
       $('#heart_beat').val('');
        $('#blood_pressure').val('');
       $('#description').val('');
       $('#mot_date').val('');
    }

    }
    });
});
</script>

   @if(Request::segment(1) == 'trainer' && Request::segment(2) == 'add_session') 
<script>
  
   $(document).ready(function() {
    src = "{{ route('customersearch') }}";
     $("#apply2").autocomplete({
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


                    $('#right').hide();
                    $('#wrong').hide();
                    $('#mail').hide();
                    
                   
                }


            });
        },
        minLength: 3,
        select: function(event, ui) {
        $("#customer_id").val(ui.item.id);  // ui.item.value contains the id of the selected label
        $("#customer_idd").val(ui.item.id);  // ui.item.value contains the id of the selected label
        $("#mail").show();
        
        $("#cus_det").text(ui.item.value + ", " + ui.item.email + ", " + ui.item.ph_no);

         var Data = 
  {
    'id': ui.item.id
 
  }
    $.ajax({
          url: "{{route('check_customer_session')}}",
          json_enc: Data,
          type: "GET",
          dataType: "json",
          data:
          {
            'data': Data,
          },
          success: function (data)
          {

         if(data>0)
         {

          $('#total_slots').val(data);
          $('#total_slots2').val(data);
          $('#right').show();
         }
         else
         {
          $('#total_slots').val(data);
          $('#total_slots2').val(data);
          $('#wrong').show();
         }
       
          }
        });
    }
    });
});

</script>

@endif

<script src="{{url('frontend/js/accotab.js')}}"></script>

</body>
</html>