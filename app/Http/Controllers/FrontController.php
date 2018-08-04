<?php



namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\Enquiry;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DateTime;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Auth;
class FrontController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:customer');
    }



public function bbl()
  	
 {
    

    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
     ->join('users','users.id','slot_request.trainer_id')
     ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')

    ->select('customers.name','slots.slots_name','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_start_date','purchases_history.purchases_end_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_request.slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.customer_id',Auth::user()->id)->get()->all();

        foreach($data as $dt)
{
           $now = Carbon::now();
  $end=Carbon::createFromFormat('Y-m-d', $dt->purchases_end_date);
$totalDuration = $end->diffInDays($now);
$dt->timeremaining=$totalDuration;
}

return view('customerpanel.bbl')->with(compact('data','dt'));

  }
     






  public function about()
    {	   
    
$data=DB::table('our_client')->where('deleted_at',null)->get();
    return view('customerpanel/frontabout')->with(compact('data'));
    }






public function details()
   {	
    return view('customerpanel/frontdetails');
   }

public function history()
   {	
    return view('customerpanel/fronthistory');
   }

public function frontlogin()
   {	
    return view('customerpanel/frontlogin_registration');
   }


public function frontprice(Request $request)
{
    $data=DB::table('slots')->where('deleted_at',null)->get();
    return view('customerpanel.frontpricing')->with(compact('data'));
}


public function services()
   {	
    return view('customerpanel/frontservices');
   }



public function purchase_form($id)
   { 

     
      $slot_id=$id;
      $data=DB::table('customers')->where('id',Auth::user()->id)->first();
      Log::debug(":: purchase details :: ".print_r($data,true));

    return view('customerpanel.purchases')->with(compact('data','slot_id'));
   }


function purchaseinsert(Request $request)
{


 $data['slot_id']=$request->id;
$data['payment_options']=$request->selector1;
$data['purchases_start_date']=Carbon::now();
$data['purchases_end_date']=Carbon::now()->addDay(25);
DB::table('purchases_history')->insert($data);
return redirect()->route("customer.pricing")->with("success","Your slot is subscribe successfully !");
}



public function customer_profile($id)
   {  
    Log::debug(":: Show Profile :: ".print_r($id,true));

    $data=DB::table('customers')->where('id',$id)->first();
    Log::debug(":: customers data :: ".print_r($data,true));
    return view('customerpanel.profile')->with(compact('data'));
   }


public function customer_showupdateform($id)
{
    $data= DB::table('customers')->where('id',$id)->first();
    Log::debug(" data ".print_r($data,true));

    return view ("customerpanel.editprofile")->with(compact('data'));

}




// update profile of trainer
public function updateprofile(Request $request)
{


    if($request->image!="")
    {
        $myimage=$request->image;
        $folder="backend/images/"; 
      $extension=$myimage->getClientOriginalExtension(); 
        $image_name=time()."_trainerimg.".$extension; 
        $upload=$myimage->move($folder,$image_name); 
        $mydata['image']=$image_name; 
    }
    else {   $mydata['image']=$request->oldimage; }
    $mydata['name']=$request->name;
    $mydata['email']=$request->email;
    $mydata['ph_no']=$request->ph_no;
    $mydata['address']=$request->address;
    $data['updated_at']=Carbon::now();


    $data=DB::table('customers')->where('id',$request->id)->update($mydata);
    return redirect()->back()->with("success","Your profile is update successfully !");
}






public function purchases_history(Request $request)
{

    $data=DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->select('slots.slots_name','slots.slots_price','slots.slots_validity','purchases_history.purchases_start_date','purchases_history.payment_options','slots.slots_validity','purchases_history.purchases_end_date','purchases_history.id')->where('purchases_history.customer_id',Auth::user()->id)->get()->all();
Log::debug(" Check id ".print_r($data,true));

foreach($data as $dt)
{
  
  $now = Carbon::now();
  $end=Carbon::createFromFormat('Y-m-d', $dt->purchases_end_date);
$totalDuration = $end->diffInDays($now);
$dt->timeremaining=$totalDuration;
}
Log::debug(" Check id ".print_r($data,true));

    return view('customerpanel.purchases_history')->with(compact('data'));

   
}



public function booking_slot($id)
{

$purchases_id=$id;
 $data=DB::table('users')->get();
return view('customerpanel.booking_slot')->with(compact('data','purchases_id'));

}




function slotinsert(Request $request)
{

Log::debug(" Check id ".print_r($request->all(),true));

$data['purchases_id']=$request->idd;
 
$data['trainer_id']=$request->id;
$data['slot_time']=$request->time;
$data['slot_date']=$request->date;

$data["customer_id"]=Auth::user()->id;
DB::table('slot_request')->insert($data);

Log::debug(" Check id ".print_r($data,true));

return redirect()->back()->with("success","Your booking form is update successfully !");

}




public function booking_history()
{

$data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
     ->join('users','users.id','slot_request.trainer_id')
     ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')

    ->select('customers.name','slots.slots_name','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_start_date','purchases_history.purchases_end_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_request.slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.customer_id',Auth::user()->id)->get()->all();

foreach($data as $dt)
{
           $now = Carbon::now();
  $end=Carbon::createFromFormat('Y-m-d', $dt->purchases_end_date);
$totalDuration = $end->diffInDays($now);
$dt->timeremaining=$totalDuration;
}


return view('customerpanel.booking_history')->with(compact('data','dt'));

}






public function my_mot()
{


 
$data=DB::table('customer_mot')
    ->join('customers','customers.id','customer_mot.customer_id')
    ->join('users','users.id','customer_mot.trainer_id')
    ->select('customer_mot.id as mot_id','customer_mot.customer_id as customer_id','customer_mot.trainer_id','customer_mot.date','customer_mot.left_arm','users.name as users_name','customer_mot.right_arm','customer_mot.chest','customer_mot.waist','customer_mot.hips','customer_mot.right_thigh','customer_mot.left_thigh','customer_mot.weight','customer_mot.right_calf','customer_mot.left_calf')->get();



return view('customerpanel.my_mot')->with(compact('data'));

}








 public function customer_contact()
   {  
    return view('customerpanel/frontcontact');
   }


 public function front_contact_insert(Request $request)
   {  

Log::debug(" data ".print_r($request->all(),true)); 
$data['user_name']=$request->form_name;
$data['user_email']=$request->form_email;
$data['user_subject']=$request->form_subject;
$data['user_phone']=$request->form_phone;
$data['message']=$request->form_message;
$data['created_at']=Carbon::now();
DB::table('contact_us')->insert($data);
 return redirect()->back()->with("success","Your Enquiry is submitted successfully!");

   }



public function cust_testimonial(Request $request)
{

$data=DB::table('testimonial')->where('deleted_at',null)->get();
return view('customerpanel.cust_testimonial')->with(compact('data'));

}






public function exercise()
   {  

$data=DB::table('exercise_details')->where('deleted_at',null)->get();
    
    return view('customerpanel.front_gym')->with(compact('data'));
   }















}