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
// use Illuminate\Database\Eloquent\Collection;
use App\Customer;
use App\User;
use App\Notifications\SessionRequestNotification;
use App\Notifications\SessionRequestNotificationToTrainer;
use Illuminate\Support\Facades\Input;

class FrontController extends Controller
{


public function __construct()
{
  $this->middleware('auth:customer');
}

public function session_delete($id)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_customer();

  $remaining_session_request_now=Carbon::now()->toDateString();
  $deleted_data['deleted_at']=Carbon::now();
  $deleted_data['approval_id']=2;
                 
  $slot_request_details=DB::table('slot_request')->where('id',$id)->first();

    $package_history=DB::table('purchases_history')
    ->where('customer_id',$slot_request_details->customer_id)
    ->where('purchases_history.active_package',1)
    ->where('purchases_history.package_validity_date','>=',$remaining_session_request_now)
    ->orderBy('package_validity_date','DESC')->first();

    if($package_history)
      {
        $package_history_update_data['package_remaining']=$package_history->package_remaining+1;
        $package_history_update=DB::table('purchases_history')->where('id',$package_history->id)->update($package_history_update_data);
      }

    DB::table('slot_request')->where('id',$id)->update($deleted_data);

    $customer_details=Customer::find($slot_request_details->customer_id);
    $trainer_details=User::find($slot_request_details->trainer_id);

    $session_time=DB::table('slot_times')->where('id',$slot_request_details->slot_time_id)->first();

    $notifydata['url'] = '/customer/mybooking';
    $notifydata['url1'] = '/trainer-login';

    if($notifydata['url'] == '/customer/mybooking')
    {
      $notifydata['url'] = '/customer/mybooking';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Delete Session Request To Customer';
      $notifydata['session_booked_on']=$slot_request_details->created_at;
      $notifydata['session_booking_date']=$slot_request_details->slot_date;
      $notifydata['session_booking_time']=$session_time->time;
      $notifydata['trainer_name']=$trainer_details->name;
      $notifydata['decline_reason']=' ';

      
      $customer_details->notify(new SessionRequestNotification($notifydata));
    }
    if($notifydata['url1'] == '/trainer-login')
    {
      $notifydata['url'] = '/trainer-login';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Delete Session Request To Trainer';
      $notifydata['session_booked_on']=$slot_request_details->created_at;
      $notifydata['session_booking_date']=$slot_request_details->slot_date;
      $notifydata['session_booking_time']=$session_time->time;
      $notifydata['trainer_name']=$trainer_details->name;
      $notifydata['decline_reason']=' ';

      Log::debug("Delete Session Request notification to trainer ".print_r($notifydata,true));
      $customer_details->notify(new SessionRequestNotification($notifydata));
    }

    DB::commit();
    return redirect()->back()->with("session_delete","You have successfully cancelled one session");
  }

    catch(\Exception $e) {
      DB::rollback();
      return abort(400);
  }
   
}


public function bbl()
    
{
  try{
  $this->cart_delete_customer();

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

    catch(\Exception $e) {

      return abort(400);
  }
}
     
public function about()
{    
try{   
  $this->cart_delete_customer();

  $data=DB::table('our_client')->where('deleted_at',null)->get();
  return view('customerpanel/frontabout')->with(compact('data'));

  }

    catch(\Exception $e) {

      return abort(400);
  }
}

public function details()
{  
  $this->cart_delete_customer();
  return view('customerpanel/frontdetails');
}

public function history()
{  
  $this->cart_delete_customer();
  return view('customerpanel/fronthistory');
}

public function frontlogin()
{ 
  $this->cart_delete_customer();
  return view('customerpanel/frontlogin_registration');
}


public function frontprice(Request $request)
{
  try{
  $this->cart_delete_customer();
  $data=DB::table('slots')->where('deleted_at',null)->get();

  $personal_training_product_details=DB::table('products')
  ->join('training_type','products.training_type_id','training_type.id')
  ->join('payment_type','products.payment_type_id','payment_type.id')
  ->select('products.id as product_id','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.price_session_or_month as price_session_or_month','products.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration',(DB::raw('products.validity_value * products.validity_duration  as validity')),(DB::raw('products.notice_period_value * products.notice_period_duration  as notice_period')))
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
  $this->cart_delete_customer();
  return view('customerpanel/frontservices');
}


public function purchase_form($id)
{ 
  try{
  $this->cart_delete_customer();
  $slot_id=$id;

  //Log::debug(":: slot_id :: ".print_r($slot_id,true));

  $package_details=DB::table('slots')->where('id',$slot_id)->first();
     
  $data=DB::table('customers')->where('id',Auth::guard('customer')->user()->id)->first();
  //Log::debug(":: purchase details :: ".print_r($data,true));
 
  if($data && $package_details )
  {
     return view('customerpanel.purchases')->with(compact('data','package_details'));
  }
  else
  {
     return abort(400);
  }
 
  }

    catch(\Exception $e) {

      return abort(400);
  }
}


public function purchase_payment_mode(Request $request)
{
  try{
  $this->cart_delete_customer();
  $coupon_code=$request->coupon_code;
  $coupon_id=$request->coupon_id;
  $new_package_price=$request->new_package_price;
//Log::debug(" coupon_code ".print_r($coupon_code,true));
//Log::debug(" coupon_id ".print_r($coupon_id,true));
   //Log::debug(" new_package_price ".print_r($new_package_price,true));
  $slot_details=DB::table('slots')->where('id',$request->id)->first();

if($request->new_package_price)
{
  $data["slots_name"]=$slot_details->slots_name;
  $data["slots_number"]=$slot_details->slots_number;
  $data["slots_price"]=$new_package_price;
  $data["customer_id"]=Auth::guard('customer')->user()->id;
  $data['slot_id']=$request->id;
  $data['payment_options']=$request->selector1;
  $data['purchases_date']=Carbon::now();
  $data['package_validity_date']=Carbon::now()->addDay($slot_details->slots_validity);
}
else{
  $data["slots_name"]=$slot_details->slots_name;
  $data["slots_number"]=$slot_details->slots_number;
  $data["slots_price"]=$slot_details->slots_price;
  $data["customer_id"]=Auth::guard('customer')->user()->id;
  $data['slot_id']=$request->id;
  $data['payment_options']=$request->selector1;
  $data['purchases_date']=Carbon::now();
  $data['package_validity_date']=Carbon::now()->addDay($slot_details->slots_validity);
}

  if($request->selector1=='Paypal')
  {
    return view('customerpanel.paypal-payment')->with(compact('data','coupon_code','coupon_id'));
  }
  if($request->selector1=='Bank Transfer')
  {
    return view('customerpanel.bank-payment')->with(compact('data','coupon_code','coupon_id'));
  }

  }

    catch(\Exception $e) {

      return abort(400);
  }
}


public function paypal_payment_success()
{
  $this->cart_delete_customer();
  return view('customerpanel.payment-success');
}


public function customer_profile()
{  
 try{
  $this->cart_delete_customer();
  $data=DB::table('customers')->where('id',Auth::guard('customer')->user()->id)->first();
  //Log::debug(":: customers data :: ".print_r($data,true));
  return view('customerpanel.profile')->with(compact('data'));

   }

    catch(\Exception $e) {

      return abort(400);
  }
}


public function customer_showupdateform()
{
  try{
  $this->cart_delete_customer();
  $data= DB::table('customers')->where('id',Auth::guard('customer')->user()->id)->first();
  //Log::debug(" data ".print_r($data,true));
  return view ("customerpanel.editprofile")->with(compact('data'));

   }

    catch(\Exception $e) {

      return abort(400);
  }
}

// update profile of trainer
public function updateprofile(Request $request)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_customer();
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
    DB::commit();
    return redirect()->back()->with("success","Your profile is update successfully !");


   }

    catch(\Exception $e) {
      DB::rollback();
      return abort(400);
  }
}

