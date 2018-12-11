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
  $this->cart_delete_trainer();
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
  

  return view('trainer.home')->with(compact('future_pending_request','future_approve_request','past_request','decline_request','total_number_of_trainer','total_number_of_customer','total_booking_count_month','total_booking_qtr'));

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
  $this->cart_delete_trainer();
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
  $this->cart_delete_trainer();
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
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();

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

    DB::commit();
    return redirect()->back()->with("success","Your profile has been updated successfully.");

  }
  catch(\Exception $e) {
    DB::rollback();
      return abort(200);
  }
}

/**
* Show slot's record.
*
*/
public function showslot()
{
  try{
  $this->cart_delete_trainer();
  $data=DB::table('slots')->where('deleted_at',null)->get();
  return view('trainer.addslot')->with(compact('data'));
  }
  catch(\Exception $e) {
      return abort(200);
  }
}


/**
* add slot's form record.
*
*/
public function addslot()
{
  $this->cart_delete_trainer();
  return view('trainer.addslotrecord');
}

/**
* add slot's form record.
*
*/
public function insertslot(Request $request)
{
  //DB::beginTransaction();
   //try{
  $this->cart_delete_trainer();
  // create log for showing error and print result
  //Log::debug(" data ".print_r($request->all(),true)); 
  // validation of data
  $request->validate
  ([ 'slots_number'=>'required|integer|min:1', //accept only integer and must be minimum value of 1 is required
    'slots_price'=>'required|numeric|between:1,999999.99',//accept only integer and must be minimum value of 1 is required
    'slots_validity'=>'required|integer|min:1',
    // same as slots_number
   
    // 'slots_name'=>'required|max:255|unique:slots'
    'slots_name' => 'required|max:255|unique:slots,slots_name,NULL,id,deleted_at,NULL'
  ]);

  $data['slots_name']=$request->slots_name;
  $data['slots_number']=$request->slots_number;
  $data['slots_price']=$request->slots_price;
  $data['slots_validity']=$request->slots_validity;
  $data['created_at']=Carbon::now();

  DB::table('slots')->insert($data);
  //DB::commit();
  return redirect('trainer/add-slot')->with("success","You have successfully added one package");

   // }
   // catch(\Exception $e) {
   //   DB::rollback();
   //     return abort(200);
   // }
}


// open the edit form of slots
public function showslotseditform($id)
{
  try{
  $this->cart_delete_trainer();
  $data= DB::table('slots')->where('id',$id)->first();
  Log::debug(" data ".print_r($data,true));
  return view ("trainer.slotseditform")->with(compact('data'));
}
  catch(\Exception $e) {
      return abort(200);
  }
}

// update the slots
public function slotsedit(Request $request)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
  $slotsdata['slots_name']=$request->slots_name;
  $slotsdata['slots_number']=$request->slots_number;
  $slotsdata['slots_price']=$request->slots_price;
  $slotsdata['slots_validity']=$request->slots_validity;
  $slotsdata['updated_at']=Carbon::now();
  DB::table('slots')->where('id',$request->id)->update($slotsdata);
  DB::commit();
  return redirect('trainer/add-slot')->with("success","You have successfully updated one package");
  }
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}


// delete the slots
public function slotsdelete($id)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
  $slotsdata['deleted_at']=Carbon::now();

  DB::table('slots')->where('id',$id)->update($slotsdata);
  DB::commit();
  return redirect('trainer/add-slot')->with("delete","You have successfully deleted one package");
}
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}



public function showlist()
{

  try{
  $this->cart_delete_trainer();
  $data=DB::table('users')->where('master_trainer',2)->whereNull('deleted_at')->get()->all();
  return view('trainer.trainerlist')->with(compact('data'));
  }
  catch(\Exception $e) {
      return abort(200);
  }

}


//trainer ajax function//
public function trainer_active_deactive(Request $request)
{
  
  $this->cart_delete_trainer();
  $data=$request->get('data');
  $id=$data['id'];
  $action=$data['action'];
    
  if($action=="Active")
  {
    $a=DB::table('users')->where('id',$id)->update(['is_active'=>1]);
        
    $trainer_details=User::find($id);

    $notifydata['status']='Trainer Active';
    $notifydata['trainer_name']=$trainer_details->name;

    //Log::debug("Trainer Active notification ".print_r($notifydata,true));

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

    //Log::debug(" total_decline ".print_r($total_decline,true));

    $customer_id=0; $slot_date='';
    foreach($total_decline as $my_total)
    {
      $remaining_package=DB::table('purchases_history')
      ->where('customer_id',$my_total->customer_id)
      ->where('active_package',1)
      ->where('package_remaining','>=',0)
      ->orderBy('package_validity_date','DESC')
      ->first();

      $extra_package=DB::table('purchases_history')
      ->select('id','package_validity_date','package_remaining','extra_package_remaining')
      ->where('customer_id',$customer_id)
      ->where('active_package',1)
      ->where('extra_package_remaining','>=',0)
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

    //Log::debug("Trainer Deactive notification ".print_r($notifydata,true));

    $trainer_details->notify(new TrainerActiveDeactiveNotification($notifydata));

    return response()->json(2);
  }
}


public function addtrainer()
{
  $this->cart_delete_trainer();
    return view('trainer.addtrainer');
}


public function trainerdelete($id)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
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


  //Log::debug(" total_decline ".print_r($total_decline,true));

  foreach($total_decline as $my_total)
  {
    $remaining_package=DB::table('purchases_history')
    ->where('customer_id',$my_total->customer_id)
    ->where('active_package',1)
    ->where('package_remaining','>=',0)
    ->where('package_validity_date','>=',$remaining_session_request_now)
    ->orderBy('package_validity_date','DESC')
    ->first();

    $extra_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining','extra_package_remaining')
    ->where('customer_id',$my_total->customer_id)
    ->where('active_package',1)
    ->where('extra_package_remaining','>=',0)
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

      //Log::debug("Declined Session Request notification ".print_r($notifydata,true));

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

      //Log::debug("Declined Session Request notification ".print_r($notifydata,true));

      $customer_details->notify(new SessionRequestNotification($notifydata));
    }
  }

  $trainer_details=User::find($id);

  $notifydata['status']='Trainer Delete';
  $notifydata['trainer_name']=$trainer_details->name;

  //Log::debug("Trainer Delete notification ".print_r($notifydata,true));

  $trainer_details->notify(new TrainerActiveDeactiveNotification($notifydata));

  $slot_rquest_update=DB::table('slot_request')
  ->where('trainer_id',$id)
  ->where(function($q) {
      $q->where('approval_id', 1)
        ->orWhere('approval_id', 3);
      })
  ->where('slot_date','>=',$remaining_session_request_now)
  ->update(['approval_id'=>4]);

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

  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();

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

  DB::commit();
  return redirect('trainer/trainerlist')->with("success","You have successfully added one trainer");
  }

  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}



