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
  <style>



</style>
</head>
<body style="margin: 0; padding: 0;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc;">
    <tr>
      <td align="center" bgcolor="#fb5b21" style="padding: 15px; width: 35%;">
        <img src="{{asset('frontend/images/logo2.png')}}" alt="Creating Email Magic" width="35%" style="display: block;" />
      </td>
    </tr>
    
        <tr>
            <td colspan="2" bgcolor="#ffffff" style="padding: 20px 20px 30px 20px;">
    <p align="left"> </p>
    
<table style="width:100%">
  <tr>
    <th>
    Hi {{$customer_name}},</th>
  </tr>
  <tr>
    <th> 
    @if($status=='Payment Success' && $payment_mode=='Paypal')
    You have successfully paid <i class="fa fa-gbp"> </i>{{$package_amount}} through PayPal and your Transaction ID is {{$payment_id}}. Please see the below purchased package. <a href="{{URL::to($url)}}">Click Here </a> to see your purchased package details.

    <br><br>
    <table  class="table table-bordered">
      <thead style="background-color:#FACFA4;">
  <tr style="font-size: 13px;">
    <th style="vertical-align:top">Package Name</th>
    <th style="vertical-align:top">Package Validity Upto</th>
    <th style="vertical-align:top">Available Session</th>
    <th style="vertical-align:top">Price</th>
  </tr>
</thead>
  <tbody>
  <tr style="font-size: 12px;">
    <td>{{$package_name}}</td>
    <td>{{date('d F Y', strtotime($package_validity))}}</td>
    <td>{{$slots_number}}</td>
    <td>{{$package_amount}}</td>
  </tr>
</tbody>
</table>
    @endif

    @if($status=='Payment Cancelled' && $payment_mode=='Paypal')
    The payment has not been completed due to cancelled transaction by you and if the amount is already debited from your account then it will autometically credited in your account within 7 working days.
    @endif

    @if($status=='Payment Failed' && $payment_mode=='Paypal')
    The payment has not been completed due some technical issue and if the amount is already debited from your account then it will autometically credited in your account within 7 working days.
    @endif

    @if($status=='Payment Success' && $payment_mode=='Bank Transfer')
    You have successfully paid <i class="fa fa-gbp"> </i>{{$package_amount}} through Bank Transfer and your Transaction ID is {{$payment_id}} and once the System Admin will approves your payment you can access the below mentioned package. <a href="{{URL::to($url)}}">Click Here </a> to see your purchased package details.


    <br><br>
    <table  class="table table-bordered">
      <thead style="background-color:#FACFA4;">
  <tr style="font-size: 13px;">
    <th style="vertical-align:top">Package Name</th>
    <th style="vertical-align:top">Package Validity Upto</th>
    <th style="vertical-align:top">Available Session</th>
    <th style="vertical-align:top">Price</th>
  </tr>
</thead>
 <tbody>
  <tr style="font-size: 12px;">
    <td>{{$package_name}}</td>
    <td>{{date('d F Y', strtotime($package_validity))}}</td>
    <td>{{$slots_number}}</td>
    <td>{{$package_amount}}</td>
  </tr>
</tbody>
</table>
    @endif
    @if($status=='Payment Failed' && $payment_mode=='Bank Transfer')
     The payment has not been completed due some technical issue using your bank transfer payment.
    @endif

    @if($status=='Bank Payment Approved' && $payment_mode=='Bank Transfer')
    Your payment of <i class="fa fa-gbp"> </i>{{$package_amount}} through bank transfer has been approved by the System Admin. Now you can avail your purchased package. <a href="{{URL::to($url)}}">Click Here </a> to see your purchased package details.
    @endif


    @if($status=='Bank Payment Declined' && $payment_mode=='Bank Transfer')
    Your payment of <i class="fa fa-gbp"> </i>{{$package_amount}} through bank transfer has been declined by the System Admin due some reason. Please wait for some time & our team will get back to your soon.
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
  <tr>
   <td colspan="2" bgcolor="#5C342C" style="padding: 7px 10px 7px 15px; background: url({{url('frontend/images/ghg.png')}}) no-repeat top center; background-size: cover; width: 100%; height: 60px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td width="50%" style="margin-top: 40px;">
            <p style="color: #fff; margin-top: 40px;font-family: 'Open Sans', sans-serif;"><i class="fa fa-copyright" aria-hidden="true"></i> Bodybylekan.com <?php echo date("Y"); ?></p>
          </td>
          <td align="right">
            <table border="0" cellpadding="0" cellspacing="0" style="margin-top: 22px;">
              <tr>
                <td>
                  <a href="https://www.youtube.com/channel/UCvFStHTPHjHY-_7BXA17Fug" style="margin-left:15px; font-size: 20px; color: #fff;">
                    <i class="fab fa-youtube"></i>
                  </a>
                </td>
                <td>
                  <a href="https://www.instagram.com/lekanfitness/" style="margin-left:15px; font-size: 20px; color: #fff;">
                    <i class="fab fa-instagram"></i>
                  </a>
                </td>
                <td>
                  <a href="https://twitter.com/bodybylekan" style="margin-left:15px; font-size: 20px; color: #fff;">
                    <i class="fab fa-twitter"></i>
                  </a>
                </td>
                <td>
                  <a href="https://www.facebook.com/bodybylekan" style="margin-left:15px; font-size: 20px; color: #fff;">
                    <i class="fab fa-facebook-f"></i>
                  </a>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  </table>
</body>
</html>
