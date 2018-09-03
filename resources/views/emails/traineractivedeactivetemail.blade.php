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
</style>
</head>
<body style="margin: 0; padding: 0;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc;">
    <tr>
      <td align="center" bgcolor="#5C342C" style="padding: 20px 0 20px 0;">
        <h1><img src="https://www.bodybylekan.com/frontend/images/logo.png"></h1>
      </td>
    </tr>
    <tr> 
        <tr>
            <td style="padding: 20px 0 30px 0; text-align: center;">
    <p align="left"> </p>
    
          


<table style="width:100%">
  <tr>
    <th>
        Hi {{$trainer_name}},
    </th>
  </tr>
  <tr>
    <th> 
    @if($status=='Trainer Deactive')
    Your trainer account in Body By Lekan has been Deactivated by the Master Trainer due to some reason. Please contact with the Master Trainer if required.
    @endif

    @if($status=='Trainer Active')
    Your trainer account in Body By Lekan has been Activated by the Master Trainer.
    @endif

    @if($status=='Trainer Delete')
    Your trainer account in Body By Lekan has been Deleted by the Master Trainer due to some reason. Please contact with the Master Trainer if required.
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