public function showtrainerseditform($id)
{

  try{
  $this->cart_delete_trainer();
  $data= DB::table('users')->where('id',$id)->first();
  Log::debug(" data ".print_r($data,true));
  return view ("trainer.edittrainer")->with(compact('data'));
}
catch(\Exception $e) {
      return abort(200);
  }
}


public function traineredit(Request $request)
{ 
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
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
    DB::commit();

    return redirect('trainer/trainerlist')->with("success","You have successfully updated one trainer");
    }
    catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}


//past customer list//
public function pastshowlist(Request $request)
{
  try{
  $this->cart_delete_trainer();
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
  ->where('approval_id','<>',2)->orderBy('slot_request.slot_date', 'ASC')
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
  ->where('slot_request.trainer_id',$id)->orderBy('slot_request.slot_date', 'ASC')->get();
  }
  
  return view('trainer.past_request_customers')->with(compact('data'));

  }
  catch(\Exception $e) {
     
      return abort(200);
  }
}


//past customer list//
public function cancelledshowlist()
{
  try{
  $this->cart_delete_trainer();
  if(Auth::user()->master_trainer==1)
  {
    $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select('slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')
  ->where('approval_id',2)->orderBy('slot_request.slot_date', 'ASC')
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
  ->where('slot_request.trainer_id',Auth::user()->id)->orderBy('slot_request.slot_date', 'ASC')->get();
  }
  
  return view('trainer.cancelled_request_customers')->with(compact('data'));
  }
  catch(\Exception $e) {
      return abort(200);
  }
}

//future customer ajax function//
public function approve_customer_request(Request $request)
{

  $this->cart_delete_trainer();
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
    ->where('purchases_history.package_remaining','>',0)
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
    ->where('package_remaining','>=',0)
    ->where('purchases_history.package_validity_date','>=',$remaining_session_request_now)
    ->orderBy('package_validity_date','DESC')->first();

    $extra_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining','extra_package_remaining')
    ->where('customer_id',$customer_id->customer_id)
    ->where('active_package',1)
    ->where('extra_package_remaining','>=',0)
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
  try{
  $this->cart_delete_trainer();
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
  })->orderBy('slot_request.slot_date', 'ASC')->get();
  
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
  })->where('slot_request.trainer_id',$id)->orderBy('slot_request.slot_date', 'ASC')->get();
}
  
  
  return view('trainer.future_request_customers')->with(compact('data'));

}
  catch(\Exception $e) {
     
      return abort(200);
  }
}


//future customer pending list//

public function future_pending_showlist(Request $request)
{
  try{
  $this->cart_delete_trainer();
  $id=$request->id;
  $cur_date =Carbon::now()->toDateString();
  $cur_time =date("H:i:s");

  if(Auth::user()->master_trainer==1){
 $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select( 'slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')->where('slot_request.slot_date','>=',$cur_date)->where('slot_request.approval_id',1)->orderBy('slot_request.slot_date', 'ASC')->get();

        }

   else{
  $data=DB::table('slot_request')
  ->join('customers','customers.id','slot_request.customer_id')
  ->join('users','users.id','slot_request.trainer_id')
  ->join('slot_approval','slot_approval.id','slot_request.approval_id')
  ->join('slot_times','slot_times.id','slot_request.slot_time_id')
  ->select( 'slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time','users.name as trainer_name')->where('slot_request.slot_date','>=',$cur_date)->where('slot_request.approval_id',1)->where('slot_request.trainer_id',$id)->orderBy('slot_request.slot_date', 'ASC')->get();

     }       
  
  return view('trainer.future_pending_request_customers')->with(compact('data'));
}
catch(\Exception $e) {
      return abort(200);
  }
}

//future  pending customer request ajax function//
public function approve_pending_request(Request $request)
{
  $this->cart_delete_trainer();
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
    ->where('package_remaining','>=',0)
    ->where('purchases_history.package_validity_date','>=',$remaining_session_request_now)
    ->orderBy('package_validity_date','DESC')->first();

    $extra_package=DB::table('purchases_history')
    ->select('id','purchases_date','package_validity_date','package_remaining','extra_package_remaining')
    ->where('customer_id',$customer_id->customer_id)
    ->where('active_package',1)
    ->where('extra_package_remaining','>=',0)
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
  try{
  $this->cart_delete_trainer();
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
  $this->cart_delete_trainer();
  return view('trainer.exercise_insert_details');
}

//gym insert function//
public function exercise_user_insert(Request $request)
{

  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
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
  DB::commit();
  return redirect('trainer/gymType')->with("success","You have successfully added one exercise.");
}
catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}

