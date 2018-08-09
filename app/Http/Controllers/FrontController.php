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

    ->select('customers.name','slots.slots_name','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_request.slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.customer_id',Auth::user()->id)->get()->all();

        foreach($data as $dt)
{
           $now = Carbon::now();
  $end=Carbon::createFromFormat('Y-m-d', $dt->package_validity_date);
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
      
    $data=DB::table('customers')->where('id',Auth::guard('customer')->user()->id)->first();
    Log::debug(":: purchase details :: ".print_r($data,true));
    return view('customerpanel.purchases')->with(compact('data','slot_id','slots_name' ));
  }


function purchase_payment_mode(Request $request)
{
  $slot_details=DB::table('slots')->where('id',$request->id)->first();

  $data["slots_name"]=$slot_details->slots_name;
  $data["slots_number"]=$slot_details->slots_number;
  $data["slots_price"]=$slot_details->slots_price;
  $data["customer_id"]=Auth::guard('customer')->user()->id;
  $data['slot_id']=$request->id;
  $data['payment_options']=$request->selector1;
  $data['purchases_date']=Carbon::now();
  $data['package_validity_date']=Carbon::now()->addDay($slot_details->slots_validity);

  if($request->selector1=='Paypal')
  {
    return view('customerpanel.paypal-payment')->with(compact('data'));
  }
// DB::table('purchases_history')->insert($data);
// return redirect()->route("customer.pricing")->with("success","Your slot is subscribe successfully !");
}

