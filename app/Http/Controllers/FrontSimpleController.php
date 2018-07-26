<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\Enquiry;
use Illuminate\Support\Facades\Mail;

class FrontSimpleController extends Controller
{





public function index(Request $request)
  {
   
 $data=DB::table('slots')->where('deleted_at',null)->get();
     return view('bbl')->with(compact('data'));
  }











  public function about()
    {	   	
    return view('frontabout');
    }



public function details()
   {	
    return view('frontdetails');
   }




public function history()
   {	
    return view('fronthistory');
   }

public function frontlogin()
   {	
    return view('frontlogin_registration');
   }


public function frontprice(Request $request)
{
    $data=DB::table('slots')->where('deleted_at',null)->get();
    return view('frontpricing')->with(compact('data'));
}


public function services()
   {	
    return view('frontservices');
   }






public function testimonial(Request $request)
{

$data=DB::table('testimonial')->where('deleted_at',null)->get();
return view('testimonial')->with(compact('data'));

}




 public function contact()
   {  
    return view('frontcontact');
   }













}