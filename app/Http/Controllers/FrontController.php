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
use Session;

use App\Customer;
use App\User;
use App\Notifications\SessionRequestNotification;
use App\Notifications\SessionRequestNotificationToTrainer;



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
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select('customers.name','slots.slots_name','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_times.time as slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.customer_id',Auth::user()->id)->get()->all();

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

  Log::debug(":: slot_id :: ".print_r($slot_id,true));

  $package_details=DB::table('slots')->where('id',$slot_id)->first();
      
  $data=DB::table('customers')->where('id',Auth::guard('customer')->user()->id)->first();
  Log::debug(":: purchase details :: ".print_r($data,true));
  return view('customerpanel.purchases')->with(compact('data','package_details'));
}


public function purchase_payment_mode(Request $request)
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
  if($request->selector1=='Bank Transfer')
  {
    return view('customerpanel.bank-payment')->with(compact('data'));
  }
}


public function paypal_payment_success()
{
  return view('customerpanel.payment-success');
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

  

  if(isset($request->start_date) && isset($request->end_date) && !empty($request->start_date) && !empty($request->end_date))
    {
      $start_date=$request->start_date;
      $end_date=$request->end_date;
      Log::debug(" Check ".print_r($start_date,true)); 
      Log::debug(" Check id ".print_r($end_date,true)); 
    }

    $now = Carbon::now()->toDateString();
    $now_month = Carbon::now()->addDays(30)->toDateString();
  if($request->option=='future_pending')
  {
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->join('users','users.id','slot_request.trainer_id')
    ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('slot_times','slot_times.id','slot_request.slot_time_id')
    ->select('customers.name','slots.slots_name','slots.slots_number','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_times.time as slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.slot_date','>=',$now )->where('slot_request.approval_id',1 )->whereBetween('slot_request.slot_date', [$start_date, $end_date])
    ->where('slot_request.customer_id',Auth::guard('customer')->user()->id)->paginate(10);
  }
  else if($request->option=='delete_request')
  {
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->join('users','users.id','slot_request.trainer_id')
    ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('slot_times','slot_times.id','slot_request.slot_time_id')
    ->select('customers.name','slots.slots_name','slots.slots_number','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_times.time as slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.approval_id',2 )->whereBetween('slot_request.slot_date', [$start_date, $end_date])
    ->where('slot_request.customer_id',Auth::guard('customer')->user()->id)->paginate(10);
  }
  else if($request->option=='declined_request' )
  {
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->join('users','users.id','slot_request.trainer_id')
    ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('slot_times','slot_times.id','slot_request.slot_time_id')
    ->select('customers.name','slots.slots_name','slots.slots_number','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_times.time as slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.approval_id',4 )->whereBetween('slot_request.slot_date', [$start_date, $end_date])->where('slot_request.customer_id',Auth::guard('customer')->user()->id)->paginate(10);
  }
  else if($request->option=='past_request' )
  {
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->join('users','users.id','slot_request.trainer_id')
    ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('slot_times','slot_times.id','slot_request.slot_time_id')
    ->select('customers.name','slots.slots_name','slots.slots_number','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_times.time as slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.slot_date','<',$now )->whereBetween('slot_request.slot_date', [$start_date, $end_date])->where('slot_request.customer_id',Auth::guard('customer')->user()->id)->paginate(10);

    foreach($data as $past_data)
    {

      $past_data->past_mot=DB::table('customer_mot')
      ->join('customers','customers.id','customer_mot.customer_id')
      ->join('users','users.id','customer_mot.trainer_id')
      ->select('customer_mot.id as mot_id','customer_mot.customer_id as customer_id','customer_mot.trainer_id','customer_mot.date','customer_mot.left_arm','users.name as users_name','customer_mot.right_arm','customer_mot.chest','customer_mot.waist','customer_mot.hips','customer_mot.right_thigh','customer_mot.left_thigh','customer_mot.weight','customer_mot.right_calf','customer_mot.left_calf','customer_mot.starting_weight','customer_mot.ending_weight','customer_mot.heart_beat','customer_mot.blood_pressure','customer_mot.height','customer_mot.description')->where('customer_mot.date',$past_data->slot_date)->first();
    }
  }
  else
  {
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->join('users','users.id','slot_request.trainer_id')
    ->join('purchases_history','purchases_history.id','slot_request.purchases_id')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('slot_times','slot_times.id','slot_request.slot_time_id')
    ->select('customers.name','slots.slots_name','slots.slots_number','slots.slots_price','slots.slots_validity','users.name as users_name','purchases_history.purchases_date','purchases_history.package_validity_date','slot_request.purchases_id as slot_purchases_id','slot_approval.status','slot_request.slot_date','slot_times.time as slot_time','slot_approval.status', 'slot_request.created_at')->where('slot_request.slot_date','>=',$now)->where('slot_request.approval_id',3 )->where('slot_request.customer_id',Auth::guard('customer')->user()->id);
    if($request->start_date && $request->end_date)
    {
      $data->whereBetween('slot_request.slot_date', [$start_date, $end_date]);
    }
    else
    {
      $data->whereBetween('slot_request.slot_date', [$now, $now_month]);
    }
    $data=$data->paginate(10);
  }


    Log::debug(" Check id ".print_r($data,true));  
    
 
     //@totan

    //when a customer's past request (s) are not approved/ declined then for that session 
    // all sessions are added of latest-end package and into the slot_request table update 
    // all past request approval_id=5 of that customer after login. 

    $remaining_session_request_now=Carbon::now()->toDateString();

     $all_package=DB::table('purchases_history')
      ->select('id','purchases_date','package_validity_date','package_remaining','slots_number')
      ->where('customer_id',Auth::guard('customer')->user()->id)
      ->where('active_package',1)
      ->where('package_validity_date','>=',$remaining_session_request_now)
      ->orderBy('package_validity_date', 'DESC')
      ->first();
      if($all_package)
      {
        $count_past_slot_request=DB::table('slot_request')
        ->where('customer_id',Auth::guard('customer')->user()->id)
        ->where('slot_date','<',$remaining_session_request_now)
        ->where('approval_id',1)
        ->count();

        $total_remaining_package=$all_package->package_remaining+$count_past_slot_request;

        $package_update=DB::table('purchases_history')
        ->where('id',$all_package->id)
        ->update(['package_remaining'=>$total_remaining_package]);

        $past_slot_request_update=DB::table('slot_request')
        ->where('customer_id',Auth::guard('customer')->user()->id)
        ->where('slot_date','<',$remaining_session_request_now)
        ->where('approval_id',1)
        ->update(['approval_id'=>5]);
      }

      ////@end totan

      $sum_slots = DB::table('purchases_history')
      ->select('active_package','package_remaining','customer_id')
      ->where('customer_id',Auth::guard('customer')->user()->id)
      ->where('active_package',1 )
      ->where('package_validity_date','>=',$remaining_session_request_now)
      ->sum('package_remaining');

      session(['sum_slots' => $sum_slots]);
      Log::debug(" session_value ".print_r(session('sum_slots'),true));

      $count=DB::table('slot_request')->where('slot_date','<=',$remaining_session_request_now )->count();

      $future_pending_count=DB::table('purchases_history')
      ->join('slots','slots.id','purchases_history.slot_id')
      ->join('slot_request','slot_request.purchases_id','purchases_history.id')->select('slot_request.purchases_id','slots.slots_number','slots.slot_date')->where('slot_request.customer_id',Auth::guard('customer')->user()->id)->where('slot_request.slot_date','>=',$remaining_session_request_now )->where('slot_request.approval_id',1 )->count();
    

      $accepted_count= DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('slot_request','slot_request.purchases_id','purchases_history.id')->select('slot_request.purchases_id','slots.slots_number','slots.slot_date')->where('slot_request.customer_id',Auth::guard('customer')->user()->id)->where('slot_request.slot_date','>=',$remaining_session_request_now )->where('slot_request.approval_id',3 )->count();
     Log::debug(" Check id ".print_r($sum_slots,true));  

     $remaining_session_request=DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('customers','customers.id','purchases_history.customer_id')
    ->where('purchases_history.customer_id',Auth::guard('customer')->user()->id)
    ->where('purchases_history.active_package',1)
    ->where('purchases_history.package_remaining','>',0)
    ->where('purchases_history.package_validity_date','>=',$remaining_session_request_now)->count();
 


 if($request->ajax()){
return response()->json($data);
}

return view('customerpanel.booking_history',['data' => $data])->with(compact('data','dt','sum_slots','count','accepted_count','future_pending_count','remaining_session_request'));

}


