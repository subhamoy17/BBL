<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Body By Lekan</title>
  <!--Font awesome cdn-->
  <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="http://localhost:8000/images/icon-fav.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Black+Han+Sans|Open+Sans:400,600,700|Righteous" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 
</head>
<body style="margin: 0; padding: 0;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #eae6e6;">
   <tr>
      <td align="center" bgcolor="#fb5b21" style="padding: 15px; width: 35%;">
        <img src="{{asset('frontend/images/logo2.png')}}" alt="Creating Email Magic" width="35%" style="display: block;" />
      </td>
   
    </tr>
    <tr> 
        <tr>
            <td colspan="2" bgcolor="#ffffff" style="padding: 20px 20px 30px 20px;">
    <p align="left"> </p>
    

<table style="width:100%">
  <tr>
    <th>
      <?php 
      if($session_booking_time!= '')
      {
        
       $session_booking_time=date('h:i A', strtotime($session_booking_time)); 
      }

      ?>


      @if($status=='Sent Session Request To Trainer' || $status=='Delete Session Request To Trainer')
        Hi {{$trainer_name}},

      @else
        Hi {{$customer_name}},
      @endif

      </th>
  </tr>
  <tr>
    <th> 

      <!-- after sent request to client -->
    @if($status=='Sent Session Request') 
    Thank you for your request, Please wait for trainer to approve your booking and once the trainer will aprrove your booking request we will let your know. <a href="{{URL::to($url)}}">Click Here </a> to see your session booking details.
    @endif

      <!-- after approved request by trainer to client -->
    @if($status=='Approved Session Request')
    Your booking on {{date('d F Y', strtotime($session_booked_on))}} at {{$session_booking_time}} with trainer {{$trainer_name}} has been approved. <a href="{{URL::to($url)}}">Click Here </a> to see your session booking details.
    @endif

      <!-- after declined request by trainer to client -->

    @if($status=='Declined Session Request')
    Your booking on {{date('d F Y', strtotime($session_booked_on))}} at {{$session_booking_time}} with trainer {{$trainer_name}} has been declined due to {{$decline_reason}}. <a href="{{URL::to($url)}}">Click Here </a> to see your session booking details.
    @endif

      <!-- after deactive/ delete trainer by master trainer to client -->
    @if($status=='Cancelled Session Request')
    Your booking on {{date('d F Y', strtotime($session_booked_on))}} at {{$session_booking_time}} with trainer {{$trainer_name}} has been cancelled due to {{$decline_reason}}. Our team will get back to you soon for the same. <a href="{{URL::to($url)}}">Click Here </a> to see your session booking details.
    @endif

      <!-- after sent session request by client to trainer -->
    @if($status=='Sent Session Request To Trainer')
    You have new session request on {{date('d F Y', strtotime($session_booking_date))}} at {{$session_booking_time}} with a client named {{$customer_name}}. Please login your account in BBL Trainer portal to approve the same. <a href="{{URL::to($url)}}">Click Here </a> to see the list of session request.
    @endif

      <!-- after delete session request by client -->
    @if($status=='Delete Session Request To Customer')
    You have successfully cancelled your session request scheduled on {{date('d F Y', strtotime($session_booking_date))}} at {{$session_booking_time}} with {{$trainer_name}}. <a href="{{URL::to($url)}}">Click Here </a> to see your session request details.
    @endif

      <!-- after delete session request by client to trainer-->
    @if($status=='Delete Session Request To Trainer')
    {{$customer_name}} has cancelled the session request with you on {{date('d F Y', strtotime($session_booking_date))}} at {{$session_booking_time}} due to some reason. <a href="{{URL::to($url)}}">Click Here </a> to see list of cacellation request.
    @endif

    <!-- after sent session request by trainer-->
    @if($status=='Sent Session Request by trainer') 
    Your session on {{date('d F Y', strtotime($session_booking_date))}} at {{$session_booking_time}} has been booked with {{$trainer_name}} by {{$sending_trainer}}. <a href="{{URL::to($url)}}">Click Here </a> to see your session booking details.
    @endif

    

    </th> 
     </tr>

     <tr>
    <th> 
        Regards,
        </th> 
     </tr>
<tr>
    <th> 
        Team BBL
        </th> 
     </tr>

</table>

</td>
  </tr>
     <td colspan="2" bgcolor="#5C342C" style="padding: 7px 10px 7px 15px; background: url({{url('frontend/images/ghg.png')}}) no-repeat top center; background-size: cover; width: 100%; height: 60px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td width="50%" style="margin-top: 40px;">
            <p style="color: #fff; margin-top: 40px;font-family: 'Open Sans', sans-serif;">&copy;<a href='https://www.bodybylekan.com/' target="_blank" style='color: white;'>bodybylekan.com</a> <?php echo date("Y"); ?></p>
          </td>
          <td align="right">
            <table border="0" cellpadding="0" cellspacing="0" style="margin-top: 22px;">
              <tr>
                <td>
                  <a href="https://www.youtube.com/channel/UCvFStHTPHjHY-_7BXA17Fug" style="margin-left:15px; font-size: 20px; color: #fff;">
                    <img src="{{url('frontend/images/youtube-icon.png')}}" style="width: 40px; margin-top: 20px;">
                  </a>
                </td>
                <td>
                  <a href="https://www.instagram.com/lekanfitness/" style="margin-left:15px; font-size: 20px; color: #fff;">
                    <img src="{{url('frontend/images/insta-icon.png')}}" style="width: 40px; margin-top: 20px;">
                  </a>
                </td>
                <td>
                  <a href="https://twitter.com/bodybylekan" style="margin-left:15px; font-size: 20px; color: #fff;">
                    <img src="{{url('frontend/images/twitter-icon.png')}}" style="width: 40px; margin-top: 20px;">
                  </a>
                </td>
                <td>
                  <a href="https://www.facebook.com/bodybylekan" style="margin-left:15px; font-size: 20px; color: #fff;">
                    <img src="{{url('frontend/images/facebook-icon.png')}}" style="width: 40px; margin-top: 20px;">
                  </a>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </table>
</body>
</html>
