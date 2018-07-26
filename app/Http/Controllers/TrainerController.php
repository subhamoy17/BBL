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
    return view('trainer.home');

}
/**
* Show trainer own profile
*
*/
public function showprofile($id)
{
    Log::debug(":: Show Profile :: ".print_r($id,true));
// echo "asd";die();
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

// Log::debug("::Inserted::".print_r($myimage,true));
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
    return redirect()->back()->with("success","Your profile is update successfully !");
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
Log::debug(" data ".print_r($request->all(),true)); /// create log for showing error and print result
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
return redirect('trainer/add-slot')->with("success","Your new record of slot is insert successfully !");
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

    $slotsdata['slots_name']=$request->slots_name;
    $slotsdata['slots_number']=$request->slots_number;
    $slotsdata['slots_price']=$request->slots_price;
    $slotsdata['slots_validity']=$request->slots_validity;
    $slotsdata['updated_at']=Carbon::now();
    DB::table('slots')->where('id',$request->id)->update($slotsdata);
    return redirect('trainer/add-slot')->with("success","The data of slots successfully Updated!");
}


// delete the slots
public function slotsdelete($id)
{
    $slotsdata['deleted_at']=Carbon::now();
    
    DB::table('slots')->where('id',$id)->update($slotsdata);
    return redirect('trainer/add-slot')->with("delete","Your record of slot is deleted successfully !");
}


public function showlist()
{
    $data=DB::table('users')->where('master_trainer',2)->wherenull('deleted_at')->get();
    return view('trainer.trainerlist')->with(compact('data'));
}



public function addtrainer()
{
    return view('trainer.addtrainer');
}


public function trainerdelete($id)
{
    $updatedata['deleted_at']=Carbon::now();

    DB::table('users')->where('id',$id)->update($updatedata);
    return redirect('trainer/trainerlist')->with("delete","Your trainer is deleted successfully !");
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
 

Log::debug(" data ".print_r($request->all(),true)); /// create log for showing error and print resul
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



DB::table('users')->insert($data);

Mail::send('emails.enquirymail',['password' =>$password_code,'email' =>$data['email'],'name'=>$data['name']], function($message) {
    $message->to(Input::get('email'));
});
return redirect('trainer/trainerlist')->with("success","Your new record of Trainer is insert successfully !");
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
    return redirect('trainer/trainerlist')->with("success","The data of trainer successfully updated!");
}

//past customer list//
public function pastshowlist(Request $request)
{
    $id=$request->id;
    $cur_date =TODAY();
    $cur_time =date("H:i:s");
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->select( 'slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_request.slot_time')->where('slot_request.slot_date','<',$cur_date)->where('slot_request.trainer_id',$id)->get();
    return view('trainer.past_request_customers')->with(compact('data'));
}


//past customer ajax function//
public function approve_past_customer_request(Request $request)
{
    $data=$request->get('data');
    $id=$data['id'];
    $action=$data['action'];
    Log::debug(" Check id ".print_r($id,true));
    Log::debug(" Check action ".print_r($action,true));
    if($action=="Approve"){
        DB::table('slot_request')->where('id',$id)->update(['approval_id' =>3, 'decline_reason'=>null]);
        return response()->json(1);
    }
    elseif($action=="Decline")
    {
        $reason=$data['comment'];
        DB::table('slot_request')->where('id',$id)->update(['approval_id' => 4, 'decline_reason'=> $reason]);
        return response()->json(2);
    }
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
        DB::table('slot_request')->where('id',$id)->update(['approval_id' => 4, 'decline_reason'=> $reason]);
        return response()->json(2);
    }
}

