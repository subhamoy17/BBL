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

.table-bordered
{
  border: 2px solid black;
}

</style>
</head>
<body style="margin: 0; padding: 0;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc;">
    <tr>
      <td align="center" bgcolor="#5C342C" style="padding: 20px 0 20px 0;">
        <h1><img src="http://www.bodybylekan.com/frontend/images/logo.png"  style="width: 200px;"></h1>
      </td>
    </tr>
    
        <tr>
            <td style="padding: 20px 0 30px 0; text-align: center;">
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
    <table style="width:100%" class="table-bordered">
  <tr>
    <th class="table-bordered">Package Name</th>
    <th class="table-bordered">Package Validity Upto</th>
    <th class="table-bordered">Available Session</th>
    <th class="table-bordered">Price</th>
  </tr>
  <tr>
    <th class="table-bordered">{{$package_name}}</th>
    <th class="table-bordered">{{date('d F Y', strtotime($package_validity))}}</th>
    <th class="table-bordered">{{$slots_number}}</th>
    <th class="table-bordered">{{$package_amount}}</th>
  </tr>
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
    <table style="width:100%" class="table-bordered">
  <tr>
    <th class="table-bordered">Package Name</th>
    <th class="table-bordered">Package Validity Upto</th>
    <th class="table-bordered">Available Session</th>
    <th class="table-bordered">Price</th>
  </tr>
  <tr>
    <th class="table-bordered">{{$package_name}}</th>
    <th class="table-bordered">{{date('d F Y', strtotime($package_validity))}}</th>
    <th class="table-bordered">{{$slots_number}}</th>
    <th class="table-bordered">{{$package_amount}}</th>
  </tr>
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
  </tr>
  </table>
</body>
</html>
