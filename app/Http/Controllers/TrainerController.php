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

  $currentMonth = date('m');
  $total_booking_count_month = DB::table("slot_request")
            ->whereRaw('MONTH(slot_date) = ?',[$currentMonth])
            ->count();

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

  $currentMonth = date('m');
  $total_booking_count_month = DB::table("slot_request")
            ->whereRaw('MONTH(slot_date) = ?',[$currentMonth])->where('trainer_id',Auth::user()->id)
            ->count();

  $qtrMonth=Carbon::now()->subMonth(3);
  $total_booking_qtr=DB::table('slot_request')->where('slot_date','>=',$qtrMonth)->where('trainer_id',Auth::user()->id)->count();
}
  

Log::debug(":: total_booking_qtr data :: ".print_r($qtrMonth,true));

  return view('trainer.home')->with(compact('future_pending_request','future_approve_request','past_request','decline_request','total_number_of_trainer','total_number_of_customer','total_booking_count_month','total_booking_qtr'));
}


/**
* Show trainer own profile
*
*/
public function showprofile()
{
  // Log::debug(":: Show Profile :: ".print_r($id,true));

  $data=DB::table('users')->where('Id',Auth::user()->id)->first();
  Log::debug(":: Trainer data :: ".print_r($data,true));
  return view('trainer.trainerprofile')->with(compact('data'));
}

// open the update form of trainer
public function showupdateform()
{
  $data= DB::table('users')->where('Id',Auth::user()->id)->first();
  Log::debug(" data ".print_r($data,true));

  return view ("trainer.editform")->with(compact('data'));
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
    $mydata['address']=$request->address;
    $mydata['contact_no']=$request->contact_no;
    $data['updated_at']=Carbon::now();

    $data=DB::table('users')->where('id',$request->id)->update($mydata);
    return redirect()->back()->with("success","Your profile has been updated successfully.");
}

/**
* Show slot's record.
*
*/
public function showslot()
{
  $data=DB::table('slots')->where('deleted_at',null)->get();
  //Log::debug(":: Slots Data :: ".print_r($data,true));
  return view('trainer.addslot')->with(compact('data'));
}


/**
* add slot's form record.
*
*/
public function addslot()
{
  return view('trainer.addslotrecord');
}

/**
* add slot's form record.
*
*/
public function insertslot(Request $request)
{
  // create log for showing error and print result
  Log::debug(" data ".print_r($request->all(),true)); 
  // validation of data
  $request->validate
  ([ 'slots_number'=>'required|integer|min:1', //accept only integer and must be minimum value of 1 is required
    'slots_price'=>'required|numeric|between:1,999999.99',//accept only integer and must be minimum value of 1 is required
    'slots_validity'=>'required|integer|min:1',
    // same as slots_number

    'slots_name'=>'required|max:255|unique:slots'
  ]);

  $data['slots_name']=$request->slots_name;
  $data['slots_number']=$request->slots_number;
  $data['slots_price']=$request->slots_price;
  $data['slots_validity']=$request->slots_validity;
  $data['created_at']=Carbon::now();

  DB::table('slots')->insert($data);
  return redirect('trainer/add-slot')->with("success","You have successfully added one package");
}


// open the edit form of slots
public function showslotseditform($id)
{
  $data= DB::table('slots')->where('id',$id)->first();
  Log::debug(" data ".print_r($data,true));
  return view ("trainer.slotseditform")->with(compact('data'));
}

// update the slots
public function slotsedit(Request $request)
{
  $slotsdata['slots_name']=$request->slots_name;
  $slotsdata['slots_number']=$request->slots_number;
  $slotsdata['slots_price']=$request->slots_price;
  $slotsdata['slots_validity']=$request->slots_validity;
  $slotsdata['updated_at']=Carbon::now();
  DB::table('slots')->where('id',$request->id)->update($slotsdata);
  return redirect('trainer/add-slot')->with("success","You have successfully updated one package");
}


// delete the slots
public function slotsdelete($id)
{
  $slotsdata['deleted_at']=Carbon::now();

  DB::table('slots')->where('id',$id)->update($slotsdata);
  return redirect('trainer/add-slot')->with("delete","You have successfully deleted one package");
}



public function showlist()
{
  $data=DB::table('users')->where('master_trainer',2)->whereNull('deleted_at')->get()->all();
  return view('trainer.trainerlist')->with(compact('data'));
}


