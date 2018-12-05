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
   try
      {
   $bootcamp_product_details=DB::table('products')
  ->join('training_type','products.training_type_id','training_type.id')
  ->join('payment_type','products.payment_type_id','payment_type.id')
  ->select('products.id as product_id','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.price_session_or_month as price_session_or_month','products.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration',(DB::raw('products.validity_value * products.validity_duration  as validity')),(DB::raw('products.notice_period_value * products.notice_period_duration  as notice_period')))
  ->whereNull('products.deleted_at')
  ->where('training_type.id',2)
  ->orderby('products.id','DESC')->get();

     return view('bbl')->with(compact('bootcamp_product_details'));
  }
      catch(\Exception $e) 
      {
        return abort(400);
      }
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
        $all_common_diet_plan=DB::table('common_diet_plan')->whereNull('deleted_at')->orderby('id','DESC')->get();
        return view('diet_plans')->with(compact('all_common_diet_plan'));
      }
      catch(\Exception $e) 
      {
        return abort(400);
      }
    }

    public function bootcamp_training()
    {     
    return view('bootcamp_training');
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
  try{
  
  $data=DB::table('slots')->where('deleted_at',null)->get();

  $personal_training_product_details=DB::table('products')
  ->join('training_type','products.training_type_id','training_type.id')
  ->join('payment_type','products.payment_type_id','payment_type.id')
  ->select('products.id as product_id','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.price_session_or_month as price_session_or_month','products.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration', (DB::raw('products.validity_value * products.validity_duration  as validity')), (DB::raw('products.notice_period_value * products.notice_period_duration  as notice_period')))
  ->whereNull('products.deleted_at')
  ->where('training_type.id',1)->where('products.status',1)
  ->orderby('products.id','DESC')->get();


  


  

  $bootcamp_product_details=DB::table('products')
  ->join('training_type','products.training_type_id','training_type.id')
  ->join('payment_type','products.payment_type_id','payment_type.id')
  ->select('products.id as product_id','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.price_session_or_month as price_session_or_month','products.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration',(DB::raw('products.validity_value * products.validity_duration  as validity')),(DB::raw('products.notice_period_value * products.notice_period_duration  as notice_period')))
  ->whereNull('products.deleted_at')
  ->where('training_type.id',2)->where('products.status',1)
  ->orderby('products.id','DESC')->get();

  // Log::debug(":: personal_training_product_details :: ".print_r($personal_training_product_details,true));


  $gym_product_details=DB::table('products')
  ->join('training_type','products.training_type_id','training_type.id')
  ->join('payment_type','products.payment_type_id','payment_type.id')
  ->select('products.id as product_id','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.price_session_or_month as price_session_or_month','products.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration',(DB::raw('products.validity_value * products.validity_duration  as validity')),(DB::raw('products.notice_period_value * products.notice_period_duration  as notice_period')))
  ->whereNull('products.deleted_at')
  ->where('training_type.id',3)->where('products.status',1)
  ->orderby('products.id','DESC')->get();


  
  return view('customerpanel.frontpricing')->with(compact('data','personal_training_product_details','bootcamp_product_details','gym_product_details'));

  }

    catch(\Exception $e) {

      return abort(400);
  }
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