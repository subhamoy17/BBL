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

    //number of future pending request
    $future_pending_request=DB::table('slot_request')->where('trainer_id',Auth::user()->id)->where('slot_date','>=',$cur_date)->where('approval_id',1)->count(); 

    //number of future approve request 
    $future_approve_request=DB::table('slot_request')->where('trainer_id',Auth::user()->id)
    ->where(function($q) {
         $q->where('approval_id', 3)
           ->orWhere('approval_id', 4);
     })->where('slot_date','>=',$cur_date)->count(); 

    //number of past request
    $past_request=DB::table('slot_request')->where('trainer_id',Auth::user()->id)->where('slot_date','<',$cur_date)->count();

    //number of decline request
    $decline_request=DB::table('slot_request')->where('trainer_id',Auth::user()->id)->where('approval_id',4)->count();

    

    return view('trainer.home')->with(compact('future_pending_request','future_approve_request','past_request','decline_request'));
}


/**
* Show trainer own profile
*
*/
public function showprofile($id)
{
    Log::debug(":: Show Profile :: ".print_r($id,true));

    $data=DB::table('users')->where('Id',$id)->first();
    Log::debug(":: Trainer data :: ".print_r($data,true));
    return view('trainer.trainerprofile')->with(compact('data'));
}

// open the update form of trainer
public function showupdateform($id)
{
    $data= DB::table('users')->where('id',$id)->first();
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
    (
    [ 'slots_number'=>'required|integer|min:1', //accept only integer and must be minimum value of 1 is required
    'slots_price'=>'required|numeric|between:1,999999.99',//accept only integer and must be minimum value of 1 is required
    'slots_validity'=>'required|integer|min:1',
    // same as slots_number

    'slots_name'=>'required|max:255|unique:slots'
    ]
    );
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
    $data=DB::table('users')
    ->where('master_trainer',2)->whereNull('deleted_at')->get()->all();
    return view('trainer.trainerlist')->with(compact('data'));
}