public function booking_history(Request $request)
{  


    try{   
  $this->cart_delete_customer();
  if(isset($request->start_date) && isset($request->end_date) && !empty($request->start_date) && !empty($request->end_date))
  {
    $start_date=$request->start_date;
    $end_date=$request->end_date;
  }
  else
  {
    $start_date=Carbon::now()->toDateString();
    $end_date=Carbon::now()->addDays(30)->toDateString();
  }

    $now = Carbon::now()->toDateString();
    $now_month = Carbon::now()->addDays(30)->toDateString();

    $all_booking=DB::table('bootcamp_booking')
    ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
    ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
    ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
    ->where('bootcamp_booking.customer_id',Auth::guard('customer')->user()->id);

    if($request->option=='past_booking')
    {
      $all_booking=$all_booking->where('bootcamp_plan_shedules.plan_date','<',$now )->whereBetween('bootcamp_plan_shedules.plan_date', [$start_date, $end_date])->whereNull('bootcamp_booking.deleted_at');
    }
    elseif($request->option=='cancelled_booking')
    {
      $all_booking=$all_booking->whereNotNull('bootcamp_booking.deleted_at')->whereBetween('bootcamp_plan_shedules.plan_date', [$start_date, $end_date]);
    }
    else
    {
      $all_booking=$all_booking->whereNull('bootcamp_booking.deleted_at')->whereBetween('bootcamp_plan_shedules.plan_date', [$start_date, $end_date])->where('bootcamp_plan_shedules.plan_date','>=',$now);
    }
    
    $all_booking=$all_booking->orderby('bootcamp_booking.id','DESC')->paginate(10);


  
  $no_of_session_unlimited=DB::table('order_details')
  ->join('products','products.id','order_details.product_id')
  ->join('training_type','training_type.id','products.training_type_id')
  ->where('order_details.customer_id',Auth::guard('customer')->user()->id)
  ->where('order_details.status',1)
  ->where('training_type.id',2)
  ->where('order_details.order_validity_date','>=',$now)
  ->where('order_details.remaining_sessions','Unlimited')
  ->get()->all();

  if(count($no_of_session_unlimited)>0)
  {
    $no_of_sessions='Unlimited';
  }
  else
  {
    $no_of_sessions=0;
  $no_of_session_notunlimited=DB::table('order_details')
  ->join('products','products.id','order_details.product_id')
  ->join('training_type','training_type.id','products.training_type_id')
  ->where('order_details.customer_id',Auth::guard('customer')->user()->id)
  ->where('order_details.status',1)
  ->where('training_type.id',2)
  ->where('order_details.order_validity_date','>=',$now)
  ->where('order_details.remaining_sessions','!=','Unlimited')
  ->get()->all();

    foreach($no_of_session_notunlimited as $total)
    {
      $no_of_sessions=$no_of_sessions+$total->remaining_sessions;
    }
  }

  $total_future_booking=DB::table('bootcamp_booking')
    ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
    ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
    ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
    ->where('bootcamp_booking.customer_id',Auth::guard('customer')->user()->id)
    ->whereNull('bootcamp_booking.deleted_at')->where('bootcamp_plan_shedules.plan_date','>=',$now)->count();
    $total_cancelled_booking=DB::table('bootcamp_booking')
    ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
    ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
    ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
    ->where('bootcamp_booking.customer_id',Auth::guard('customer')->user()->id)
    ->whereNotNull('bootcamp_booking.deleted_at')->count();

    $total_past_booking=DB::table('bootcamp_booking')
    ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
    ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
    ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
    ->where('bootcamp_booking.customer_id',Auth::guard('customer')->user()->id)
    ->whereNull('bootcamp_booking.deleted_at')->where('bootcamp_plan_shedules.plan_date','<',$now)->count();
  
    return view('customerpanel.booking_history')->with(compact('all_booking','no_of_sessions','total_future_booking','total_cancelled_booking','total_past_booking'));

     }

    catch(\Exception $e) {
// Log::debug(" Check id ".print_r($e->getMessage(),true));  
      return abort(400);
  }
}