public function purchases_history(Request $request)
{

$remaining_session_request_now=Carbon::now()->toDateString();
  
if(isset($request->start_date) && isset($request->end_date) && !empty($request->start_date) && !empty($request->end_date))
{
  $now = Carbon::now()->toDateString();
        $start_date=$request->start_date;
        $end_date=$request->end_date;
      // echo $start_date."-".$end_date;die();
      Log::debug(" Check ".print_r($start_date,true)); 
      Log::debug(" Check id ".print_r($end_date,true)); 
  

    $purchases_data=DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('customers','customers.id','purchases_history.customer_id')
    ->select('purchases_history.slots_name','purchases_history.slots_price','slots.slots_validity','purchases_history.slots_number','purchases_history.payment_options','purchases_history.package_validity_date','purchases_history.id','slots.slots_number','purchases_history.purchases_date','purchases_history.active_package','purchases_history.package_remaining','customers.id as customer_id')
    
    ->whereBetween('purchases_history.purchases_date', [$start_date, $end_date])
    ->where('purchases_history.customer_id',Auth::guard('customer')->user()->id)
    ->orderBy('purchases_history.active_package','DESC')
    ->paginate(10);


}
else
{
  $now = Carbon::now()->toDateString();
   $start_date=$request->start_date;
        $end_date=$request->end_date;
  $purchases_data=DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('customers','customers.id','purchases_history.customer_id')
    ->select('purchases_history.slots_name','purchases_history.slots_price','slots.slots_validity','purchases_history.slots_number','purchases_history.payment_options','purchases_history.package_validity_date','purchases_history.id','slots.slots_number','purchases_history.purchases_date','purchases_history.active_package','purchases_history.package_remaining','customers.id as customer_id')
    ->where('purchases_history.customer_id',Auth::guard('customer')->user()->id)
    ->orderBy('purchases_history.active_package','DESC')
    ->paginate(10);


    Log::debug(" Check id ".print_r($purchases_data,true));

}


  $remaining_session_request_now=Carbon::now()->toDateString();


  $remaining_session_request=DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('customers','customers.id','purchases_history.customer_id')
    ->where('purchases_history.customer_id',Auth::guard('customer')->user()->id)
    ->where('purchases_history.active_package',1)
    ->where('purchases_history.package_remaining','>',0)
    ->where('purchases_history.package_validity_date','>=',$remaining_session_request_now)->count();

  Log::debug(" remaining_session_request ".print_r($remaining_session_request,true));
  Log::debug(" Check id ".print_r($purchases_data,true));

  return view('customerpanel.purchases_history')->with(compact('purchases_data','remaining_session_request','remaining_session_request_now'));   
}


