<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\Enquiry;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class FrontSimpleController extends Controller
{


public function index(Request $request)
  {
   
 $data=DB::table('slots')->where('deleted_at',null)->get();
     return view('bbl')->with(compact('data'));
  }


  public function about()
    {	   	
      
      $data=DB::table('our_client')->where('deleted_at',null)->get();
    return view('frontabout')->with(compact('data'));
    }

    public function gym_training()
    {     
      
    return view('gym_training');
    }

    public function diet_plans()
    {  
      try
      {
        $all_common_diet_plan=DB::table('common_diet_plan')->whereNull('deleted_at')->get();
        return view('diet_plans')->with(compact('all_common_diet_plan'));
      }
      catch(\Exception $e) 
      {
        return abort(400);
      }
    }

    public function health_package()
    {     
    return view('health_package');
    }

    public function personal_instructor()
    {     
    return view('personal_instructor');
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




 public function front_contact()
   {  
    

    return view('frontcontact');
   }




 public function front_contact_insert(Request $request)
   {  
    
DB::beginTransaction();

    try{
 
//Log::debug(" data ".print_r($request->all(),true)); 
$data['user_name']=$request->form_name;
$data['user_email']=$request->form_email;
$data['user_subject']=$request->form_subject;
$data['user_phone']=$request->form_phone;
$data['message']=$request->form_message;
$data['created_at']=Carbon::now();
DB::table('contact_us')->insert($data);
DB::commit();
 return redirect()->back()->with("success","Your Enquiry is submitted successfully!");

}

    catch(\Exception $e) {
      DB::rollback();
      return abort(400);
  }  

   }




public function gym_gallery()
   {  

    

$data=DB::table('exercise_details')->where('deleted_at',null)->get();
    
    return view('frontgym')->with(compact('data'));
   }


}