public function purchases_history(Request $request)
{

  try{
  $this->cart_delete_customer();
  $remaining_session_request_now=Carbon::now()->toDateString();
  
  if(isset($request->start_date) && isset($request->end_date) && !empty($request->start_date) && !empty($request->end_date))
  {
    $now = Carbon::now()->toDateString();
    $start_date=$request->start_date;
    $end_date=$request->end_date;
    // echo $start_date."-".$end_date;die();
    //Log::debug(" Check ".print_r($start_date,true)); 
    //Log::debug(" Check id ".print_r($end_date,true)); 
  
    $purchases_data=DB::table('purchases_history')
    ->join('slots','slots.id','purchases_history.slot_id')
    ->join('customers','customers.id','purchases_history.customer_id')
    ->select('purchases_history.slots_name','purchases_history.slots_price','slots.slots_validity','slots.slots_price as price','purchases_history.slots_number','purchases_history.payment_options','purchases_history.package_validity_date','purchases_history.id','slots.slots_number','purchases_history.purchases_date','purchases_history.active_package','purchases_history.package_remaining','purchases_history.extra_package_remaining','customers.id as customer_id','purchases_history.payment_options as payment_options')  
    ->whereBetween('purchases_history.purchases_date', [$start_date, $end_date])
    ->where('purchases_history.customer_id',Auth::guard('customer')->user()->id)
    ->orderBy('purchases_history.active_package','DESC')
    ->orderby('purchases_history.id','DESC')
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
    ->select('purchases_history.slots_name','purchases_history.slots_price','slots.slots_validity','slots.slots_price as price','purchases_history.slots_number','purchases_history.payment_options','purchases_history.package_validity_date','purchases_history.id','slots.slots_number','purchases_history.purchases_date','purchases_history.active_package','purchases_history.extra_package_remaining','purchases_history.package_remaining','customers.id as customer_id','purchases_history.payment_options as payment_options')
    ->where('purchases_history.customer_id',Auth::guard('customer')->user()->id)
    ->orderBy('purchases_history.active_package','DESC')
    ->orderby('purchases_history.id','DESC')
    ->paginate(10);

    Log::debug(" Check id ".print_r($purchases_data,true));
  }

  $remaining_session_request_now=Carbon::now()->toDateString();
  

  return view('customerpanel.purchases_history')->with(compact('purchases_data','remaining_session_request_now'));   

     }

    catch(\Exception $e) {

      return abort(400);
  }
}


public function booking_slot()
{
  try{
  $this->cart_delete_customer();
  $remaining_session_request_now=Carbon::now()->toDateString();
  
  $data=DB::table('users')->whereNull('deleted_at')->where('is_active',1)->get();
  $all_times=DB::table('slot_times')->get()->all();

  $sum_slots = DB::table('purchases_history')
  ->select('active_package','package_remaining','customer_id')
  ->where('customer_id',Auth::guard('customer')->user()->id)
  ->where('active_package',1 )
  ->where('package_remaining','>=',0)
  ->where('package_validity_date','>=',$remaining_session_request_now)
  ->sum('package_remaining');

  $sum_extra_slots = DB::table('purchases_history')
  ->select('active_package','package_remaining','extra_package_remaining','customer_id')
  ->where('customer_id',Auth::guard('customer')->user()->id)
  ->where('active_package',1)
  ->where('extra_package_remaining','>=',0)
  ->sum('extra_package_remaining');

  $total_remaining_slots=$sum_slots+$sum_extra_slots;

  return view('customerpanel.booking_slot')->with(compact('data','total_remaining_slots','all_times'));

  }

    catch(\Exception $e) {

      return abort(400);
  }
 
}


public function get_slot_time(Request $request)
{

  
  $this->cart_delete_customer();

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

  if(count($get_slot_times))
{
foreach($get_slot_times as $key=>$hour) {

}

  $length=$key+1;
  $upto=$length*4;

  for($i=$length;$i<$upto;$i++)
{
  $get_slot_times[$i]=$get_slot_times[$i-$length]+1;

}

foreach($get_slot_times as $key=>$hour) {

}

$length=$key+1;
$upto=$length*4;

  for($i=$length;$i<$upto;$i++)
{
  $get_slot_times[$i]=$get_slot_times[$i-$length]-1;

}

}

$final_slot_time=DB::table('slot_times')->whereNotIn('id',$get_slot_times)
  ->get()->all();


  foreach($final_slot_time as $myslot_time)
  {
    $myslot_time->time=date('h:i A', strtotime($myslot_time->time));
  }

    return json_encode($final_slot_time);
  
  
 
}



public function get_current_slot_time(Request $request)
{

  $this->cart_delete_customer();

  $trainer_id=$request->trainer_id;
  $slot_date=$request->slot_date;

  //Log::debug(" Check get_slot_times ".print_r($request->all(),true));
  
  $get_slot_times=DB::table('slot_request')
  ->where('trainer_id',$trainer_id)
  ->where('slot_date',$slot_date)
  ->where(function($q) {
         $q->where('approval_id', 1)
           ->orWhere('approval_id', 3);
     })
  ->pluck('slot_time_id')->all();

  $get_slot_times2=DB::table('slot_times')
  ->wherein('id',$request->time_id)
  ->pluck('id')->all();

  $get_slot_times=array_merge($get_slot_times,$get_slot_times2);



  if(count($get_slot_times))
{
foreach($get_slot_times as $key=>$hour) {

}

  $length=$key+1;
  $upto=$length*4;

  for($i=$length;$i<$upto;$i++)
{
  $get_slot_times[$i]=$get_slot_times[$i-$length]+1;

}

foreach($get_slot_times as $key=>$hour) {

}

$length=$key+1;
$upto=$length*4;

  for($i=$length;$i<$upto;$i++)
{
  $get_slot_times[$i]=$get_slot_times[$i-$length]-1;

}

}


$final_slot_time=DB::table('slot_times')->whereNotIn('id',$get_slot_times)
  ->get()->all();



  foreach($final_slot_time as $myslot_time)
  {
    $myslot_time->time=date('h:i A', strtotime($myslot_time->time));
  }
  
  return json_encode($final_slot_time);
}