//gym view function//
public function gym_showlist(Request $request)
{ 
  try{
  $this->cart_delete_trainer();
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
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
  DB::table('exercise_details')->delete($id);
  DB::commit();
  return redirect()->back()->with("delete","You have successfully deleted one exercise.");
}
catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}
//gym edit form//
public function show_edit_exercise_form($id)
{
  try{
  $this->cart_delete_trainer();
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

  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
  
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

  DB::commit();
  return redirect()->route("gymType")->with("success","You have successfully updated one exercise.");

}

  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }

}



//feedback function//
public function feedbacklist(Request $request)
{
  try{
  $this->cart_delete_trainer();
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
  $this->cart_delete_trainer();
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
  $this->cart_delete_trainer();
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
  $this->cart_delete_trainer();
  return view('trainer.testimonial_backend');
}
catch(\Exception $e) {
      return abort(200);
  }
}

public function testimonialinsert(Request $request)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
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
  DB::commit();
  return redirect('trainer/testimonial_view')->with("success","You have successfully added one testimonial.");
}
catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}

// open the edit form of slots
public function testimonialedit($id)
{
  try{
  $this->cart_delete_trainer();
  $data= DB::table('testimonial')->where('id',$id)->first();
  Log::debug(" data ".print_r($data,true));
  return view ("trainer.edit_testimonial")->with(compact('data'));
}
catch(\Exception $e) {
      return abort(200);
  }
}

public function testimonialupdate(Request $request)
{ 
DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
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
  DB::commit();
  return redirect('trainer/testimonial_view')->with("success","You have successfully updated one testimonial.");
}
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }

}


public function testimonialdelete($id)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
  $updatedata['deleted_at']=Carbon::now();

  DB::table('testimonial')->where('id',$id)->update($updatedata);
  DB::commit();
  return redirect('trainer/testimonial_view')->with("delete","You have successfully deleted one testimonial.");
}
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}

public function mot_show(Request $request)
{
  try{
  $this->cart_delete_trainer();
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
DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
  $data=DB::table('customers')->get();
  DB::commit();
  return view('trainer.motinsertshow')->with(compact('data'));
}
catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}


public function motinsertshowauto(Request $request)
{
  Log::debug(" motinsertshowauto ".print_r($request->all(),true)); 
$this->cart_delete_trainer();
  $query = $request->get('term','');
    
      
        Log::debug ( " :: query :: ".print_r ($query,true));    
        $products=DB::table('customers')->where('name','LIKE','%'.$query.'%')->orwhere('email','LIKE','%'.$query.'%')->orwhere('ph_no','LIKE','%'.$query.'%')->get();
        
        $data=array();
        $data1=array();
        foreach ($products as $product) {
               
          $data[]=array('value'=>$product->name,'id'=>$product->id, 'email'=>$product->email,'ph_no'=>$product->ph_no );

               
        }

        Log::debug ( " :: motinsertshowauto :: ".print_r ($data,true));
        Log::debug ( " :: products :: ".print_r ($products,true));

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
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
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

// print_r($data);die();
    DB::table('customer_mot')->insert($data);
    Log::debug(" customer_mot ".print_r($data,true));

    DB::commit();
    return redirect('trainer/mot_show')->with("success","You have successfully added one customer's MOT.");
  }
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }

}




public function mot_customer_request(Request $request)
{
  $this->cart_delete_trainer();
  $data=$request->get('data');
  $id=$data['id'];
  $positions = DB::table('customer_mot')->where('customer_id',$id)->orderBy('date','DESC')->first();
  Log::debug(" Check id ".print_r($positions,true));
  return response()->json($positions);
}

public function moteditshow($id)
{
  try{
  $this->cart_delete_trainer();
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

  DB::beginTransaction();
  try{

  $this->cart_delete_trainer();
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
    DB::commit();
    return redirect('trainer/mot_show')->with("success","You have successfully updated one customer's MOT.");
  }
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }

}


public function motdelete($id)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
  $updatedata['deleted_at']=Carbon::now();
  DB::table('customer_mot')->where('id',$id)->update($updatedata);
  DB::commit();
  return redirect('trainer/mot_show')->with("delete","You have successfully deleted one customer's MOT.");
}
catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}

public function our_client_show()
{
  try{
  $this->cart_delete_trainer();
  $data=DB::table('our_client')->where('deleted_at',null)->get();
  return view('trainer.our_client_list')->with(compact('data'));
}catch(\Exception $e) {
      
      return abort(200);
  }
}


public function client_insert_view()
{
  $this->cart_delete_trainer();
  return view('trainer.client_insert_view');
}


public function client_insert(Request $request)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
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

    DB::commit();
    return redirect('trainer/our_trainer_list')->with("success","One trainer is insert successfully !");

  }
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}

public function client_edit_view($id)
{
  try{
  $this->cart_delete_trainer();
    $data= DB::table('our_client')->where('id',$id)->first();
    Log::debug(" data ".print_r($data,true));
    return view ("trainer.client_edit_view")->with(compact('data'));
  }
  catch(\Exception $e) {
      return abort(200);
  }


}

public function client_update(Request $request)
{ 
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
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
    DB::commit();
    return redirect('trainer/our_trainer_list')->with("success","One trainer details updated successfully!");
  }
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }

}

