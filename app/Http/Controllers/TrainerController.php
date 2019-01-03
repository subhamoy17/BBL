<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

use Session;
use App\Customer;
use App\User;
use App\Notifications\PackagePurchaseNotification;
use App\Notifications\SessionRequestNotification;
use App\Notifications\TrainerActiveDeactiveNotification;

use App\Notifications\SessionRequestNotificationToTrainer;
use App\Notifications\BootcampSessionNotification;
use App\Notifications\PlanPurchasedNotification;
use App\Notifications\PersonalTrainingSessionNotification;
use App\Notifications\PersonalTrainingSessionBookingNotification;



class TrainerController extends Controller
{
/**
* Create a new controller instance.
*
* @return void
*/
public function __construct()
{
    $this->middleware('auth');
}

/**
* Show the application dashboard.
*
* @return \Illuminate\Http\Response
*/
public function index()

{
  try{
    $cur_date =Carbon::now()->toDateString();

    if(Auth::user()->master_trainer==1)
    {
      //number of future pending request
      $future_pending_request=DB::table('slot_request')->where('slot_date','>=',$cur_date)->where('approval_id',1)->count(); 

      //number of future approve request 
      $future_approve_request=DB::table('slot_request')
      ->where(function($q) {
        $q->where('approval_id', 3)
          ->orWhere('approval_id', 4);
      })->where('slot_date','>=',$cur_date)->count(); 

      //number of past request
      $past_request=DB::table('slot_request')->where('approval_id','<>',2)->where('slot_date','<',$cur_date)->count();

      //number of decline request
      $decline_request=DB::table('slot_request')->where('approval_id',4)->count();

      $total_number_of_trainer=DB::table('users')->where('master_trainer',2)->whereNull('deleted_at')->count();
      $total_number_of_customer=DB::table('customers')->where('confirmed',1)->whereNull('deleted_at')->count();
      // For Bootcamp
      $now = Carbon::now()->toDateString();
      $total_bootcamop_future_booking=DB::table('bootcamp_booking')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
      ->whereNull('bootcamp_booking.deleted_at')->where('bootcamp_plan_shedules.plan_date','>=',$now)->count();

      $total_bootcamop_declined_booking=DB::table('bootcamp_booking')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
      ->whereNotNull('bootcamp_plan_shedules.deleted_at')->where('bootcamp_booking.cancelled_by',0)->count();

      $total_bootcamop_cancelled_booking=DB::table('bootcamp_booking')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
      ->whereNotNull('bootcamp_booking.deleted_at')->where('bootcamp_booking.cancelled_by','>',0)->count();

      $total_bootcamop_past_booking=DB::table('bootcamp_booking')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
      ->whereNull('bootcamp_booking.deleted_at')->where('bootcamp_plan_shedules.plan_date','<',$now)->count();

      $currentMonth = date('m');
      $total_bootcamop_booking_count_month = DB::table("bootcamp_booking")->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')->where('bootcamp_booking.cancelled_by',0)->whereNull('bootcamp_booking.deleted_at')
                ->whereRaw('MONTH(bootcamp_plan_shedules.plan_date) = ?',[$currentMonth])
                ->count();

      $total_pt_booking_crnt_month = DB::table("personal_training_booking")->join('personal_training_plan_schedules','personal_training_plan_schedules.id','personal_training_booking.personal_training_plan_shedules_id')->where('personal_training_booking.cancelled_by',0)->whereNull('personal_training_booking.deleted_at')
                ->whereRaw('MONTH(personal_training_plan_schedules.plan_date) = ?',[$currentMonth])
                ->count();

     $total_pt_future_booking=DB::table('personal_training_booking')
      ->join('personal_training_plan_schedules','personal_training_plan_schedules.id','personal_training_booking.personal_training_plan_shedules_id')
      ->whereNull('personal_training_booking.deleted_at')->where('personal_training_plan_schedules.plan_date','>=',$now)->count();

      $total_pt_past_booking=DB::table('personal_training_booking')
      ->join('personal_training_plan_schedules','personal_training_plan_schedules.id','personal_training_booking.personal_training_plan_shedules_id')
      ->whereNull('personal_training_booking.deleted_at')
      ->where('personal_training_plan_schedules.plan_date','<',$now)->count();

      $total_pt_cancelled_booking=DB::table('personal_training_booking')
      ->join('personal_training_plan_schedules','personal_training_plan_schedules.id','personal_training_booking.personal_training_plan_shedules_id')
      ->where('personal_training_booking.cancelled_by','>',0)->count();

      $total_pt_declined_booking=DB::table('personal_training_booking')
      ->join('personal_training_plan_schedules','personal_training_plan_schedules.id','personal_training_booking.personal_training_plan_shedules_id')
      ->whereNotNull('personal_training_booking.deleted_at')->where('personal_training_booking.cancelled_by',0)->count();

      $qtrMonth=Carbon::now()->subMonth(3);
      $total_booking_qtr=DB::table('slot_request')->where('slot_date','>=',$qtrMonth)->count();
    }
    else
    {
      //number of future pending request
      $future_pending_request=DB::table('slot_request')->where('trainer_id',Auth::user()->id)->where('slot_date','>=',$cur_date)->where('approval_id',1)->count(); 

      //number of future approve request 
      $future_approve_request=DB::table('slot_request')->where('trainer_id',Auth::user()->id)
      ->where(function($q) {
        $q->where('approval_id', 3)
          ->orWhere('approval_id', 4);
      })->where('slot_date','>=',$cur_date)->count(); 

      //number of past request
      $past_request=DB::table('slot_request')->where('trainer_id',Auth::user()->id)->where('approval_id','<>',2)->where('slot_date','<',$cur_date)->count();

      //number of decline request
      $decline_request=DB::table('slot_request')->where('trainer_id',Auth::user()->id)->where('approval_id',4)->count();

      $total_number_of_trainer=DB::table('users')->where('master_trainer',2)->whereNull('deleted_at')->count();
      $total_number_of_customer=DB::table('customers')->where('confirmed',1)->whereNull('deleted_at')->count();


      // For Bootcamp
      $now = Carbon::now()->toDateString();
      $total_bootcamop_future_booking=DB::table('bootcamp_booking')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
      ->whereNull('bootcamp_booking.deleted_at')->where('bootcamp_plan_shedules.plan_date','>=',$now)->count();

      $total_bootcamop_declined_booking=DB::table('bootcamp_booking')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
      ->whereNotNull('bootcamp_booking.deleted_at')->where('bootcamp_booking.cancelled_by',0)->count();

      $total_bootcamop_cancelled_booking=DB::table('bootcamp_booking')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
      ->whereNotNull('bootcamp_booking.deleted_at')->where('bootcamp_booking.cancelled_by','>',0)->count();

      $total_bootcamop_past_booking=DB::table('bootcamp_booking')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_booking.created_at')
      ->whereNull('bootcamp_booking.deleted_at')->where('bootcamp_plan_shedules.plan_date','<',$now)->count();

      $currentMonth = date('m');
  
     $total_bootcamop_booking_count_month = DB::table("bootcamp_booking")->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')->where('bootcamp_booking.cancelled_by',0)->whereNull('bootcamp_booking.deleted_at')
        ->whereRaw('MONTH(bootcamp_plan_shedules.plan_date) = ?',[$currentMonth])
        ->count();


      $qtrMonth=Carbon::now()->subMonth(3);
      $total_booking_qtr=DB::table('slot_request')->where('slot_date','>=',$qtrMonth)->where('trainer_id',Auth::user()->id)->count();

      $total_pt_future_booking=DB::table('personal_training_booking')
      ->join('personal_training_plan_schedules','personal_training_plan_schedules.id','personal_training_booking.personal_training_plan_shedules_id')
      ->whereNull('personal_training_booking.deleted_at')->where('personal_training_plan_schedules.plan_date','>=',$now)
      ->where('personal_training_plan_schedules.trainer_id',Auth::user()->id)->count();

      $total_pt_past_booking=DB::table('personal_training_booking')
      ->join('personal_training_plan_schedules','personal_training_plan_schedules.id','personal_training_booking.personal_training_plan_shedules_id')
      ->whereNull('personal_training_booking.deleted_at')
      ->where('personal_training_plan_schedules.plan_date','<',$now)
      ->where('personal_training_plan_schedules.trainer_id',Auth::user()->id)->count();

      $total_pt_cancelled_booking=DB::table('personal_training_booking')
      ->join('personal_training_plan_schedules','personal_training_plan_schedules.id','personal_training_booking.personal_training_plan_shedules_id')
      ->where('personal_training_booking.cancelled_by','>',0)
      ->where('personal_training_plan_schedules.trainer_id',Auth::user()->id)->count();

      $total_pt_declined_booking=DB::table('personal_training_booking')
      ->join('personal_training_plan_schedules','personal_training_plan_schedules.id','personal_training_booking.personal_training_plan_shedules_id')
      ->whereNotNull('personal_training_booking.deleted_at')->where('personal_training_booking.cancelled_by',0)
      ->where('personal_training_plan_schedules.trainer_id',Auth::user()->id)->count();
    }
    return view('trainer.home')->with(compact('total_number_of_trainer','total_number_of_customer','total_bootcamop_booking_count_month','total_bootcamop_future_booking','total_bootcamop_declined_booking','total_bootcamop_cancelled_booking','total_bootcamop_past_booking','total_pt_booking_crnt_month','total_pt_future_booking','total_pt_past_booking','total_pt_cancelled_booking','total_pt_declined_booking'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}


/**
* Show trainer own profile
*
*/
public function showprofile()
{
  try{
  $data=DB::table('users')->where('id',Auth::user()->id)->first();
  return view('trainer.trainerprofile')->with(compact('data'));
  }
  catch(\Exception $e) {
      return abort(200);
  }
}

// open the update form of trainer
public function showupdateform()
{
  try{
  $data= DB::table('users')->where('id',Auth::user()->id)->first();
  return view ("trainer.editform")->with(compact('data'));
  }
  catch(\Exception $e) {
      return abort(200);
  }
}


// update profile of trainer
public function updateprofile(Request $request)
{
  try{

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
    $mydata['address']=$request->address;
    $mydata['contact_no']=$request->contact_no;
    $data['updated_at']=Carbon::now();

    $data=DB::table('users')->where('id',$request->id)->update($mydata);
    return redirect()->back()->with("success","Your profile has been updated successfully.");

  }
  catch(\Exception $e) {
    return abort(200);
  }
}



public function showlist()
{

  try{
  
  $data=DB::table('users')->whereNull('deleted_at')->get()->all();
  return view('trainer.trainerlist')->with(compact('data'));
  }
  catch(\Exception $e) {
      return abort(200);
  }

}


//trainer ajax function//
public function trainer_active_deactive(Request $request)
{
  
Log::debug(":: bootcamp_onlinepayment :: ".print_r($request->all(),true));
  $data=$request->get('data');
  $id=$data['id'];
  $action=$data['action'];
   $remaining_session_request_now=Carbon::now()->toDateString();

  if($action=="Active")
  {
    $a=DB::table('users')->where('id',$id)->update(['is_active'=>1]);
        
    $slot_rquest_trainer=DB::table('personal_training_available_trainer')
    ->where('trainer_id',$id)->update(['deleted_at'=>NULL]);

    $total_schedule=DB::table('personal_training_plan_schedules')
    ->where('personal_training_plan_schedules.trainer_id',$id)
    ->where('personal_training_plan_schedules.status',1)
    ->where('personal_training_plan_schedules.plan_date','>=',$remaining_session_request_now)->whereNotNull('personal_training_plan_schedules.deleted_at')
    ->get()->all();


Log::debug(" total_schedule1 ".print_r($total_schedule,true));

if($total_schedule){

foreach($total_schedule as $my_schedule)
    {

  // $updatedata['deleted_at']=Carbon::now();
    $slot_rquest_update=DB::table('personal_training_plan_schedules')
    ->where('trainer_id',$my_schedule->trainer_id)
    
    ->where('plan_date','>=',$remaining_session_request_now)
    ->update(['deleted_at'=>NULL]);

    }

    $trainer_details=User::find($id);

    $notifydata['status']='Trainer Active';
    $notifydata['trainer_name']=$trainer_details->name;

    //Log::debug("Trainer Active notification ".print_r($notifydata,true));

    $trainer_details->notify(new TrainerActiveDeactiveNotification($notifydata));

    return response()->json(1);
  }
}
  elseif($action=="Deactive")
  {
    
   $a=DB::table('users')->where('id',$id)->update(['is_active'=>0]);
    $updatedata1['deleted_at']=Carbon::now();
    $slot_rquest_trainer=DB::table('personal_training_available_trainer')
    ->where('trainer_id',$id)
    ->update($updatedata1);

    $total_schedule=DB::table('personal_training_plan_schedules')
    ->where('personal_training_plan_schedules.trainer_id',$id)
    ->where('personal_training_plan_schedules.status',1)
    ->where('personal_training_plan_schedules.plan_date','>=',$remaining_session_request_now)->whereNull('personal_training_plan_schedules.deleted_at')
    ->get()->all();


 Log::debug(" total_schedule1 ".print_r($total_schedule,true));

if($total_schedule){

foreach($total_schedule as $key=>$my_schedule)
    {



  $updatedata['deleted_at']=Carbon::now();
    $slot_rquest_update=DB::table('personal_training_plan_schedules')
    ->where('trainer_id',$my_schedule->trainer_id)
    ->where('plan_date','>=',$remaining_session_request_now)
    ->update($updatedata);


    $slot_time=DB::table('slot_times')->where('id',$my_schedule->plan_st_time_id)->first();

    $total_decline=DB::table('personal_training_booking')
    ->where('personal_training_booking.personal_training_plan_shedules_id',$my_schedule->id)
    ->where('cancelled_by',0)
    ->whereNull('personal_training_booking.deleted_at')
    ->get()->all();

      Log::debug(" total_decline ".print_r($total_decline,true));


        // $customer_id=0; $plan_date='';
        foreach($total_decline as $my_total)
        {

         $all_customer=DB::table('order_details')
          ->where('id',$my_total->customer_id)->where('status',1)
          ->whereNull('deleted_at')
          ->orderBy('order_validity_date','DESC')->get()->all();
         Log::debug(" all_customer ".print_r($all_customer,true));

          $add_session=DB::table('order_details')
          ->where('id',$my_total->order_details_id)->where('status',1)
          ->whereNull('deleted_at')
         ->increment('remaining_sessions',1);
    

        $customer_details=Customer::find($my_total->customer_id);
        $trainer_details=User::find($id);

        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$customer_details->name;
        $notifydata['customer_email']=$customer_details->email;
        $notifydata['customer_phone']=$customer_details->ph_no;
        $notifydata['status']='Cancelled Session Request';
        $notifydata['session_booked_on']=$my_schedule->created_at;
        $notifydata['session_booking_date']=$my_schedule->plan_date;
        $notifydata['session_booking_time']=$slot_time->time;
        $notifydata['trainer_name']=$trainer_details->name;
        $notifydata['decline_reason']='Deactivate Trainer';

        $customer_details->notify(new SessionRequestNotification($notifydata));
   
     
    }

  }
}


     
 


    $trainer_details=User::find($id);

    $notifydata['status']='Trainer Deactive';
    $notifydata['trainer_name']=$trainer_details->name;

    Log::debug("Trainer Deactive notification ".print_r($trainer_details,true));

    $trainer_details->notify(new TrainerActiveDeactiveNotification($notifydata));

    return response()->json(2);
  }

}

public function addtrainer()
{
  return view('trainer.addtrainer');
}


public function trainerdelete($id)
{
  DB::beginTransaction();
  try{
  
  $updatedata['deleted_at']=Carbon::now();

  DB::table('users')->where('id',$id)->update($updatedata);

  $remaining_session_request_now=Carbon::now()->toDateString();


    $total_schedule=DB::table('personal_training_plan_schedules')
    ->where('personal_training_plan_schedules.trainer_id',$id)
    ->where('personal_training_plan_schedules.status',1)
    ->where('personal_training_plan_schedules.plan_date','>=',$remaining_session_request_now)
    ->get()->all();

  // Log::debug(" total_schedule ".print_r($total_schedule,true));


    if($total_schedule){

  foreach($total_schedule as $key=>$my_schedule)
    {

   $updatedata1['deleted_at']=Carbon::now();
      $slot_rquest_trainer=DB::table('personal_training_available_trainer')
    ->where('trainer_id',$my_schedule->trainer_id)
    ->update($updatedata1);
    $slot_rquest_update=DB::table('personal_training_plan_schedules')
     ->where('plan_date','>=',$remaining_session_request_now)
    ->where('trainer_id',$my_schedule->trainer_id)  
     ->update($updatedata1);

 

    $slot_time=DB::table('slot_times')->where('id',$my_schedule->plan_st_time_id)->first();

    $total_decline=DB::table('personal_training_booking')
    ->where('personal_training_booking.personal_training_plan_shedules_id',$my_schedule->id)
    ->where('cancelled_by',0)
    ->whereNull('personal_training_booking.deleted_at')
    ->get()->all();

      // Log::debug(" total_decline ".print_r($total_decline,true));


        $customer_id=0; $plan_date='';
        foreach($total_decline as $my_total)
        {

         $all_customer=DB::table('order_details')
          ->where('id',$my_total->customer_id)->where('status',1)
          ->whereNull('deleted_at')
          ->orderBy('order_validity_date','DESC')->get()->all();
         // Log::debug(" all_customer ".print_r($all_customer,true));

          $add_session=DB::table('order_details')
          ->where('id',$my_total->order_details_id)->where('status',1)
          ->whereNull('deleted_at')
         ->increment('remaining_sessions',1);
    

        $customer_details=Customer::find($my_total->customer_id);
        $trainer_details=User::find($id);

        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$customer_details->name;
        $notifydata['customer_email']=$customer_details->email;
        $notifydata['customer_phone']=$customer_details->ph_no;
        $notifydata['status']='Cancelled Session Request';
        $notifydata['session_booked_on']=$my_schedule->created_at;
        $notifydata['session_booking_date']=$my_schedule->plan_date;
        $notifydata['session_booking_time']=$slot_time->time;
        $notifydata['trainer_name']=$trainer_details->name;
        $notifydata['decline_reason']='Deactivate Trainer';

        $customer_details->notify(new SessionRequestNotification($notifydata));
   
     
    }

  }
}

  $trainer_details=User::find($id);

  $notifydata['status']='Trainer Delete';
  $notifydata['trainer_name']=$trainer_details->name;

  //Log::debug("Trainer Delete notification ".print_r($notifydata,true));

  $trainer_details->notify(new TrainerActiveDeactiveNotification($notifydata));

  

  DB::commit();

  return redirect('trainer/trainerlist')->with("delete","You have successfully deleted one trainer");
  }
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}



public function inserttrainer(Request $request)
{
  try{

      $validator=Validator::make($request->all(), [

        'email' => 'sometimes|email|max:255|unique:users',
      ]);

      if($validator->fails())
      {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      if($request->image!="")
      {
        $request->validate
        ([ 'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048', ]);
        $myimage=$request->image;
        $folder="backend/images/"; 
        $extension=$myimage->getClientOriginalExtension(); 
        $image_name=time()."_adminimg.".$extension; 
        $upload=$myimage->move($folder,$image_name); 
        $data['image']=$image_name; 
      }
      else
      { $data['image']=$request->oldimage;  }
      $data['name']=$request->name;
      $data['contact_no']=$request->contact_no;
      $data['address']=$request->address;
      $data['email']=$request->email;
      $data['master_trainer']=2;
      $password_code = str_random(6);
      $data['password']= bcrypt($password_code);
      $data['created_at']=Carbon::now();
      $data['is_active']=1;

      $data['title']=(isset($request->title) && !empty($request->title)) ? $request->title : NULL ;
      $data['designation']=(isset($request->designation) && !empty($request->designation)) ? $request->designation : NULL ;
      $data['description']=(isset($request->description) && !empty($request->description)) ? $request->description : NULL ;
      $data['facebook']=(isset($request->facebook) && !empty($request->facebook)) ? $request->facebook : NULL ;
      $data['twitter']=(isset($request->twitter) && !empty($request->twitter)) ? $request->twitter : NULL ;
      $data['instagram']=(isset($request->instagram) && !empty($request->instagram)) ? $request->instagram : NULL ;
      $data['show_in_about_us']=(isset($request->show_in_about_us) && !empty($request->show_in_about_us)) ? 1 : 0 ;

      DB::table('users')->insert($data);

      Mail::send('emails.enquirymail',['password' =>$password_code,'email' =>$data['email'],'name'=>$data['name']], function($message) {
      $message->to(Input::get('email'))->subject('Successfully add as a trainer');
      });
      return redirect('trainer/trainerlist')->with("success","You have successfully added one trainer");
    }
    catch(\Exception $e) {
        return abort(200);
    }
}



public function showtrainerseditform($id)
{

  try{
  
    $data= DB::table('users')->where('id',$id)->first();
    //Log::debug(" data ".print_r($data,true));
    return view ("trainer.edittrainer")->with(compact('data'));
  }
  catch(\Exception $e) {
      return abort(200);
  }
}


public function traineredit(Request $request)
{ 

  try{
    
    if($request->image!="")
    {
      $myimage=$request->image;
      $folder="backend/images/"; 
      $extension=$myimage->getClientOriginalExtension(); 
      $image_name=time()."_adminimg.".$extension; 
      $upload=$myimage->move($folder,$image_name); 
      $data['image']=$image_name; 
    }else {   $data['image']=$request->oldimage; }

    $data['name']=$request->name;
    $data['contact_no']=$request->contact_no;
    $data['address']=$request->address;
    $data['email']=$request->email;
    $data['updated_at']=Carbon::now();
    $data['title']=(isset($request->title) && !empty($request->title)) ? $request->title : NULL ;
    $data['designation']=(isset($request->designation) && !empty($request->designation)) ? $request->designation : NULL ;
    $data['description']=(isset($request->description) && !empty($request->description)) ? $request->description : NULL ;
    $data['facebook']=(isset($request->facebook) && !empty($request->facebook)) ? $request->facebook : NULL ;
    $data['twitter']=(isset($request->twitter) && !empty($request->twitter)) ? $request->twitter : NULL ;
    $data['instagram']=(isset($request->instagram) && !empty($request->instagram)) ? $request->instagram : NULL ;
    $data['show_in_about_us']=(isset($request->show_in_about_us) && !empty($request->show_in_about_us)) ? 1 : 0 ;
    DB::table('users')->where('id',$request->id)->update($data);


    return redirect('trainer/trainerlist')->with("success","You have successfully updated one trainer");
  }
  catch(\Exception $e) {
   return abort(200);
  }
}

//all customers table//
public function all_customers()
{
  try{
  
    $data=DB::table('customers')->whereNull('deleted_at')->where('confirmed',1)->get();
    return view('trainer.customers_all')->with(compact('data'));
  }
  catch(\Exception $e) {
      return abort(200);
  }
}
//gym insert form//
public function add_exercise_trainer()
{
  return view('trainer.exercise_insert_details');
}

//gym insert function//
public function exercise_user_insert(Request $request)
{

  try{
  
    // Log::debug(" data ".print_r($request->all(),true)); /// create log for showing error and print resul
    if($request->image!="")
    {
      $request->validate
      (
          [ 'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048']
      );
      $myimage=$request->image;
      $folder="backend/images/"; 
      $extension=$myimage->getClientOriginalExtension(); 
      $image_name=time()."_adminimg.".$extension; 
      $upload=$myimage->move($folder,$image_name); 
      $data['image']=(isset($request->video) && !empty($request->video)) ? null : $image_name; 
    }
    $data['title']=$request->title;
    $data['description']=$request->description;
    $data['duration']=$request->duration;
    $data['trainer_id']=$request->trainer_id;
    $data['video']=(isset($request->video) && !empty($request->video)) ? $request->video : null; 
    $data['created_at']=Carbon::now();

    DB::table('exercise_details')->insert($data);
  
    return redirect('trainer/gymType')->with("success","You have successfully added one exercise.");
  }
  catch(\Exception $e) {
      return abort(200);
  }
}

//gym view function//
public function gym_showlist(Request $request)
{ 
  try{
  
    $trainer_details=DB::table('users')->where('users.id',Auth::user()->id)->value('master_trainer');
    if($trainer_details==2)
    {
      $data=DB::table('exercise_details')->where('exercise_details.trainer_id',Auth::user()->id)->get();
      return view('trainer.gymlist')->with(compact('data'));
    }
    else
    {
      $data=DB::table('exercise_details')->get();
      return view('trainer.gymlist')->with(compact('data'));
    }
  }
  catch(\Exception $e) {
      return abort(200);
  }
}

//gym delete function//
public function gymdelete($id)
{ 
  try{
  
    DB::table('exercise_details')->delete($id);
    return redirect()->back()->with("delete","You have successfully deleted one exercise.");
  }
  catch(\Exception $e) {
    return abort(200);
  }
}

//gym edit form//
public function show_edit_exercise_form($id)
{
  try{
  
    $data= DB::table('exercise_details')->where('id',$id)->first();
    //Log::debug(" data ".print_r($data,true));
    return view ("trainer.editexercise")->with(compact('data'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}

//gym edit function//
public function update_exercise(Request $request)
{ 
  try{
  
    if($request->image!="")
    {
      $myimage=$request->image;
      $folder="backend/images/"; 
      $extension=$myimage->getClientOriginalExtension(); 
      $image_name=time()."_adminimg.".$extension; 
      $upload=$myimage->move($folder,$image_name); 
      $data['image']= (isset($request->video) && !empty($request->video)) ? null : $image_name; 
    }
    else
    {
      $data['image']= (isset($request->video) && !empty($request->video)) ? null : $request->oldimage; 
    }

    $data['title']=$request->title;
    $data['description']=$request->description;
    $data['duration']=$request->duration;
    $data['video']=(isset($request->video) && !empty($request->video)) ? $request->video : null;
    $data['updated_at']=Carbon::now();

    DB::table('exercise_details')->where('id',$request->id)->update($data);
    return redirect()->route("gymType")->with("success","You have successfully updated one exercise.");
  }
  catch(\Exception $e) {
    return abort(200);
  }

}



//feedback function//
public function feedbacklist(Request $request)
{
  try{
  
    $data=DB::table('feedback')->orderBy('feedback.id','desc')->get();
    return view('trainer.feedbacklist')->with(compact('data'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}

// For contact details
public function contactlist(Request $request)
{
  try{
  
    $data=DB::table('contact_us')->orderBy('contact_us.id','desc')->get();
    return view('trainer.contactlist')->with(compact('data'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}


public function testimonial_view()
{
  try{
  
    $data=DB::table('testimonial')->where('deleted_at',null)->get();
    return view('trainer.testimonial_view')->with(compact('data'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}


public function testimonialshow()
{
  try{
  return view('trainer.testimonial_backend');
  }
  catch(\Exception $e) {
    return abort(200);
  }
}

public function testimonialinsert(Request $request)
{

  try{
  
    if($request->image!="")
    {
      $request->validate
      (
        [ 'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048']
      );
      $myimage=$request->image;
      $folder="backend/images/"; 
      $extension=$myimage->getClientOriginalExtension(); 
      $image_name=time()."_adminimg.".$extension; 
      $upload=$myimage->move($folder,$image_name); 
      $data['image']=$image_name; 
    }
    else{ $data['image']=$request->oldimage;  }

    $data['name']=$request->name;
    $data['designation']=$request->designation;
    $data['description']=$request->description;
    DB::table('testimonial')->insert($data);
  
    return redirect('trainer/testimonial_view')->with("success","You have successfully added one testimonial.");
  }
  catch(\Exception $e) {
    return abort(200);
  }
}

// open the edit form of slots
public function testimonialedit($id)
{
  try{
  
    $data= DB::table('testimonial')->where('id',$id)->first();
    return view ("trainer.edit_testimonial")->with(compact('data'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}

public function testimonialupdate(Request $request)
{ 
  try{
  
    if($request->image!="")
    {
      $myimage=$request->image;
      $folder="backend/images/"; 
      $extension=$myimage->getClientOriginalExtension(); 
      $image_name=time()."_adminimg.".$extension; 
      $upload=$myimage->move($folder,$image_name); 
      $data['image']=$image_name; 
    }
    else {   $data['image']=$request->oldimage; }

    $data['name']=$request->name;
    $data['designation']=$request->designation;
    $data['description']=$request->description;
    $data['updated_at']=Carbon::now();

    DB::table('testimonial')->where('id',$request->id)->update($data);
  
    return redirect('trainer/testimonial_view')->with("success","You have successfully updated one testimonial.");
  }
  catch(\Exception $e) {
    return abort(200);
  }

}


public function testimonialdelete($id)
{
  try{
  
    $updatedata['deleted_at']=Carbon::now();

    DB::table('testimonial')->where('id',$id)->update($updatedata);
  
    return redirect('trainer/testimonial_view')->with("delete","You have successfully deleted one testimonial.");
  }
  catch(\Exception $e) {
    return abort(200);
  }
}

public function mot_show(Request $request)
{
  try{
  
    $data=DB::table('customer_mot')
    ->join('customers','customers.id','customer_mot.customer_id')
    ->select('customer_mot.*','customers.name','customers.ph_no','customers.email')->where('customer_mot.deleted_at',null)->get();
    return view('trainer.customer_mot')->with(compact('data'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}

public function motinsertshow()
{
  try{
  
    $data=DB::table('customers')->get();
    return view('trainer.motinsertshow')->with(compact('data'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}


public function motinsertshowauto(Request $request)
{
  //Log::debug(" motinsertshowauto ".print_r($request->all(),true)); 

  $query = $request->get('term','');
     
  $products=DB::table('customers')->where('name','LIKE','%'.$query.'%')->orwhere('email','LIKE','%'.$query.'%')->orwhere('ph_no','LIKE','%'.$query.'%')->get();
        
  $data=array();  $data1=array();
  foreach ($products as $product) 
  {
               
    $data[]=array('value'=>$product->name,'id'=>$product->id, 'email'=>$product->email,'ph_no'=>$product->ph_no );
  }

  if(count($data)) {  return $data;  }
  else {   $data1[]=array('value'=>'No Result Found');    return $data1;  } 
}



public function motinsert(Request $request)
{
  try{
  
  //Log::debug(" metric ".print_r($request->right_arm_credential,true));

    if($request->right_arm_credential=="metric")
      {
          $right_arm =$request->right_arm;
      }
      else
      {
          $right_arm =($request->right_arm/0.39370 );
      }
      if($request->left_arm_credential=="metric")
      {
          $left_arm =$request->left_arm;
      }
      else
      {
          $left_arm =($request->left_arm/0.39370 );
      }
      if($request->chest_credential=="metric")
      {
          $chest =$request->chest;
      }
      else
      {
          $chest =($request->chest/0.39370 );
      }
      if($request->waist_credential=="metric")
      {
          $waist =$request->waist;
      }
      else
      {
          $waist =($request->waist/0.39370 );
      }
      if($request->hips_credential=="metric")
      {
          $hips =$request->hips;
      }
      else
      {
          $hips =($request->hips/0.39370 );
      }
      if($request->right_thigh_credential=="metric")
      {
          $right_thigh =$request->right_thigh;
      }
      else
      {
          $right_thigh =($request->right_thigh/0.39370 );
      }
      if($request->left_thigh_credential=="metric")
      {
          $left_thigh =$request->left_thigh;
      }
      else
      {
          $left_thigh =($request->left_thigh/0.39370 );
      }
      if($request->height_credential=="metric")
      {
          $height =$request->height;
      }
      else
      {
          $height =($request->height/0.39370 );
      }


      if($request->right_calf_credential=="metric")
      {
          $right_calf =$request->right_calf;
      }
      else
      {
          $right_calf =($request->right_calf/0.39370 );
      }



      if($request->left_calf_credential=="metric")
      {
          $left_calf =$request->left_calf;
      }
      else
      {
          $left_calf =($request->left_calf/0.39370 );
      }

     if($request->starting_weight_credential=="metric")
        {
            $starting_weight =$request->starting_weight;
        }
        else
        {
            $starting_weight =($request->starting_weight/2.2046 );
        }

     if($request->ending_weight_credential=="metric")
        {
            $ending_weight =$request->ending_weight;
        }
        else
        {
            $ending_weight =($request->ending_weight/2.2046 );
        }

      $data['right_arm']=(isset($right_arm) && !empty($right_arm)) ? $right_arm : null;
      $data['left_arm']=(isset($left_arm) && !empty($left_arm)) ? $left_arm : null;
      $data['chest']=(isset($chest) && !empty($chest)) ? $chest : null;
      $data['waist']=(isset($waist) && !empty($waist)) ? $waist : null;
      $data['hips']=(isset($hips) && !empty($hips)) ? $hips : null;
      $data['right_thigh']=(isset($right_thigh) && !empty($right_thigh)) ? $right_thigh : null;
      $data['left_thigh']=(isset($left_thigh) && !empty($left_thigh)) ? $left_thigh : null;
      $data['right_calf']=(isset($right_calf) && !empty($right_calf)) ? $right_calf : null;
      $data['left_calf']=(isset($left_calf) && !empty($left_calf)) ? $left_calf : null;
      $data['starting_weight']=(isset($starting_weight) && !empty($starting_weight)) ? $starting_weight : null;
      $data['ending_weight']=(isset($ending_weight) && !empty($ending_weight)) ? $ending_weight : null;
      $data['heart_beat']=(isset($request->heart_beat) && !empty($request->heart_beat)) ? $request->heart_beat : null;
      $data['blood_pressure']=(isset($request->blood_pressure) && !empty($request->blood_pressure)) ? $request->blood_pressure : null;
      $data['height']=(isset($height) && !empty($height)) ? $height : null;

      $data['date']=(isset($request->date) && !empty($request->date)) ? $request->date : null;

      $data['description']=(isset($request->description) && !empty($request->description)) ? $request->description : null;

      $data['trainer_id']=(isset($request->trainer_id) && !empty($request->trainer_id)) ? $request->trainer_id : null;
      $data['trainer_id']=(isset($request->trainer_id) && !empty($request->trainer_id)) ? $request->trainer_id : null;
      $data['customer_id']=(isset($request->apply) && !empty($request->apply)) ? $request->apply : null;

      DB::table('customer_mot')->insert($data);

      return redirect('trainer/mot_show')->with("success","You have successfully added one customer's MOT.");
    }
    catch(\Exception $e) {
      return abort(200);
    }
}


public function mot_customer_request(Request $request)
{
  
  $data=$request->get('data');
  $id=$data['id'];
  $positions = DB::table('customer_mot')->where('customer_id',$id)->orderBy('date','DESC')->first();
  return response()->json($positions);
}

public function moteditshow($id)
{
  try{
  
    $data=DB::table('customer_mot')
    ->join('customers','customers.id','customer_mot.customer_id')
    ->join('users','users.id','customer_mot.trainer_id')
    ->select('customer_mot.id as mot_id','customer_mot.height','customer_mot.customer_id as customer_id','customer_mot.trainer_id','customer_mot.right_arm','customer_mot.left_arm','customer_mot.chest','customer_mot.waist','customer_mot.hips','customer_mot.right_thigh','customer_mot.left_thigh','customer_mot.starting_weight','customer_mot.date','customer_mot.right_calf','customer_mot.left_calf','customer_mot.heart_beat','customers.name as current_customer_name','customer_mot.blood_pressure','customer_mot.ending_weight','customer_mot.description')->where('customer_mot.id',$id)->first();

    return view('trainer.moteditshow')->with(compact('data'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}



public function motedit(Request $request){

  try{

  
    if($request->right_arm_credential=="metric")
    {
        $right_arm =$request->right_arm;
    }
    else
    {
        $right_arm =($request->right_arm/0.39370 );
    }
    if($request->left_arm_credential=="metric")
    {
        $left_arm =$request->left_arm;
    }
    else
    {
        $left_arm =($request->left_arm/0.39370 );
    }
    if($request->chest_credential=="metric")
    {
        $chest =$request->chest;
    }
    else
    {
        $chest =($request->chest/0.39370 );
    }
    if($request->waist_credential=="metric")
    {
        $waist =$request->waist;
    }
    else
    {
        $waist =($request->waist/0.39370 );
    }
    if($request->hips_credential=="metric")
    {
        $hips =$request->hips;
    }
    else
    {
        $hips =($request->hips/0.39370 );
    }
    if($request->right_thigh_credential=="metric")
    {
        $right_thigh =$request->right_thigh;
    }
    else
    {
        $right_thigh =($request->right_thigh/0.39370 );
    }
    if($request->left_thigh_credential=="metric")
    {
        $left_thigh =$request->left_thigh;
    }
    else
    {
        $left_thigh =($request->left_thigh/0.39370 );
    }
    if($request->height_credential=="metric")
    {
        $height =$request->height;
    }
    else
    {
        $height =($request->height/0.39370 );
    }


    if($request->right_calf_credential=="metric")
    {
        $right_calf =$request->right_calf;
    }
    else
    {
        $right_calf =($request->right_calf/0.39370 );
    }

    if($request->left_calf_credential=="metric")
    {
        $left_calf =$request->left_calf;
    }
    else
    {
        $left_calf =($request->left_calf/0.39370 );
    }

    if($request->starting_weight_credential=="metric")
    {
        $starting_weight=$request->starting_weight;
    }
    else
    {
        $starting_weight =($request->starting_weight/2.2046 );
    }

    if($request->ending_weight_credential=="metric")
    {
        $ending_weight=$request->ending_weight;
    }
    else
    {
        $ending_weight =($request->ending_weight/2.2046 );
    }

    $data['right_arm']=(isset($right_arm) && !empty($right_arm)) ? $right_arm : null;
    $data['left_arm']=(isset($left_arm) && !empty($left_arm)) ? $left_arm : null;
    $data['chest']=(isset($chest) && !empty($chest)) ? $chest : null;
    $data['waist']=(isset($waist) && !empty($waist)) ? $waist : null;
    $data['hips']=(isset($hips) && !empty($hips)) ? $hips : null;
    $data['right_thigh']=(isset($right_thigh) && !empty($right_thigh)) ? $right_thigh : null;
    $data['left_thigh']=(isset($left_thigh) && !empty($left_thigh)) ? $left_thigh : null;
    $data['right_calf']=(isset($right_calf) && !empty($right_calf)) ? $right_calf : null;
    $data['left_calf']=(isset($left_calf) && !empty($left_calf)) ? $left_calf : null;

    $data['starting_weight']=(isset($starting_weight) && !empty($starting_weight)) ? $starting_weight : null;
    $data['ending_weight']=(isset($ending_weight) && !empty($ending_weight)) ? $ending_weight : null;
    $data['heart_beat']=(isset($request->heart_beat) && !empty($request->heart_beat)) ? $request->heart_beat : null;
    $data['blood_pressure']=(isset($request->blood_pressure) && !empty($request->blood_pressure)) ? $request->blood_pressure : null;
    $data['height']=(isset($request->height) && !empty($request->height)) ? $request->height : null;
    $data['description']=(isset($request->description) && !empty($request->description)) ? $request->description : null;

    $data['date']=(isset($request->date) && !empty($request->date)) ? $request->date : null;
    DB::table('customer_mot')->where('id',$request->id)->update($data);
    
    return redirect('trainer/mot_show')->with("success","You have successfully updated one customer's MOT.");
  }
  catch(\Exception $e) {
      return abort(200);
  }

}


public function motdelete($id)
{
  try{
  
    $updatedata['deleted_at']=Carbon::now();
    DB::table('customer_mot')->where('id',$id)->update($updatedata);
    return redirect('trainer/mot_show')->with("delete","You have successfully deleted one customer's MOT.");
  }
  catch(\Exception $e) {
    return abort(200);
  }
}


public function cheeck_exercise_category(Request $request)
{
    
  $category=$request->title;
  $category=preg_replace('/\s+/', ' ', $category);
  
  $exercise_details=DB::table('exercise_details')->where('title',$category)->count();

  if($exercise_details>0) {  return 1;  }
  else  {   return 0;  }
}


public function cheeckexercisecategory_edit(Request $request)
{
    
  $category=$request->title;
  $category=preg_replace('/\s+/', ' ', $category);
  
  $edit_category=DB::table('exercise_details')->where('id',$request->id)->pluck('title');
  $all_category=DB::table('exercise_details')->where('id','!=',$request->id)->get()->all();

  $duplicate_cat=0;
  foreach($all_category as $each_category)
  {
    if($each_category->title==$category)  {   $duplicate_cat=1;   }
  }

  if($duplicate_cat==1) {   return 1;  }
  else  {    return 0;   }
}

public function cheecktestimonialname(Request $request)
{
  $name=$request->name;
  $name=preg_replace('/\s+/', ' ', $name);
  
  $testimonial_details=DB::table('testimonial')->where('name',$name)->count();

  if($testimonial_details>0) {  return 1;  }
  else  {    return 0;  }
}

public function cheecktestimonialname_edit(Request $request)
{
    $name=$request->name;
    $name=preg_replace('/\s+/', ' ', $name);
    
    $edit_name=DB::table('testimonial')->where('id',$request->id)->pluck('name');
    $all_name=DB::table('testimonial')->where('id','!=',$request->id)->get()->all();

    $duplicate_name=0;
    foreach($all_name as $each_name)
    {
      if($each_name->name==$name)   {    $duplicate_name=1;   }
    }
  
    if($duplicate_name==1)  {  return 1;  }
    else {   return 0;   } 
}


  public function add_bc_session($id)
  {
    try{
    $bc_schedule_id=\Crypt::decrypt($id);

    $bc_schedule_details=DB::table('bootcamp_plan_shedules')->where('id',$bc_schedule_id)->whereNull('deleted_at')->first();

    return view('trainer.add_bc_session_bytrainer')->with(compact('bc_schedule_details'));
    }
  catch(\Exception $e) {
    return abort(200);
  }
  }

public function search_customer_bc(Request $request)
{
  $query = $request->get('term','');   
  $customers_details=DB::table('customers')
  ->where('name','LIKE','%'.$query.'%')
  ->orwhere('email','LIKE','%'.$query.'%')
  ->orwhere('ph_no','LIKE','%'.$query.'%')->get();
        $data=array();
         $data1=array();

    foreach ($customers_details as $all_details) {
               
      $data[]=array('value'=>$all_details->name,'id'=>$all_details->id, 'email'=>$all_details->email,'ph_no'=>$all_details->ph_no );
    }
    if(count($data)) {  return $data;  }
    else{ $data1[]=array('value'=>'No Result Found');   return $data1;   }
}

  public function check_customer_bc_session(Request $request)
  {

    //Log::debug(" insert_bootcamp_plan data ".print_r($request->all(),true));

    $data=$request->get('data');
    $customer_id=$data['id'];
    $schedule_id=$data['schedule_id'];

    $current_date=Carbon::now()->toDateString(); // current date

    $remaining_session_notunlimited=DB::table('order_details')
    ->join('products','products.id','order_details.product_id')
    ->join('training_type','training_type.id','products.training_type_id')
    ->where('order_details.customer_id',$customer_id)
    ->where('order_details.status',1)
    ->where('training_type.id',2)
    ->where('order_details.order_validity_date','>=',$current_date)
    ->where('order_details.remaining_sessions','>',0)
    ->sum('order_details.remaining_sessions');

    $remaining_session_unlimited=DB::table('order_details')
    ->join('products','products.id','order_details.product_id')
    ->join('training_type','training_type.id','products.training_type_id')
    ->where('order_details.customer_id',$customer_id)
    ->where('order_details.status',1)
    ->where('training_type.id',2)
    ->where('order_details.order_validity_date','>=',$current_date)
    ->where('order_details.remaining_sessions','Unlimited')
    ->get()->all();

    $schedule_booking=DB::table('bootcamp_booking')
    ->where('customer_id',$customer_id)->where('bootcamp_plan_shedules_id',$schedule_id)->whereNull('deleted_at')->first();

    if(!empty($schedule_booking))
    {
      $already_booked='booked';
      return json_encode($already_booked);
    }
    elseif($remaining_session_notunlimited>0)
    {
      return json_encode($remaining_session_notunlimited);
    }
    elseif(count($remaining_session_unlimited)>0)
    {
      $remaining_session_unlimited='Unlimited';
      return json_encode($remaining_session_unlimited);
    }
    else
    {
      return json_encode(0);
    }
    
    //Log::debug(" insert_bootcamp_plan data ".print_r(count($total_remaining_session),true));
    
  }

  public function add_bc_by_mastertrainer(Request $request)
  {
    //Log::debug(" insert_bootcamp_plan data ".print_r($request->all(),true));

    DB::beginTransaction();
    try
    {

      $today = Carbon::now();

      for($i=0;$i<count($request->customer_name);$i++)
      {
        $no_of_session_unlimited=DB::table('order_details')
        ->join('products','products.id','order_details.product_id')
        ->join('training_type','training_type.id','products.training_type_id')
        ->select('order_details.id as order_id','order_details.remaining_sessions as remaining_sessions')
        ->where('order_details.customer_id',$request->customer_id[$i])
        ->where('order_details.status',1)
        ->where('training_type.id',2)
        ->where('order_details.order_validity_date','>=',$today)
        ->where('order_details.remaining_sessions','Unlimited')
        ->orderBy('order_details.order_validity_date', 'ASC')->first();

        $no_of_session_notunlimited=DB::table('order_details')
        ->join('products','products.id','order_details.product_id')
        ->join('training_type','training_type.id','products.training_type_id')
        ->select('order_details.id as order_id','order_details.remaining_sessions as remaining_sessions')
        ->where('order_details.customer_id',$request->customer_id[$i])
        ->where('order_details.status',1)
        ->where('training_type.id',2)
        ->where('order_details.order_validity_date','>=',$today)
        ->where('order_details.remaining_sessions','>',0)
        ->orderBy('order_details.order_validity_date', 'ASC')->first();

        $no_of_session_free=DB::table('order_details')
        ->join('products','products.id','order_details.product_id')
        ->join('training_type','training_type.id','products.training_type_id')
        ->select('order_details.id as order_id','order_details.remaining_sessions as remaining_sessions','order_details.free_product as free_product')
        ->where('order_details.customer_id',$request->customer_id[$i])
        ->where('order_details.status',1)
        ->where('training_type.id',2)
        ->where('order_details.order_validity_date','>=',$today)
        ->where('order_details.remaining_sessions','>',0)
        ->where('order_details.free_product',1)
        ->orderBy('order_details.order_validity_date', 'ASC')->first();

        $bootcamp_booking_data['bootcamp_plan_shedules_id']=$request->schedule_id;
        $bootcamp_booking_data['customer_id']=$request->customer_id[$i];

        if(!empty($no_of_session_free))
        {
          $bootcamp_booking_data['free_product']=1;
          $bootcamp_booking_data['order_details_id']=$no_of_session_free->order_id;
          $decrease_remaining_session=DB::table('order_details')->where('id',$no_of_session_free->order_id)->where('remaining_sessions','>',0)->decrement('remaining_sessions',1);
        }
        elseif(!empty($no_of_session_notunlimited))
        { 
          $bootcamp_booking_data['order_details_id']=$no_of_session_notunlimited->order_id;
          $decrease_remaining_session=DB::table('order_details')->where('id',$no_of_session_notunlimited->order_id)->where('remaining_sessions','>',0)->decrement('remaining_sessions',1);
        }
        elseif(!empty($no_of_session_unlimited))
        {
          $bootcamp_booking_data['order_details_id']=$no_of_session_unlimited->order_id;
        }
        else
        {
          $bootcamp_booking_data['order_details_id']=time();
        }

        $bootcamp_booking_insert=DB::table('bootcamp_booking')->insert($bootcamp_booking_data);

        $bootcamp_plan_shedules_update=DB::table('bootcamp_plan_shedules')
        ->where('id',$request->schedule_id)->whereNull('deleted_at')->increment('no_of_uses', 1);

        $bootcamp_plan_shedules_details=DB::table('bootcamp_plan_shedules')
        ->where('id',$request->schedule_id)->whereNull('deleted_at')->first();
        $schedule_address=DB::table('bootcamp_plan_address')
        ->where('id',$bootcamp_plan_shedules_details->address_id)->first();

        $client_details=Customer::find($request->customer_id[$i]);

        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$client_details->name;
        $notifydata['customer_email']=$client_details->email;
        $notifydata['customer_phone']=$client_details->ph_no;
        $notifydata['status']='Book Bootcamp Session By Admin';
        $notifydata['session_booked_on']=$today;
        $notifydata['session_booking_date']=$bootcamp_plan_shedules_details->plan_date;
        $notifydata['session_booking_day']=$bootcamp_plan_shedules_details->plan_day;
        $notifydata['session_booking_time']=date('h:i A', strtotime($bootcamp_plan_shedules_details->plan_st_time)).' to '.date('h:i A', strtotime($bootcamp_plan_shedules_details->plan_end_time));
        $notifydata['cancelled_reason']='';
        $notifydata['schedule_address']=$schedule_address->address_line1;

        $client_details->notify(new BootcampSessionNotification($notifydata));
      }
    DB::commit();
    return redirect()->back()->with('booking_success','All customers booking are successfully done!');
  }
  catch(\Exception $e) {
    DB::rollback();
    return abort(200);
  }
  }

public function bootcamp_plan()
{ 
  try{
  $form_address=DB::table('bootcamp_plan_address')->select('id','address_line1')->get();
  return view('trainer.add_bootcamp_plan')->with(compact('form_address'));
  }
   catch(\Exception $e) {
       return abort(200);
   }
}

public function insert_bootcamp_plan(Request $request)
{
 //Log::debug(" insert_bootcamp_plan data ".print_r($request->all(),true));
  DB::beginTransaction();
   try{
  $mon_flg=$tue_flg=$wed_flg=$thu_flg=$fri_flg=$sat_flg=$sun_flg=7;

  // set flg for check day of week
  if($request->has('mon_session_flg')){ $bootcamp_data['mon_session_flg']=1; $mon_flg=1;}
  if($request->has('tue_session_flg')){ $bootcamp_data['tue_session_flg']=1; $tue_flg=2;}
  if($request->has('wed_session_flg')){ $bootcamp_data['wed_session_flg']=1; $wed_flg=3;}
  if($request->has('thu_session_flg')){ $bootcamp_data['thu_session_flg']=1; $thu_flg=4;}
  if($request->has('fri_session_flg')){ $bootcamp_data['fri_session_flg']=1; $fri_flg=5;}
  if($request->has('sat_session_flg')){ $bootcamp_data['sat_session_flg']=1; $sat_flg=6;}
  if($request->has('sun_session_flg')){ $bootcamp_data['sun_session_flg']=1; $sun_flg=0;}

  if($request->address!='')
  {
    $location_address_data['address_line1']=$request->address;
    $location_address_data['street_number']=$request->street_number;
    $location_address_data['route']=$request->route;
    $location_address_data['city']=$request->city;
    $location_address_data['state']=$request->state;
    $location_address_data['postal_code']=$request->postal_code;
    $location_address_data['country']=$request->country;
    $location_address_data['lat']=$request->lat;
    $location_address_data['lng']=$request->lng;
    $bootcamp_address=DB::table('bootcamp_plan_address')->insert($location_address_data);
    $address_id=DB::getPdo()->lastInsertId();
  }
  elseif($request->address_select!='')
  {
    $address_id=$request->address_select;
  }

  $bootcamp_data['session_st_time']=date("H:i:s", strtotime($request->session_st_time));
  $bootcamp_data['session_end_time']=date("H:i:s", strtotime($request->session_end_time));
  $bootcamp_data['plan_st_date']=$request->plan_st_date;
  if($request->has('never_expire'))
  {
    $bootcamp_data['plan_end_date']='2099-12-30';
    $bootcamp_data['never_expire']=1;
  }
  else
  {
    $bootcamp_data['plan_end_date']=$request->plan_end_date;
  }
  
  $bootcamp_data['max_allowed']=$request->max_allowed;
  $bootcamp_data['address_id']=$address_id;
  $bootcamp_data['status']=1;

  $bootcamp_details=DB::table('bootcamp_plans')->insert($bootcamp_data);
  $bootcamp_id=DB::getPdo()->lastInsertId();

  //calculate difference between start date and end date
  $datetime = new \DateTime($bootcamp_data['plan_end_date']);
  $datetimest = new \DateTime($bootcamp_data['plan_st_date']);
  $enddate=$datetime->modify('+1 day')->format('Y-m-d');

  $period = new \DatePeriod(
     new \DateTime($request->plan_st_date),
     new \DateInterval('P1D'),
     new \DateTime($enddate)
    );
 
  // all day and date calculating
  $all_session_date=$all_session_day=[];
  foreach ($period as $key=>$value) 
  {
    if($key<=180)
    {
      $dateofweek = $value->format('Y-m-d');
      $dayofweek = date('w', strtotime($value->format('Y-m-d')));

      if($mon_flg==$dayofweek)
      {
        $all_session_date[]=$dateofweek;
        $all_session_day[]='Monday';        
      }
      elseif($tue_flg==$dayofweek)
      {
        $all_session_date[]=$dateofweek;
        $all_session_day[]='Tuesday'; 
      }
      elseif($wed_flg==$dayofweek)
      {
        $all_session_date[]=$dateofweek;
        $all_session_day[]='Wednesday';
      }
      elseif($thu_flg==$dayofweek)
      {
        $all_session_date[]=$dateofweek;
        $all_session_day[]='Thursday';
      }
      elseif($fri_flg==$dayofweek)
      {
        $all_session_date[]=$dateofweek;
        $all_session_day[]='Friday';
      }
      elseif($sat_flg==$dayofweek)
      {
        $all_session_date[]=$dateofweek;
        $all_session_day[]='Saturday';
      }
      elseif($sun_flg==$dayofweek)
      {
        $all_session_date[]=$dateofweek;
        $all_session_day[]='Sunday';
      }
      
    }
  }

  //Log::debug(" insert_bootcamp_plan day ".print_r($all_session_day,true));
  //Log::debug(" insert_bootcamp_plan date ".print_r($all_session_date,true));

  for($i=0;$i<count($all_session_date);$i++)
  {
    $schedule_data['bootcamp_plan_id']=$bootcamp_id;
    $schedule_data['plan_date']=$all_session_date[$i];
    $schedule_data['plan_day']=$all_session_day[$i];
    $schedule_data['plan_st_time']=date("H:i:s", strtotime($request->session_st_time));
    $schedule_data['plan_end_time']=date("H:i:s", strtotime($request->session_end_time));
    $schedule_data['address_id']=$address_id;
    $schedule_data['max_allowed']=$request->max_allowed;
    $schedule_data['no_of_uses']=0;
    $schedule_data['status']=1;
    $schedule_inser=DB::table('bootcamp_plan_shedules')->insert($schedule_data);
  }

  DB::commit();
  return redirect('trainer/bootcamp-plan')->with("success","You have successfully added a bootcamp plan.");
   }
   catch(\Exception $e) {
     DB::rollback();
       return abort(200);
   }
  
}

public function bootcamp_plan_list()
{
  try{
  
  $bootcamp_details=DB::table('bootcamp_plans')
  ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plans.address_id')
  ->select('bootcamp_plans.id as bootcamp_id','bootcamp_plans.mon_session_flg as monday','bootcamp_plans.tue_session_flg as tuesday','bootcamp_plans.wed_session_flg as wednesday','bootcamp_plans.thu_session_flg as thursday','bootcamp_plans.fri_session_flg as friday','bootcamp_plans.sat_session_flg as saturday','bootcamp_plans.sun_session_flg as sunday','bootcamp_plans.session_st_time as session_st_time','bootcamp_plans.session_end_time as session_end_time','bootcamp_plans.plan_st_date as plan_st_date','bootcamp_plans.plan_end_date as plan_end_date','bootcamp_plans.never_expire as never_expire','bootcamp_plans.max_allowed as max_allowed','bootcamp_plans.status as status','bootcamp_plan_address.address_line1 as address','bootcamp_plans.deleted_at')
  ->orderby('bootcamp_plans.id','DESC')->get();
    return view('trainer.bootcamp_plan_list')->with(compact('bootcamp_details'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}


public function bootcamp_plan_edit_view($id)
{
  try{
    
    $plan_id=\Crypt::decrypt($id);
    $form_address=DB::table('bootcamp_plan_address')->select('id','address_line1')->get(); 

    $edit_bootcamp= DB::table('bootcamp_plans')->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plans.address_id')->select('bootcamp_plans.id as bootcamp_plan_id','bootcamp_plans.mon_session_flg as mon_session_flg','bootcamp_plans.tue_session_flg as tue_session_flg','bootcamp_plans.wed_session_flg as wed_session_flg','bootcamp_plans.thu_session_flg as thu_session_flg','bootcamp_plans.fri_session_flg as fri_session_flg','bootcamp_plans.sat_session_flg as sat_session_flg','bootcamp_plans.sun_session_flg as sun_session_flg','bootcamp_plans.session_st_time as session_st_time','bootcamp_plans.session_end_time as session_end_time','bootcamp_plans.address_id as address_id','bootcamp_plans.plan_st_date as plan_st_date','bootcamp_plans.plan_end_date as plan_end_date','bootcamp_plans.never_expire as never_expire','bootcamp_plans.max_allowed as max_allowed','bootcamp_plan_address.address_line1 as address_line1')->where('bootcamp_plans.id',$plan_id)->first();
      //Log::debug(" edit_bootcamp ".print_r($edit_bootcamp,true));

      return view("trainer.editbootcamp")->with(compact('edit_bootcamp','form_address'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}
  public function bootcamp_plan_edit_insert(Request $request)
{
  //Log::debug(" data bootcamp_plan_edit_insert ".print_r($request->all(),true));

  DB::beginTransaction();
  try
  {

    if($request->has('never_expire'))
    {
      $edit_data['plan_end_date']='2099-12-30';
      $edit_data['never_expire']=1;
    }
    else
    {
      $edit_data['plan_end_date']=$request->plan_end_date;
    }

    // start if date is decrease from the previous end date of this plan
  
    $previous_plan_end_date=DB::table('bootcamp_plans')->where('id',$request->id)->whereNull('deleted_at')->pluck('plan_end_date')->first();

    if($previous_plan_end_date>$edit_data['plan_end_date'])
    {
      $prevenddate = new \DateTime($previous_plan_end_date);
      $prevenddate=$prevenddate->modify('+1 day')->format('Y-m-d');

      $curenddate = new \DateTime($request->plan_end_date);
      $curenddate=$curenddate->modify('+1 day')->format('Y-m-d');

      $period = new \DatePeriod(
         new \DateTime($curenddate),
         new \DateInterval('P1D'),
         new \DateTime($prevenddate)
        );

      $all_session_date=[];
      foreach ($period as $key=>$value) 
      {
        $all_session_date[]=$value->format('Y-m-d');              
      }

      $all_booking_schedule=DB::table('bootcamp_plan_shedules')->whereIn('plan_date',$all_session_date)->where('no_of_uses','>',0)->whereNull('deleted_at')->where('bootcamp_plan_id',$request->id)->get()->all();

      if(count($all_booking_schedule)>0)
      {

        $all_booking_schedule_id=[];
        foreach ($all_booking_schedule as $all_booking) 
        {
          $all_booking_schedule_id[]=$all_booking->id;              
        }

        //Log::debug(" all_booking_schedule_id ".print_r($all_booking_schedule_id,true));

        $customer_details=DB::table('bootcamp_booking')->join('customers','customers.id','bootcamp_booking.customer_id')->whereIn('bootcamp_booking.bootcamp_plan_shedules_id',$all_booking_schedule_id)->get()->all();

        $today = Carbon::now();

        $all_customers=DB::table('customers')
        ->join('bootcamp_booking','bootcamp_booking.customer_id','customers.id')
        ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
        ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
        ->select('customers.id as customer_id','customers.name as customer_name','customers.ph_no as customer_ph_no','customers.email as customer_email','bootcamp_booking.created_at as booked_on','bootcamp_plan_shedules.plan_date as shedule_date','bootcamp_plan_shedules.plan_st_time as plan_st_time','bootcamp_plan_shedules.plan_end_time as plan_end_time','bootcamp_plan_shedules.plan_day as plan_day','bootcamp_plan_address.address_line1')
        ->whereIn('bootcamp_booking.bootcamp_plan_shedules_id',$all_booking_schedule_id)
        ->get()->all();

        //Log::debug(" all_booking_schedule_id ".print_r($all_booking_schedule_id,true));

        $update_schedule=DB::table('bootcamp_plan_shedules')
        ->whereIn('id',$all_booking_schedule_id)->where('no_of_uses','>',0)->update(['deleted_at'=>Carbon::now()]);

        $delete_schedule=DB::table('bootcamp_plan_shedules')
        ->whereIn('plan_date',$all_session_date)->where('no_of_uses',0)->where('bootcamp_plan_id',$request->id)->delete();

        $cancelled_booking=DB::table('bootcamp_booking')
        ->whereIn('bootcamp_booking.bootcamp_plan_shedules_id',$all_booking_schedule_id)->update(['deleted_at'=>Carbon::now()]);

        $update_bootcamp_plan=DB::table('bootcamp_plans')->where('id',$request->id)->update($edit_data);

        foreach($all_customers as $each_customer)
        {
          $bookings=DB::table('bootcamp_booking')
          ->whereIn('bootcamp_plan_shedules_id',$all_booking_schedule_id)
          ->where('customer_id',$each_customer->customer_id)
          ->pluck('order_details_id');

          $return_sessions=DB::table('order_details')
          ->where('customer_id',$each_customer->customer_id)
          ->where('id',$bookings)
          ->increment('remaining_sessions',1);
          

          $notifydata['url'] = '/customer/mybooking';
          $notifydata['customer_name']=$each_customer->customer_name;
          $notifydata['customer_email']=$each_customer->customer_email;
          $notifydata['customer_phone']=$each_customer->customer_ph_no;
          $notifydata['status']='Changed End Date Bootcamp Session By Admin';
          $notifydata['session_booked_on']=$each_customer->booked_on;
          $notifydata['session_booking_date']=$each_customer->shedule_date;
          $notifydata['session_booking_day']=$each_customer->plan_day;
          $notifydata['session_booking_time']=date('h:i A', strtotime($each_customer->plan_st_time)).' to '.date('h:i A', strtotime($each_customer->plan_end_time));
          $notifydata['cancelled_reason']=$request->cancelled_reason;
          $notifydata['schedule_address']=$each_customer->address_line1;

          $client_details=Customer::find($each_customer->customer_id);

          $client_details->notify(new BootcampSessionNotification($notifydata));
        }
       
        DB::commit();
        return redirect('trainer/bootcamp-plan')->with("success","This plan end date is update successfully and mail send to all customer");
      }
      else
      {
        $update_bootcamp_schedule=DB::table('bootcamp_plan_shedules')->whereIn('plan_date',$all_session_date)
        ->where('bootcamp_plan_id',$request->id)->delete();

        $update_bootcamp_plan=DB::table('bootcamp_plans')->where('id',$request->id)->update($edit_data);

        DB::commit();
        return redirect('trainer/bootcamp-plan')->with("success","This plan end date is update successfully");
      }
    }
    // end

    // start if date is increase from the previous end date of this plan

    $mon_flg=$tue_flg=$wed_flg=$thu_flg=$fri_flg=$sat_flg=$sun_flg=7;

    // set flg for check day of week
    if($request->has('mon_session_flg')){ $mon_flg=1;}
    if($request->has('tue_session_flg')){ $tue_flg=2;}
    if($request->has('wed_session_flg')){ $wed_flg=3;}
    if($request->has('thu_session_flg')){ $thu_flg=4;}
    if($request->has('fri_session_flg')){ $fri_flg=5;}
    if($request->has('sat_session_flg')){ $sat_flg=6;}
    if($request->has('sun_session_flg')){ $sun_flg=0;}

    if($previous_plan_end_date<$edit_data['plan_end_date'])
    {
    
      //calculate difference between start date and end date
      $datetimest = new \DateTime($request->plan_end_date);
      $currenddate=$datetimest->modify('+1 day')->format('Y-m-d');

      $period = new \DatePeriod(
         new \DateTime($request->plan_st_date),
         new \DateInterval('P1D'),
         new \DateTime($currenddate)
        );
      $all_session_date=$all_session_day=[];

      $prev_last_date=DB::table('bootcamp_plan_shedules')->where('bootcamp_plan_id',$request->id)->orderby('id','DESC')->whereNull('deleted_at')->pluck('plan_date')->first();

      foreach ($period as $key=>$value) 
      {
        if($key<=180 && $prev_last_date<$value->format('Y-m-d'))
        {
          $dateofweek = $value->format('Y-m-d');
          $dayofweek = date('w', strtotime($value->format('Y-m-d')));

          if($mon_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Monday';        
          }
          elseif($tue_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Tuesday'; 
          }
          elseif($wed_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Wednesday';
          }
          elseif($thu_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Thursday';
          }
          elseif($fri_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Friday';
          }
          elseif($sat_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Saturday';
          }
          elseif($sun_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Sunday';
          } 
        }
      }

      //Log::debug(" insert_bootcamp_plan day ".print_r($all_session_day,true));
      //Log::debug(" insert_bootcamp_plan date ".print_r($all_session_date,true));
      
      for($i=0;$i<count($all_session_date);$i++)
      {
        
        $schedule_data['bootcamp_plan_id']=$request->id;
        $schedule_data['plan_date']=$all_session_date[$i];
        $schedule_data['plan_day']=$all_session_day[$i];
        $schedule_data['plan_st_time']=date("H:i:s", strtotime($request->session_st_time));
        $schedule_data['plan_end_time']=date("H:i:s", strtotime($request->session_end_time));
        $schedule_data['address_id']=$request->address_select;
        $schedule_data['max_allowed']=$request->max_allowed;
        $schedule_data['no_of_uses']=0;
        $schedule_data['status']=1;

        $schedule_insert=DB::table('bootcamp_plan_shedules')->insert($schedule_data);
      } 
      $update_bootcamp_plan=DB::table('bootcamp_plans')->where('id',$request->id)->update($edit_data);   
      DB::commit();
      return redirect('trainer/bootcamp-plan')->with("success","This plan end date is update successfully");
    }

      DB::commit();
      return redirect('trainer/bootcamp-plan')->with("success","You dont change any data of this plan");
  }catch(\Exception $e) {
      DB::rollback();
      return abort(200);
    }
}

public function bootcamp_plan_delete($id)
{
  DB::beginTransaction();
  try{
    
    $plan_details=DB::table('bootcamp_plans')->where('id',$id)->first();

    $today=date('Y-m-d');
    $plan_end_date=$plan_details->plan_end_date;
    $plan_end_date = new \DateTime($plan_end_date);
    $plan_end_date=$plan_end_date->modify('+1 day')->format('Y-m-d');

    $period = new \DatePeriod(
         new \DateTime($today),
         new \DateInterval('P1D'),
         new \DateTime($plan_end_date)
        );

    $all_session_date=[];
    foreach ($period as $key=>$value) 
    {
      $all_session_date[]=$value->format('Y-m-d');              
    }

    $all_booking_schedule_date=DB::table('bootcamp_plan_shedules')->whereIn('plan_date',$all_session_date)->where('no_of_uses','>',0)->where('bootcamp_plan_id',$id)->pluck('plan_date');

    if(count($all_booking_schedule_date)>0)
    {

      $last_booking_date=$all_booking_schedule_date[count($all_booking_schedule_date)-1];

      $no_booking_schedule_date=DB::table('bootcamp_plan_shedules')->where('plan_date','>',$last_booking_date)->where('bootcamp_plan_id',$id)->pluck('plan_date');


      $first_no_booking_schedule_date=$no_booking_schedule_date[0];
      $last_no_booking_schedule_date=$no_booking_schedule_date[count($no_booking_schedule_date)-1];

      DB::commit();
      return view('trainer.bootcamp_plan_booking_delete')->with(compact('last_booking_date','first_no_booking_schedule_date','last_no_booking_schedule_date','plan_details'));
    }
    else
    {
      $bootcamp_plan_delete['deleted_at']=Carbon::now();

      DB::table('bootcamp_plans')->where('id',$id)->update($bootcamp_plan_delete);

      DB::table('bootcamp_plan_shedules')->whereIn('plan_date',$all_session_date)
        ->where('bootcamp_plan_id',$id)->where('no_of_uses',0)->delete();

      DB::table('bootcamp_plan_shedules')->whereIn('plan_date',$all_session_date)
        ->where('bootcamp_plan_id',$id)->where('no_of_uses','>',0)->update($bootcamp_plan_delete);

     DB::commit();
      return redirect('trainer/bootcamp-plan')->with("success","You have successfully deleted one bootcamp plan");
    }
}
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}
public function bootcamp_plan_final_delete(Request $request)
{
  //Log::debug(" bootcamp_plan_final_delete ".print_r($request->all(),true));
  DB::beginTransaction();
  try{

  $all_booking_schedule_cancele=DB::table('bootcamp_plan_shedules')->where('plan_date','>=',$request->delete_date)->where('no_of_uses','>',0)->where('bootcamp_plan_id',$request->plan_id)->update(['deleted_at'=>Carbon::now()]);

  $all_booking_schedule_delete=DB::table('bootcamp_plan_shedules')->where('plan_date','>=',$request->delete_date)->where('no_of_uses',0)->where('bootcamp_plan_id',$request->plan_id)->delete();

  $all_booking_schedule_id=DB::table('bootcamp_plan_shedules')->where('plan_date','>=',$request->delete_date)->where('no_of_uses','>',0)->where('bootcamp_plan_id',$request->plan_id)->pluck('id');

  // $plan_delete=DB::table('bootcamp_plans')->where('id',$request->plan_id)->update(['deleted_at'=>Carbon::now()]);

$plan_delete=DB::table('bootcamp_plans')->where('id',$request->plan_id)->update(['bootcamp_plans.plan_end_date',$request->delete_date]);

  $all_customers=DB::table('customers')
  ->join('bootcamp_booking','bootcamp_booking.customer_id','customers.id')
  ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
  ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
  ->select('customers.id as customer_id','customers.name as customer_name','customers.ph_no as customer_ph_no','customers.email as customer_email','bootcamp_booking.created_at as booked_on','bootcamp_plan_shedules.plan_date as shedule_date','bootcamp_plan_shedules.plan_st_time as plan_st_time','bootcamp_plan_shedules.plan_end_time as plan_end_time','bootcamp_plan_shedules.plan_day as plan_day','bootcamp_plan_address.address_line1')
  ->whereIn('bootcamp_booking.bootcamp_plan_shedules_id',$all_booking_schedule_id)
  ->get()->all();


  foreach($all_customers as $each_customer)
  {

    $bookings=DB::table('bootcamp_booking')
    ->whereIn('bootcamp_plan_shedules_id',$all_booking_schedule_id)
    ->where('customer_id',$each_customer->customer_id)
    ->pluck('order_details_id');

    $return_sessions=DB::table('order_details')
    ->where('customer_id',$each_customer->customer_id)
    ->where('id',$bookings)
    ->increment('remaining_sessions',1);

    $notifydata['url'] = '/customer/mybooking';
    $notifydata['customer_name']=$each_customer->customer_name;
    $notifydata['customer_email']=$each_customer->customer_email;
    $notifydata['customer_phone']=$each_customer->customer_ph_no;
    $notifydata['status']='Changed End Date Bootcamp Session By Admin';
    $notifydata['session_booked_on']=$each_customer->booked_on;
    $notifydata['session_booking_date']=$each_customer->shedule_date;
    $notifydata['session_booking_day']=$each_customer->plan_day;
    $notifydata['session_booking_time']=date('h:i A', strtotime($each_customer->plan_st_time)).' to '.date('h:i A', strtotime($each_customer->plan_end_time));
    $notifydata['cancelled_reason']='';
    $notifydata['schedule_address']=$each_customer->address_line1;

    $client_details=Customer::find($each_customer->customer_id);

    $client_details->notify(new BootcampSessionNotification($notifydata));
  }

  DB::commit();
  return redirect('trainer/bootcamp-plan')->with("success","You have successfully deleted one bootcamp plan");
  }
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}
  

  public function bootcamp_plan_schedule(Request $request)
  {
    $now = Carbon::now()->toDateString();
    $all_schedules=DB::table('bootcamp_plan_shedules')
    ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
    ->select('bootcamp_plan_shedules.id as schedule_id','bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_plan_shedules.max_allowed','bootcamp_plan_shedules.no_of_uses','bootcamp_plan_shedules.bootcamp_plan_id','bootcamp_plan_shedules.deleted_at');

    if($request->option=='future_schedule')
      {
      $all_schedules=$all_schedules->where('bootcamp_plan_shedules.plan_date','>=',$now);
      }
      elseif($request->option=='past_schedule')
      {
        $all_schedules=$all_schedules->where('bootcamp_plan_shedules.plan_date','<',$now);
      }
      elseif($request->option=='cancelled_schedule')
      {
        $all_schedules=$all_schedules->whereNotNull('bootcamp_plan_shedules.deleted_at');
      }
      elseif($request->option=='future_booking')
      {
        $all_schedules=$all_schedules->join('bootcamp_booking','bootcamp_booking.bootcamp_plan_shedules_id','bootcamp_plan_shedules.id')->where('bootcamp_plan_shedules.plan_date','>=',$now)->whereNull('bootcamp_booking.deleted_at');
      }
      elseif($request->option=='past_booking')
      {
        $all_schedules=$all_schedules->join('bootcamp_booking','bootcamp_booking.bootcamp_plan_shedules_id','bootcamp_plan_shedules.id')->where('bootcamp_plan_shedules.plan_date','<',$now)->whereNull('bootcamp_booking.deleted_at');
      }
      elseif($request->option=='cancelled_booking')
      {
        $all_schedules=$all_schedules->join('bootcamp_booking','bootcamp_booking.bootcamp_plan_shedules_id','bootcamp_plan_shedules.id')->whereNotNull('bootcamp_booking.deleted_at')->where('bootcamp_booking.cancelled_by','>',0);
      }
      elseif($request->option=='declined_booking')
      {
        $all_schedules=$all_schedules->join('bootcamp_booking','bootcamp_booking.bootcamp_plan_shedules_id','bootcamp_plan_shedules.id')->whereNotNull('bootcamp_plan_shedules.deleted_at')->where('bootcamp_booking.cancelled_by',0);
      }
      else
      {
        $all_schedules=$all_schedules;
      }

      $all_schedules=$all_schedules->get();
  
    return view('trainer.bootcamp_plan_schedule_list')->with(compact('all_schedules','now'));
  }

  public function bootcamp_schedule_edit_view($id)
  {
    try{
     
    
    $schedule_id=\Crypt::decrypt($id);

    $all_schedules=DB::table('bootcamp_plan_shedules')
    ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
    ->select('bootcamp_plan_shedules.id as schedule_id','bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_plan_shedules.max_allowed','bootcamp_plan_shedules.no_of_uses','bootcamp_plan_shedules.bootcamp_plan_id','bootcamp_plan_shedules.deleted_at')->where('bootcamp_plan_shedules.id',$schedule_id)->first();
  
    return view('trainer.bootcamp_plan_schedule_edit')->with(compact('all_schedules'));
    }
  catch(\Exception $e) {
    return abort(200);
  }
}

public function update_bootcamp_plan_schedules(Request $request)
{
   DB::beginTransaction();
    try{
  
  $schedule_id=$request->schedule_id;

  $today = Carbon::now();

      $all_customers=DB::table('customers')
      ->join('bootcamp_booking','bootcamp_booking.customer_id','customers.id')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('customers.id as customer_id','customers.name as customer_name','customers.ph_no as customer_ph_no','customers.email as customer_email','bootcamp_booking.created_at as booked_on','bootcamp_plan_shedules.plan_date as shedule_date','bootcamp_plan_shedules.plan_st_time as plan_st_time','bootcamp_plan_shedules.plan_end_time as plan_end_time','bootcamp_plan_shedules.plan_day as plan_day','bootcamp_plan_address.address_line1')
      ->whereIn('bootcamp_booking.bootcamp_plan_shedules_id',$schedule_id)->get()->all();
      


  $schedules_data['plan_st_time']=date("H:i:s", strtotime($request->session_st_time));
  $schedules_data['plan_end_time']=date("H:i:s", strtotime($request->session_end_time));
 

  $schedules_data['updated_at']=Carbon::now();
  DB::table('bootcamp_plan_shedules')->where('id',$schedule_id)->update($schedules_data);

foreach($all_customers as $each_customer)
      {
        $bookings=DB::table('bootcamp_booking')
        ->whereIn('bootcamp_plan_shedules_id',$request->schedule_id)
        ->where('customer_id',$each_customer->customer_id)
        ->pluck('order_details_id');       
        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$each_customer->customer_name;
        $notifydata['customer_email']=$each_customer->customer_email;
        $notifydata['customer_phone']=$each_customer->customer_ph_no;
        $notifydata['status']='Bootcamp Session Time Change By Admin';
        $notifydata['session_booked_on']=$each_customer->booked_on;
        $notifydata['session_booking_date']=$each_customer->shedule_date;
        $notifydata['session_booking_day']=$each_customer->plan_day;
        $notifydata['session_booking_time']=date('h:i A', strtotime($request->session_st_time)).' to '.date('h:i A', strtotime($request->session_end_time));
        $notifydata['cancelled_reason']='';
        $notifydata['schedule_address']=$each_customer->address_line1;

        $client_details=Customer::find($each_customer->customer_id);

        $client_details->notify(new BootcampSessionNotification($notifydata));
      }



   DB::commit();
  return redirect('trainer/bootcamp-plan-schedule')->with("success","You have successfully updated schedule time");
  }
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }

}

  public function bootcamp_schedule_cancelled_admin(Request $request)
  {
    //Log::debug(" bootcamp_schedule_cancelled_admin ".print_r($request->all(),true));
    DB::beginTransaction();
    try
    {

      $today = Carbon::now();

      $all_customers=DB::table('customers')
      ->join('bootcamp_booking','bootcamp_booking.customer_id','customers.id')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('customers.id as customer_id','customers.name as customer_name','customers.ph_no as customer_ph_no','customers.email as customer_email','bootcamp_booking.created_at as booked_on','bootcamp_plan_shedules.plan_date as shedule_date','bootcamp_plan_shedules.plan_st_time as plan_st_time','bootcamp_plan_shedules.plan_end_time as plan_end_time','bootcamp_plan_shedules.plan_day as plan_day','bootcamp_plan_address.address_line1')
      ->whereIn('bootcamp_booking.bootcamp_plan_shedules_id',$request->cancele_schedule)
      ->get()->all();

      $cancelled_schedule=DB::table('bootcamp_plan_shedules')
      ->whereIn('id',$request->cancele_schedule)->update(['deleted_at'=>Carbon::now()]);

      $cancelled_booking=DB::table('bootcamp_booking')
      ->whereIn('bootcamp_booking.bootcamp_plan_shedules_id',$request->cancele_schedule)->update(['deleted_at'=>Carbon::now()]);

      foreach($all_customers as $each_customer)
      {
        $bookings=DB::table('bootcamp_booking')
        ->whereIn('bootcamp_plan_shedules_id',$request->cancele_schedule)
        ->where('customer_id',$each_customer->customer_id)
        ->pluck('order_details_id');

        $return_sessions=DB::table('order_details')
        ->where('customer_id',$each_customer->customer_id)
        ->where('id',$bookings)
        ->where('remaining_sessions','!=','Unlimited')
        ->increment('remaining_sessions',1);
      //Log::debug(" bootcamp_schedule_cancelled_admin 2 ".print_r($return_sessions,true));

        $decrease_schedule_uses=DB::table('bootcamp_plan_shedules')
        ->whereIn('id',$request->cancele_schedule)->where('no_of_uses','>',0)->decrement('no_of_uses',1);


        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$each_customer->customer_name;
        $notifydata['customer_email']=$each_customer->customer_email;
        $notifydata['customer_phone']=$each_customer->customer_ph_no;
        $notifydata['status']='Declined Bootcamp Session By Admin';
        $notifydata['session_booked_on']=$each_customer->booked_on;
        $notifydata['session_booking_date']=$each_customer->shedule_date;
        $notifydata['session_booking_day']=$each_customer->plan_day;
        $notifydata['session_booking_time']=date('h:i A', strtotime($each_customer->plan_st_time)).' to '.date('h:i A', strtotime($each_customer->plan_end_time));
        $notifydata['cancelled_reason']=$request->cancelled_reason;
        $notifydata['schedule_address']=$each_customer->address_line1;

        $client_details=Customer::find($each_customer->customer_id);

        $client_details->notify(new BootcampSessionNotification($notifydata));
      }

      //Log::debug(" bootcamp_schedule_cancelled_admin 2 ".print_r($all_customers,true));
    DB::commit();
    return redirect()->back();
  }
  catch(\Exception $e) {
    DB::rollback();
    return abort(200);
  }
}


 public function bootcamp_schedule_cancelled_admin2(Request $request)
  {
    
    DB::beginTransaction();
    try
    {

  $data=$request->get('data');
  $id=$data['id'];

   $comment=$data['comment'];
   Log::debug(" id  ".print_r($id,true));
   Log::debug(" comment  ".print_r($comment,true));
    Log::debug(" data  ".print_r($data,true));
      $today = Carbon::now();

      $all_customers=DB::table('customers')
      ->join('bootcamp_booking','bootcamp_booking.customer_id','customers.id')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('customers.id as customer_id','customers.name as customer_name','customers.ph_no as customer_ph_no','customers.email as customer_email','bootcamp_booking.created_at as booked_on','bootcamp_plan_shedules.plan_date as shedule_date','bootcamp_plan_shedules.plan_st_time as plan_st_time','bootcamp_plan_shedules.plan_end_time as plan_end_time','bootcamp_plan_shedules.plan_day as plan_day','bootcamp_plan_address.address_line1')
      ->where('bootcamp_booking.bootcamp_plan_shedules_id',$id)
      ->get()->all();

      $cancelled_schedule=DB::table('bootcamp_plan_shedules')
      ->where('id',$id)->update(['deleted_at'=>Carbon::now()]);

      $cancelled_booking=DB::table('bootcamp_booking')
      ->where('bootcamp_booking.bootcamp_plan_shedules_id',$id)->update(['deleted_at'=>Carbon::now()]);

      foreach($all_customers as $each_customer)
      {
        $bookings=DB::table('bootcamp_booking')
        ->where('bootcamp_plan_shedules_id',$id)
        ->where('customer_id',$each_customer->customer_id)
        ->pluck('order_details_id');

        $return_sessions=DB::table('order_details')
        ->where('customer_id',$each_customer->customer_id)
        ->where('id',$bookings)
        ->where('remaining_sessions','!=','Unlimited')
        ->increment('remaining_sessions',1);
      //Log::debug(" bootcamp_schedule_cancelled_admin 2 ".print_r($return_sessions,true));

        $decrease_schedule_uses=DB::table('bootcamp_plan_shedules')
        ->where('id',$id)->where('no_of_uses','>',0)->decrement('no_of_uses',1);


        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$each_customer->customer_name;
        $notifydata['customer_email']=$each_customer->customer_email;
        $notifydata['customer_phone']=$each_customer->customer_ph_no;
        $notifydata['status']='Declined Bootcamp Session By Admin';
        $notifydata['session_booked_on']=$each_customer->booked_on;
        $notifydata['session_booking_date']=$each_customer->shedule_date;
        $notifydata['session_booking_day']=$each_customer->plan_day;
        $notifydata['session_booking_time']=date('h:i A', strtotime($each_customer->plan_st_time)).' to '.date('h:i A', strtotime($each_customer->plan_end_time));
        $notifydata['cancelled_reason']=$comment;
        $notifydata['schedule_address']=$each_customer->address_line1;

        $client_details=Customer::find($each_customer->customer_id);

        $client_details->notify(new BootcampSessionNotification($notifydata));
      }

      //Log::debug(" bootcamp_schedule_cancelled_admin 2 ".print_r($all_customers,true));
     DB::commit();
    return redirect()->back();
  }
  catch(\Exception $e) {
    DB::rollback();
    return abort(200);
  }
}


  public function bootcamp_booking_individual_cancelled($id)
  {
    try
    {
      $schedule_id=\Crypt::decrypt($id);

      $allcustomer=DB::table('bootcamp_booking')
      ->join('customers','customers.id','bootcamp_booking.customer_id')
      ->select('customers.id as customer_id','customers.name as customer_name','customers.email as customer_email','customers.ph_no as customer_phone','bootcamp_booking.bootcamp_plan_shedules_id as schedule_id','bootcamp_booking.deleted_at')
      ->where('bootcamp_booking.bootcamp_plan_shedules_id',$schedule_id)->get();

      $shedule_details=DB::table('bootcamp_plan_shedules')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('bootcamp_plan_shedules.plan_date as shedule_date','bootcamp_plan_shedules.plan_st_time as plan_st_time','bootcamp_plan_shedules.plan_end_time as plan_end_time','bootcamp_plan_shedules.plan_day as plan_day','bootcamp_plan_address.address_line1')
      ->where('bootcamp_plan_shedules.id',$schedule_id)->first();

      //Log::debug(":: allcustomer :: ".print_r($allcustomer,true));

      return view('trainer.schedule_list_for_cancele')->with(compact('allcustomer','shedule_details'));
    }
    catch(\Exception $e) {
      return abort(200);
    }
  }

  public function individual_bootcamp_cancele(Request $request)
  {
    
    $schedule_id=$customer_id=[];
    for($i=0;$i<count($request->cancele_schedule);$i++)
    {
      $all=explode('_',$request->cancele_schedule[$i]);
      $schedule_id[]=$all[0];
      $customer_id[]=$all[1];
    }

    // Log::debug(":: schedule_id :: ".print_r($schedule_id,true));
    // Log::debug(":: customer_id :: ".print_r($customer_id,true));
    DB::beginTransaction();
    try
    {

      $current_date=Carbon::now()->toDateString();

      $customer_booking_details=DB::table('bootcamp_booking')
      ->join('customers','customers.id','bootcamp_booking.customer_id')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('customers.id as customer_id','customers.name as customer_name','customers.email as customer_email','customers.ph_no as customer_phone','bootcamp_booking.bootcamp_plan_shedules_id as shedule_id','bootcamp_booking.deleted_at','bootcamp_booking.created_at as booked_on','bootcamp_plan_shedules.plan_date as shedule_date','bootcamp_plan_shedules.plan_st_time as plan_st_time','bootcamp_plan_shedules.plan_end_time as plan_end_time','bootcamp_plan_shedules.plan_day as plan_day','bootcamp_plan_address.address_line1','bootcamp_booking.order_details_id')
      ->whereIn('bootcamp_booking.bootcamp_plan_shedules_id',$schedule_id)
      ->whereIn('customers.id',$customer_id)
      ->get();

      foreach($customer_booking_details as $all_customers)
      {
        $cancelled_booking=DB::table('bootcamp_booking')->where('customer_id',$all_customers->customer_id)->where('bootcamp_plan_shedules_id',$all_customers->shedule_id)->update(['deleted_at'=>Carbon::now(),'cancelled_by'=>2]);

        $cancelled_booking_schedule=DB::table('bootcamp_plan_shedules')
        ->where('id',$all_customers->shedule_id)->where('no_of_uses','>',0)->decrement('no_of_uses',1);

        $increase_remaining_session=DB::table('order_details')->where('id',$all_customers->order_details_id)->where('remaining_sessions','!=','Unlimited')->increment('remaining_sessions',1);

        $client_details=Customer::find($all_customers->customer_id);

        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$client_details->name;
        $notifydata['customer_email']=$client_details->email;
        $notifydata['customer_phone']=$client_details->ph_no;
        $notifydata['status']='Cancelled Bootcamp Session By Admin';
        $notifydata['session_booked_on']=$all_customers->booked_on;
        $notifydata['session_booking_date']=$all_customers->shedule_date;
        $notifydata['session_booking_day']=$all_customers->plan_day;
        $notifydata['session_booking_time']=date('h:i A', strtotime($all_customers->plan_st_time)).' to '.date('h:i A', strtotime($all_customers->plan_end_time));
        $notifydata['cancelled_reason']='';
        $notifydata['schedule_address']=$all_customers->address_line1;

        $client_details->notify(new BootcampSessionNotification($notifydata));
      }
    //Log::debug(":: allcustomer :: ".print_r($allcustomer,true));
      DB::commit();
      return redirect()->back()->with("bootcamp_session_cancelled","You have successfully cancelled one session!");
    }
    catch(\Exception $e) {
      DB::rollback();
      return abort(200);
    }
  }


 public function bootcamp_schedule_delete($id)
  {
    
    $schedule_id=$customer_id=[];
    for($i=0;$i<count($request->cancele_schedule);$i++)
    {
      $all=explode('_',$request->cancele_schedule[$i]);
      $schedule_id[]=$all[0];
      $customer_id[]=$all[1];
    }

    // Log::debug(":: schedule_id :: ".print_r($schedule_id,true));
    // Log::debug(":: customer_id :: ".print_r($customer_id,true));
    DB::beginTransaction();
    try
    {

      $current_date=Carbon::now()->toDateString();

      $customer_booking_details=DB::table('bootcamp_booking')
      ->join('customers','customers.id','bootcamp_booking.customer_id')
      ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
      ->select('customers.id as customer_id','customers.name as customer_name','customers.email as customer_email','customers.ph_no as customer_phone','bootcamp_booking.bootcamp_plan_shedules_id as shedule_id','bootcamp_booking.deleted_at','bootcamp_booking.created_at as booked_on','bootcamp_plan_shedules.plan_date as shedule_date','bootcamp_plan_shedules.plan_st_time as plan_st_time','bootcamp_plan_shedules.plan_end_time as plan_end_time','bootcamp_plan_shedules.plan_day as plan_day','bootcamp_plan_address.address_line1','bootcamp_booking.order_details_id')
      ->whereIn('bootcamp_booking.bootcamp_plan_shedules_id',$schedule_id)
      ->whereIn('customers.id',$customer_id)
      ->get();

      foreach($customer_booking_details as $all_customers)
      {
        $cancelled_booking=DB::table('bootcamp_booking')->where('customer_id',$all_customers->customer_id)->where('bootcamp_plan_shedules_id',$all_customers->shedule_id)->update(['deleted_at'=>Carbon::now(),'cancelled_by'=>2]);

        $cancelled_booking_schedule=DB::table('bootcamp_plan_shedules')
        ->where('id',$all_customers->shedule_id)->where('no_of_uses','>',0)->decrement('no_of_uses',1);

        $increase_remaining_session=DB::table('order_details')->where('id',$all_customers->order_details_id)->where('remaining_sessions','!=','Unlimited')->increment('remaining_sessions',1);

        $client_details=Customer::find($all_customers->customer_id);

        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$client_details->name;
        $notifydata['customer_email']=$client_details->email;
        $notifydata['customer_phone']=$client_details->ph_no;
        $notifydata['status']='Cancelled Bootcamp Session By Admin';
        $notifydata['session_booked_on']=$all_customers->booked_on;
        $notifydata['session_booking_date']=$all_customers->shedule_date;
        $notifydata['session_booking_day']=$all_customers->plan_day;
        $notifydata['session_booking_time']=date('h:i A', strtotime($all_customers->plan_st_time)).' to '.date('h:i A', strtotime($all_customers->plan_end_time));
        $notifydata['cancelled_reason']='';
        $notifydata['schedule_address']=$all_customers->address_line1;

        $client_details->notify(new BootcampSessionNotification($notifydata));
      }
    //Log::debug(":: allcustomer :: ".print_r($allcustomer,true));
      DB::commit();
      return redirect()->back()->with("bootcamp_session_cancelled","You have successfully cancelled one session!");
    }
    catch(\Exception $e) {
      DB::rollback();
      return abort(200);
    }
  }
  

////Common diet plan controller////

  //Show common diet plan list
  public function common_diet_plan()
  {
    $diet = DB::table('common_diet_plan')->whereNull('deleted_at')->orderby('id','DESC')->get();
    return view('trainer.common-diet-plan', compact('diet'));
  }

  //Add new diet plan
   public function add_common_diet_plan()
  {
    return view('trainer.add-common-diet-plan'); 
  }

  public function insert_common_diet_plan(Request $request)
  {
  
    try
    {
    
      $data['diet_plan_name'] = $request->diet_plan_name;
      $data['description'] = $request->description;
      $data['video'] = $request->video;
      if($request->common_diet_image!="")
      {
        $image=$request->common_diet_image;
        $folder="backend/common_diet_plan_images/"; 
        $extension=$image->getClientOriginalExtension(); 
        $image_name=time()."common_diet_plan_images.".$extension; 
        $upload=$image->move($folder,$image_name); 
        $data['image']=$image_name; 
      }
      if($request->hasFile('diet_plan_pdf'))
      {
        $pdf=$request->diet_plan_pdf;
        $folder="backend/common_diet_plan_images/"; 
        $extension=$pdf->getClientOriginalExtension(); 
        $pdf_name=time()."common_diet_plan_pdf.".$extension; 
        $upload=$pdf->move($folder,$pdf_name); 
        $data['diet_plan_pdf']=$pdf_name; 
      }
      $data['price'] = $request->price;
      $data['author_name'] = $request->author_name;
      // $data['author_designation'] = $request->author_designation;
      if($request->author_image!="")
      {
        $auth_image=$request->author_image;
        $folder="backend/common_diet_plan_images/"; 
        $extension=$auth_image->getClientOriginalExtension(); 
        $image_name=time()."common_diet_plan_auther_images.".$extension; 
        $upload=$auth_image->move($folder,$image_name); 
        $data['author_image']=$image_name; 
      }

      $data['inserted_by'] = Auth::user()->id;
      DB::table('common_diet_plan')->insert($data);
        
      return redirect('trainer/common-diet-plan')->with("success","You have successfully added a diet plan.");
    }
    catch(\Exception $e) 
    {
      return abort(200);
    }
  }

  //Delete diet plan from list
  public function delete_common_diet_plan($id)
  {
    try{
    
      $updatedata['deleted_at']=Carbon::now();
      DB::table('common_diet_plan')->where('id',$id)->update($updatedata);
      return redirect('trainer/common-diet-plan')->with("delete","One diet plan is deleted successfully !");
    }
    catch(\Exception $e) {
      return abort(200);
    }
  }

  //Edit common diet plan
  public function edit_common_diet_plan($id)
  {
    try{
      $diet= DB::table('common_diet_plan')->find($id);
      return view ("trainer.edit-common-diet-plan",compact('diet'));
    }
    catch(\Exception $e) {
        return abort(200);
    }
  }

  public function update_common_diet_plan(Request $request)
  { 
    try
    {
      $data['diet_plan_name']=$request->diet_plan_name;
      $data['description']=$request->description;
      if($request->common_diet_image!="")
        {
          $image=$request->common_diet_image;
          $folder="backend/common_diet_plan_images/"; 
          $extension=$image->getClientOriginalExtension(); 
          $image_name=time()."common_diet_plan_images.".$extension; 
          $upload=$image->move($folder,$image_name); 
          $data['image']=(isset($request->video) && !empty($request->video)) ? null : $image_name; 
        }
      else
      {
        $data['image']= (isset($request->video) && !empty($request->video)) ? null : $request->oldimage; 
      }
      $data['video']=(isset($request->video) && !empty($request->video)) ? $request->video : null;
      if($request->diet_plan_pdf!="")
        {
          $pdf=$request->diet_plan_pdf;
          $folder="backend/common_diet_plan_images/"; 
          $extension=$pdf->getClientOriginalExtension(); 
          $pdf_name=time()."common_diet_plan_pdf.".$extension; 
          $upload=$pdf->move($folder,$pdf_name); 
          $data['diet_plan_pdf']=$pdf_name; 
        }
      $data['price'] = $request->price;
      $data['author_name'] = $request->author_name;
      // $data['author_designation'] = $request->author_designation;
      if($request->author_image!="")
        {
          $auth_image=$request->author_image;
          $folder="backend/common_diet_plan_images/"; 
          $extension=$auth_image->getClientOriginalExtension(); 
          $image_name=time()."common_diet_plan_auther_images.".$extension; 
          $upload=$auth_image->move($folder,$image_name); 
          $data['author_image']=$image_name; 
        }


      $data['inserted_by'] = Auth::user()->id;
      $data['updated_by'] = Auth::user()->id;
      $data['updated_at'] = Carbon::now();

      DB::table('common_diet_plan')->where('id',$request->id)->update($data);
      return redirect('trainer/common-diet-plan')->with("editsuccess","You have successfully update your diet plan");
    }
    catch(\Exception $e) {
      return abort(200);
    }
  }

  function checkDietPlan_duplicate(Request $request)
  {
    
    $dietPlanName=$request->diet_plan_name;
    $dietPlanName=preg_replace('/\s+/', ' ', $dietPlanName);
    
    $dietPlanList=DB::table('common_diet_plan')->where('diet_plan_name',$dietPlanName)->whereNull('deleted_at')->count();

    if($dietPlanList>0)  {  return 1;  }
    else  {   return 0;   }
  }

  function check_editDietPlan_duplicate(Request $request)
  {
    $dietPlanName=$request->diet_plan_name;
    $dietPlanName=preg_replace('/\s+/', ' ', $dietPlanName);

    $all_diet_plan=DB::table('common_diet_plan')->where('id','!=',$request->id)->whereNull('deleted_at')->get()->all();

    $duplicate_diet_plan=0;
    foreach($all_diet_plan as $each_diet_plan)
    {
      if($each_diet_plan->diet_plan_name==$dietPlanName)
      {
        $duplicate_diet_plan=1;
      }
    }

    if($duplicate_diet_plan==1)  { return 1;  }
    else  {  return 0; }
  }

public function searchslots(Request $request)
{
  

  $query = $request->get('term','');   
  $products=DB::table('slots')->whereNull('deleted_at')
  ->where('slots_name','LIKE','%'.$query.'%')
  ->get();
        $data=array();
         $data1=array();

  foreach ($products as $product) {
               
          // $data[]=array('value'=>$product->email,'id'=>$product->id);
    $data[]=array('value'=>$product->slots_name,'id'=>$product->id, 'slots_number'=>$product->slots_number,'slots_price'=>$product->slots_price, 'slots_validity'=>$product->slots_validity );       
  }
  if(count($data))  {  return $data; }
  else{   $data1[]=array('value'=>'No Result Found');   return $data1;   } 
}

public function add_coupon()
{
  try{
  
    $slots = DB::table('slots')->get()->all();
    return view('trainer.addcoupon')->with(compact('slots'));
  }
  catch(\Exception $e) {
    return abort(200);
  } 
}

public function coupon_insert(Request $request)
{
//Log::debug(" data customer_email ".print_r($request->all(),true)); 

  try{

    $daterange=$request->daterange; 
    $mode_of_date=explode(" - ",$daterange);
    $format = 'Y-m-d';
    $startDate=$mode_of_date[0];
    $endDate=$mode_of_date[1];
      
    $cupon_data['slots_id']=$request->apply_slots; 
    $cupon_data['coupon_code']=$request->coupon_code;
    $cupon_data['discount_price']=$request->discount_price;
    $cupon_data['valid_from']=$startDate;
    $cupon_data['valid_to']= $endDate;
    $cupon_data['is_active']=$request->is_active;
      
    DB::table('slots_discount_coupon')->insert($cupon_data);
  
    return redirect('trainer/our_coupon_list')->with("success","You have successfully added one coupon");
  }
  catch(\Exception $e) {
      return abort(200);
  }
  
}

function duplicatecoupon(Request $request)
  {
    
    $duplicatecoupon=$request->coupon_code;
    $apply_slots=$request->apply_slots;
    $duplicatecoupon=preg_replace('/\s+/', ' ', $duplicatecoupon);
    
    $duplicatecoupon_details=DB::table('slots_discount_coupon')->where('coupon_code',$duplicatecoupon)->where('slots_id',$apply_slots)->whereNull('slots_discount_coupon.deleted_at')->count();

    if($duplicatecoupon_details>0) {  return 1;  }
    else   {    return 0;  }
  }

public function our_coupon_list(Request $request)
{
   try{
  
    $all_cupon_data=DB::table('slots_discount_coupon')->join('slots','slots.id','slots_discount_coupon.slots_id')->select('slots_discount_coupon.id as coupon_id','slots_discount_coupon.coupon_code','slots_discount_coupon.discount_price','slots_discount_coupon.valid_from','slots_discount_coupon.valid_to','slots_discount_coupon.is_active','slots.id as slots_id','slots.slots_name as slots_name')->whereNull('slots_discount_coupon.deleted_at')->get()->all();
    return view('trainer.viewcoupon')->with(compact('all_cupon_data'));
  }catch(\Exception $e) { 
    return abort(200);
  }
}


public function our_coupon_edit_view($id)
{
  
  try{
  
    $edit_coupondata= DB::table('slots_discount_coupon')->join('slots','slots.id','slots_discount_coupon.slots_id')->select('slots_discount_coupon.id','slots_discount_coupon.coupon_code','slots_discount_coupon.discount_price','slots_discount_coupon.valid_from','slots_discount_coupon.valid_to','slots.id as slots_id','slots.slots_name as slots_name','slots_discount_coupon.is_active')->where('slots_discount_coupon.id',$id)->first();
    return view ("trainer.editcoupon")->with(compact('edit_coupondata'));
  }
  catch(\Exception $e) {
      return abort(200);
  }

}

public function coupon_edit_insert(Request $request)
{
  try{
    $daterange=$request->daterange; 
    $mode_of_date=explode(" - ",$daterange);
    $format = 'Y-m-d';
    $startDate=$mode_of_date[0];
    $endDate=$mode_of_date[1];
  
    $edit_coupondata['slots_id']=$request->slots_id;
    $edit_coupondata['coupon_code']=$request->coupon_code;
    $edit_coupondata['discount_price']=$request->discount_price;
    $edit_coupondata['valid_from']=$startDate;
    $edit_coupondata['valid_to']=$endDate;
    $edit_coupondata['is_active']=$request->is_active;
    $edit_coupondata['updated_at']=Carbon::now();
    DB::table('slots_discount_coupon')->where('id',$request->id)->update($edit_coupondata);
  
    return redirect('trainer/our_coupon_list')->with("success","You have successfully updated one coupon");
  }
  catch(\Exception $e) {
    return abort(200);
  }
}

function duplicatecoupon_edit(Request $request)
  {
    
    $duplicatecoupon_edit=$request->coupon_code;
    $apply_slots=$request->slots_id;
    $duplicatecoupon_edit=preg_replace('/\s+/', ' ', $duplicatecoupon_edit);
    
    $edit_coupon=DB::table('slots_discount_coupon')->where('id',$request->id)->where('slots_id',$apply_slots)->whereNull('slots_discount_coupon.deleted_at')->pluck('coupon_code');
    $all_coupon=DB::table('slots_discount_coupon')->where('id','!=',$request->id)->where('slots_id',$apply_slots)->whereNull('slots_discount_coupon.deleted_at')->get()->all();

    $duplicate_cat=0;
    foreach($all_coupon as $each_coupon)
    {
      if($each_coupon->coupon_code==$duplicatecoupon_edit)
      {
        $duplicate_cat=1;
      }
    }
    if($duplicate_cat==1)  {  return 1;  }
    else  {  return 0;  }
  }

public function coupon_delete($id)
{
  try{
  
    $coupon_delete['deleted_at']=Carbon::now();

    DB::table('slots_discount_coupon')->where('id',$id)->update($coupon_delete);
    return redirect('trainer/our_coupon_list')->with("success","You have successfully deleted one coupon");
  }
  catch(\Exception $e) {
      return abort(200);
  }
}

function checkdiscount_price(Request $request)
  {
    
    $discount_price=$request->discount_price;
    $apply_slots=$request->apply_slots;
    $discount_price=preg_replace('/\s+/', ' ', $discount_price);
    
    $checkdiscount_price=DB::table('slots')->where('slots.id',$apply_slots)->whereNull('slots.deleted_at')->value('slots_price');
 
    if($discount_price >= $checkdiscount_price  )  {  return 2;   }
    else   {     return 0;   }
  }

function checkdiscount_price_edit(Request $request)
  {
    
    $discount_price=$request->discount_price;
    $apply_slots=$request->slots_id;
    $discount_price=preg_replace('/\s+/', ' ', $discount_price);

    $checkdiscount_price=DB::table('slots')->where('slots.id',$apply_slots)->whereNull('slots.deleted_at')->value('slots_price');

    if($discount_price >= $checkdiscount_price  )  {   return 2;  }
    else   {  return 0;  }
  }

  public function diet_plan_purchases(Request $request)
{
  
   try{
 
      $diet_plan_purchases=DB::table('common_diet_plan_purchases_history')->join('customers','customers.id','common_diet_plan_purchases_history.plan_purchase_by')->join('common_diet_plan','common_diet_plan.id','common_diet_plan_purchases_history.plan_id')->select('common_diet_plan_purchases_history.id as diet_plan_id','common_diet_plan_purchases_history.plan_name as plan_name','common_diet_plan_purchases_history.plan_price as plan_price','common_diet_plan_purchases_history.plan_purchase_by as plan_purchase_by','common_diet_plan_purchases_history.payment_reference_id as payment_reference_id','common_diet_plan_purchases_history.purchase_date as purchase_date', 'common_diet_plan_purchases_history.status as status','common_diet_plan.diet_plan_name as diet_plan_name','common_diet_plan.id as common_diet_plan_id','customers.id as customers_id','customers.name as customers_name')->get();

      return view('trainer.diet_plan_purchases_history')->with(compact('diet_plan_purchases'));
    }
    catch(\Exception $e) {
      return abort(200);
    }
}

public function add_product()
{
  try{
    $all_traning_type=DB::table('training_type')->where('id',1)->orwhere('id',2)->get();
    $all_payment_type=DB::table('payment_type')->get();
    $all_slot_time=DB::table('slot_times')->get();
    return view('trainer/add_product')->with(compact('all_traning_type','all_payment_type','all_slot_time'));
  }
  catch(\Exception $e) {
      return abort(200);
  }
}

public function insert_product(Request $request)
{
  
  try{
    $products_data['training_type_id']=$request->training_type;
    $products_data['payment_type_id']=$request->payment_type;
    if($request->submit == 'Save')
    {
      $products_data['status']=0;
    }
    else{
      $products_data['status']=1;
    }
  
    if($request->payment_type == 1)
    {
      $products_data['total_sessions']=$request->no_session;
       $products_data['price_session_or_month']=$request->price;
       $products_data['total_price']=$request->final_total_price;
       $products_data['validity_value']=$request->validity;
       $products_data['validity_duration']=$request->validity_2;
    }
    else if($request->payment_type == 2)
    {

      if($request->has('session_unlimited'))
    {
      $products_data['total_sessions']='Unlimited';
    }
    elseif($request->no_session_mon!='')
    {
      $products_data['total_sessions']=$request->no_session_mon;
    }

     $products_data['price_session_or_month']=$request->sub_price;
     $products_data['total_price']=$request->anual_total_price;
     $products_data['contract']=$request->contract;
     $products_data['notice_period_value']=$request->notice_period;
    $products_data['notice_period_duration']=$request->notice_period_2;
    }

    $insert_products=DB::table('products')->insert($products_data);
    return redirect('trainer/all-products')->with("success","You have successfully added one package");
  }
  catch(\Exception $e) {
      return abort(200);
  }

}

public function edit_product($id)
{

  try{
    $product_id=\Crypt::decrypt($id);
    $all_traning_type=DB::table('training_type')->get();
    $all_payment_type=DB::table('payment_type')->get();
    $all_slot_time=DB::table('slot_times')->get();

    $product_details=DB::table('products')
    ->join('training_type','products.training_type_id','training_type.id')
    ->join('payment_type','products.payment_type_id','payment_type.id')
    ->select('products.id as product_id','training_type.training_name as training_name','training_type.id as training_type_id','payment_type.payment_type_name as payment_type_name','payment_type.id as payment_type_id','products.total_sessions as total_sessions','products.price_session_or_month as price_session_or_month','products.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration')
    ->where('products.id',$product_id)
    ->first();

    return view('trainer.edit_product')->with(compact('product_details','all_traning_type','all_payment_type','all_slot_time','product_day'));
  }
  catch(\Exception $e) {
      return abort(200);
   }
}

public function update_product(Request $request)
{

  try{
    $products_data['training_type_id']=$request->training_type;
    $products_data['payment_type_id']=$request->payment_type;

    if($request->payment_type == 1)
    {
      $products_data['total_sessions']=$request->no_session;
       $products_data['price_session_or_month']=$request->price;
       $products_data['total_price']=$request->final_total_price;
       $products_data['validity_value']=$request->validity;
       $products_data['validity_duration']=$request->validity_2;
       if($request->save == 'Save')
    {
      $products_data['status']=0;
    }
    else{
      $products_data['status']=1;
    }
    }
    else if($request->payment_type == 2)
    {

      if($request->save == 'Save')
    {
      $products_data['status']=0;
    }
    else{
      $products_data['status']=1;
    }
      if($request->has('session_unlimited'))
    {
      $products_data['total_sessions']='Unlimited';
    }
    elseif($request->no_session!='')
    {
      $products_data['total_sessions']=$request->no_session;
    }
    
     $products_data['price_session_or_month']=$request->price;
     $products_data['total_price']=$request->final_total_price;
     $products_data['contract']=$request->contract;
     $products_data['notice_period_value']=$request->notice_period;
     $products_data['notice_period_duration']=$request->notice_period_2;
    }

    $update_products=DB::table('products')->where('id',$request->product_id)->update($products_data);
    
    return redirect('trainer/all-products')->with("success","You have successfully updated one package");
  }
   catch(\Exception $e) {
      return abort(200);
   }

}

public function product_delete($id)
{
  try{
  $delete_data['deleted_at']=Carbon::now();
  $delete_product=DB::table('products')->where('id',$id)->update($delete_data);
  
  return redirect('trainer/all-products')->with("success","You have successfully deleted one package");
  }
  catch(\Exception $e) {
      return abort(200);
   }

}


public function view_product(Request $request)
{
   try{
  

    $all_products_data=DB::table('products')
    ->join('training_type','products.training_type_id','training_type.id')
    ->join('payment_type','products.payment_type_id','payment_type.id')
    ->select('products.id as product_id','products.payment_type_id as payment_type_id','products.deleted_at as deleted_at','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.price_session_or_month as price_session_or_month','products.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.status as status','products.notice_period_duration as notice_period_duration',(DB::raw('products.validity_value * products.validity_duration  as validity')),(DB::raw('products.notice_period_value * products.notice_period_duration  as notice_period')))
    ->orderby('products.id','DESC')->get();

    return view('trainer.allproducts')->with(compact('all_products_data','products_day_time','products_st_time','products_end_time'));
  }catch(\Exception $e) { 
    return abort(200);
  }
}


public function order_history(Request $request)
{
   try{
  
  $all_order_history=DB::table('order_details')->join('products','products.id','order_details.product_id')->join('payment_history','payment_history.id','order_details.payment_id')->join('training_type','training_type.id','products.training_type_id')->join('payment_type','payment_type.id','products.payment_type_id')->join('customers','customers.id','order_details.customer_id')->select('order_details.id as order_details_id','order_details.customer_id as customer_id','order_details.order_purchase_date as order_purchase_date','order_details.remaining_sessions as remaining_sessions','order_details.payment_type as payment_type','order_details.training_type as training_type','order_details.order_validity_date as order_validity_date','order_details.payment_option as payment_option','order_details.status as status','products.training_type_id as training_type_id', 'products.total_sessions as total_sessions', 'order_details.price_session_or_month as price_session_or_month','products.id as product_id','order_details.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','customers.name as customer_name','payment_type.payment_type_name as payment_type_name','payment_history.payment_id as payment_id','payment_history.description as description','payment_history.image as image','payment_history.status as payment_status')->whereNull('order_details.deleted_at')
  ->orderby('order_details.id','DESC')->get();

  // Log::debug(":: personal_training_product_details :: ".print_r($all_order_history,true));
  
  return view('trainer.customer_order_history')->with(compact('all_order_history'));
}catch(\Exception $e) { 
    return abort(200);
  }
}

public function active_order_by_admin($order_id)
{
  try{
  $order_id=\Crypt::decrypt($order_id);

  $order_history=DB::table('order_details')->join('products','products.id','order_details.product_id')->join('payment_history','payment_history.id','order_details.payment_id')->join('training_type','training_type.id','products.training_type_id')->join('payment_type','payment_type.id','products.payment_type_id')->join('customers','customers.id','order_details.customer_id')->select('order_details.id as order_details_id','order_details.customer_id as customer_id','order_details.order_purchase_date as order_purchase_date','order_details.remaining_sessions as remaining_sessions','order_details.payment_type as payment_type','order_details.training_type as training_type','order_details.order_validity_date as order_validity_date','order_details.payment_option as payment_option','order_details.status as status','products.training_type_id as training_type_id', 'products.total_sessions as total_sessions', 'order_details.price_session_or_month as price_session_or_month','products.id as product_id','order_details.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','customers.name as customer_name','payment_type.payment_type_name as payment_type_name','payment_history.payment_id as payment_id','payment_history.description as description','payment_history.image as image','payment_history.status as payment_status')->whereNull('order_details.deleted_at')
  ->where('order_details.id',$order_id)->first();
  return view('trainer.active_order_by_admin')->with(compact('order_history'));
  }
  catch(\Exception $e) { 
    return abort(200);
  }

}

public function active_order_success(Request $request)
{
    try{
  $update_order=DB::table('order_details')->where('id',$request->order_id)
  ->update(['order_validity_date'=>$request->order_validity_date]);
  return redirect()->back()->with('success','This order is successfully activate');
  }
   catch(\Exception $e) {
       return abort(200);
   }
}

public function deactive_order_by_admin($order_id)
{
  try{
  $order_id=\Crypt::decrypt($order_id);

  $order_history=DB::table('order_details')->join('products','products.id','order_details.product_id')->join('payment_history','payment_history.id','order_details.payment_id')->join('training_type','training_type.id','products.training_type_id')->join('payment_type','payment_type.id','products.payment_type_id')->join('customers','customers.id','order_details.customer_id')->select('order_details.id as order_details_id','order_details.customer_id as customer_id','order_details.order_purchase_date as order_purchase_date','order_details.remaining_sessions as remaining_sessions','order_details.payment_type as payment_type','order_details.training_type as training_type','order_details.order_validity_date as order_validity_date','order_details.payment_option as payment_option','order_details.status as status','products.training_type_id as training_type_id', 'products.total_sessions as total_sessions', 'order_details.price_session_or_month as price_session_or_month','products.id as product_id','order_details.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','customers.name as customer_name','payment_type.payment_type_name as payment_type_name','payment_history.payment_id as payment_id','payment_history.description as description','payment_history.image as image','payment_history.status as payment_status')->whereNull('order_details.deleted_at')
  ->where('order_details.id',$order_id)->first();
  return view('trainer.deactive_order_by_admin')->with(compact('order_history'));
  }
  catch(\Exception $e) { 
    return abort(200);
  }

}

public function deactive_order_success(Request $request)
{
    try{
  $update_order=DB::table('order_details')->where('id',$request->order_id)
  ->update(['order_validity_date'=>$request->order_validity_date]);

  return redirect()->back()->with('success','This order is successfully de-activate');
  }
   catch(\Exception $e) {
       return abort(200);
   }
}

public function order_history_backend_request(Request $request)
{
  
    $data=$request->get('data');
    $purchased_history_id=$data['id'];
    $action=$data['action'];

    $order_details=DB::table('order_details')->where('id',$purchased_history_id)->first();

    $package_details=DB::table('products')
    ->join('training_type','training_type.id','products.training_type_id')
    ->join('payment_type','payment_type.id','products.payment_type_id')
    ->select('training_type.training_name as product_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.id as product_id','products.id as product_id',(DB::raw('products.validity_value * products.validity_duration  as validity')),'products.total_price as total_price','products.price_session_or_month as price_session_or_month','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration')
    ->where('products.id',$order_details->product_id)->first();

    $customer_details=Customer::find($order_details->customer_id);
    
    if($action=="Approve"){

    $update_purchases_history=DB::table('order_details')
    ->where('id',$purchased_history_id)->update(['status' =>1,'remaining_sessions'=>$order_details->no_of_sessions]);

    $update_payment_history=DB::table('payment_history')
    ->where('id',$order_details->payment_id)->update(['status'=> 'Success']);

    // send notification mail
      
      $notifydata['product_name'] =$package_details->product_name;
      $notifydata['no_of_sessions'] =$package_details->total_sessions;
      $notifydata['product_validity'] =$order_details->order_validity_date;
      $notifydata['product_purchase_date'] =$order_details->order_purchase_date;
      $notifydata['product_amount'] =$package_details->total_price;
      $notifydata['order_id'] =' ';
      $notifydata['payment_mode'] ='Bank Transfer';
      $notifydata['url'] = '/customer/purchased-history';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Bootcamp Bank Payment Approved';

      $customer_details->notify(new PlanPurchasedNotification($notifydata));

    return response()->json(1);
    }
    elseif($action=="Decline")
    {

    $update_payment_history=DB::table('payment_history')
    ->where('id',$order_details->payment_id)->update(['status'=> 'Decline']);

    // send notification mail

    $notifydata['product_name'] =$package_details->product_name;
      $notifydata['no_of_sessions'] =$package_details->total_sessions;
      $notifydata['product_validity'] =$order_details->order_validity_date;
      $notifydata['product_purchase_date'] =$order_details->order_purchase_date;
      $notifydata['product_amount'] =$package_details->total_price;
      $notifydata['order_id'] =' ';
      $notifydata['payment_mode'] ='Bank Transfer';
      $notifydata['url'] = '/customer/purchased-history';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Bootcamp Bank Payment Declined';

      $customer_details->notify(new PlanPurchasedNotification($notifydata));

    return response()->json(2);
    }
}


public function checked_bootcampdate(Request $request)
  {
   
    $bootcamp_plan_date=$request->plan_end_date;
    $bootcamp_plan_id=$request->id;
    
    $checked_bootcampdate=DB::table('bootcamp_plans')->join('bootcamp_plan_shedules','bootcamp_plan_shedules.bootcamp_plan_id','bootcamp_plans.id')->where('bootcamp_plan_shedules.plan_date','>',$bootcamp_plan_date)->where('bootcamp_plans.id',$bootcamp_plan_id)->where('bootcamp_plan_shedules.no_of_uses','>',0)->whereNull('bootcamp_plan_shedules.deleted_at')->count();
    //Log::debug(":: checked_bootcampdate :: ".print_r($checked_bootcampdate,true));
    if($checked_bootcampdate > 0)  {  return 1;  }
    else   {   return 0;  }
  }

  //all new personal training functions

  public function personal_training_plan_list()
  {
    try{
      
     $pt_plan_details=DB::table('personal_training_plans')
     ->join('bootcamp_plan_address','bootcamp_plan_address.id','personal_training_plans.address_id')
     ->join('personal_training_available_trainer','personal_training_available_trainer.personal_training_plan_id','personal_training_plans.id')
     ->join('personal_training_available_time','personal_training_available_time.personal_training_available_trainer_id','personal_training_available_trainer.id')
     ->join('users','users.id','personal_training_available_trainer.trainer_id')
     ->select('personal_training_plans.mon_session_flg','personal_training_plans.tue_session_flg','personal_training_plans.wed_session_flg','personal_training_plans.thu_session_flg','personal_training_plans.fri_session_flg','personal_training_plans.sat_session_flg','personal_training_plans.sun_session_flg','personal_training_plans.plan_st_date','personal_training_plans.plan_end_date','personal_training_plans.status','personal_training_available_trainer.trainer_id','personal_training_available_time.start_time_id','personal_training_available_time.end_time_id','bootcamp_plan_address.address_line1 as address','personal_training_plans.deleted_at','personal_training_plans.id as pt_plan_id','users.name as trainer_name')
     ->whereNull('personal_training_plans.deleted_at');


       if(Auth::user()->master_trainer==1)
      {
        $pt_plan_details=$pt_plan_details->get()->all();
      }
      else
      {
        $pt_plan_details=$pt_plan_details->where('users.id',Auth::user()->id)->get()->all();
      }
     foreach($pt_plan_details as $each_details)
     {
        $start_time=DB::table('slot_times')->where('id',$each_details->start_time_id)->value('time');
        $end_time=DB::table('slot_times')->where('id',$each_details->end_time_id)->value('time');

        $start_time=date('h:i A', strtotime($start_time));
        $end_time=date('h:i A', strtotime($end_time));

        $each_details->start_time=$start_time;
        $each_details->end_time=$end_time;
     }

     //Log::debug(" pt_plan_details data ".print_r($pt_plan_details,true));
      return view('trainer.personal_training_plan_list')->with(compact('pt_plan_details'));
    }
    catch(\Exception $e) {
      return abort(200);
    }
  }


  public function add_pt_plan()
  { 
    try
    {
      $form_address=DB::table('bootcamp_plan_address')->select('id','address_line1')->get()->all();
      $available_trainer=DB::table('users')->whereNull('deleted_at')
      ->where('is_active',1)->orderby('name','ASC')->get()->all();
      $available_time=DB::table('slot_times')->orderby('id','ASC')->get()->all();
      return view('trainer.add_pt_plan')->with(compact('form_address','available_trainer','available_time'));
    }
    catch(\Exception $e) {
         return abort(200);
    }
  }

  public function insert_pt_plan(Request $request)
  { //Log::debug(" insert_bootcamp_plan data ".print_r($request->all(),true));
    DB::beginTransaction();
    try{
      $mon_flg=$tue_flg=$wed_flg=$thu_flg=$fri_flg=$sat_flg=$sun_flg=7;

      // set flg for check day of week
      if($request->has('mon_session_flg')){ $pt_data['mon_session_flg']=1; $mon_flg=1;}
      if($request->has('tue_session_flg')){ $pt_data['tue_session_flg']=1; $tue_flg=2;}
      if($request->has('wed_session_flg')){ $pt_data['wed_session_flg']=1; $wed_flg=3;}
      if($request->has('thu_session_flg')){ $pt_data['thu_session_flg']=1; $thu_flg=4;}
      if($request->has('fri_session_flg')){ $pt_data['fri_session_flg']=1; $fri_flg=5;}
      if($request->has('sat_session_flg')){ $pt_data['sat_session_flg']=1; $sat_flg=6;}
      if($request->has('sun_session_flg')){ $pt_data['sun_session_flg']=1; $sun_flg=0;}

      if($request->address!='')
      {
        $location_address_data['address_line1']=$request->address;
        $location_address_data['street_number']=$request->street_number;
        $location_address_data['route']=$request->route;
        $location_address_data['city']=$request->city;
        $location_address_data['state']=$request->state;
        $location_address_data['postal_code']=$request->postal_code;
        $location_address_data['country']=$request->country;
        $location_address_data['lat']=$request->lat;
        $location_address_data['lng']=$request->lng;
        $bootcamp_address=DB::table('bootcamp_plan_address')->insert($location_address_data);
        $address_id=DB::getPdo()->lastInsertId();
      }
      elseif($request->address_select!='')
      {
        $address_id=$request->address_select;
      }

      $pt_data['plan_st_date']=$request->plan_st_date;
      if($request->has('never_expire'))
      {
        $pt_data['plan_end_date']='2099-12-30';
        $pt_data['never_expire']=1;
      }
      else
      {
        $pt_data['plan_end_date']=$request->plan_end_date;
      }
      $pt_data['address_id']=$address_id;
      $pt_data['status']=1;

      $pt_details=DB::table('personal_training_plans')->insert($pt_data);
      $pt_plan_id=DB::getPdo()->lastInsertId();

      $available_trainer_id=0;
      for($avt=0;$avt<count($request->trainer_id);$avt++)
      {
        $available_trainer_data['personal_training_plan_id']=$pt_plan_id;
        $available_trainer_data['trainer_id']=$request->trainer_id[$avt];

        if($available_trainer_data['trainer_id']!=$available_trainer_id)
        {
          $available_trainer_insert=DB::table('personal_training_available_trainer')->insert($available_trainer_data);
          $available_trainer_insert_id=DB::getPdo()->lastInsertId();
        }
        $available_trainer_id=$request->trainer_id[$avt];

        $available_time_data['personal_training_available_trainer_id']=$available_trainer_insert_id;
        $available_time_data['start_time_id']=$request->st_time_id[$avt];
        $available_time_data['end_time_id']=$request->end_time_id[$avt];
        $available_time_insert=DB::table('personal_training_available_time')->insert($available_time_data);
      }
      
     

     //calculate difference between start date and end date
      $datetime = new \DateTime($pt_data['plan_end_date']);
      $datetimest = new \DateTime($pt_data['plan_st_date']);
      $enddate=$datetime->modify('+1 day')->format('Y-m-d');

      $period = new \DatePeriod(
         new \DateTime($request->plan_st_date),
         new \DateInterval('P1D'),
         new \DateTime($enddate)
        );
     
      // all day and date calculating
      $all_session_date=$all_session_day=[];
      foreach ($period as $key=>$value) 
      {
        if($key<=180)
        {
          $dateofweek = $value->format('Y-m-d');
          $dayofweek = date('w', strtotime($value->format('Y-m-d')));

          if($mon_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Monday';        
          }
          elseif($tue_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Tuesday'; 
          }
          elseif($wed_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Wednesday';
          }
          elseif($thu_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Thursday';
          }
          elseif($fri_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Friday';
          }
          elseif($sat_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Saturday';
          }
          elseif($sun_flg==$dayofweek)
          {
            $all_session_date[]=$dateofweek;
            $all_session_day[]='Sunday';
          }
          
        }
      }

      for($i=0;$i<count($all_session_date);$i++)
      {
        $schedule_data['personal_training_plan_id']=$pt_plan_id;
        $schedule_data['plan_date']=$all_session_date[$i];
        $schedule_data['plan_day']=$all_session_day[$i];
        $schedule_data['address_id']=$address_id;
        $schedule_data['status']=1;

        for($avt1=0;$avt1<count($request->trainer_id);$avt1++)
        {
          $schedule_data['trainer_id']=$request->trainer_id[$avt1];
          for($a=$request->st_time_id[$avt1];$a<$request->end_time_id[$avt1]-3;$a++)
          {
            $schedule_data['plan_st_time_id']=$a;
            $schedule_data['plan_end_time_id']=$a+4;
            $schedule_inser=DB::table('personal_training_plan_schedules')->insert($schedule_data);
          }           
        }
        
      }
      DB::commit();
      return redirect('trainer/personal-training-plan')->with("success","You have successfully added a personal training plan.");
    }
    catch(\Exception $e) {
      DB::rollback();
      return abort(200);
    }

  }


  public function pt_plan_schedule(Request $request)
  {
    try{
    $now = Carbon::now()->toDateString();

    $all_schedules=DB::table('personal_training_plan_schedules')
    ->join('bootcamp_plan_address','bootcamp_plan_address.id','personal_training_plan_schedules.address_id')
    ->join('users','users.id','personal_training_plan_schedules.trainer_id')
    ->select('personal_training_plan_schedules.id as schedule_id','personal_training_plan_schedules.plan_date','personal_training_plan_schedules.plan_day','personal_training_plan_schedules.plan_st_time_id','personal_training_plan_schedules.plan_end_time_id','bootcamp_plan_address.address_line1','personal_training_plan_schedules.personal_training_plan_id','personal_training_plan_schedules.deleted_at','users.name as trainer_name');

    if(Auth::user()->master_trainer==1)
      {
        $all_schedules=$all_schedules;
      }
      else
      {
        $all_schedules=$all_schedules->where('users.id',Auth::user()->id);
      }

      if($request->option=='future_schedule')
      {
      $all_schedules=$all_schedules->where('personal_training_plan_schedules.plan_date','>=',$now);
      }
      elseif($request->option=='past_schedule')
      {
        $all_schedules=$all_schedules->where('personal_training_plan_schedules.plan_date','<',$now);
      }
      elseif($request->option=='cancelled_schedule')
      {
        $all_schedules=$all_schedules->whereNotNull('personal_training_plan_schedules.deleted_at');
      }
      elseif($request->option=='future_booking')
      {
        $all_schedules=$all_schedules->join('personal_training_booking','personal_training_booking.personal_training_plan_shedules_id','personal_training_plan_schedules.id')->where('personal_training_plan_schedules.plan_date','>=',$now);
      }
      elseif($request->option=='past_booking')
      {
        $all_schedules=$all_schedules->join('personal_training_booking','personal_training_booking.personal_training_plan_shedules_id','personal_training_plan_schedules.id')
        ->whereNull('personal_training_booking.deleted_at')
        ->where('personal_training_plan_schedules.plan_date','<',$now);
      }
      elseif($request->option=='cancelled_booking')
      {
        $all_schedules=$all_schedules->join('personal_training_booking','personal_training_booking.personal_training_plan_shedules_id','personal_training_plan_schedules.id')->where('personal_training_booking.cancelled_by','>',0);
      }
      elseif($request->option=='declined_booking')
      {
        $all_schedules=$all_schedules->join('personal_training_booking','personal_training_booking.personal_training_plan_shedules_id','personal_training_plan_schedules.id')->where('personal_training_booking.cancelled_by',0)->whereNotNull('personal_training_booking.deleted_at');
      }
      else
      {
        $all_schedules=$all_schedules;
      }


      $all_schedules=$all_schedules->get();

    foreach($all_schedules as $each_schedule)
     {
        $start_time=DB::table('slot_times')->where('id',$each_schedule->plan_st_time_id)->value('time');
        $end_time=DB::table('slot_times')->where('id',$each_schedule->plan_end_time_id)->value('time');
        $booking_seat=DB::table('personal_training_booking')
        ->join('customers','customers.id','personal_training_booking.customer_id')
        ->select('customers.name','customers.email','customers.ph_no')
        ->where('personal_training_booking.personal_training_plan_shedules_id',$each_schedule->schedule_id)
        ->whereNull('personal_training_booking.deleted_at')->first();

        if(empty($booking_seat))
        {
          $each_schedule->customer_name='';
          $each_schedule->customer_email='';
          $each_schedule->customer_ph_no='';
        }
        else
        {
          $each_schedule->customer_name=$booking_seat->name;
          $each_schedule->customer_email=$booking_seat->email;
          $each_schedule->customer_ph_no=$booking_seat->ph_no;
        }

        $each_schedule->start_time=$start_time;
        $each_schedule->end_time=$end_time;
        
     }
  
    return view('trainer.pt_plan_schedule_list')->with(compact('all_schedules','now'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}


  public function pt_schedule_trainer_edit($id)
  {
    try{
     
    
    $schedule_id=\Crypt::decrypt($id);

    $all_schedules=DB::table('personal_training_plan_schedules')
    ->join('bootcamp_plan_address','bootcamp_plan_address.id','personal_training_plan_schedules.address_id')
    ->join('users','users.id','personal_training_plan_schedules.trainer_id')
    ->select('personal_training_plan_schedules.id as schedule_id','personal_training_plan_schedules.plan_date','personal_training_plan_schedules.plan_day','bootcamp_plan_address.address_line1','personal_training_plan_schedules.personal_training_plan_id','personal_training_plan_schedules.deleted_at','personal_training_plan_schedules.plan_st_time_id','personal_training_plan_schedules.plan_end_time_id','users.name as trainer_name','users.id as trainer_id')->where('personal_training_plan_schedules.id',$schedule_id)->first();

    $start_time=DB::table('slot_times')->where('id',$all_schedules->plan_st_time_id)->value('time');
    $end_time=DB::table('slot_times')->where('id',$all_schedules->plan_end_time_id)->value('time');

    $available_time=DB::table('slot_times')->get()->all();

    $is_available=DB::table('personal_training_plan_schedules')->where('plan_st_time_id',$all_schedules->plan_st_time_id)->where('plan_date',$all_schedules->plan_date)->where('trainer_id','!=',$all_schedules->trainer_id)->pluck('trainer_id');

    $available_trainer=DB::table('users')->whereNull('deleted_at')
      ->where('is_active',1)->whereNotIn('id',$is_available)->orderby('name','ASC')->get()->all();

    $start_time=date('h:i A', strtotime($start_time));
    $end_time=date('h:i A', strtotime($end_time));

    $all_schedules->start_time=$start_time;
    $all_schedules->end_time=$end_time;
  
    return view('trainer.personal_training_plan_schedules_edit')->with(compact('all_schedules','available_time','available_trainer'));
    }
  catch(\Exception $e) {
    return abort(200);
  }
}

 public function update_pt_plan_schedules(Request $request)
  {
    //Log::debug(" update_pt_plan_schedules data ".print_r($request->all(),true));
    try
    {
  
      $schedule_id=$request->schedule_id;
      $today = Carbon::now();

      $all_schedules=DB::table('personal_training_plan_schedules')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','personal_training_plan_schedules.address_id')
      ->join('users','users.id','personal_training_plan_schedules.trainer_id')
      ->select('personal_training_plan_schedules.id as schedule_id','personal_training_plan_schedules.plan_date','personal_training_plan_schedules.plan_day','bootcamp_plan_address.address_line1','personal_training_plan_schedules.personal_training_plan_id','personal_training_plan_schedules.deleted_at','personal_training_plan_schedules.plan_st_time_id','personal_training_plan_schedules.plan_end_time_id','users.name as trainer_name','users.id as trainer_id')->where('personal_training_plan_schedules.id',$schedule_id)->first();

      $start_time=DB::table('slot_times')->where('id',$all_schedules->plan_st_time_id)->value('time');
      $end_time=DB::table('slot_times')->where('id',$all_schedules->plan_end_time_id)->value('time');

      $all_schedules->start_time=$start_time;
      $all_schedules->end_time=$end_time;

      DB::table('personal_training_plan_schedules')->where('id',$schedule_id)->update(['trainer_id'=>$request->trainer_id]);

      $is_booking=DB::table('personal_training_booking')->where('personal_training_plan_shedules_id',$schedule_id)->first();

      if(!empty($is_booking))
      {
        $client_details=Customer::find($is_booking->customer_id);
        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$client_details->name;
        $notifydata['customer_email']=$client_details->email;
        $notifydata['customer_phone']=$client_details->ph_no;
        $notifydata['status']='PT Schedule Trainer Change By Admin';
        $notifydata['session_booked_on']=$is_booking->created_at;
        $notifydata['session_booking_date']=$all_schedules->plan_date;
        $notifydata['session_booking_day']=$all_schedules->plan_day;
        $notifydata['session_booking_time']=date('h:i A', strtotime($all_schedules->start_time)).' to '.date('h:i A', strtotime($all_schedules->end_time));
        $notifydata['cancelled_reason']='';
        $notifydata['schedule_address']=$all_schedules->address_line1;

        $client_details->notify(new PersonalTrainingSessionNotification($notifydata));
      }
    
      return redirect('trainer/personal-training-plan-schedule')->with("trainer_change_success","You have successfully changed schedule trainer");
    }
    catch(\Exception $e) {
        return abort(200);
    }
  }



  public function pt_booking_cancel($id)
  {
    DB::beginTransaction();
    try{
       
      $now = Carbon::now()->toDateString();
      $schedule_id=$id;

      $schedules_details=DB::table('personal_training_plan_schedules')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','personal_training_plan_schedules.address_id')
      ->join('users','users.id','personal_training_plan_schedules.trainer_id')
      ->select('personal_training_plan_schedules.id as schedule_id','personal_training_plan_schedules.plan_date','personal_training_plan_schedules.plan_day','bootcamp_plan_address.address_line1','personal_training_plan_schedules.personal_training_plan_id','personal_training_plan_schedules.deleted_at','personal_training_plan_schedules.plan_st_time_id','personal_training_plan_schedules.plan_end_time_id','users.name as trainer_name','users.id as trainer_id')->where('personal_training_plan_schedules.id',$schedule_id)->first();

        $start_time=DB::table('slot_times')->where('id',$schedules_details->plan_st_time_id)->value('time');
        $end_time=DB::table('slot_times')->where('id',$schedules_details->plan_end_time_id)->value('time');

        $schedules_details->start_time=$start_time;
        $schedules_details->end_time=$end_time;

        $pt_booking_details=DB::table('personal_training_booking')
        ->where('personal_training_plan_shedules_id',$schedule_id)->first();

        if($pt_booking_details->deleted_at=='')
        {

          $delete_booking=DB::table('personal_training_booking')
          ->where('personal_training_plan_shedules_id',$schedule_id)->update(['cancelled_by'=>1,'deleted_at'=>$now]);

          $update_order=DB::table('order_details')
        ->where('id',$pt_booking_details->order_details_id)->increment('remaining_sessions',1);

        $client_details=Customer::find($pt_booking_details->customer_id);
        $trainer_details=User::find($schedules_details->trainer_id);

        $notifydata['url'] = '/customer/mybooking';
        $notifydata['url1'] = '/trainer/personal-training-plan-schedule';

        if($notifydata['url']=='/customer/mybooking')
        {
          $notifydata['url'] = '/customer/mybooking';
          $notifydata['customer_name']=$client_details->name;
          $notifydata['customer_email']=$client_details->email;
          $notifydata['customer_phone']=$client_details->ph_no;
          $notifydata['status']='Cancelled PT Session By Admin To Customer';
          $notifydata['session_booked_on']=date('d F Y', strtotime($pt_booking_details->created_at));
          $notifydata['session_booking_date']=$schedules_details->plan_date;
          $notifydata['session_booking_day']=$schedules_details->plan_day;
          $notifydata['session_booking_time']=date('h:i A', strtotime($schedules_details->start_time)).' to '.date('h:i A', strtotime($schedules_details->end_time));
          $notifydata['cancelled_reason']='';
          $notifydata['schedule_address']=$schedules_details->address_line1;

          $client_details->notify(new PersonalTrainingSessionNotification($notifydata));
        }
        if($notifydata['url1']=='/trainer/personal-training-plan-schedule')
        {
          $notifydata['url'] = '/trainer/personal-training-plan-schedule';
          $notifydata['trainer_name']=$trainer_details->name;
          $notifydata['trainer_email']=$trainer_details->email;
          $notifydata['trainer_phone']=$trainer_details->contact_no;
          $notifydata['status']='Cancelled PT Session By Admin To Trainer';
          $notifydata['session_booked_on']=date('d F Y', strtotime($pt_booking_details->created_at));
          $notifydata['session_booking_date']=$schedules_details->plan_date;
          $notifydata['session_booking_day']=$schedules_details->plan_day;
          $notifydata['session_booking_time']=date('h:i A', strtotime($schedules_details->start_time)).' to '.date('h:i A', strtotime($schedules_details->end_time));
          $notifydata['cancelled_reason']='';
          $notifydata['schedule_address']=$schedules_details->address_line1;
          $notifydata['booked_by_id']=$schedules_details->trainer_id;

          $trainer_details->notify(new PersonalTrainingSessionBookingNotification($notifydata));
        }
        
        DB::commit();
        return back()->with('cancelled_by_trainer_success',"One customer's booking cancel successfully done!");
      }
      else
      {
        DB::commit();
        return back()->with('cancelled_by_trainer_unsuccess',"This booking is already cancelled!");
      }
    }
    catch(\Exception $e) {
      DB::rollback();
      return abort(200);
    }
  }

  public function pt_single_schedule_delete(Request $request)
  {
    DB::beginTransaction();
    try{
       
      $data=$request->get('data');
      $schedule_id=$data['id'];
      
      $now = Carbon::now()->toDateString();

      //fetch delete schedule details
      $schedules_details=DB::table('personal_training_plan_schedules')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','personal_training_plan_schedules.address_id')
      ->join('users','users.id','personal_training_plan_schedules.trainer_id')
      ->select('personal_training_plan_schedules.id as schedule_id','personal_training_plan_schedules.plan_date','personal_training_plan_schedules.plan_day','bootcamp_plan_address.address_line1','personal_training_plan_schedules.personal_training_plan_id','personal_training_plan_schedules.deleted_at','personal_training_plan_schedules.plan_st_time_id','personal_training_plan_schedules.plan_end_time_id','users.name as trainer_name','users.id as trainer_id')->where('personal_training_plan_schedules.id',$schedule_id)->first();
      //end

        //fetch times of this schedule
        $start_time=DB::table('slot_times')->where('id',$schedules_details->plan_st_time_id)->value('time');
        $end_time=DB::table('slot_times')->where('id',$schedules_details->plan_end_time_id)->value('time');

        $schedules_details->start_time=$start_time;
        $schedules_details->end_time=$end_time;
        //end

        // check this schedule booking
        $pt_booking_details=DB::table('personal_training_booking')
        ->where('personal_training_plan_shedules_id',$schedule_id)->first();
        //end

        // check this schedule is already deleted by another one
      if($schedules_details->deleted_at=='')
      {
        // check any customer can booked this schedule and sent mail to customer and trainer
        if(!empty($pt_booking_details))
        {
          $delete_booking=DB::table('personal_training_booking')
          ->where('personal_training_plan_shedules_id',$schedule_id)->update(['deleted_at'=>$now]);

          $update_order=DB::table('order_details')
          ->where('id',$pt_booking_details->order_details_id)->increment('remaining_sessions',1);

          $client_details=Customer::find($pt_booking_details->customer_id);

          $notifydata['url'] = '/customer/mybooking';
          $notifydata['customer_name']=$client_details->name;
          $notifydata['customer_email']=$client_details->email;
          $notifydata['customer_phone']=$client_details->ph_no;
          $notifydata['status']='Single PT Schedule Delete By Admin To Customer';
          $notifydata['session_booked_on']=date('d F Y', strtotime($pt_booking_details->created_at));
          $notifydata['session_booking_date']=$schedules_details->plan_date;
          $notifydata['session_booking_day']=$schedules_details->plan_day;
          $notifydata['session_booking_time']=date('h:i A', strtotime($schedules_details->start_time)).' to '.date('h:i A', strtotime($schedules_details->end_time));
          $notifydata['cancelled_reason']='some reason';
          $notifydata['schedule_address']=$schedules_details->address_line1;

          $client_details->notify(new PersonalTrainingSessionNotification($notifydata));
          
        } //end check any customer can booked this schedule and sent mail to customer

        $trainer_details=User::find($schedules_details->trainer_id);

        $delete_schedule=DB::table('personal_training_plan_schedules')
        ->where('id',$schedule_id)->update(['deleted_at'=>$now]);

        $notifydata['url'] = '/trainer/personal-training-plan-schedule';
        $notifydata['trainer_name']=$trainer_details->name;
        $notifydata['trainer_email']=$trainer_details->email;
        $notifydata['trainer_phone']=$trainer_details->contact_no;
        $notifydata['status']='Single PT Schedule Delete By Admin To Trainer';
        $notifydata['session_booked_on']='';
        $notifydata['session_booking_date']=$schedules_details->plan_date;
        $notifydata['session_booking_day']=$schedules_details->plan_day;
        $notifydata['session_booking_time']=date('h:i A', strtotime($schedules_details->start_time)).' to '.date('h:i A', strtotime($schedules_details->end_time));
        $notifydata['cancelled_reason']='';
        $notifydata['schedule_address']=$schedules_details->address_line1;
        $notifydata['booked_by_id']=$schedules_details->trainer_id;

        $trainer_details->notify(new PersonalTrainingSessionBookingNotification($notifydata));
         

      DB::commit();
      return response()->json('success');
      } // end checking of this schedule is already deleted by another one
      else
      {
        DB::commit();
        return response()->json('unsuccess');
      }
    }
    catch(\Exception $e) {
      DB::rollback();
      return response()->json('something_wrong');
    }
  }


  public function pt_multiple_schedule_delete(Request $request)
  {
    //Log::debug(" bootcamp_schedule_cancelled_admin ".print_r($request->all(),true));
    DB::beginTransaction();
    try
    {

      $today = Carbon::now();

      $all_customers=DB::table('customers')
      ->join('personal_training_booking','personal_training_booking.customer_id','customers.id')
      ->join('personal_training_plan_schedules','personal_training_plan_schedules.id','personal_training_booking.personal_training_plan_shedules_id')
      ->join('bootcamp_plan_address','bootcamp_plan_address.id','personal_training_plan_schedules.address_id')
      ->select('customers.id as customer_id','customers.name as customer_name','customers.ph_no as customer_ph_no','customers.email as customer_email','personal_training_booking.created_at as booked_on','personal_training_plan_schedules.plan_date as shedule_date','personal_training_plan_schedules.plan_day as plan_day','bootcamp_plan_address.address_line1','personal_training_plan_schedules.plan_st_time_id','personal_training_plan_schedules.plan_end_time_id','personal_training_plan_schedules.trainer_id')
      ->whereIn('personal_training_booking.personal_training_plan_shedules_id',$request->cancele_schedule)
      ->get()->all();

      $cancelled_schedule=DB::table('personal_training_plan_schedules')
      ->whereIn('id',$request->cancele_schedule)->update(['deleted_at'=>Carbon::now()]);

      $cancelled_booking=DB::table('personal_training_booking')
      ->whereIn('personal_training_plan_shedules_id',$request->cancele_schedule)->update(['deleted_at'=>Carbon::now()]);

      foreach($all_customers as $each_customer)
      {

        $start_time=DB::table('slot_times')->where('id',$each_customer->plan_st_time_id)->value('time');
        $end_time=DB::table('slot_times')->where('id',$each_customer->plan_end_time_id)->value('time');

        $each_customer->start_time=$start_time;
        $each_customer->end_time=$end_time;


        $bookings=DB::table('personal_training_booking')
        ->whereIn('personal_training_plan_shedules_id',$request->cancele_schedule)
        ->where('customer_id',$each_customer->customer_id)
        ->pluck('order_details_id');

        $return_sessions=DB::table('order_details')
        ->where('customer_id',$each_customer->customer_id)
        ->where('id',$bookings)
        ->increment('remaining_sessions',1);
      //Log::debug(" bootcamp_schedule_cancelled_admin 2 ".print_r($return_sessions,true));

        $client_details=Customer::find($each_customer->customer_id);

        $notifydata['url'] = '/customer/mybooking';
        $notifydata['url1'] = '/trainer/personal-training-plan-schedule';

        if($notifydata['url']=='/customer/mybooking')
        {

          $notifydata['url'] = '/customer/mybooking';
          $notifydata['customer_name']=$each_customer->customer_name;
          $notifydata['customer_email']=$each_customer->customer_email;
          $notifydata['customer_phone']=$each_customer->customer_ph_no;
          $notifydata['status']='Single PT Schedule Delete By Admin To Customer';
          $notifydata['session_booked_on']=$each_customer->booked_on;
          $notifydata['session_booking_date']=$each_customer->shedule_date;
          $notifydata['session_booking_day']=$each_customer->plan_day;
          $notifydata['session_booking_time']=date('h:i A', strtotime($each_customer->start_time)).' to '.date('h:i A', strtotime($each_customer->end_time));
          $notifydata['cancelled_reason']=$request->cancelled_reason;
          $notifydata['schedule_address']=$each_customer->address_line1;

          $client_details->notify(new PersonalTrainingSessionNotification($notifydata));
        }

        if($notifydata['url1'] == '/trainer/personal-training-plan-schedule')
        {
          $trainer_details=User::find($each_customer->trainer_id);

          $notifydata['url'] = '/trainer/personal-training-plan-schedule';
          $notifydata['trainer_name']=$trainer_details->name;
          $notifydata['trainer_email']=$trainer_details->email;
          $notifydata['trainer_phone']=$trainer_details->contact_no;
          $notifydata['status']='Single PT Schedule Delete By Admin To Trainer';
          $notifydata['session_booked_on']='';
          $notifydata['session_booking_date']=$each_customer->shedule_date;
          $notifydata['session_booking_day']=$each_customer->plan_day;
          $notifydata['session_booking_time']=date('h:i A', strtotime($each_customer->start_time)).' to '.date('h:i A', strtotime($each_customer->end_time));
          $notifydata['cancelled_reason']=$request->cancelled_reason;
          $notifydata['schedule_address']=$each_customer->address_line1;
          $notifydata['booked_by_id']=$each_customer->trainer_id;

          $trainer_details->notify(new PersonalTrainingSessionBookingNotification($notifydata));
        }
      }

      //Log::debug(" bootcamp_schedule_cancelled_admin 2 ".print_r($all_customers,true));
      DB::commit();
      return response()->json('success');
  }
  catch(\Exception $e) {
    DB::rollback();
    return response()->json('something_wrong');
  }
}

  public function add_pt_session_from_schedule($id)
  {
    try
    {
    $schedule_id=\Crypt::decrypt($id);

    $schedule_details=DB::table('personal_training_plan_schedules')->where('id',$schedule_id)->whereNull('deleted_at')->first();
    $start_time=DB::table('slot_times')->where('id',$schedule_details->plan_st_time_id)->value('time');
    $end_time=DB::table('slot_times')->where('id',$schedule_details->plan_end_time_id)->value('time');
    $trainer_name=DB::table('users')->where('id',$schedule_details->trainer_id)->value('name');
    $schedule_details->start_time=$start_time;
    $schedule_details->end_time=$end_time;
    $schedule_details->trainer_name=$trainer_name;

    return view('trainer.add_pt_session_bytrainer')->with(compact('schedule_details'));
    }
  catch(\Exception $e) {
    return abort(200);
  }
  }



public function search_customer_pt(Request $request)
{
  $query = $request->get('term','');   
  $customers_details=DB::table('customers')
  ->where('name','LIKE','%'.$query.'%')
  ->orwhere('email','LIKE','%'.$query.'%')
  ->orwhere('ph_no','LIKE','%'.$query.'%')->get();
        $data=array();
         $data1=array();

        foreach ($customers_details as $all_details) {
               
  $data[]=array('value'=>$all_details->name,'id'=>$all_details->id, 'email'=>$all_details->email,'ph_no'=>$all_details->ph_no );
               
        }
        if(count($data))
        {  return $data;  }
        else{ $data1[]=array('value'=>'No Result Found'); return $data1; }  
}

  public function check_customer_pt_session(Request $request)
  {

    $data=$request->get('data');
    $customer_id=$data['id'];
    $schedule_id=$data['schedule_id'];

    $current_date=Carbon::now()->toDateString(); // current date

    $remaining_session=DB::table('order_details')
    ->join('products','products.id','order_details.product_id')
    ->join('training_type','training_type.id','products.training_type_id')
    ->where('order_details.customer_id',$customer_id)
    ->where('order_details.status',1)
    ->where('training_type.id',1)
    ->where('order_details.order_validity_date','>=',$current_date)
    ->where('order_details.remaining_sessions','>',0)
    ->sum('order_details.remaining_sessions');

    if($remaining_session>0)
    {
      return json_encode($remaining_session);
    }
    if($remaining_session==0 && Auth::user()->master_trainer!=1)
    {
      return json_encode('not_booked');
    }
    else
    {
      return json_encode(0);
    }
    
  }

  public function book_pt_session_trainer(Request $request)
  {
    //Log::debug(" insert_bootcamp_plan data ".print_r($request->all(),true));

    DB::beginTransaction();
    try
    {

      $today = Carbon::now();

      for($i=0;$i<count($request->customer_name);$i++)
      {
        $no_of_session=DB::table('order_details')
        ->join('products','products.id','order_details.product_id')
        ->join('training_type','training_type.id','products.training_type_id')
        ->select('order_details.id as order_id','order_details.remaining_sessions as remaining_sessions')
        ->where('order_details.customer_id',$request->customer_id[$i])
        ->where('order_details.status',1)
        ->where('training_type.id',1)
        ->where('order_details.order_validity_date','>=',$today)
        ->where('order_details.remaining_sessions','>',0)
        ->orderBy('order_details.order_validity_date', 'ASC')->first();

        $is_booking=DB::table('personal_training_booking')->whereNull('deleted_at')->where('personal_training_plan_shedules_id',$request->schedule_id)->first();

        if(!empty($is_booking))
        {
          return redirect()->back()->with('booking_unsuccess','This schedule is already booked !');
        }
        else
        {
          $pt_booking_data['personal_training_plan_shedules_id']=$request->schedule_id;
          $pt_booking_data['customer_id']=$request->customer_id[$i];

          if(!empty($no_of_session))
          {
            $pt_booking_data['order_details_id']=$no_of_session->order_id;
          }
          else
          {
            $pt_booking_data['order_details_id']=time();
          }

          $pt_booking_insert=DB::table('personal_training_booking')->insert($pt_booking_data);

          if(!empty($no_of_session))
          {
            $decrease_remaining_session=DB::table('order_details')
            ->where('id',$no_of_session->order_id)->where('remaining_sessions','>',0)
            ->decrement('remaining_sessions',1);
          }

          $pt_plan_shedules_details=DB::table('personal_training_plan_schedules')
          ->where('id',$request->schedule_id)->whereNull('deleted_at')->first();

          $schedule_address=DB::table('bootcamp_plan_address')
          ->where('id',$pt_plan_shedules_details->address_id)->first();

          $schedule_st_time=DB::table('slot_times')
          ->where('id',$pt_plan_shedules_details->plan_st_time_id)->value('time');

          $schedule_end_time=DB::table('slot_times')
          ->where('id',$pt_plan_shedules_details->plan_end_time_id)->value('time');

          $client_details=Customer::find($request->customer_id[$i]);

          $notifydata['url'] = '/customer/mybooking';
          $notifydata['url1'] = '/trainer/personal-training-plan-schedule';

          if($notifydata['url'] == '/customer/mybooking')
          {
            $notifydata['customer_name']=$client_details->name;
            $notifydata['customer_email']=$client_details->email;
            $notifydata['customer_phone']=$client_details->ph_no;
            $notifydata['status']='Book PT Session By Admin To Customer';
            $notifydata['session_booked_on']=$today;
            $notifydata['session_booking_date']=$pt_plan_shedules_details->plan_date;
            $notifydata['session_booking_day']=$pt_plan_shedules_details->plan_day;
            $notifydata['session_booking_time']=date('h:i A', strtotime($schedule_st_time)).' to '.date('h:i A', strtotime($schedule_end_time));
            $notifydata['cancelled_reason']='';
            $notifydata['schedule_address']=$schedule_address->address_line1;

            $client_details->notify(new PersonalTrainingSessionNotification($notifydata));
          }
          if($notifydata['url1'] == '/trainer/personal-training-plan-schedule')
          {
            $trainer_details=User::find($pt_plan_shedules_details->trainer_id);

            $notifydata['url'] = '/trainer/personal-training-plan-schedule';
            $notifydata['trainer_name']=$trainer_details->name;
            $notifydata['trainer_email']=$trainer_details->email;
            $notifydata['trainer_phone']=$trainer_details->contact_no;
            $notifydata['status']='Book PT Session By Admin To Trainer';
            $notifydata['session_booked_on']=$today;
            $notifydata['session_booking_date']=$pt_plan_shedules_details->plan_date;
            $notifydata['session_booking_day']=$pt_plan_shedules_details->plan_day;
            $notifydata['session_booking_time']=date('h:i A', strtotime($schedule_st_time)).' to '.date('h:i A', strtotime($schedule_end_time));
            $notifydata['cancelled_reason']='';
            $notifydata['schedule_address']=$schedule_address->address_line1;
            $notifydata['booked_by_id']=$pt_plan_shedules_details->trainer_id;

            $trainer_details->notify(new PersonalTrainingSessionBookingNotification($notifydata));
          }

          DB::commit();
          return redirect()->back()->with('booking_success',"The selected customer's booking is successfully done!");
        }
      } 
  }
  catch(\Exception $e) {
    DB::rollback();
    return abort(200);
  }
}


}