public function booking_slot($id)
{
  $customer_id=$id;

  if($customer_id!=0)
  {
    $data=DB::table('users')->whereNull('deleted_at')->where('is_active',1)->get();
    return view('customerpanel.booking_slot')->with(compact('data','customer_id'));
  }
  else
  {
    return view('customerpanel.booking_slot')->with(compact('customer_id'));
  }
}


public function booking_slot_times(Request $request)
{

  $trainer_id=$request->trainer_id;
  $slot_date=$request->slot_date;

  $get_slot_times=DB::table('slot_request')
  ->where('trainer_id',$trainer_id)
  ->where('slot_date',$slot_date)
  ->where(function($q) {
         $q->where('approval_id', 1)
           ->orWhere('approval_id', 3);
     })
  ->pluck('slot_time_id');

  Log::debug(" get_slot_times ".print_r($get_slot_times,true));
  $final_slot_time=DB::table('slot_times')->whereNotIn('id',$get_slot_times)->get()->all();
  Log::debug(" final_slot_times ".print_r($final_slot_time,true));
  return json_encode($final_slot_time);
}



public function slotinsert(Request $request)
{
  

  $total_slots=$request->total_slots;

  $customer_id=$request->idd; //customer_id

  $remaining_session_request_now=Carbon::now()->toDateString();

  for($i=0;$i<$total_slots;$i++)
  {
    $all_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining')
    ->where('customer_id',$customer_id)
    ->where('active_package',1)
    ->where('package_remaining','>',0)
    ->where('package_validity_date','>=',$remaining_session_request_now)
    ->orderBy('package_validity_date', 'ASC')
    ->first();
   
    $oldest_package_id=$all_package->id;
    $package_remaining=$all_package->package_remaining;
    
    $trainer_id=$request->trainer_id[$i];
    $slots_date=$request->slots_date[$i];
    $slots_time_id=$request->slots_time_id[$i];


    $slots_data['customer_id']=$customer_id;
    $slots_data['trainer_id']=$trainer_id;
    $slots_data['purchases_id']=$oldest_package_id;
    $slots_data['slot_date']=$slots_date;
    $slots_data['slot_time_id']=$slots_time_id;
    $slots_data['approval_id']=1;
    //$slots_data['created_at']=Carbon::now();

    Log::debug(" Check session request data1 ".print_r($slots_data,true));

    $insert_slot_session=DB::table('slot_request')->insert($slots_data);

    if($package_remaining>0)
  {
    $new_remaining_package['package_remaining']=$package_remaining-1;
    $new_remaining_package['active_package']=1;
  }
  if($package_remaining==1)
  {
    $new_remaining_package['package_remaining']=$package_remaining-1;
    $new_remaining_package['active_package']=0;
  }

  $update_package_purchase=DB::table('purchases_history')
  ->where('id',$oldest_package_id)
  ->update($new_remaining_package);

  Log::debug(" all_package ".print_r($all_package,true));


  
  $customer_details=Customer::find($customer_id);
  $trainer_details=User::find($trainer_id);

  $notifydata['url'] = '/trainer-login';
  $notifydata['customer_name']=$customer_details->name;
  $notifydata['customer_email']=$customer_details->email;
  $notifydata['customer_phone']=$customer_details->ph_no;
  $notifydata['status']='Sent Session Request To Trainer';
  $notifydata['session_booking_date']=$slots_date;
  $notifydata['trainer_name']=$trainer_details->name;

  Log::debug("Sent Session Request notification to trainer ".print_r($notifydata,true));

  $customer_details->notify(new SessionRequestNotificationToTrainer($notifydata));


}

  if($insert_slot_session && $update_package_purchase) 
  {

    $sum_slots = DB::table('purchases_history')->
    select('active_package','package_remaining','customer_id')
    ->where('customer_id',Auth::guard('customer')->user()->id)
    ->where('active_package',1)
    ->where('package_remaining','>',0)
    ->where('package_validity_date','>=',$remaining_session_request_now)
    ->sum('package_remaining');

    session(['sum_slots' => $sum_slots]);

    $customer_details=Customer::find($customer_id);

    $notifydata['url'] = '/customer/mybooking';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Sent Session Request';
    $notifydata['session_booked_on']=' ';
    $notifydata['session_booking_date']=' ';
    $notifydata['trainer_name']=' ';

    Log::debug("Sent Session Request notification ".print_r($notifydata,true));

    $customer_details->notify(new SessionRequestNotification($notifydata));

  }

  return redirect()->back()->with("success","Your session booking request is sent successfully !");
  
}

public function my_mot()
{

    $data=DB::table('customer_mot')
    ->join('customers','customers.id','customer_mot.customer_id')
    ->join('users','users.id','customer_mot.trainer_id')
    ->select('customer_mot.id as mot_id','customer_mot.customer_id as customer_id','customer_mot.trainer_id','customer_mot.date','customer_mot.left_arm','users.name as users_name','customer_mot.right_arm','customer_mot.chest','customer_mot.waist','customer_mot.hips','customer_mot.right_thigh','customer_mot.left_thigh','customer_mot.weight','customer_mot.right_calf','customer_mot.left_calf','customer_mot.starting_weight','customer_mot.ending_weight','customer_mot.heart_beat','customer_mot.blood_pressure','customer_mot.height','customer_mot.description')->where('customer_mot.customer_id',Auth::guard('customer')->user()->id)->paginate(10);

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