public function client_delete($id)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
    $updatedata['deleted_at']=Carbon::now();

    DB::table('our_client')->where('id',$id)->update($updatedata);
    DB::commit();
    return redirect('trainer/our_trainer_list')->with("delete","One trainer is deleted successfully !");
  }

    catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}





public function payment_history_backend()
{
  try{
  $this->cart_delete_trainer();

    $data=DB::table('purchases_history')
    ->join('customers','customers.id','purchases_history.customer_id')
    ->join('payment_history','payment_history.purchase_history_id','purchases_history.id')
    ->select('purchases_history.id','purchases_history.slots_name','purchases_history.slots_price','customers.name','customers.name','purchases_history.payment_options','purchases_history.active_package','payment_history.status','purchases_history.purchases_date','payment_history.payment_id','payment_history.description','payment_history.image','payment_history.payment_mode')
    ->orderBy('payment_history.payment_mode','ASC')->orderBy('payment_history.id','DESC')->get()->all();

    return view('trainer.payment_history_backend')->with(compact('data'));
  }

  catch(\Exception $e) {
      return abort(200);
  }


}


public function payment_history_backend_request(Request $request)
{
  $this->cart_delete_trainer();
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
    $this->cart_delete_trainer();
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
    $this->cart_delete_trainer();
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
    $this->cart_delete_trainer();

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
    $this->cart_delete_trainer();

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
  $this->cart_delete_trainer();
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

public function admin_get_current_slot_time(Request $request)
{
  $this->cart_delete_trainer();
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
    
    $final_slot_trainer=DB::table('users')->whereNull('deleted_at')->where('is_active', 1)->whereNotIn('id',$old_trainer_id)->get();
  }
 else
  {
    //Log::debug(" not equal");
    $final_slot_trainer=DB::table('users')->whereNull('deleted_at')->where('is_active', 1)->whereNotIn('id',$get_slot_trainer)->get();
  }

  
  return json_encode($final_slot_trainer);
}




public function slot_insert_to_cart_trainer(Request $request)
{

  $cart_data['trainer_id']=$request->trainer_id;
  $cart_data['slot_date']=$request->slot_date;
  $cart_data['slot_time_id']=$request->slots_time_id;
  $cart_data['approval_id']=3;
  $cart_data['request_trainer_id']=Auth::user()->id;

  $insert_cart=DB::table('cart_slot_request')->insert($cart_data);

  $id = DB::getPdo()->lastInsertId();

   return json_encode($id);

}

public function cart_data_delete_trainer(Request $request)
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



  public function add_session(Request $request)
  {
    $this->cart_delete_trainer();
  $remaining_session_request_now=Carbon::now()->toDateString();  
  $customers=DB::table('customers')->whereNull('deleted_at')->where('confirmed',1)->get();
  $data=DB::table('users')->whereNull('deleted_at')->where('is_active',1)->get();
  $all_times=DB::table('slot_times')->get()->all();

  $sum_slots = DB::table('purchases_history')
  ->select('active_package','package_remaining','customer_id')  
  ->where('active_package',1 )
  ->where('package_remaining','>',0)
  ->where('package_validity_date','>=',$remaining_session_request_now)
  ->sum('package_remaining');

  $sum_extra_slots = DB::table('purchases_history')
  ->select('active_package','package_remaining','extra_package_remaining','customer_id')
  ->where('active_package',1)
  ->where('extra_package_remaining','>',0)
  ->sum('extra_package_remaining');

  $trainer_data=DB::table('users')->whereNull('deleted_at')->where('is_active',1)->get();
 
  $total_remaining_session=$sum_slots+$sum_extra_slots;
    return view('trainer.add_session')->with(compact('data','total_remaining_session','customers','trainer_data','all_times'));
  }

  

public function customersearch(Request $request)
{
  $this->cart_delete_trainer();

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

    $this->cart_delete_trainer();
    $remaining_session_request_now=Carbon::now()->toDateString(); // current date

  $sum_slots = DB::table('purchases_history')
  ->select('active_package','package_remaining','customer_id')
  ->where('customer_id',$request->get('data'))
  ->where('active_package',1 )
  ->where('package_remaining','>',0)
  ->where('package_validity_date','>=',$remaining_session_request_now)
  ->sum('package_remaining');

  $sum_extra_slots = DB::table('purchases_history')
  ->select('active_package','package_remaining','extra_package_remaining','customer_id')
  ->where('customer_id',$request->get('data'))
  ->where('active_package',1)
  ->where('extra_package_remaining','>',0)
  ->sum('extra_package_remaining');

  $total_remaining_session=$sum_slots+$sum_extra_slots;

 return json_encode($total_remaining_session);
  }