//trainer ajax function//
public function trainer_active_deactive(Request $request)
{
  $data=$request->get('data');
  $id=$data['id'];
  $action=$data['action'];
    
  if($action=="Active")
  {
    $a=DB::table('users')->where('id',$id)->update(['is_active'=>1]);
        
    $trainer_details=User::find($id);

    $notifydata['status']='Trainer Active';
    $notifydata['trainer_name']=$trainer_details->name;

    Log::debug("Trainer Active notification ".print_r($notifydata,true));

    $trainer_details->notify(new TrainerActiveDeactiveNotification($notifydata));

    return response()->json(1);
  }
  elseif($action=="Deactive")
  {
    $remaining_session_request_now=Carbon::now()->toDateString();

    DB::table('users')->where('id',$id)->update(['is_active'=>0 ]);

    $total_decline=DB::table('slot_request')
    ->where('trainer_id',$id)
    ->where(function($q) {
         $q->where('approval_id', 1)
           ->orWhere('approval_id', 3);
        })
    ->where('slot_date','>=',$remaining_session_request_now)
    ->get()->all();

    Log::debug(" total_decline ".print_r($total_decline,true));

    $customer_id=0; $slot_date='';
    foreach($total_decline as $my_total)
    {
      $remaining_package=DB::table('purchases_history')
      ->where('customer_id',$my_total->customer_id)
      ->where('active_package',1)
      ->orderBy('package_validity_date','DESC')
      ->first();

      $extra_package=DB::table('purchases_history')
      ->select('id','package_validity_date','package_remaining','extra_package_remaining')
      ->where('customer_id',$customer_id)
      ->where('active_package',1)
      ->orderBy('package_validity_date', 'DESC')
      ->first();


      $slot_time=DB::table('slot_times')->where('id',$my_total->slot_time_id)->first();
        
      if($remaining_package) 
      {
        $add_session_remaining=$remaining_package->package_remaining+1;
            

        $update_package_purchase=DB::table('purchases_history')
        ->where('id',$remaining_package->id)
        ->update(['package_remaining'=>$add_session_remaining]);

        $customer_details=Customer::find($my_total->customer_id);
        $trainer_details=User::find($id);



        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$customer_details->name;
        $notifydata['customer_email']=$customer_details->email;
        $notifydata['customer_phone']=$customer_details->ph_no;
        $notifydata['status']='Cancelled Session Request';
        $notifydata['session_booked_on']=$my_total->created_at;
        $notifydata['session_booking_date']=$my_total->slot_date;
        $notifydata['session_booking_time']=$slot_time->time;
        $notifydata['trainer_name']=$trainer_details->name;
        $notifydata['decline_reason']='Deactivate Trainer';

        Log::debug("Declined Session Request notification ".print_r($notifydata,true));

        $customer_details->notify(new SessionRequestNotification($notifydata));
      }
      else
      {
        $add_session_remaining=$extra_package->extra_package_remaining+1;
            

        $update_package_purchase=DB::table('purchases_history')
        ->where('id',$extra_package->id)
        ->update(['extra_package_remaining'=>$add_session_remaining]);

        $customer_details=Customer::find($my_total->customer_id);
        $trainer_details=User::find($id);

        $notifydata['url'] = '/customer/mybooking';
        $notifydata['customer_name']=$customer_details->name;
        $notifydata['customer_email']=$customer_details->email;
        $notifydata['customer_phone']=$customer_details->ph_no;
        $notifydata['status']='Cancelled Session Request';
        $notifydata['session_booked_on']=$my_total->created_at;
        $notifydata['session_booking_date']=$my_total->slot_date;
        $notifydata['session_booking_time']=$slot_time->time;
        $notifydata['trainer_name']=$trainer_details->name;
        $notifydata['decline_reason']='Deactivate Trainer';

        Log::debug("Declined Session Request notification ".print_r($notifydata,true));

        $customer_details->notify(new SessionRequestNotification($notifydata));
      }
    }
       
    $slot_rquest_update=DB::table('slot_request')
    ->where('trainer_id',$id)
    ->where(function($q) {
        $q->where('approval_id', 1)
          ->orWhere('approval_id', 3);
      })
    ->where('slot_date','>=',$remaining_session_request_now)
    ->update(['approval_id'=>4]);


    $trainer_details=User::find($id);

    $notifydata['status']='Trainer Deactive';
    $notifydata['trainer_name']=$trainer_details->name;

    Log::debug("Trainer Deactive notification ".print_r($notifydata,true));

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
  $updatedata['deleted_at']=Carbon::now();

  DB::table('users')->where('id',$id)->update($updatedata);

  $remaining_session_request_now=Carbon::now()->toDateString();

  $total_decline=DB::table('slot_request')
  ->where('trainer_id',$id)
  ->where(function($q) {
      $q->where('approval_id', 1)
        ->orWhere('approval_id', 3);
  })
  ->where('slot_date','>=',$remaining_session_request_now)
  ->get()->all();


  Log::debug(" total_decline ".print_r($total_decline,true));

  foreach($total_decline as $my_total)
  {
    $remaining_package=DB::table('purchases_history')
    ->where('customer_id',$my_total->customer_id)
    ->where('active_package',1)
    ->where('package_validity_date','>=',$remaining_session_request_now)
    ->orderBy('package_validity_date','DESC')
    ->first();

    $extra_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining','extra_package_remaining')
    ->where('customer_id',$my_total->customer_id)
    ->where('active_package',1)
    ->orderBy('package_validity_date', 'DESC')
    ->first();

    $slot_time=DB::table('slot_times')->where('id',$my_total->slot_time_id)->first();
        
    if($remaining_package) 
    {
            
      $add_session_remaining=$remaining_package->package_remaining+1;
            
      $update_package_purchase=DB::table('purchases_history')
      ->where('id',$remaining_package->id)
      ->update(['package_remaining'=>$add_session_remaining]);


      $customer_details=Customer::find($my_total->customer_id);
      $trainer_details=User::find($id);

      $notifydata['url'] = '/customer/mybooking';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Cancelled Session Request';
      $notifydata['session_booked_on']=$my_total->created_at;
      $notifydata['session_booking_date']=$my_total->slot_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;
      $notifydata['decline_reason']='Deleted Trainer';

      Log::debug("Declined Session Request notification ".print_r($notifydata,true));

      $customer_details->notify(new SessionRequestNotification($notifydata));
    }
    else
    {
      $add_session_remaining=$extra_package->extra_package_remaining+1;
            
      $update_package_purchase=DB::table('purchases_history')
      ->where('id',$extra_package->id)
      ->update(['extra_package_remaining'=>$add_session_remaining]);


      $customer_details=Customer::find($my_total->customer_id);
      $trainer_details=User::find($id);

      $notifydata['url'] = '/customer/mybooking';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Cancelled Session Request';
      $notifydata['session_booked_on']=$my_total->created_at;
      $notifydata['session_booking_date']=$my_total->slot_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;
      $notifydata['decline_reason']='Deleted Trainer';

      Log::debug("Declined Session Request notification ".print_r($notifydata,true));

      $customer_details->notify(new SessionRequestNotification($notifydata));
    }
  }

  $trainer_details=User::find($id);

  $notifydata['status']='Trainer Delete';
  $notifydata['trainer_name']=$trainer_details->name;

  Log::debug("Trainer Delete notification ".print_r($notifydata,true));

  $trainer_details->notify(new TrainerActiveDeactiveNotification($notifydata));

  $slot_rquest_update=DB::table('slot_request')
  ->where('trainer_id',$id)
  ->where(function($q) {
      $q->where('approval_id', 1)
        ->orWhere('approval_id', 3);
      })
  ->where('slot_date','>=',$remaining_session_request_now)
  ->update(['approval_id'=>4]);

  return redirect('trainer/trainerlist')->with("delete","You have successfully deleted one trainer");
}



public function inserttrainer(Request $request)
{

  $validator=Validator::make($request->all(), [

    'email' => 'sometimes|email|max:255|unique:users',
  ]);

  if($validator->fails())
  {
    Log::debug(" Validator ".print_r($validator->errors(),true));
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

  DB::table('users')->insert($data);

  Mail::send('emails.enquirymail',['password' =>$password_code,'email' =>$data['email'],'name'=>$data['name']], function($message) {
    $message->to(Input::get('email'))->subject('Successfully add as a trainer');
    });
  return redirect('trainer/trainerlist')->with("success","You have successfully added one trainer");
}



public function showtrainerseditform($id)
{
  $data= DB::table('users')->where('id',$id)->first();
  Log::debug(" data ".print_r($data,true));
  return view ("trainer.edittrainer")->with(compact('data'));
}


public function traineredit(Request $request)
{ 
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
    $data['contact_no']=$request->contact_no;
    $data['address']=$request->address;
    $data['email']=$request->email;
    $data['updated_at']=Carbon::now();

    DB::table('users')->where('id',$request->id)->update($data);
    return redirect('trainer/trainerlist')->with("success","You have successfully updated one trainer");
}


//past customer list//
public function pastshowlist(Request $request)
{
  $id=$request->id;
  $cur_date =Carbon::now()->toDateString();
  $cur_time =date("H:i:s");
  if(Auth::user()->master_trainer==1)
  {
 $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select('slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')
  ->where('slot_request.slot_date','<',$cur_date)
  ->where('approval_id','<>',2)
  ->get();
  }
  else{
    $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select('slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')
  ->where('slot_request.slot_date','<',$cur_date)
  ->where('approval_id','<>',2)
  ->where('slot_request.trainer_id',$id)->get();
  }
  
  return view('trainer.past_request_customers')->with(compact('data'));
}


//past customer list//
public function cancelledshowlist()
{
  
  if(Auth::user()->master_trainer==1)
  {
    $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select('slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')
  ->where('approval_id',2)
  ->get();
  }
  else{
    $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select('slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')
  ->where('approval_id',2)
  ->where('slot_request.trainer_id',Auth::user()->id)->get();
  }
  
  return view('trainer.cancelled_request_customers')->with(compact('data'));
}

//future customer ajax function//
public function approve_customer_request(Request $request)
{

  $remaining_session_request_now=Carbon::now()->toDateString();
  $data=$request->get('data');
  $id=$data['id'];
  $action=$data['action'];

  $customer_id=DB::table('slot_request')->where('id',$id)->first();

  

  $slot_time=DB::table('slot_times')->where('id',$customer_id->slot_time_id)->first();


    
  if($action=="Approve")
  {
    $package_history=DB::table('purchases_history')
    ->where('customer_id',$customer_id->customer_id)
    ->where('purchases_history.active_package',1)
    ->where('purchases_history.package_remaining','>=',0)
    ->where('purchases_history.package_validity_date','>=',$remaining_session_request_now)
    ->orderBy('package_validity_date','ASC')->first();

    $extra_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining','extra_package_remaining')
    ->where('customer_id',$customer_id->customer_id)
    ->where('active_package',1)
    ->where('extra_package_remaining','>',0)
    ->orderBy('package_validity_date', 'DESC')
    ->first();


    if($package_history)
    {

      $package_history_update_data['package_remaining']=$package_history->package_remaining-1;

      $package_history_update=DB::table('purchases_history')->where('id',$package_history->id)->update($package_history_update_data);


      DB::table('slot_request')->where('id',$id)->update(['approval_id' =>3,'decline_reason'=>null]);

      $customer_details=Customer::find($customer_id->customer_id);
      $trainer_details=User::find($customer_id->trainer_id);

      $notifydata['url'] = '/customer/mybooking';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Approved Session Request';
      $notifydata['session_booked_on']=$customer_id->created_at;
      $notifydata['session_booking_date']=$customer_id->slot_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;
      $notifydata['decline_reason']=' ';

      Log::debug("Approved Session Request notification ".print_r($notifydata,true));

      $customer_details->notify(new SessionRequestNotification($notifydata));  
    }
    else
    {
      $package_history_update_data['extra_package_remaining']=$extra_package->extra_package_remaining-1;

      $package_history_update=DB::table('purchases_history')->where('id',$extra_package->id)->update($package_history_update_data);


      DB::table('slot_request')->where('id',$id)->update(['approval_id' =>3,'decline_reason'=>null]);

      $customer_details=Customer::find($customer_id->customer_id);
      $trainer_details=User::find($customer_id->trainer_id);

      $notifydata['url'] = '/customer/mybooking';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Approved Session Request';
      $notifydata['session_booked_on']=$customer_id->created_at;
      $notifydata['session_booking_date']=$customer_id->slot_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;
      $notifydata['decline_reason']=' ';

      Log::debug("Approved Session Request notification ".print_r($notifydata,true));

      $customer_details->notify(new SessionRequestNotification($notifydata));
     
    }
    return response()->json(1);
  }
  elseif($action=="Decline")
  {
    $reason=$data['comment'];
        
    $package_history=DB::table('purchases_history')
    ->where('customer_id',$customer_id->customer_id)
    ->where('purchases_history.active_package',1)
    ->where('purchases_history.package_validity_date','>=',$remaining_session_request_now)
    ->orderBy('package_validity_date','DESC')->first();

    $extra_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining','extra_package_remaining')
    ->where('customer_id',$customer_id->customer_id)
    ->where('active_package',1)
    ->orderBy('package_validity_date', 'DESC')
    ->first();

    if($package_history)
    {

      $package_history_update_data['package_remaining']=$package_history->package_remaining+1;

      $package_history_update=DB::table('purchases_history')->where('id',$package_history->id)->update($package_history_update_data);
        
      Log::debug(" package_history_update ".print_r($package_history_update,true));


      DB::table('slot_request')->where('id',$id)->update(['approval_id' => 4, 'decline_reason'=> $reason]);

      $customer_details=Customer::find($customer_id->customer_id);
      $trainer_details=User::find($customer_id->trainer_id);

      $notifydata['url'] = '/customer/mybooking';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Declined Session Request';
      $notifydata['session_booked_on']=$customer_id->created_at;
      $notifydata['session_booking_date']=$customer_id->slot_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;
      $notifydata['decline_reason']=$reason;

      Log::debug("Declined Session Request notification ".print_r($notifydata,true));

      $customer_details->notify(new SessionRequestNotification($notifydata));
    }
    else
    {
      $package_history_update_data['extra_package_remaining']=$extra_package->extra_package_remaining+1;

      $package_history_update=DB::table('purchases_history')->where('id',$extra_package->id)->update($package_history_update_data);
        
      Log::debug(" package_history_update ".print_r($package_history_update,true));

      DB::table('slot_request')->where('id',$id)->update(['approval_id' => 4, 'decline_reason'=> $reason]);

      $customer_details=Customer::find($customer_id->customer_id);
      $trainer_details=User::find($customer_id->trainer_id);

      $notifydata['url'] = '/customer/mybooking';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Declined Session Request';
      $notifydata['session_booked_on']=$customer_id->created_at;
      $notifydata['session_booking_date']=$customer_id->slot_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;
      $notifydata['decline_reason']=$reason;

      Log::debug("Declined Session Request notification ".print_r($notifydata,true));

      $customer_details->notify(new SessionRequestNotification($notifydata));
    }
    return response()->json(2);
  }
}

//future customer list//
public function futureshowlist(Request $request)
{

  $id=$request->id;
  $cur_date =Carbon::now()->toDateString();

Log::debug("id ".print_r($id,true));
  Log::debug("cur_date ".print_r($cur_date,true));

  $cur_time =date("H:i:s");
  if(Auth::user()->master_trainer==1)
{
  $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select( 'slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')->where('slot_request.slot_date','>=',$cur_date)
  ->where(function($q) {
    $q->where('approval_id', 3)
      ->orWhere('approval_id', 4);
  })->get();
  
}

else{
    $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select( 'slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')->where('slot_request.slot_date','>=',$cur_date)
  ->where(function($q) {
    $q->where('approval_id', 3)
      ->orWhere('approval_id', 4);
  })->where('slot_request.trainer_id',$id)->get();
}
  
  
  return view('trainer.future_request_customers')->with(compact('data'));
}


//future customer pending list//

public function future_pending_showlist(Request $request)
{
  $id=$request->id;
  $cur_date =Carbon::now()->toDateString();
  $cur_time =date("H:i:s");

  if(Auth::user()->master_trainer==1){
 $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select( 'slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')->where('slot_request.slot_date','>=',$cur_date)->where('slot_request.approval_id',1)->get();

        }

   else{
  $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select( 'slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')->where('slot_request.slot_date','>=',$cur_date)->where('slot_request.approval_id',1)->where('slot_request.trainer_id',$id)->get();

     }       
  
  return view('trainer.future_pending_request_customers')->with(compact('data'));
}

//future  pending customer request ajax function//
public function approve_pending_request(Request $request)
{
  $data=$request->get('data');
  $id=$data['id'];
  $action=$data['action'];   

  if($action=="Approve")
  {
        
    DB::table('slot_request')->where('id',$id)->update(['approval_id' =>3,'decline_reason'=>null]);

    $get_customer_id=DB::table('slot_request')->where('id',$id)->first();

    $slot_time=DB::table('slot_times')->where('id',$get_customer_id->slot_time_id)->first();

    $customer_details=Customer::find($get_customer_id->customer_id);
    $trainer_details=User::find($get_customer_id->trainer_id);

    $notifydata['url'] = '/customer/mybooking';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Approved Session Request';
    $notifydata['session_booked_on']=$get_customer_id->created_at;
    $notifydata['session_booking_date']=$get_customer_id->slot_date;
    $notifydata['session_booking_time']=$slot_time->time;
    $notifydata['trainer_name']=$trainer_details->name;
    $notifydata['decline_reason']=' ';

    Log::debug("Approved Session Request notification ".print_r($notifydata,true));

    $customer_details->notify(new SessionRequestNotification($notifydata));

    return response()->json(1);
  }
  elseif($action=="Decline")
  {

    $reason=$data['comment'];
    $remaining_session_request_now=Carbon::now()->toDateString();

    $customer_id=DB::table('slot_request')->where('id',$id)->first();
    $slot_time=DB::table('slot_times')->where('id',$customer_id->slot_time_id)->first();

    $package_history=DB::table('purchases_history')
    ->where('customer_id',$customer_id->customer_id)
    ->where('purchases_history.active_package',1)
    ->where('purchases_history.package_validity_date','>=',$remaining_session_request_now)
    ->orderBy('package_validity_date','DESC')->first();

    $extra_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining','extra_package_remaining')
    ->where('customer_id',$customer_id->customer_id)
    ->where('active_package',1)
    ->orderBy('package_validity_date', 'DESC')
    ->first();

    if($package_history)
    {
      $package_history_update_data['package_remaining']=$package_history->package_remaining+1;

      $package_history_update=DB::table('purchases_history')->where('id',$package_history->id)->update($package_history_update_data);

      Log::debug(" package_history_update ".print_r($package_history_update,true));
      DB::table('slot_request')->where('id',$id)->update(['approval_id' => 4, 'decline_reason'=> $reason]);

      $customer_details=Customer::find($customer_id->customer_id);
      $trainer_details=User::find($customer_id->trainer_id);

      $notifydata['url'] = '/customer/mybooking';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Declined Session Request';
      $notifydata['session_booked_on']=$customer_id->created_at;
      $notifydata['session_booking_date']=$customer_id->slot_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;
      $notifydata['decline_reason']=$reason;

      Log::debug("Declined Session Request notification ".print_r($notifydata,true));

      $customer_details->notify(new SessionRequestNotification($notifydata));
    }
    else
    {
      $package_history_update_data['extra_package_remaining']=$extra_package->extra_package_remaining+1;

      $package_history_update=DB::table('purchases_history')->where('id',$extra_package->id)->update($package_history_update_data);

      Log::debug(" package_history_update ".print_r($package_history_update,true));
      DB::table('slot_request')->where('id',$id)->update(['approval_id' => 4, 'decline_reason'=> $reason]);

      $customer_details=Customer::find($customer_id->customer_id);
      $trainer_details=User::find($customer_id->trainer_id);

      $notifydata['url'] = '/customer/mybooking';
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Declined Session Request';
      $notifydata['session_booked_on']=$customer_id->created_at;
      $notifydata['session_booking_date']=$customer_id->slot_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;
      $notifydata['decline_reason']=$reason;

      Log::debug("Declined Session Request notification ".print_r($notifydata,true));

      $customer_details->notify(new SessionRequestNotification($notifydata));
    }
    return response()->json(2);
  }
}


//all customers table//
public function all_customers()
{
  $data=DB::table('customers')->whereNull('deleted_at')->where('confirmed',1)->get();
  return view('trainer.customers_all')->with(compact('data'));
}
//gym insert form//
public function add_exercise_trainer()
{
  return view('trainer.exercise_insert_details');
}

//gym insert function//
public function exercise_user_insert(Request $request)
{
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

//gym view function//
public function gym_showlist(Request $request)
{ 

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

//gym delete function//
public function gymdelete($id)
{
  DB::table('exercise_details')->delete($id);
  return redirect()->back()->with("delete","You have successfully deleted one exercise.");;
}
//gym edit form//
public function show_edit_exercise_form($id)
{
  $data= DB::table('exercise_details')->where('id',$id)->first();
  //Log::debug(" data ".print_r($data,true));
  return view ("trainer.editexercise")->with(compact('data'));
}

//gym edit function//
public function update_exercise(Request $request)
{ 

  
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



//feedback function//
public function feedbacklist(Request $request)
{
  $data=DB::table('feedback')->orderBy('feedback.id','desc')->get();
  return view('trainer.feedbacklist')->with(compact('data'));
}

// For contact details
public function contactlist(Request $request)
{
  $data=DB::table('contact_us')->orderBy('contact_us.id','desc')->get();
  return view('trainer.contactlist')->with(compact('data'));
}


public function testimonial_view()
{
  $data=DB::table('testimonial')->where('deleted_at',null)->get();
  return view('trainer.testimonial_view')->with(compact('data'));
}


public function testimonialshow()
{
  return view('trainer.testimonial_backend');
}

public function testimonialinsert(Request $request)
{

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

// open the edit form of slots
public function testimonialedit($id)
{
  $data= DB::table('testimonial')->where('id',$id)->first();
  Log::debug(" data ".print_r($data,true));
  return view ("trainer.edit_testimonial")->with(compact('data'));
}

public function testimonialupdate(Request $request)
{ 

    
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


public function testimonialdelete($id)
{
  $updatedata['deleted_at']=Carbon::now();

  DB::table('testimonial')->where('id',$id)->update($updatedata);

  return redirect('trainer/testimonial_view')->with("delete","You have successfully deleted one testimonial.");
}

public function mot_show(Request $request)
{

  $data=DB::table('customer_mot')
  ->join('customers','customers.id','customer_mot.customer_id')
  ->select('customer_mot.*','customers.name','customers.ph_no','customers.email')->where('customer_mot.deleted_at',null)->get();
  return view('trainer.customer_mot')->with(compact('data'));
}

public function motinsertshow()
{
  $data=DB::table('customers')->get();
  return view('trainer.motinsertshow')->with(compact('data'));
}


public function motinsertshowauto(Request $request)
{
  

  $query = $request->get('term','');
        
        $products=DB::table('customers')->where('name','LIKE','%'.$query.'%')->orwhere('email','LIKE','%'.$query.'%')->orwhere('ph_no','LIKE','%'.$query.'%')->get();
        
        $data=array();
        $data1=array();
        foreach ($products as $product) {
               
          $data[]=array('value'=>$product->name,'id'=>$product->id, 'email'=>$product->email,'ph_no'=>$product->ph_no );

               
        }

        Log::debug ( " :: motinsertshowauto :: ".print_r ($data,true));

        if(count($data))
        {
          return $data;
        }
        else
        {
          
          $data1[]=array('value'=>'No Result Found');
          return $data1;
        }
    
    
}



public function motinsert(Request $request)
{

  Log::debug(" metric ".print_r($request->right_arm_credential,true));

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

// print_r($data);die();
    DB::table('customer_mot')->insert($data);
    Log::debug(" customer_mot ".print_r($data,true));
    return redirect('trainer/mot_show')->with("success","You have successfully added one customer's MOT.");


}




public function mot_customer_request(Request $request)
{
  $data=$request->get('data');
  $id=$data['id'];
  $positions = DB::table('customer_mot')->where('customer_id',$id)->orderBy('date','DESC')->first();
  Log::debug(" Check id ".print_r($positions,true));
  return response()->json($positions);
}

public function moteditshow($id)
{
  $data=DB::table('customer_mot')
  ->join('customers','customers.id','customer_mot.customer_id')
  ->join('users','users.id','customer_mot.trainer_id')
  ->select('customer_mot.id as mot_id','customer_mot.height','customer_mot.customer_id as customer_id','customer_mot.trainer_id','customer_mot.right_arm','customer_mot.left_arm','customer_mot.chest','customer_mot.waist','customer_mot.hips','customer_mot.right_thigh','customer_mot.left_thigh','customer_mot.starting_weight','customer_mot.date','customer_mot.right_calf','customer_mot.left_calf','customer_mot.heart_beat','customers.name as current_customer_name','customer_mot.blood_pressure','customer_mot.ending_weight','customer_mot.description')->where('customer_mot.id',$id)->first();

  return view('trainer.moteditshow')->with(compact('data'));
}



public function motedit(Request $request){


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
    Log::debug(" Check id ".print_r($data,true));
    return redirect('trainer/mot_show')->with("success","You have successfully updated one customer's MOT.");

}


public function motdelete($id)
{
    
  $updatedata['deleted_at']=Carbon::now();
  DB::table('customer_mot')->where('id',$id)->update($updatedata);
  return redirect('trainer/mot_show')->with("delete","You have successfully deleted one customer's MOT.");
}

public function our_client_show()
{
  $data=DB::table('our_client')->where('deleted_at',null)->get();
  return view('trainer.our_client_list')->with(compact('data'));
}


public function client_insert_view()
{
  return view('trainer.client_insert_view');
}


public function client_insert(Request $request)
{
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
    else
        { $data['image']=$request->oldimage;  }


    $data['title']=$request->title;
    $data['name']=$request->name;
    $data['designation']=$request->designation;
    $data['description']=$request->description;
    $data['facebook']=$request->facebook;
    $data['twitter']=$request->twitter;
    $data['instagram']=$request->instagram;

    DB::table('our_client')->insert($data);
    Log::debug(" Check id ".print_r($data,true));
    return redirect('trainer/our_trainer_list')->with("success","One trainer is insert successfully !");
}

public function client_edit_view($id)
{

    $data= DB::table('our_client')->where('id',$id)->first();
    Log::debug(" data ".print_r($data,true));
    return view ("trainer.client_edit_view")->with(compact('data'));


}

public function client_update(Request $request)
{ 
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

    $data['title']=$request->title;
    $data['name']=$request->name;
    $data['designation']=$request->designation;
    $data['description']=$request->description;
    $data['facebook']=$request->facebook;
    $data['twitter']=$request->twitter;
    $data['instagram']=$request->instagram;
    $data['updated_at']=Carbon::now();

    DB::table('our_client')->where('id',$request->id)->update($data);
    return redirect('trainer/our_trainer_list')->with("success","One trainer details updated successfully!");
}

public function client_delete($id)
{
    $updatedata['deleted_at']=Carbon::now();

    DB::table('our_client')->where('id',$id)->update($updatedata);

    return redirect('trainer/our_trainer_list')->with("delete","One trainer is deleted successfully !");
}





public function payment_history_backend()
{


    $data=DB::table('purchases_history')
    ->join('customers','customers.id','purchases_history.customer_id')
    ->join('payment_history','payment_history.purchase_history_id','purchases_history.id')
    ->select('purchases_history.id','purchases_history.slots_name','purchases_history.slots_price','customers.name','customers.name','purchases_history.payment_options','purchases_history.active_package','payment_history.status','purchases_history.purchases_date','payment_history.payment_id','payment_history.description','payment_history.image','payment_history.payment_mode')
    ->orderBy('payment_history.payment_mode','ASC')->orderBy('payment_history.id','DESC')->get()->all();

    return view('trainer.payment_history_backend')->with(compact('data'));

}


public function payment_history_backend_request(Request $request)
{
    $data=$request->get('data');
    $purchase_history_id=$data['id'];
    $action=$data['action'];

    $slot_number=DB::table('purchases_history')->where('id',$purchase_history_id)->first();
    
    if($action=="Approve"){

    $update_purchases_history=DB::table('purchases_history')
    ->where('id',$purchase_history_id)->update(['active_package' =>1,'package_remaining'=>$slot_number->slots_number]);

    $update_payment_history=DB::table('payment_history')
    ->where('purchase_history_id',$purchase_history_id)->update(['status'=> 'Success']);

    // send notification mail

    $customer_details=Customer::find($slot_number->customer_id);

    $payment_history_details=DB::table('payment_history')
    ->where('purchase_history_id',$purchase_history_id)->first();


    $notifydata['package_name'] =$slot_number->slots_name;
    $notifydata['slots_number'] =$slot_number->slots_number;
    $notifydata['package_validity'] =$slot_number->package_validity_date;
    $notifydata['package_purchase_date'] =$slot_number->purchases_date;
    $notifydata['package_amount'] =$slot_number->slots_price;
    $notifydata['payment_id'] =$payment_history_details->payment_id;
    $notifydata['payment_mode'] ='Bank Transfer';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Bank Payment Approved';

    Log::debug(" bank transfer approve notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    return response()->json(1);
    }
    elseif($action=="Decline")
    {

    $update_purchases_history=DB::table('purchases_history')
    ->where('id',$purchase_history_id)->update(['active_package' =>0,'package_remaining'=>0]);

    $update_payment_history=DB::table('payment_history')
    ->where('purchase_history_id',$purchase_history_id)->update(['status'=> 'Decline']);

    // send notification mail

    $customer_details=Customer::find($slot_number->customer_id);

    $payment_history_details=DB::table('payment_history')
    ->where('purchase_history_id',$purchase_history_id)->first();


    $notifydata['package_name'] =$slot_number->slots_name;
    $notifydata['slots_number'] =$slot_number->slots_number;
    $notifydata['package_validity'] =$slot_number->package_validity_date;
    $notifydata['package_purchase_date'] =$slot_number->purchases_date;
    $notifydata['package_amount'] =$slot_number->slots_price;
    $notifydata['payment_id'] =$payment_history_details->payment_id;
    $notifydata['payment_mode'] ='Bank Transfer';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Bank Payment Declined';

    //Log::debug(" bank transfer decline notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    return response()->json(2);
    }
}


  function cheeck_exercise_category(Request $request)
  {
    $category=$request->title;
    $category=preg_replace('/\s+/', ' ', $category);
    
    $exercise_details=DB::table('exercise_details')->where('title',$category)->count();

    if($exercise_details>0)
    {
      return 1;
    }
    else
    {
      return 0;
    }
  }


function cheeckexercisecategory_edit(Request $request)
  {
    $category=$request->title;
    $category=preg_replace('/\s+/', ' ', $category);
    
    $edit_category=DB::table('exercise_details')->where('id',$request->id)->pluck('title');
    $all_category=DB::table('exercise_details')->where('id','!=',$request->id)->get()->all();

    $duplicate_cat=0;
    foreach($all_category as $each_category)
    {
      if($each_category->title==$category)
      {
        $duplicate_cat=1;
      }
    }

  
    if($duplicate_cat==1)
    {
      return 1;
    }
    else
    {
      return 0;
    }
  }
function cheecktestimonialname(Request $request)
  {
    $name=$request->name;
    $name=preg_replace('/\s+/', ' ', $name);
    
    $testimonial_details=DB::table('testimonial')->where('name',$name)->count();

    if($testimonial_details>0)
    {
      return 1;
    }
    else
    {
      return 0;
    }
  }

  function cheecktestimonialname_edit(Request $request)
  {
    $name=$request->name;
    $name=preg_replace('/\s+/', ' ', $name);
    
    $edit_name=DB::table('testimonial')->where('id',$request->id)->pluck('name');
    $all_name=DB::table('testimonial')->where('id','!=',$request->id)->get()->all();

    $duplicate_name=0;
    foreach($all_name as $each_name)
    {
      if($each_name->name==$name)
      {
        $duplicate_name=1;
      }
    }

  
    if($duplicate_name==1)
    {
      return 1;
    }
    else
    {
      return 0;
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

public function admin_get_current_slot_time(Request $request)
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


public function admin_get_slot_trainer(Request $request)
{

// $slot_time=DB::table('slot_times')->where('id',$slots_time_id)->first();

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


  Log::debug(" get_slot_times ".print_r($get_slot_trainer,true));
  $final_slot_trainer=DB::table('users')->whereNull('deleted_at')->where('is_active', 1)->whereNotIn('id',$get_slot_trainer)->get();

  return json_encode($final_slot_trainer);
}


public function admin_get_time(Request $request)
{

  $slot_date=$request->slot_date;


  //$time_data=DB::table('slot_times')->get()->all();

  $get_slot_times=DB::table('slot_request')
  ->where('slot_date',$slot_date)
  ->where(function($q) {
         $q->where('approval_id', 1)
           ->orWhere('approval_id', 3);
     })
  ->pluck('slot_time_id');

  if(count($get_slot_times)){

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

public function admin_get_current_time(Request $request)
{

  $slot_date=$request->slot_date;

  $get_slot_times=DB::table('slot_request')
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

  if(count($get_slot_times)){

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





  function add_session(Request $request)
  {

  $remaining_session_request_now=Carbon::now()->toDateString();  
  $customers=DB::table('customers')->whereNull('deleted_at')->where('confirmed',1)->get();
  $data=DB::table('users')->whereNull('deleted_at')->where('is_active',1)->get();

  $sum_slots = DB::table('purchases_history')
  ->select('active_package','package_remaining','customer_id')  
  ->where('active_package',1 )
  ->where('package_validity_date','>=',$remaining_session_request_now)
  ->sum('package_remaining');

  $sum_extra_slots = DB::table('purchases_history')
  ->select('active_package','package_remaining','extra_package_remaining','customer_id')
  ->where('active_package',1)
  ->sum('extra_package_remaining');

  $trainer_data=DB::table('users')->whereNull('deleted_at')->where('is_active',1)->get();
 

  $total_remaining_session=$sum_slots+$sum_extra_slots;
    return view('trainer.add_session')->with(compact('data','total_remaining_session','customers','trainer_data'));
  }

  

public function customersearch(Request $request)
{

  $query = $request->get('term','');   
  $products=DB::table('customers')
  ->where('name','LIKE','%'.$query.'%')
  ->orwhere('email','LIKE','%'.$query.'%')
  ->orwhere('ph_no','LIKE','%'.$query.'%')->get();
        $data=array();
         $data1=array();

        foreach ($products as $product) {
               
          // $data[]=array('value'=>$product->email,'id'=>$product->id);
 $data[]=array('value'=>$product->name,'id'=>$product->id, 'email'=>$product->email,'ph_no'=>$product->ph_no );
               
        }
        if(count($data))
        {
          
            return $data;
                     
            }
        else{

           $data1[]=array('value'=>'No Result Found');
          return $data1;
            // return ['value'=>'No Result Found','id'=>''];
          }
    
    
}

  public function check_customer_session(Request $request)
  {

    $remaining_session_request_now=Carbon::now()->toDateString(); // current date

  $sum_slots = DB::table('purchases_history')
  ->select('active_package','package_remaining','customer_id')
  ->where('customer_id',$request->get('data'))
  ->where('active_package',1 )
  ->where('package_validity_date','>=',$remaining_session_request_now)
  ->sum('package_remaining');

  $sum_extra_slots = DB::table('purchases_history')
  ->select('active_package','package_remaining','extra_package_remaining','customer_id')
  ->where('customer_id',$request->get('data'))
  ->where('active_package',1)
  ->sum('extra_package_remaining');

  $total_remaining_session=$sum_slots+$sum_extra_slots;

 return json_encode($total_remaining_session);
  }

public function trainer_slotinsert(Request $request)
{
  
  $req_type=$request->req_type;
  $total_slots=$request->total_slots;
  $customer_id=$request->customer_id; //customer_id
  $remaining_session_request_now=Carbon::now()->toDateString(); // current date

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

    $extra_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining','extra_package_remaining')
    ->where('customer_id',$customer_id)
    ->where('extra_package_remaining','>',0)
    ->where('active_package',1)
    ->first();

    $trainer_id=$request->trainer_id[$i];
    $slots_date=$request->slots_date[$i];
    $slots_time_id=$request->slots_time_id[$i];

    $slot_time=DB::table('slot_times')->where('id',$slots_time_id)->first();

    if($extra_package)
    {

      $oldest_package_id=$extra_package->id;
      $package_remaining=$extra_package->extra_package_remaining;

      $slots_data['customer_id']=$customer_id;
      $slots_data['trainer_id']=$trainer_id;
      $slots_data['purchases_id']=$oldest_package_id;
      $slots_data['slot_date']=$slots_date;
      $slots_data['slot_time_id']=$slots_time_id;
      $slots_data['approval_id']=3;

      $new_remaining_package['extra_package_remaining']=$package_remaining-1;
      
      $insert_slot_session=DB::table('slot_request')->insert($slots_data);

      $update_package_purchase=DB::table('purchases_history')
      ->where('id',$oldest_package_id)
      ->update($new_remaining_package);
      

      $customer_details=Customer::find($customer_id);
      $trainer_details=User::find($trainer_id);

      $notifydata['url'] = '/trainer-login';
      if($notifydata['url'] == '/trainer-login')
      {
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

    $notifydata['url'] = '/customer/mybooking';

    if($notifydata['url'] = '/customer/mybooking')
    {

    $notifydata['url'] = '/customer/mybooking';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Sent Session Request by trainer';
    $notifydata['session_booked_on']=' ';
    $notifydata['session_booking_date']=$slots_date;
    $notifydata['session_booking_time']=$slot_time->time;
    $notifydata['trainer_name']=$trainer_details->name;
    $notifydata['decline_reason']=' ';


    $customer_details->notify(new SessionRequestNotification($notifydata));
  }
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
      $slots_data['approval_id']=3;

      Log::debug(" Check session request data1 ".print_r($slots_data,true));

      $insert_slot_session=DB::table('slot_request')->insert($slots_data);

      $new_remaining_package['package_remaining']=$package_remaining-1;


      $update_package_purchase=DB::table('purchases_history')
      ->where('id',$oldest_package_id)
      ->update($new_remaining_package);


      $customer_details=Customer::find($customer_id);
      $trainer_details=User::find($trainer_id);

      $notifydata['url'] = '/trainer-login';
      if($notifydata['url'] == '/trainer-login')
      {
      $notifydata['customer_name']=$customer_details->name;
      $notifydata['customer_email']=$customer_details->email;
      $notifydata['customer_phone']=$customer_details->ph_no;
      $notifydata['status']='Sent Session Request To Trainer';
      $notifydata['session_booking_date']=$slots_date;
      $notifydata['session_booking_time']=$slot_time->time;
      $notifydata['trainer_name']=$trainer_details->name;


      $trainer_details->notify(new SessionRequestNotificationToTrainer($notifydata));

    }

    $notifydata['url'] = '/customer/mybooking';

    if($notifydata['url'] = '/customer/mybooking')
    {

    $notifydata['url'] = '/customer/mybooking';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Sent Session Request by trainer';
    $notifydata['session_booked_on']=' ';
    $notifydata['session_booking_date']=$slots_date;
    $notifydata['session_booking_time']=$slot_time->time;
    $notifydata['trainer_name']=$trainer_details->name;
    $notifydata['decline_reason']=' ';
    $notifydata['sending_trainer']=Auth::user()->name;


    $customer_details->notify(new SessionRequestNotification($notifydata));
  }
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
    ->where('customer_id',$customer_id)
    ->where('active_package',1)
    ->where('package_remaining','>',0)
    ->where('package_validity_date','>=',$remaining_session_request_now)
    ->sum('package_remaining');

    $sum_extra_slots = DB::table('purchases_history')
    ->select('active_package','package_remaining','extra_package_remaining','customer_id')
    ->where('customer_id',$customer_id)
    ->where('active_package',1)
    ->sum('extra_package_remaining');

    $total_remaining_session=$sum_slots+$sum_extra_slots;

    $trainer_name = Input::get('trainer_name');
    $slots_date = Input::get('slots_date');
    $slots_time = Input::get('slots_time');
    $total_slots = Input::get('total_slots');

    $a=new \stdClass;

    $a->trainer_name=$trainer_name;
    $a->slots_date=$slots_date;
    $a->slots_time=$slots_time;
    $a->total_slots=$total_slots;
        
    $successdata=array('success'=>1,'session_remaining'=>$total_remaining_session,'all_data'=>$a);
    
    return response()->json($successdata);
  }
  else
  {

    $successdata=array('success'=>0,'session_remaining'=>0);

    return response()->json($successdata);
  }  
   
}

public function add_customer_session(Request $request)
{

  Log::debug(" data customer_email ".print_r($request->all(),true)); 
  $remaining_session_request_now=Carbon::now()->toDateString();
   $customer_email=$request->user_email;
Log::debug(" Check all_package  ".print_r($customer_email,true));
    $all_package=DB::table('purchases_history')->join('customers','customers.id','purchases_history.customer_id')
    ->select('purchases_history.id','purchases_history.purchases_date','purchases_history.package_validity_date','purchases_history.package_remaining','customers.id as customer_id','customers.name as customer_name','customers.email as customer_email')
    ->where(function ($query) {
    $query->where('package_remaining', '>', 0)
          ->where('active_package',1)
          ->where('package_validity_date','>=',$remaining_session_request_now)
          ->orWhere('extra_package_remaining', '>', 0);
})->where('customers.email','=', $customer_email)->get()->all();
   
   Log::debug(" Check all_package  ".print_r($all_package,true));
   if($all_package)
    {
      return response()->json(1);
    }
    else{
      return response()->json(2);
    }
  
}

}