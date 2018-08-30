<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>BBL</title>
  <!--Font awesome cdn-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="shortcut icon" href="{{url('/images/icon-fav.png')}}" type="image/x-icon">
</head>
<body style="margin: 0; padding: 0;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc;">
    <tr>
      <td align="center" bgcolor="#5C342C" style="padding: 20px 0 20px 0;">
        <h1><img src="{{asset('frontend/images/logo.png')}}"></h1>
      </td>
    </tr>
    <tr> 
        <tr>
            <td style="padding: 20px 0 30px 0; text-align: center;">
    <p align="left"> </p>
    
          

<style>
table, th, td {
    border: 0px solid black;
    border-collapse: collapse;
    font-weight: 400;
}
th, td {
    padding: 5px;
}
th {
    text-align: left;
}
</style>
<table style="width:100%">
  <tr>
    <th>
      <?php 
      if($session_booking_time!= '')
      {
       $session_booking_time=substr($session_booking_time,0,2); 
      
      if($session_booking_time==12 )    { $session_booking_time='12 PM';  }
      elseif($session_booking_time==13) { $session_booking_time='1 PM'; }
      elseif($session_booking_time==14)  { $session_booking_time='2 PM'; }
      elseif($session_booking_time==15)  { $session_booking_time='3 PM'; }
      elseif($session_booking_time==16)  { $session_booking_time='4 PM'; }
      elseif($session_booking_time==17)  { $session_booking_time='5 PM'; }
      elseif($session_booking_time==18)  { $session_booking_time='6 PM'; }
      elseif($session_booking_time==19)  { $session_booking_time='7 PM'; }
      elseif($session_booking_time==20)  { $session_booking_time='8 PM'; }
      elseif($session_booking_time==21)  { $session_booking_time='9 PM'; }
      elseif($session_booking_time==22)  { $session_booking_time='10 PM'; }
      elseif($session_booking_time==23) { $session_booking_time='11 PM'; }
      elseif($session_booking_time==24)  { $session_booking_time='12 AM'; }
      else  { $session_booking_time=$session_booking_time.' AM'; }
      
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
    <td bgcolor="#5C342C" style="padding: 7px 30px 7px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td width="50%" style="padding: 0 0 0 0;">
          
          </td>
          <td align="right">
            <table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td>
                  <a href="http://www.youtube.com/" style="margin-left:10px;">
                    <img src="http://i.imgur.com/bn30JGj.png" alt="Youtube" width="38" height="38" style="display: inline-black; margin-left:5px;" border="0" />
                  </a>
                </td>
                <td>
                  <a href="http://www.google.com/" style="margin-left:10px;">
                    <img src="http://i.imgur.com/FtMuVSL.png" alt="Google+" width="38" height="38" style="display: inline-black; margin-left:5px;" border="0" />
                  </a>
                </td>
                <td>
                  <a href="http://www.twitter.com/" style="margin-left:10px;">
                    <img src="http://i.imgur.com/Da2dbTK.png" alt="Twitter" width="38" height="38" style="display: inline-black; margin-left:5px;" border="0" />
                  </a>
                </td>
                <td>
                  <a href="http://www.facebook.com/" style="margin-left:10px;">
                    <img src="http://i.imgur.com/t0a2zDt.png" alt="Facebook" width="38" height="38" style="display: inline-black; margin-left:5px;" border="0" />
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