public function get_slot_trainer(Request $request)
{

  

  $slot_time=$request->slot_time;
  $slot_date=$request->slot_date;

  $get_slot_trainer=DB::table('slot_request')
  ->where('slot_time_id',$slot_time)
  ->where('slot_date',$slot_date)
  ->where(function($q) {
         $q->where('approval_id', 1)
           ->orWhere('approval_id', 3);
     })
  ->pluck('trainer_id');

  $old_slot_time_id=DB::table('slot_request')
  ->where('slot_date',$slot_date)
  ->where(function($q) {
         $q->where('approval_id', 1)
           ->orWhere('approval_id', 3);
     })
  ->pluck('slot_time_id')->toArray();

  $cart_slot_time_id=DB::table('cart_slot_request')
  ->where('slot_date',$slot_date)
  ->where(function($q) {
         $q->where('approval_id', 1)
           ->orWhere('approval_id', 3);
     })
  ->pluck('slot_time_id')->toArray();

  if($cart_slot_time_id)
  {
    $old_slot_time_id=array_merge($old_slot_time_id,$cart_slot_time_id);
  }

  //Log::debug(" old_slot_time_id ".print_r(count($old_slot_time_id),true));

  $old_trainer_id=DB::table('slot_request')
  ->where('slot_date',$slot_date)
  ->where(function($q) {
         $q->where('approval_id', 1)
           ->orWhere('approval_id', 3);
     })
  ->pluck('trainer_id')->toArray();

  $cart_trainer_id=DB::table('cart_slot_request')
  ->where('slot_date',$slot_date)
  ->where(function($q) {
         $q->where('approval_id', 1)
           ->orWhere('approval_id', 3);
     })
  ->pluck('trainer_id')->toArray();

  if($cart_trainer_id)
  {
    $old_trainer_id=array_merge($old_trainer_id,$cart_trainer_id);
  }

  
  $length=count($old_slot_time_id);
  $upto=$length*4;

  for($i=$length;$i<$upto;$i++)
  {
    $old_slot_time_id[$i]=$old_slot_time_id[$i-$length]+1;
  }

  $choose_slot_times=array();
  $choose_slot_times[0]=$slot_time;
  $slot_date=array();
  $slot_date[0]=$slot_date;

  $length=1;
  $upto=$length*4;

  for($i=$length;$i<$upto;$i++)
  {
    $choose_slot_times[$i]=$choose_slot_times[$i-$length]+1;
  }


  if(array_intersect($old_slot_time_id, $choose_slot_times))
  {
    //Log::debug("equal");
    
    $final_slot_trainer=DB::table('users')->whereNull('deleted_at')->where('is_active', 1)->whereNotIn('id',$old_trainer_id)->get();
  }
 else
  {
    //Log::debug(" not equal");
    $final_slot_trainer=DB::table('users')->whereNull('deleted_at')->where('is_active', 1)->whereNotIn('id',$get_slot_trainer)->get();
  }

  
  return json_encode($final_slot_trainer);
}


public function slot_insert_to_cart(Request $request)
{
  $cart_data['trainer_id']=$request->trainer_id;
  $cart_data['slot_date']=$request->slot_date;
  $cart_data['slot_time_id']=$request->slots_time_id;
  $cart_data['approval_id']=1;
  $cart_data['request_customer_id']=Auth::guard('customer')->user()->id;

  $insert_cart=DB::table('cart_slot_request')->insert($cart_data);

  $id = DB::getPdo()->lastInsertId();

   return json_encode($id);

}

public function cart_data_delete(Request $request)
{
  Log::debug("cart data delete");

  $total_slots=$request->total_slots;
  for($i=0;$i<$total_slots;$i++)
  {

     $trainer_id=$request->trainer_id[$i];
    $slots_date=$request->slots_date[$i];
    $slots_time_id=$request->slots_time_id[$i];

    $delete_from_cart=DB::table('cart_slot_request')
    ->where('trainer_id',$trainer_id)
    ->where('slot_date',$slots_date)
    ->where('slot_time_id',$slots_time_id)
    ->delete();

    return json_encode($delete_from_cart);

  }

}

public function slotinsert(Request $request)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_customer();

  $total_slots=$request->total_slots;
  $customer_id=$request->idd; //customer_id
  $remaining_session_request_now=Carbon::now()->toDateString(); // current date


  $nd_btn=$request->nd_btn;


  for($i=0;$i<$total_slots;$i++)
  {
    $all_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining')
    ->where('customer_id',$customer_id)
    ->where('active_package',1)
    ->where('package_remaining','>',0)
    ->where('package_validity_date','>',$remaining_session_request_now)
    ->orderBy('package_validity_date', 'ASC')
    ->first();

    $extra_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining','extra_package_remaining')
    ->where('customer_id',$customer_id)
    ->where('extra_package_remaining','>',0)
    ->where('active_package',1)
    // ->orderBy('package_validity_date', 'DESC')
    ->first();

    $trainer_id=$request->trainer_id[$i];
    $slots_date=$request->slots_date[$i];
    $slots_time_id=$request->slots_time_id[$i];

    $slot_time=DB::table('slot_times')->where('id',$slots_time_id)->first();


    if($slots_time_id>=21 && $slots_time_id<=93)
    {
      $slots_data['approval_id']=3;
    }
    else
    {
      $slots_data['approval_id']=1;
    }

    if($extra_package)
    {

      $oldest_package_id=$extra_package->id;
      $package_remaining=$extra_package->extra_package_remaining;

      $slots_data['customer_id']=$customer_id;
      $slots_data['trainer_id']=$trainer_id;
      $slots_data['purchases_id']=$oldest_package_id;
      $slots_data['slot_date']=$slots_date;
      $slots_data['slot_time_id']=$slots_time_id;
     

      $new_remaining_package['extra_package_remaining']=$package_remaining-1;
      
      $insert_slot_session=DB::table('slot_request')->insert($slots_data);

      $update_package_purchase=DB::table('purchases_history')
      ->where('id',$oldest_package_id)
      ->update($new_remaining_package);
      

      $customer_details=Customer::find($customer_id);
      $trainer_details=User::find($trainer_id);

      $notifydata['url'] = '/trainer-login';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Sent Session Request To Trainer';
      $notifydata['session_booking_date']=$slots_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;

  

      $trainer_details->notify(new SessionRequestNotificationToTrainer($notifydata));
    }
    elseif($all_package)
    {
   
      $oldest_package_id=$all_package->id;
      $package_remaining=$all_package->package_remaining;
    

      $slots_data['customer_id']=$customer_id;
      $slots_data['trainer_id']=$trainer_id;
      $slots_data['purchases_id']=$oldest_package_id;
      $slots_data['slot_date']=$slots_date;
      $slots_data['slot_time_id']=$slots_time_id;
      

      $insert_slot_session=DB::table('slot_request')->insert($slots_data);

      $new_remaining_package['package_remaining']=$package_remaining-1;


      $update_package_purchase=DB::table('purchases_history')
      ->where('id',$oldest_package_id)
      ->update($new_remaining_package);

      

      $customer_details=Customer::find($customer_id);
      $trainer_details=User::find($trainer_id);

      $notifydata['url'] = '/trainer-login';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Sent Session Request To Trainer';
      $notifydata['session_booking_date']=$slots_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;

      

      $trainer_details->notify(new SessionRequestNotificationToTrainer($notifydata));
    }
    else
    {
      $insert_slot_session=0;
    }

  }

  if($insert_slot_session && $update_package_purchase) 
  {

    $sum_slots = DB::table('purchases_history')->
    select('active_package','package_remaining','customer_id')
    ->where('customer_id',Auth::guard('customer')->user()->id)
    ->where('active_package',1)
    ->where('package_remaining','>=',0)
    ->where('package_validity_date','>=',$remaining_session_request_now)
    ->sum('package_remaining');

    $sum_extra_slots = DB::table('purchases_history')
    ->select('active_package','package_remaining','extra_package_remaining','customer_id')
    ->where('customer_id',Auth::guard('customer')->user()->id)
    ->where('extra_package_remaining','>=',0)
    ->where('active_package',1)
    ->sum('extra_package_remaining');

    $total_remaining_session=$sum_slots+$sum_extra_slots;

    session(['sum_slots' => $total_remaining_session]);

    $customer_details=Customer::find($customer_id);

    $notifydata['url'] = '/customer/mybooking';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Sent Session Request';
    $notifydata['session_booked_on']=' ';
    $notifydata['session_booking_date']=' ';
    $notifydata['session_booking_time']=' ';
    $notifydata['trainer_name']=' ';
    $notifydata['decline_reason']=' ';

    $trainer_name = Input::get('trainer_name');
    $slots_date = Input::get('slots_date');
    $slots_time = Input::get('slots_time');
    $total_slots = Input::get('total_slots');

    $a=new \stdClass;

    $a->trainer_name=$trainer_name;
    $a->slots_date=$slots_date;
    $a->slots_time=$slots_time;
    $a->total_slots=$total_slots;
    $all_data=array($a);
    

    $customer_details->notify(new SessionRequestNotification($notifydata));

    DB::commit();

      if($nd_btn==1)
      {
      return redirect()->route('booking_slot')->with(["success"=>"You have successfully sent the bellow PT session request(s)!",'all_data'=>$all_data]);
    }
    else
    {
      return redirect()->route('booking_slot')->with(["success1"=>"You have successfully sent the bellow PT session request(s)!",'all_data'=>$all_data]);
    }
    
  }

  else
  {
    DB::commit();
    return redirect()->route('booking_slot')->with("success","You don't have any available session!");
  }


  }

    catch(\Exception $e) {
      DB::rollback();

      return abort(400);
  }  
}