public function trainer_slotinsert(Request $request)
{
  $this->cart_delete_trainer();

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
    ->where('package_remaining','>=',0)
    ->where('package_validity_date','>=',$remaining_session_request_now)
    ->sum('package_remaining');

    $sum_extra_slots = DB::table('purchases_history')
    ->select('active_package','package_remaining','extra_package_remaining','customer_id')
    ->where('customer_id',$customer_id)
    ->where('active_package',1)
    ->where('extra_package_remaining','>=',0)
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

  $this->cart_delete_trainer();

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

public function admin_get_time(Request $request)
{

  $this->cart_delete_trainer();
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

  $this->cart_delete_trainer();

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
  $this->cart_delete_trainer();
  $bootcamp_details=DB::table('bootcamp_plans')
  ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plans.address_id')
  ->select('bootcamp_plans.id as bootcamp_id','bootcamp_plans.mon_session_flg as monday','bootcamp_plans.tue_session_flg as tuesday','bootcamp_plans.wed_session_flg as wednesday','bootcamp_plans.thu_session_flg as thursday','bootcamp_plans.fri_session_flg as friday','bootcamp_plans.sat_session_flg as saturday','bootcamp_plans.sun_session_flg as sunday','bootcamp_plans.session_st_time as session_st_time','bootcamp_plans.session_end_time as session_end_time','bootcamp_plans.plan_st_date as plan_st_date','bootcamp_plans.plan_end_date as plan_end_date','bootcamp_plans.never_expire as never_expire','bootcamp_plans.max_allowed as max_allowed','bootcamp_plans.status as status','bootcamp_plan_address.address_line1 as address')
  ->orderby('bootcamp_plans.id','DESC')->whereNull('bootcamp_plans.deleted_at')->get();

    return view('trainer.bootcamp_plan_list')->with(compact('bootcamp_details'));
  }
  catch(\Exception $e) {
    return abort(200);
  }
}