//future customer list//
public function futureshowlist(Request $request)
{
    $id=$request->id;
    $cur_date =TODAY();
    $cur_time =date("H:i:s");
    $data=DB::table('slot_request')
    ->join('customers','customers.id','slot_request.customer_id')
    ->join('slot_approval','slot_approval.id','slot_request.approval_id')
    ->select( 'slot_request.id','customers.name','customers.ph_no','customers.image','slot_approval.status','slot_request.created_at','slot_request.approval_id','slot_request.slot_date','slot_request.slot_time')->where('slot_request.slot_date','>',$cur_date)->where('slot_request.trainer_id',$id)->get();
    return view('trainer.future_request_customers')->with(compact('data'));

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
        $data['image'] = (isset($request->video) && !empty($request->video)) ? null : $image_name; 
    }else{
        $data['image'] = null;
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
        $data['image'] = (isset($request->video) && !empty($request->video)) ? null : $image_name; 
    }else{
        $data['image'] = null;
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

 return redirect('trainer/testimonial_view')->with("success","Your testimonial is insert successfully !");

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
    return redirect('trainer/testimonial_view')->with("success","The data of testimonial successfully updated!");
}


public function testimonialdelete($id)
{
    $updatedata['deleted_at']=Carbon::now();

    DB::table('testimonial')->where('id',$id)->update($updatedata);

    return redirect('trainer/testimonial_view')->with("delete","Your testimonial is deleted successfully !");
}






public function mot_show(Request $request)
{

$data=DB::table('customer_mot')->where('deleted_at',null)->get();
return view('trainer.customer_mot')->with(compact('data'));

}



public function motinsertshow()
{


$data=DB::table('customers')->get();
return view('trainer.motinsertshow')->with(compact('data'));

}




public function motinsert(Request $request)
{
$data['customer_id']=$request->apply;
$data['trainer_id']=$request->trainer_id;
$data['right_arm']=$request->right_arm;
$data['left_arm']=$request->left_arm;
$data['chest']=$request->chest;
$data['waist']=$request->waist;
$data['hips']=$request->hips;
$data['right_thigh']=$request->right_thigh;
$data['left_thigh']=$request->left_thigh;
$data['right_calf']=$request->right_calf;
$data['left_calf']=$request->left_calf;
$data['weight']=$request->weight;
$data['date']=$request->date;

DB::table('customer_mot')->insert($data);
Log::debug(" Check id ".print_r($data,true));

return redirect('trainer/mot_show')->with("success","Your MOT is insert successfully !");

}




public function moteditshow($id)
{


$data=DB::table('customer_mot')
    ->join('customers','customers.id','customer_mot.customer_id')
    ->join('users','users.id','customer_mot.trainer_id')

    ->select('customer_mot.id as mot_id','customer_mot.customer_id as customer_id','customer_mot.trainer_id','customer_mot.right_arm','customer_mot.left_arm','customer_mot.chest','customer_mot.waist','customer_mot.hips','customer_mot.right_thigh','customer_mot.left_thigh','customer_mot.weight','customer_mot.date','customer_mot.right_calf','customer_mot.left_calf','customers.name as current_customer_name')->where('customer_mot.id',$id)->get();

return view('trainer.moteditshow')->with(compact('data'));

}



public function motedit(Request $request)
{


   $data['customer_id']=$request->id;
$data['trainer_id']=$request->trainer_id;
$data['right_arm']=$request->right_arm;
$data['left_arm']=$request->left_arm;
$data['chest']=$request->chest;
$data['waist']=$request->waist;
$data['hips']=$request->hips;
$data['right_thigh']=$request->right_thigh;
$data['left_thigh']=$request->left_thigh;
$data['right_calf']=$request->right_calf;
$data['left_calf']=$request->left_calf;
$data['weight']=$request->weight;
$data['date']=$request->date;

    DB::table('customer_mot')->where('id',$request->id)->update($data);
    Log::debug(" Check id ".print_r($data,true));
   return redirect('trainer/mot_show')->with("success","Your MOT is update successfully !");

}










public function motdelete($id)
{
    $updatedata['deleted_at']=Carbon::now();

    DB::table('customer_mot')->where('id',$id)->update($updatedata);

    return redirect('trainer/mot_show')->with("delete","Your MOT is deleted successfully !");
}












}