//trainer ajax function//
public function trainer_active_deactive(Request $request)
{
    $data=$request->get('data');
    $id=$data['id'];
    $action=$data['action'];
    Log::debug(" Check id ".print_r($id,true));
    Log::debug(" Check action ".print_r($action,true));
    if($action=="Active"){

        DB::table('users')
       ->where('id',$id)->update(['is_active'=>1 ]);
        return response()->json(1);
    }
    elseif($action=="Deactive")
    {
        $remaining_session_request_now=Carbon::now()->toDateString();

       DB::table('users')
       ->where('id',$id)->update(['is_active'=>0 ]);


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
            ->orderBy('package_validity_date','DESC')
            ->first();
        
            
            $add_session_remaining=$remaining_package->package_remaining+1;
            

            $update_package_purchase=DB::table('purchases_history')
            ->where('id',$remaining_package->id)
            ->update(['package_remaining'=>$add_session_remaining]);       
        }
       
       $slot_rquest_update=DB::table('slot_request')
       ->where('trainer_id',$id)
       ->where(function($q) {
         $q->where('approval_id', 1)
           ->orWhere('approval_id', 3);
        })
       ->where('slot_date','>=',$remaining_session_request_now)
       ->update(['approval_id'=>4]);

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
        return redirect()->back()->withErrors($validator )
        ->withInput();
    }

    Log::debug(" data ".print_r($request->all(),true)); 
    if($request->image!="")
    {
        $request->validate
        (
            [ 'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048',

            ]
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
    $message->to(Input::get('email'));
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
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->join('slot_times','slot_times.id','slot_request.slot_time_id')
    ->select('slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time')
    ->where('slot_request.slot_date','<',$cur_date)
    ->where('slot_request.trainer_id',$id)->get();
    return view('trainer.past_request_customers')->with(compact('data'));
}



//future customer ajax function//
public function approve_customer_request(Request $request)
{

    $data=$request->get('data');
    $id=$data['id'];
    $action=$data['action'];
    Log::debug(" Check id ".print_r($id,true));
    Log::debug(" Check action ".print_r($action,true));
    if($action=="Approve"){
        DB::table('slot_request')->where('id',$id)->update(['approval_id' =>3,'decline_reason'=>null]);
        return response()->json(1);
    }
    elseif($action=="Decline")
    {
        $reason=$data['comment'];
        $remaining_session_request_now=Carbon::now()->toDateString();

        $customer_id=DB::table('slot_request')->where('id',$id)->first();

        $package_history=DB::table('purchases_history')
        ->where('customer_id',$customer_id->customer_id)
        ->where('purchases_history.active_package',1)
        ->where('purchases_history.package_validity_date','>=',$remaining_session_request_now)
        ->orderBy('package_validity_date','DESC')->first();

        $package_history_update_data['package_remaining']=$package_history->package_remaining+1;

        $package_history_update=DB::table('purchases_history')->where('id',$package_history->id)->update($package_history_update_data);
        
        Log::debug(" package_history_update ".print_r($package_history_update,true));


        DB::table('slot_request')->where('id',$id)->update(['approval_id' => 4, 'decline_reason'=> $reason]);
        return response()->json(2);
    }
}

//future customer list//
public function futureshowlist(Request $request)
{

    $id=$request->id;
    $cur_date =Carbon::now()->toDateString();


    Log::debug("cur_date ".print_r($cur_date,true));

    $cur_time =date("H:i:s");
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->join('slot_times','slot_times.id','slot_request.slot_time_id')
    ->select( 'slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time')->where('slot_request.slot_date','>=',$cur_date)->where(function($q) {
         $q->where('approval_id', 3)
           ->orWhere('approval_id', 4);
     })->where('slot_request.trainer_id',$id)->get();
    return view('trainer.future_request_customers')->with(compact('data'));
}




//future customer pending list//

public function future_pending_showlist(Request $request)
{
    $id=$request->id;
    $cur_date =Carbon::now()->toDateString();
    $cur_time =date("H:i:s");
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->join('slot_times','slot_times.id','slot_request.slot_time_id')
    ->select( 'slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_times.time as slot_time')->where('slot_request.slot_date','>=',$cur_date)->where('slot_request.approval_id',1)->where('slot_request.trainer_id',$id)->get();
    return view('trainer.future_pending_request_customers')->with(compact('data'));

}

//future  pending customer request ajax function//
public function approve_pending_request(Request $request)
{
    $data=$request->get('data');
    $id=$data['id'];
    $action=$data['action'];
    Log::debug(" Check id ".print_r($id,true));
    Log::debug(" Check action ".print_r($action,true));

    if($action=="Approve"){
        DB::table('slot_request')->where('id',$id)->update(['approval_id' =>3,'decline_reason'=>null]);
        return response()->json(1);
    }
    elseif($action=="Decline")
    {

        $reason=$data['comment'];
        $remaining_session_request_now=Carbon::now()->toDateString();

        $customer_id=DB::table('slot_request')->where('id',$id)->first();

        $package_history=DB::table('purchases_history')
        ->where('customer_id',$customer_id->customer_id)
        ->where('purchases_history.active_package',1)
        ->where('purchases_history.package_validity_date','>=',$remaining_session_request_now)
        ->orderBy('package_validity_date','DESC')->first();
        $package_history_update_data['package_remaining']=$package_history->package_remaining+1;


        $package_history_update=DB::table('purchases_history')->where('id',$package_history->id)->update($package_history_update_data);

        
        Log::debug(" package_history_update ".print_r($package_history_update,true));
        DB::table('slot_request')->where('id',$id)->update(['approval_id' => 4, 'decline_reason'=> $reason]);
        return response()->json(2);
    }
}




//all customers table//
public function all_customers()
{
    $data=DB::table('customers')->get();
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
Log::debug(" data ".print_r($request->all(),true)); /// create log for showing error and print resul
if($request->image!=""){
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
    if($trainer_details==2){
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
    Log::debug(" data ".print_r($data,true));
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
    }else{
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
    else
        { $data['image']=$request->oldimage;  }

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
    ->select('customer_mot.*','customers.name')->where('customer_mot.deleted_at',null)->get();
    return view('trainer.customer_mot')->with(compact('data'));

}



public function motinsertshow()
{


    $data=DB::table('customers')->get();
    return view('trainer.motinsertshow')->with(compact('data'));

}




public function motinsert(Request $request){

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




















public function moteditshow($id){
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


public function motdelete($id){
    $updatedata['deleted_at']=Carbon::now();
    DB::table('customer_mot')->where('id',$id)->update($updatedata);
    return redirect('trainer/mot_show')->with("delete","You have successfully deleted one customer's MOT.");
}

public function our_client_show(){
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
    ->select('purchases_history.id','purchases_history.slots_name','purchases_history.slots_price','customers.name','customers.name','purchases_history.payment_options','purchases_history.active_package','payment_history.status','purchases_history.purchases_date','payment_history.payment_id','payment_history.description','payment_history.image','payment_history.payment_mode')->get()->all();

    return view('trainer.payment_history_backend')->with(compact('data'));

}


public function payment_history_backend_request(Request $request)
{
    $data=$request->get('data');
    $purchase_history_id=$data['id'];
    $action=$data['action'];
    
    if($action=="Approve"){

    $slot_number=DB::table('purchases_history')->where('id',$purchase_history_id)->first();

    $update_purchases_history=DB::table('purchases_history')
    ->where('id',$purchase_history_id)->update(['active_package' =>1,'package_remaining'=>$slot_number->slots_number]);

    $update_payment_history=DB::table('payment_history')
    ->where('purchase_history_id',$purchase_history_id)->update(['status'=> 'Success']);

        return response()->json(1);
    }
    elseif($action=="Decline")
    {
      $update_purchases_history=DB::table('purchases_history')
    ->where('id',$purchase_history_id)->update(['active_package' =>0,'package_remaining'=>0]);

    $update_payment_history=DB::table('payment_history')
    ->where('purchase_history_id',$purchase_history_id)->update(['status'=> 'Decline']);

        return response()->json(2);
    }
}



























}