public function bootcamp_plan_edit_view($id)
{
  try{
    $this->cart_delete_trainer();
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
   try{

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

    //Log::debug(" all_booking_schedule ".print_r($all_booking_schedule,true));

    if(count($all_booking_schedule)>0)
    {
      DB::commit();
      return redirect()->back()->with('enddate_decrement','There are some bookings for this bootcamp plan to save the changes you have to decline those booking(s) manually');
    }
    else
    {
      DB::table('bootcamp_plan_shedules')->whereIn('plan_date',$all_session_date)
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
  $this->cart_delete_trainer();

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

  $all_booking_schedule=DB::table('bootcamp_plan_shedules')->whereIn('plan_date',$all_session_date)->where('no_of_uses','>',0)->get()->all();

  //Log::debug(" all_booking_schedule ".print_r($all_booking_schedule,true));

  if(count($all_booking_schedule)>0)
  {
    DB::commit();
    return redirect()->back()->with('cancele_delete','There are some bookings for this bootcamp plan to save the changes you have to decline those booking(s) manually');
  }
  else
  {
    $bootcamp_plan_delete['deleted_at']=Carbon::now();

    DB::table('bootcamp_plans')->where('id',$id)->update($bootcamp_plan_delete);

    DB::table('bootcamp_plan_shedules')->whereIn('plan_date',$all_session_date)
      ->where('bootcamp_plan_id',$id)->delete();
   DB::commit();
    return redirect('trainer/bootcamp-plan')->with("success","You have successfully deleted one bootcamp plan");
  }
}
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}

  public function cart_delete_trainer()
{
  $cart_delete=DB::table('cart_slot_request')->where('request_trainer_id',Auth::user()->id)->delete();
}

  public function bootcamp_plan_schedule()
  {
    
    $all_schedules=DB::table('bootcamp_plan_shedules')
    ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
    ->select('bootcamp_plan_shedules.id as schedule_id','bootcamp_plan_shedules.plan_date','bootcamp_plan_shedules.plan_day','bootcamp_plan_shedules.plan_st_time','bootcamp_plan_shedules.plan_end_time','bootcamp_plan_address.address_line1','bootcamp_plan_shedules.max_allowed','bootcamp_plan_shedules.no_of_uses','bootcamp_plan_shedules.bootcamp_plan_id','bootcamp_plan_shedules.deleted_at')
    ->get();
  
    return view('trainer.bootcamp_plan_schedule_list')->with(compact('all_schedules'));
  }

  public function bootcamp_schedule_cancelled_admin(Request $request)
  {
    //Log::debug(" bootcamp_schedule_cancelled_admin ".print_r($request->all(),true));
    DB::beginTransaction();
  try{

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
      $return_sessions=DB::table('order_details')
      ->where('customer_id',$each_customer->customer_id)
      ->where('order_validity_date','>=',$today)
      ->where('status',1)
      ->orderby('order_validity_date','DESC')
      ->first();

      //Log::debug(" bootcamp_schedule_cancelled_admin 2 ".print_r($return_sessions,true));

      if($return_sessions->remaining_sessions!='Unlimited')
      {
        $return_sessions=DB::table('order_details')
        ->where('customer_id',$each_customer->customer_id)
        ->where('order_validity_date','>=',$today)
        ->where('status',1)
        ->where('remaining_sessions','!=','Unlimited')
        ->where('id',$return_sessions->id)
        ->increment('remaining_sessions',1);
      }

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

  public function bootcamp_booking_individual_cancelled($id)
  {
    try{
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

  public function individual_bootcamp_cancele($id)
  {
    //Log::debug(":: allcustomer :: ".$id);
    

    DB::beginTransaction();
  try{

    $all=explode('_',$id);
    $schedule_id=$all[0];
    $customer_id=$all[1];

    $current_date=Carbon::now()->toDateString();

    $customer_booking_details=DB::table('bootcamp_booking')
    ->join('customers','customers.id','bootcamp_booking.customer_id')
    ->join('bootcamp_plan_shedules','bootcamp_plan_shedules.id','bootcamp_booking.bootcamp_plan_shedules_id')
    ->join('bootcamp_plan_address','bootcamp_plan_address.id','bootcamp_plan_shedules.address_id')
    ->select('customers.id as customer_id','customers.name as customer_name','customers.email as customer_email','customers.ph_no as customer_phone','bootcamp_booking.bootcamp_plan_shedules_id as shedule_id','bootcamp_booking.deleted_at','bootcamp_booking.created_at as booked_on','bootcamp_plan_shedules.plan_date as shedule_date','bootcamp_plan_shedules.plan_st_time as plan_st_time','bootcamp_plan_shedules.plan_end_time as plan_end_time','bootcamp_plan_shedules.plan_day as plan_day','bootcamp_plan_address.address_line1')
    ->where('bootcamp_booking.bootcamp_plan_shedules_id',$schedule_id)
    ->where('customers.id',$customer_id)
    ->first();


    $client_details=Customer::find($customer_booking_details->customer_id);

    // Log::debug(":: customer_booking_details :: ".print_r($customer_booking_details,true));

    $cancelled_booking=DB::table('bootcamp_booking')->where('customer_id',$customer_booking_details->customer_id)->where('bootcamp_plan_shedules_id',$schedule_id)->update(['deleted_at'=>Carbon::now(),'cancelled_by'=>2]);

    $cancelled_booking_schedule=DB::table('bootcamp_plan_shedules')
    ->where('id',$schedule_id)->decrement('no_of_uses',1);

    $no_of_session_unlimited=DB::table('order_details')
    ->join('products','products.id','order_details.product_id')
    ->join('training_type','training_type.id','products.training_type_id')
    ->select('order_details.id as order_id','order_details.remaining_sessions as remaining_sessions')
    ->where('order_details.customer_id',$customer_booking_details->customer_id)
    ->where('order_details.status',1)
    ->where('training_type.id',2)
    ->where('order_details.order_validity_date','>=',$current_date)
    ->where('order_details.remaining_sessions','Unlimited')
    ->orderBy('order_details.order_validity_date', 'ASC')->first();

  $no_of_session_notunlimited=DB::table('order_details')
  ->join('products','products.id','order_details.product_id')
  ->join('training_type','training_type.id','products.training_type_id')
  ->select('order_details.id as order_id','order_details.remaining_sessions as remaining_sessions')
  ->where('order_details.customer_id',$customer_booking_details->customer_id)
  ->where('order_details.status',1)
  ->where('training_type.id',2)
  ->where('order_details.order_validity_date','>=',$current_date)
  ->orderBy('order_details.order_validity_date', 'ASC')->first();


  if(empty($no_of_session_unlimited))
  { 
    $increase_remaining_session=DB::table('order_details')->where('id',$no_of_session_notunlimited->order_id)->increment('remaining_sessions',1);
  }


  $notifydata['url'] = '/customer/mybooking';
  $notifydata['customer_name']=$client_details->name;
  $notifydata['customer_email']=$client_details->email;
  $notifydata['customer_phone']=$client_details->ph_no;
  $notifydata['status']='Cancelled Bootcamp Session By Admin';
  $notifydata['session_booked_on']=$customer_booking_details->booked_on;
  $notifydata['session_booking_date']=$customer_booking_details->shedule_date;
  $notifydata['session_booking_day']=$customer_booking_details->plan_day;
  $notifydata['session_booking_time']=date('h:i A', strtotime($customer_booking_details->plan_st_time)).' to '.date('h:i A', strtotime($customer_booking_details->plan_end_time));
  $notifydata['cancelled_reason']='';
  $notifydata['schedule_address']=$customer_booking_details->address_line1;

  $client_details->notify(new BootcampSessionNotification($notifydata));
   

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
// Log::debug(":: insert_common_diet_plan :: ".print_r($request->all(),true));
    DB::beginTransaction();
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
        DB::commit();
        return redirect('trainer/common-diet-plan')->with("success","You have successfully added a diet plan.");
        
    }
    catch(\Exception $e) 
    {
      
      DB::rollback();
      return abort(200);
    }
  }

  //Delete diet plan from list
  public function delete_common_diet_plan($id)
  {
    DB::beginTransaction();
    try{
    $this->cart_delete_trainer();
      $updatedata['deleted_at']=Carbon::now();
      DB::table('common_diet_plan')->where('id',$id)->update($updatedata);
      DB::commit();
      return redirect('trainer/common-diet-plan')->with("delete","One diet plan is deleted successfully !");
    }
      catch(\Exception $e) {
        DB::rollback();
        return abort(200);
    }
  }

  //Edit common diet plan
  public function edit_common_diet_plan($id)
  {
    try{
    $this->cart_delete_trainer();
    $diet= DB::table('common_diet_plan')->find($id);
    return view ("trainer.edit-common-diet-plan",compact('diet'));
    }
    catch(\Exception $e) {
        return abort(200);
    }
  }

  public function update_common_diet_plan(Request $request)
  { 

    DB::beginTransaction();
    try
    {
      $this->cart_delete_trainer();  

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

      DB::commit();
      return redirect('trainer/common-diet-plan')->with("editsuccess","You have successfully update your diet plan");
      
    
    }
    catch(\Exception $e) {
        DB::rollback();
        return abort(200);
    }
  }

  function checkDietPlan_duplicate(Request $request)
  {

    Log::debug(":: request :: ".print_r($request->all(),true));
    
    $dietPlanName=$request->diet_plan_name;
    $dietPlanName=preg_replace('/\s+/', ' ', $dietPlanName);
    
    $dietPlanList=DB::table('common_diet_plan')->where('diet_plan_name',$dietPlanName)->whereNull('deleted_at')->count();

    if($dietPlanList>0)
    {
      return 1;
    }
    else
    {
      return 0;
    }
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

    if($duplicate_diet_plan==1)
    {
      return 1;
    }
    else
    {
      return 0;
    }

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

public function add_coupon()
{
  try{
  $this->cart_delete_trainer();
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

  DB::beginTransaction();
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
  DB::commit();
  return redirect('trainer/our_coupon_list')->with("success","You have successfully added one coupon");

  }

  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
  
}

function duplicatecoupon(Request $request)
  {
    $this->cart_delete_trainer();
    $duplicatecoupon=$request->coupon_code;
    $apply_slots=$request->apply_slots;
    $duplicatecoupon=preg_replace('/\s+/', ' ', $duplicatecoupon);
    
    $duplicatecoupon_details=DB::table('slots_discount_coupon')->where('coupon_code',$duplicatecoupon)->where('slots_id',$apply_slots)->whereNull('slots_discount_coupon.deleted_at')->count();

    if($duplicatecoupon_details>0)
    {
      return 1;
    }
    else
    {
      return 0;
    }
  }

public function our_coupon_list(Request $request)
{
   try{
  $this->cart_delete_trainer();
  $all_cupon_data=DB::table('slots_discount_coupon')->join('slots','slots.id','slots_discount_coupon.slots_id')->select('slots_discount_coupon.id as coupon_id','slots_discount_coupon.coupon_code','slots_discount_coupon.discount_price','slots_discount_coupon.valid_from','slots_discount_coupon.valid_to','slots_discount_coupon.is_active','slots.id as slots_id','slots.slots_name as slots_name')->whereNull('slots_discount_coupon.deleted_at')->get()->all();
  return view('trainer.viewcoupon')->with(compact('all_cupon_data'));
}catch(\Exception $e) { 
    return abort(200);
  }
}


public function our_coupon_edit_view($id)
{
  
  try{
  $this->cart_delete_trainer();
    $edit_coupondata= DB::table('slots_discount_coupon')->join('slots','slots.id','slots_discount_coupon.slots_id')->select('slots_discount_coupon.id','slots_discount_coupon.coupon_code','slots_discount_coupon.discount_price','slots_discount_coupon.valid_from','slots_discount_coupon.valid_to','slots.id as slots_id','slots.slots_name as slots_name','slots_discount_coupon.is_active')->where('slots_discount_coupon.id',$id)->first();
    Log::debug(" data ".print_r($edit_coupondata,true));
    return view ("trainer.editcoupon")->with(compact('edit_coupondata'));
  }
catch(\Exception $e) {
      
      return abort(200);
  }

}

public function coupon_edit_insert(Request $request)
{
    $daterange=$request->daterange; 
    $mode_of_date=explode(" - ",$daterange);
    $format = 'Y-m-d';
    $startDate=$mode_of_date[0];
    $endDate=$mode_of_date[1];
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
  $edit_coupondata['slots_id']=$request->slots_id;
  $edit_coupondata['coupon_code']=$request->coupon_code;
  $edit_coupondata['discount_price']=$request->discount_price;
  $edit_coupondata['valid_from']=$startDate;
  $edit_coupondata['valid_to']=$endDate;
  $edit_coupondata['is_active']=$request->is_active;
  $edit_coupondata['updated_at']=Carbon::now();
  DB::table('slots_discount_coupon')->where('id',$request->id)->update($edit_coupondata);
  DB::commit();
  return redirect('trainer/our_coupon_list')->with("success","You have successfully updated one coupon");
  }
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}

function duplicatecoupon_edit(Request $request)
  {
    $this->cart_delete_trainer();
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

  
    if($duplicate_cat==1)
    {
      return 1;
    }
    else
    {
      return 0;
    }
  }

public function coupon_delete($id)
{
  DB::beginTransaction();
  try{
  $this->cart_delete_trainer();
  $coupon_delete['deleted_at']=Carbon::now();

  DB::table('slots_discount_coupon')->where('id',$id)->update($coupon_delete);
  DB::commit();
  return redirect('trainer/our_coupon_list')->with("success","You have successfully deleted one coupon");
}
  catch(\Exception $e) {
      DB::rollback();
      return abort(200);
  }
}

function checkdiscount_price(Request $request)
  {
    $this->cart_delete_trainer();
    $discount_price=$request->discount_price;
    $apply_slots=$request->apply_slots;
    $discount_price=preg_replace('/\s+/', ' ', $discount_price);
    
    // $checkdiscount_price=DB::table('slots_discount_coupon')->where('coupon_code',$duplicatecoupon)->where('slots_id',$apply_slots)->whereNull('slots_discount_coupon.deleted_at')->value('discount_price');
 $checkdiscount_price=DB::table('slots')->where('slots.id',$apply_slots)->whereNull('slots.deleted_at')->value('slots_price');
 Log::debug(" checkdiscount_price ".print_r($checkdiscount_price,true));
    if($discount_price >= $checkdiscount_price  )
    {
      return 2;
    }
    else
    {
      return 0;
    }
  }

function checkdiscount_price_edit(Request $request)
  {
    $this->cart_delete_trainer();
    $discount_price=$request->discount_price;
    $apply_slots=$request->slots_id;
    $discount_price=preg_replace('/\s+/', ' ', $discount_price);

 $checkdiscount_price=DB::table('slots')->where('slots.id',$apply_slots)->whereNull('slots.deleted_at')->value('slots_price');

 Log::debug(" checkdiscount_price ".print_r($checkdiscount_price,true));
 Log::debug(" discount_price ".print_r($discount_price,true));
    if($discount_price >= $checkdiscount_price  )
    {
      return 2;
    }
    else
    {
      return 0;
    }
  }

  public function diet_plan_purchases(Request $request)
{
  
   try{
 $this->cart_delete_trainer();
 $diet_plan_purchases=DB::table('common_diet_plan_purchases_history')->join('customers','customers.id','common_diet_plan_purchases_history.plan_purchase_by')->join('common_diet_plan','common_diet_plan.id','common_diet_plan_purchases_history.plan_id')->select('common_diet_plan_purchases_history.id as diet_plan_id','common_diet_plan_purchases_history.plan_name as plan_name','common_diet_plan_purchases_history.plan_price as plan_price','common_diet_plan_purchases_history.plan_purchase_by as plan_purchase_by','common_diet_plan_purchases_history.payment_reference_id as payment_reference_id','common_diet_plan_purchases_history.purchase_date as purchase_date', 'common_diet_plan_purchases_history.status as status','common_diet_plan.diet_plan_name as diet_plan_name','common_diet_plan.id as common_diet_plan_id','customers.id as customers_id','customers.name as customers_name')->get();

 // Log::debug(" data diet_plan_purchases ".print_r($diet_plan_purchases,true));
  return view('trainer.diet_plan_purchases_history')->with(compact('diet_plan_purchases'));
}
catch(\Exception $e) {

      return abort(200);
  }
}

public function add_product()
{
  try{
    $all_traning_type=DB::table('training_type')->where('id',2)->get();
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
  
  DB::beginTransaction();
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
DB::commit();
  return redirect('trainer/all-products')->with("success","You have successfully added one product");
  }
   catch(\Exception $e) {
     DB::rollback();
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

  
  
  //Log::debug(":: product_details :: ".print_r($product_details,true));

  return view('trainer.edit_product')->with(compact('product_details','all_traning_type','all_payment_type','all_slot_time','product_day'));
  }
  catch(\Exception $e) {
      return abort(200);
   }
}

public function update_product(Request $request)
{
  //Log::debug(":: product_details :: ".print_r($request->all(),true));

  DB::beginTransaction();
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

  
    DB::commit();
  return redirect('trainer/all-products')->with("success","You have successfully updated one product");
  }
   catch(\Exception $e) {
     DB::rollback();
       return abort(200);
   }

  
}

public function product_delete($id)
{
  try{
  $delete_data['deleted_at']=Carbon::now();
  $delete_product=DB::table('products')->where('id',$id)->update($delete_data);
  
  return redirect('trainer/all-products')->with("success","You have successfully deleted one product");
  }
  catch(\Exception $e) {
     
      return abort(200);
   }

}


public function view_product(Request $request)
{
   try{
  $this->cart_delete_trainer();
  

  $all_products_data=DB::table('products')
  ->join('training_type','products.training_type_id','training_type.id')
  ->join('payment_type','products.payment_type_id','payment_type.id')
  ->select('products.id as product_id','products.payment_type_id as payment_type_id','products.deleted_at as deleted_at','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.price_session_or_month as price_session_or_month','products.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.status as status','products.notice_period_duration as notice_period_duration',(DB::raw('products.validity_value * products.validity_duration  as validity')),(DB::raw('products.notice_period_value * products.notice_period_duration  as notice_period')))
  
  ->orderby('products.id','DESC')->get();

  // Log::debug(":: personal_training_product_details :: ".print_r($personal_training_product_details,true));
  

  

  return view('trainer.allproducts')->with(compact('all_products_data','products_day_time','products_st_time','products_end_time'));
}catch(\Exception $e) { 
    return abort(200);
  }
}


public function order_history(Request $request)
{
   try{
  $this->cart_delete_trainer();
  

  $all_order_history=DB::table('order_details')->join('products','products.id','order_details.product_id')->join('payment_history','payment_history.id','order_details.payment_id')->join('training_type','training_type.id','products.training_type_id')->join('payment_type','payment_type.id','products.payment_type_id')->join('customers','customers.id','order_details.customer_id')->select('order_details.id as order_details_id','order_details.customer_id as customer_id','order_details.order_purchase_date as order_purchase_date','order_details.remaining_sessions as remaining_sessions','order_details.payment_type as payment_type','order_details.training_type as training_type','order_details.order_validity_date as order_validity_date','order_details.payment_option as payment_option','order_details.status as status','products.training_type_id as training_type_id', 'products.total_sessions as total_sessions', 'order_details.price_session_or_month as price_session_or_month','products.id as product_id','order_details.total_price as total_price','products.validity_value as validity_value','products.validity_duration as validity_duration','training_type.training_name as training_name','payment_type.payment_type_name as payment_type_name','customers.name as customer_name','payment_type.payment_type_name as payment_type_name','payment_history.payment_id as payment_id','payment_history.description as description','payment_history.image as image','payment_history.status as payment_status')->whereNull('order_details.deleted_at')
  ->orderby('order_details.id','DESC')->get();

  // Log::debug(":: personal_training_product_details :: ".print_r($all_order_history,true));
  
  return view('trainer.customer_order_history')->with(compact('all_order_history'));
}catch(\Exception $e) { 
    return abort(200);
  }
}



public function order_history_backend_request(Request $request)
{
  $this->cart_delete_trainer();
    $data=$request->get('data');
    $purchased_history_id=$data['id'];
    $action=$data['action'];

    $order_details=DB::table('order_details')->where('id',$purchased_history_id)->first();
    
    if($action=="Approve"){

    $update_purchases_history=DB::table('order_details')
    ->where('id',$purchased_history_id)->update(['status' =>1,'remaining_sessions'=>$order_details->no_of_sessions]);

    $update_payment_history=DB::table('payment_history')
    ->where('id',$order_details->payment_id)->update(['status'=> 'Success']);

    // send notification mail

    return response()->json(1);
    }
    elseif($action=="Decline")
    {

    $update_payment_history=DB::table('payment_history')
    ->where('id',$order_details->payment_id)->update(['status'=> 'Decline']);

    // send notification mail

    return response()->json(2);
    }
}



}