public function my_mot()
{

  try{
  $this->cart_delete_customer();
    $data=DB::table('customer_mot')
    ->join('customers','customers.id','customer_mot.customer_id')
    ->join('users','users.id','customer_mot.trainer_id')
    ->select('customer_mot.id as mot_id','customer_mot.customer_id as customer_id','customer_mot.trainer_id','customer_mot.date','customer_mot.left_arm','users.name as users_name','customer_mot.right_arm','customer_mot.chest','customer_mot.waist','customer_mot.hips','customer_mot.right_thigh','customer_mot.left_thigh','customer_mot.weight','customer_mot.right_calf','customer_mot.left_calf','customer_mot.starting_weight','customer_mot.ending_weight','customer_mot.heart_beat','customer_mot.blood_pressure','customer_mot.height','customer_mot.description')->where('customer_mot.customer_id',Auth::guard('customer')->user()->id)->whereNull('customer_mot.deleted_at')->paginate(10);

  return view('customerpanel.my_mot')->with(compact('data'));

   }

    catch(\Exception $e) {
      return abort(400);
  }  

}



public function customer_contact()
{  
  $this->cart_delete_customer();
  return view('customerpanel/frontcontact');
}


public function front_contact_insert(Request $request)
{  
   $this->cart_delete_customer();

  DB::beginTransaction();

    try{
 

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

public function cust_testimonial(Request $request)
{
  $this->cart_delete_customer();
try{
  $data=DB::table('testimonial')->where('deleted_at',null)->get();
  return view('customerpanel.cust_testimonial')->with(compact('data'));

   }

    catch(\Exception $e) {
      return abort(400);
  }  
}

public function exercise()
{  
  $this->cart_delete_customer();
  try{
  $data=DB::table('exercise_details')->where('deleted_at',null)->get();
  return view('customerpanel.front_gym')->with(compact('data'));
  }

    catch(\Exception $e) {
      return abort(400);
  } 
}

public function bootcamp_plan_purchase($id)
{

  try{
  $this->cart_delete_customer();

  $plan_id=\Crypt::decrypt($id);

  //Log::debug(":: slot_id :: ".print_r($slot_id,true));

  $package_details=DB::table('products')
  ->join('training_type','training_type.id','products.training_type_id')
  ->join('payment_type','payment_type.id','products.payment_type_id')
  ->select('training_type.training_name as product_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.id as product_id','products.id as product_id',(DB::raw('products.validity_value * products.validity_duration  as validity')),'products.total_price as total_price')
  ->where('products.id',$plan_id)->first();
  
    return view('customerpanel.bootcamp_product_purchase')->with(compact('package_details'));
  }

    catch(\Exception $e) {
      return abort(400);
  }

}


public function bootcamp_purchase_payment_mode(Request $request)
{
  

  try{
  $this->cart_delete_customer();

  $package_details=DB::table('products')
  ->join('training_type','training_type.id','products.training_type_id')
  ->join('payment_type','payment_type.id','products.payment_type_id')
  ->select('training_type.training_name as product_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.id as product_id','products.id as product_id',(DB::raw('products.validity_value * products.validity_duration  as validity')),'products.total_price as total_price')
  ->where('products.id',$request->product_id)->first();


  //Log::debug(":: package_details :: ".print_r($package_details,true));

  if($request->selector1=='Online')
  {
    return view('customerpanel.bootcamp_online_payment')->with(compact('package_details'));
  }
  if($request->selector1=='Bank Transfer')
  {
    return view('customerpanel.bootcamp_bank_payment')->with(compact('package_details'));
  }

  }

    catch(\Exception $e) {

      return abort(400);
  }
}

public function bootcamp_onlinepayment(Request $request)
{
 // Log::debug(":: bootcamp_onlinepayment :: ".print_r($request->all(),true));
  
DB::beginTransaction();
   try{
  $package_details=DB::table('products')
  ->join('training_type','training_type.id','products.training_type_id')
  ->join('payment_type','payment_type.id','products.payment_type_id')
  ->select('training_type.training_name as product_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.id as product_id','products.id as product_id',(DB::raw('products.validity_value * products.validity_duration  as validity')),'products.total_price as total_price','products.price_session_or_month as price_session_or_month','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration')
  ->where('products.id',$request->product_id)->first();

  $payment_history_data['payment_id']='BCPAY'.time();
  $payment_history_data['currency']='GBP';
  $payment_history_data['amount']=$package_details->total_price;
  $payment_history_data['payment_mode']='Online Payment';
  $payment_history_data['status']='Success';

  $payment_history=DB::table('payment_history')->insert($payment_history_data);

  $order_data['payment_id']=DB::getPdo()->lastInsertId();
  $order_data['customer_id']=Auth::guard('customer')->user()->id;
  $order_data['product_id']=$request->product_id;
  $order_data['training_type']=$package_details->product_name;
  $order_data['payment_type']=$package_details->payment_type_name;
  $order_data['order_purchase_date']=Carbon::now()->toDateString();

  if($package_details->validity!='')
  {
    $order_data['order_validity_date']=Carbon::now()->addDay($package_details->validity);
  }
  else{
    $order_data['order_validity_date']='2099-12-30';
  }
  
  $order_data['payment_option']='Online Payment';
  $order_data['status']=1;
  $order_data['no_of_sessions']=$package_details->total_sessions;
  $order_data['remaining_sessions']=$package_details->total_sessions;
  $order_data['price_session_or_month']=$package_details->price_session_or_month;
  $order_data['total_price']=$package_details->total_price;
  $order_data['validity_value']=$package_details->validity_value;
  $order_data['validity_duration']=$package_details->validity_duration;
  $order_data['contract']=$package_details->contract;
  $order_data['notice_period_value']=$package_details->notice_period_value;
  $order_data['notice_period_duration']=$package_details->notice_period_duration;

  $order_history=DB::table('order_details')->insert($order_data);

  \Session::put('success_bootcamp_online', 'Payment success');
  \Session::put('payment_id', $payment_history_data['payment_id']);

  DB::commit();
    return redirect('customer/bootcamponlinepaymentsuccess');
   }
   catch(\Exception $e) {
     DB::rollback();
       return abort(400);
   }

}

public function bootcamponlinepaymentsuccess()
{
  $this->cart_delete_customer();
  return view('customerpanel.payment-success');
}




public function booking_bootcamp()
{
  try{
  $this->cart_delete_customer();
  $current_date=Carbon::now()->toDateString();

  $bootcampaddress=DB::table('bootcamp_plan_address')
  ->join('bootcamp_plans','bootcamp_plans.address_id','bootcamp_plan_address.id')
  ->select('bootcamp_plan_address.address_line1','bootcamp_plan_address.id','bootcamp_plans.address_id')
  ->whereNull('bootcamp_plans.deleted_at')->distinct('bootcamp_plans.address_id')->get();

  $order_details=DB::table('order_details')
  ->join('products','products.id','order_details.product_id')
  ->join('training_type','training_type.id','products.training_type_id')
  ->where('order_details.customer_id',Auth::guard('customer')->user()->id)
  ->where('order_details.status',1)
  ->where('training_type.id',2)
  ->where('order_details.order_validity_date','>=',$current_date)
  ->get()->all();

  if(count($order_details)>0)
  {
    $order_details=count($order_details);
  }
  else
  {
    $order_details=0;
  }

  $no_of_session_unlimited=DB::table('order_details')
  ->join('products','products.id','order_details.product_id')
  ->join('training_type','training_type.id','products.training_type_id')
  ->where('order_details.customer_id',Auth::guard('customer')->user()->id)
  ->where('order_details.status',1)
  ->where('training_type.id',2)
  ->where('order_details.order_validity_date','>=',$current_date)
  ->where('order_details.remaining_sessions','Unlimited')
  ->get()->all();

  if(count($no_of_session_unlimited)>0)
  {
    $no_of_sessions='Unlimited';

    return view('customerpanel.booking_bootcamp')->with(compact('bootcampaddress','order_details','no_of_sessions'));
  }
  else
  {
    $no_of_sessions=0;

  $no_of_session_notunlimited=DB::table('order_details')
  ->join('products','products.id','order_details.product_id')
  ->join('training_type','training_type.id','products.training_type_id')
  ->where('order_details.customer_id',Auth::guard('customer')->user()->id)
  ->where('order_details.status',1)
  ->where('training_type.id',2)
  ->where('order_details.order_validity_date','>=',$current_date)
  ->where('order_details.remaining_sessions','!=','Unlimited')
  ->get()->all();

    foreach($no_of_session_notunlimited as $total)
    {
      $no_of_sessions=$no_of_sessions+$total->remaining_sessions;
    }

    return view('customerpanel.booking_bootcamp')->with(compact('bootcampaddress','order_details','no_of_sessions'));
  }

  //Log::debug(" data couponcode ".print_r(count($order_details),true));
  }

    catch(\Exception $e) {

      return abort(400);
  }
 
}

public function get_bootcamp_date(Request $request)
{


  $current_date=Carbon::now()->toDateString();

  $customer_product_validity=DB::table('order_details')
  ->join('payment_history','payment_history.id','order_details.payment_id')
  ->where('payment_history.status','Success')
  ->where('order_details.order_validity_date','>=',$current_date)
  ->where('order_details.status',1)
  ->where('order_details.customer_id',Auth::guard('customer')->user()->id)
  ->max('order_details.order_validity_date');

// Log::debug(" get_bootcamp_date_time ".print_r($customer_product_validity,true));

  $alredy_booked_shedule_id=DB::table('bootcamp_booking')
  ->where('customer_id',Auth::guard('customer')->user()->id)
  ->whereNull('deleted_at')
  ->pluck('bootcamp_plan_shedules_id');

  $alredy_booked_date=DB::table('bootcamp_plan_shedules')
  ->whereIn('id',$alredy_booked_shedule_id)
  ->orwhereColumn('max_allowed','no_of_uses')
  ->pluck('plan_date');

  $date_details=DB::table('bootcamp_plan_shedules')
  ->where('address_id',$request->address_id)
  ->where('plan_date','<=',$customer_product_validity)
  ->whereNull('deleted_at')
  ->whereNotIn('plan_date',$alredy_booked_date)
  ->get()->all();

 //Log::debug(" get_bootcamp_date ".print_r($date_details,true));

  return json_encode($date_details);
}

public function get_bootcamp_time(Request $request)
{

  $time_details=DB::table('bootcamp_plan_shedules')
  ->where('plan_date',$request->bootcamp_date)
  ->get()->all();

  foreach($time_details as $key=>$each_time)
  {
    $each_time->all_time=date('h:i A', strtotime($each_time->plan_st_time))." to ".date('h:i A', strtotime($each_time->plan_end_time));
  }

  return json_encode($time_details);
}


public function bootcamp_booking_customer(Request $request)
{

  //Log::debug(" bootcamp_booking_customer ".print_r($request->all(),true));
DB::beginTransaction();
  try
  {

  $current_date=Carbon::now()->toDateString();

   $no_of_session_unlimited=DB::table('order_details')
  ->join('products','products.id','order_details.product_id')
  ->join('training_type','training_type.id','products.training_type_id')
  ->select('order_details.id as order_id','order_details.remaining_sessions as remaining_sessions')
  ->where('order_details.customer_id',Auth::guard('customer')->user()->id)
  ->where('order_details.status',1)
  ->where('training_type.id',2)
  ->where('order_details.order_validity_date','>=',$current_date)
  ->where('order_details.remaining_sessions','Unlimited')
  ->orderBy('order_details.order_validity_date', 'ASC')->first();

  $no_of_session_notunlimited=DB::table('order_details')
  ->join('products','products.id','order_details.product_id')
  ->join('training_type','training_type.id','products.training_type_id')
  ->select('order_details.id as order_id','order_details.remaining_sessions as remaining_sessions')
  ->where('order_details.customer_id',Auth::guard('customer')->user()->id)
  ->where('order_details.status',1)
  ->where('training_type.id',2)
  ->where('order_details.order_validity_date','>=',$current_date)
  ->where('order_details.remaining_sessions','>',0)
  ->orderBy('order_details.order_validity_date', 'ASC')->first();




    for($j=0;$j<count($request->bootcamp_date);$j++)
    {
      $bootcamp_booking_data['bootcamp_plan_shedules_id']=$request->schedule_id[$j];
      $bootcamp_booking_data['customer_id']=Auth::guard('customer')->user()->id;
      $bootcamp_booking_insert=DB::table('bootcamp_booking')->insert($bootcamp_booking_data);
      $shedule_id[$j]=$request->schedule_id[$j];

      if(empty($no_of_session_unlimited))
      { 
        $decrease_remaining_session=DB::table('order_details')->where('id',$no_of_session_notunlimited->order_id)->decrement('remaining_sessions',1);
      }
    }

    $bootcamp_plan_shedules_update=DB::table('bootcamp_plan_shedules')
    ->wherein('id',$shedule_id)->increment('no_of_uses', 1);

    $a=new \stdClass;

    $a->bootcamp_address=Input::get('bootcamp_address');
    $a->bootcamp_date=Input::get('bootcamp_date');
    $a->bootcamp_time=Input::get('bootcamp_time');
    $a->total_sessions=$j;
    $all_data=array($a);

    DB::commit();

    return redirect()->back()->with(["success"=>"You have successfully sent the bellow Bootcamp session request(s)!",'all_data'=>$all_data]);
  }
   catch(\Exception $e) {
     DB::rollback();
       return abort(400);
   }

}

public function cart_delete_customer()
{
  $cart_delete=DB::table('cart_slot_request')->where('request_customer_id',Auth::guard('customer')->user()->id)->delete();
}

function couponchecking(Request $request)
  {
    $now = Carbon::now()->toDateString();
    Log::debug(" data couponchecking ".print_r($request->all(),true));
    $couponcode=$request->coupon_code;
    $package_id=$request->package_id;
    $package_price=$request->package_price;
    $couponcode=preg_replace('/\s+/', ' ', $couponcode);
     //Log::debug(" data couponcode ".print_r($couponcode,true));

    $newprice=DB::table('slots_discount_coupon')->where('coupon_code',$couponcode)->where('slots_id',$package_id)->where('is_active',1)->whereNull('slots_discount_coupon.deleted_at')->where('slots_discount_coupon.valid_to','>=',$now)->value('discount_price');
    $coupon_id=DB::table('slots_discount_coupon')->where('coupon_code',$couponcode)->where('slots_id',$package_id)->where('is_active',1)->whereNull('slots_discount_coupon.deleted_at')->value('slots_discount_coupon.id');
     $ex_coupon_code=DB::table('slots_discount_coupon')->where('coupon_code',$couponcode)->where('slots_id',$package_id)->where('is_active',0)->whereNull('slots_discount_coupon.deleted_at')->value('slots_discount_coupon.coupon_code');
//Log::debug(" data startDate ".print_r($newprice,true));
//Log::debug(" data ex_coupon_code ".print_r($ex_coupon_code,true));
  $new_package_price= $package_price-$newprice;
$coupon_expair=DB::table('slots_discount_coupon')->where('coupon_code',$couponcode)->where('slots_id',$package_id)->where('is_active',1)->whereNull('slots_discount_coupon.deleted_at')->where('slots_discount_coupon.valid_to','<=',$now)->value('slots_discount_coupon.coupon_code');

$wrong_details=DB::table('slots_discount_coupon')->where('coupon_code',$couponcode)->where('slots_id',$package_id)->whereNull('slots_discount_coupon.deleted_at')->count();
// $wrong=$wrong_details==0
//Log::debug(" data wrong_details ".print_r($wrong_details,true));
    if($newprice)
    {
      
      return response()->json(['new_package_price'=>$new_package_price, 'coupon_id'=>$coupon_id,'ex_coupon_code'=>$ex_coupon_code, 'coupon_expair'=>$coupon_expair,'now'=>$now, 'wrong_details'=>$wrong_details]);
    }
    else if($ex_coupon_code)
    {
      
      return response()->json(['ex_coupon_code'=>$ex_coupon_code]);
    }
     else if($coupon_expair)
    {
      
      return response()->json(['coupon_expair'=>$coupon_expair]);
    }
     else if($wrong_details<1)
    {
      
      return response()->json(['wrong_details'=>$wrong_details]);
    }
    else
    {
       return response()->json(0);
    }
  }


  public function validcoupon(Request $request)
  {
     $now = Carbon::now()->toDateString();
    $validcoupon=$request->coupon_code;
    $package_id=$request->package_id;
    $validcoupon=preg_replace('/\s+/', ' ', $validcoupon);
    // Log::debug(" data validcoupon ".print_r($validcoupon,true));
    // $duplicatecoupon_details=DB::table('slots_discount_coupon')->where('coupon_code',$duplicatecoupon)->where('slots_id',$package_id)->whereNull('slots_discount_coupon.deleted_at')->count();

     $coupon_code=DB::table('slots_discount_coupon')->where('coupon_code',$validcoupon)->where('slots_id',$package_id)->where('is_active',1)->whereNull('slots_discount_coupon.deleted_at')->get()->count();
     $ex_coupon_code=DB::table('slots_discount_coupon')->where('coupon_code',$validcoupon)->where('slots_id',$package_id)->where('is_active',0)->whereNull('slots_discount_coupon.deleted_at')->value('slots_discount_coupon.coupon_code');
     // $coupon_expair=DB::table('slots_discount_coupon')->where('coupon_code',$validcoupon)->where('slots_id',$package_id)->where('is_active',1)->whereNull('slots_discount_coupon.deleted_at')->where('slots_discount_coupon.valid_to','<',$now)->get();

//Log::debug(" data coupon_code ".print_r($coupon_code,true));
//Log::debug(" data ex_coupon_code ".print_r($ex_coupon_code,true));
 // Log::debug(" data coupon_expair ".print_r($coupon_expair,true));

    if($coupon_code == 1)
    {
      return 2;
    }
   else if($ex_coupon_code)
    {
      return 3;
    }    
    else
    {
      return 1;
    }
   
  }


  public function common_diet_plan_purchase(Request $request)
  {
    try{
    //Log::debug(" data coupon_code ".print_r($request->all(),true));
    $common_diet_plan=DB::table('common_diet_plan')->where('id',$request->common_diet_plan_id)->first();
    return view('customerpanel.common_diet_plan_purchase')->with(compact('common_diet_plan'));
    }
    catch(\Exception $e) {
      return abort(400);
    }
  }

  public function common_diet_plan_paymentsuccess()
  {
    $this->cart_delete_customer();
    return view('customerpanel.common_diet_plan_payment_success');
  }

public function common_diet_plan_history(Request $request)
{
  try{
 $this->cart_delete_customer();
 
  
  if(isset($request->start_date) && isset($request->end_date) && !empty($request->start_date) && !empty($request->end_date))
  {
    $now = Carbon::now()->toDateString();
    $start_date=$request->start_date;
    $end_date=$request->end_date;
    // echo $start_date."-".$end_date;die();
    // Log::debug(" Check ".print_r($start_date,true)); 
    // Log::debug(" Check id ".print_r($end_date,true)); 

     $common_diet_plan=DB::table('common_diet_plan_purchases_history')->join('customers','customers.id','common_diet_plan_purchases_history.plan_purchase_by')->join('common_diet_plan','common_diet_plan.id','common_diet_plan_purchases_history.plan_id')->select('common_diet_plan_purchases_history.id as diet_plan_id','common_diet_plan_purchases_history.plan_name as plan_name','common_diet_plan_purchases_history.plan_price as plan_price','common_diet_plan_purchases_history.plan_purchase_by as plan_purchase_by','common_diet_plan_purchases_history.payment_reference_id as payment_reference_id','common_diet_plan_purchases_history.purchase_date as purchase_date', 'common_diet_plan_purchases_history.status as status', 'common_diet_plan.diet_plan_name as diet_plan_name','common_diet_plan.id as common_diet_plan_id','customers.id as customers_id')->whereBetween('common_diet_plan_purchases_history.purchase_date', [$start_date, $end_date])->where('common_diet_plan_purchases_history.plan_purchase_by',Auth::guard('customer')->user()->id)->paginate(10);
   }

   else
   {
     $common_diet_plan=DB::table('common_diet_plan_purchases_history')->join('common_diet_plan','common_diet_plan.id','common_diet_plan_purchases_history.plan_id')->select('common_diet_plan_purchases_history.id as diet_plan_id','common_diet_plan_purchases_history.plan_name as plan_name','common_diet_plan_purchases_history.plan_price as plan_price','common_diet_plan_purchases_history.plan_purchase_by as plan_purchase_by','common_diet_plan_purchases_history.payment_reference_id as payment_reference_id','common_diet_plan_purchases_history.purchase_date as purchase_date', 'common_diet_plan_purchases_history.status as status', 'common_diet_plan.diet_plan_name as diet_plan_name','common_diet_plan.id as common_diet_plan_id')->where('common_diet_plan_purchases_history.plan_purchase_by',Auth::guard('customer')->user()->id)->paginate(10);
   }
   // Log::debug(" data common_diet_plan ".print_r($common_diet_plan,true));
  return view('customerpanel.common_diet_plan')->with(compact('common_diet_plan'));
}

catch(\Exception $e) {

      return abort(400);
  }

  }
 
  public function my_order_history(Request $request)
{
  try{
 $this->cart_delete_customer();
 
 $my_order_history=DB::table('order_details')->join('products','products.id','order_details.product_id')->join('training_type','training_type.id','products.training_type_id')->join('payment_type','payment_type.id','products.payment_type_id')->join('payment_history','payment_history.id','order_details.payment_id')->select('order_details.id as order_details_id','order_details.customer_id as customer_id','order_details.order_purchase_date as order_purchase_date','order_details.remaining_sessions as remaining_sessions','order_details.payment_type as payment_type','order_details.training_type as training_type','order_details.order_validity_date as order_validity_date','order_details.payment_option as payment_option','order_details.status as status','products.training_type_id as training_type_id', 'products.total_sessions as total_sessions', 'order_details.price_session_or_month as price_session_or_month','products.id as product_id','order_details.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','payment_history.status as payment_status')->where('order_details.customer_id',Auth::guard('customer')->user()->id)->whereNull('order_details.deleted_at');
 
  
  if(isset($request->start_date) && isset($request->end_date) && !empty($request->start_date) && !empty($request->end_date))
  {
    $now = Carbon::now()->toDateString();
    $start_date=$request->start_date;
    $end_date=$request->end_date;   
    $my_order_history->whereBetween('order_details.order_purchase_date', [$start_date, $end_date]);
   }
  $my_order_history=$my_order_history->orderby('order_details.id','DESC')->paginate(10);

     Log::debug(" data my_order_history ".print_r($my_order_history,true));
  return view('customerpanel.order_history')->with(compact('my_order_history'));
}

catch(\Exception $e) {

      return abort(400);
  }

  }


}