public function paypal_payment_success()
{
    return view('customerpanel.paypal-payment-success');
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









public function booking_history(Request $request)
{
  
     
     if(isset($request->start_date) && isset($request->end_date) && !empty($request->start_date) && !empty($request->end_date)){
        $start_date=$request->start_date;
        $end_date=$request->end_date;
      // echo $start_date."-".$end_date;die();
      Log::debug(" Check ".print_r($start_date,true)); 
      Log::debug(" Check id ".print_r($end_date,true)); 
    }
       // $startDate=Carbon::createFromFormat('Y-m-d', $start_date);
      // $endDate=Carbon::createFromFormat('Y-m-d', $end_date);
    // echo $request->option;die();
 $now = Carbon::now();
 if($request->option=='future_pending'){
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->join('users','users.id','slot_request.trainer_id')
    ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->select('customers.name','slots.slots_name','slots.slots_number','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_request.slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.slot_date','>=',$now )->where('slot_request.approval_id',1 )->whereBetween('slot_request.slot_date', [$start_date, $end_date])->where('slot_request.customer_id',Auth::user()->id)->paginate(1);

   }else if($request->option=='delete_request'){
  $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
     ->join('users','users.id','slot_request.trainer_id')
     ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')

    ->select('customers.name','slots.slots_name','slots.slots_number','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_request.slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.slot_date','>=',$now )->where('slot_request.approval_id',2 )->whereBetween('slot_request.slot_date', [$start_date, $end_date])->where('slot_request.customer_id',Auth::user()->id)->paginate(1);

 }else if($request->option=='declined_request' ){
  $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
     ->join('users','users.id','slot_request.trainer_id')
     ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')

    ->select('customers.name','slots.slots_name','slots.slots_number','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_request.slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.slot_date','>=',$now )->where('slot_request.approval_id',4 )->whereBetween('slot_request.slot_date', [$start_date, $end_date])->where('slot_request.customer_id',Auth::user()->id)->paginate(1);

}else if($request->option=='past_request' ){
  $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
     ->join('users','users.id','slot_request.trainer_id')
     ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')

    ->select('customers.name','slots.slots_name','slots.slots_number','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_request.slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.slot_date','<',$now )->whereBetween('slot_request.slot_date', [$start_date, $end_date])->where('slot_request.customer_id',Auth::user()->id)->paginate(4);

    foreach($data as $past_data){

$past_data->past_mot=DB::table('customer_mot')
    ->join('customers','customers.id','customer_mot.customer_id')
    ->join('users','users.id','customer_mot.trainer_id')
    ->select('customer_mot.id as mot_id','customer_mot.customer_id as customer_id','customer_mot.trainer_id','customer_mot.date','customer_mot.left_arm','users.name as users_name','customer_mot.right_arm','customer_mot.chest','customer_mot.waist','customer_mot.hips','customer_mot.right_thigh','customer_mot.left_thigh','customer_mot.weight','customer_mot.right_calf','customer_mot.left_calf')->where('customer_mot.date',$past_data->slot_date)->first();
    }
}else{
  $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
     ->join('users','users.id','slot_request.trainer_id')
     ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')

    ->select('customers.name','slots.slots_name','slots.slots_number','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_request.slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.slot_date','>=',$now )->where('slot_request.approval_id',3 )->where('slot_request.customer_id',Auth::user()->id);
    if($request->start_date && $request->end_date)
      $data->whereBetween('slot_request.slot_date', [$start_date, $end_date]);
    $data=$data->paginate(1);
 }


  Log::debug(" Check id ".print_r($data,true));  
// if(count($data)>0){
// foreach($data as $dt)
// {
           $now = Carbon::now();
  // $end=Carbon::createFromFormat('Y-m-d', $dt->package_validity_date);
// $totalDuration = $end->diffInDays($now);
// $dt->timeremaining=$totalDuration;

 $sum_slots = DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('slot_request','slot_request.purchases_id','purchases_history.id')->select('slot_request.purchases_id','slots.slots_number')->distinct('slot_request.purchases_id')->where('slot_request.customer_id',Auth::user()->id)
     ->sum('slots.slots_number');
     // foreach ($session_history as $key => $data_number) {

      $count=DB::table('slot_request')->where('slot_request.slot_date','<=',$now )->count();
      $future_pending_count=DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('slot_request','slot_request.purchases_id','purchases_history.id')->select('slot_request.purchases_id','slots.slots_number','slots.slot_date')->where('slot_request.customer_id',Auth::user()->id)->where('slot_request.slot_date','>=',$now )->where('slot_request.approval_id',1 )->count();
     // }

      $accepted_count= DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('slot_request','slot_request.purchases_id','purchases_history.id')->select('slot_request.purchases_id','slots.slots_number','slots.slot_date')->where('slot_request.customer_id',Auth::user()->id)->where('slot_request.slot_date','>=',$now )->where('slot_request.approval_id',3 )->count();
     Log::debug(" Check id ".print_r($sum_slots,true));  

 
 if($request->ajax()){
return response()->json($data);
}

return view('customerpanel.booking_history',['data' => $data])->with(compact('fea_pen_data','data','dt','sum_slots','count','accepted_count','future_pending_count'));

}














public function purchases_history(Request $request)
{


if(isset($request->start_date) && isset($request->end_date) && !empty($request->start_date) && !empty($request->end_date)){
        $start_date=$request->start_date;
        $end_date=$request->end_date;
      // echo $start_date."-".$end_date;die();
      Log::debug(" Check ".print_r($start_date,true)); 
      Log::debug(" Check id ".print_r($end_date,true)); 
  

    $purchases_data=DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('customers','customers.id','purchases_history.customer_id')
    ->select('purchases_history.slots_name','purchases_history.slots_price','slots.slots_validity','purchases_history.slots_number','purchases_history.payment_options','purchases_history.package_validity_date','purchases_history.id','slots.slots_number','purchases_history.purchases_date')->where('purchases_history.purchases_date','>=',[$start_date])->where('purchases_history.package_validity_date','<=',[$end_date])->where('purchases_history.customer_id',Auth::user()->id)->paginate(3);


    foreach($purchases_data as $searchdt)
{
  
  $now = Carbon::now();
  $end=Carbon::createFromFormat('Y-m-d', $searchdt->package_validity_date);
$totalDuration = $end->diffInDays($now);
$searchdt->timeremaining=$totalDuration;

}
Log::debug(" date ");
  }


else{
  $purchases_data=DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('customers','customers.id','purchases_history.customer_id')
    ->select('purchases_history.slots_name','purchases_history.slots_price','slots.slots_validity','purchases_history.slots_number','purchases_history.payment_options','purchases_history.package_validity_date','purchases_history.id','slots.slots_number','purchases_history.purchases_date')->where('purchases_history.customer_id',Auth::user()->id)->paginate(3);


Log::debug(" Check id ".print_r($purchases_data,true));

foreach($purchases_data as $dt)
{
  
  $now = Carbon::now();
  $end=Carbon::createFromFormat('Y-m-d', $dt->package_validity_date);
$totalDuration = $end->diffInDays($now);
$dt->timeremaining=$totalDuration;

}
Log::debug("all date ");
}


Log::debug(" Check id ".print_r($purchases_data,true));

 return view('customerpanel.purchases_history')->with(compact('purchases_data'));

   
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