<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileUpdateController extends Controller
{

	/*
     * Ensure the admin is signed in to access this page
     */
    public function __construct() {
 
        $this->middleware('auth:customer');
 
    }

    // open the update form
	public function showupdateform($id)
    {
    	 $data= DB::table('admins')->where('id',$id)->first();
    	 Log::debug(" data ".print_r($data,true));

    	return view ("adminpanel.editform")->with(compact('data'));


	}


    // update profile of admin
    public function updateprofile(Request $request)
    {
        $mydata['name']=$request->name;
        $mydata['address']=$request->address;
        $mydata['phone']=$request->phone;


        if($request->image!="")
        {

            $request->validate
            (
                [ 'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048']
            );
            $myimage=$request->image;
            $folder="backend/images/"; 

            // Log::debug("::Inserted::".print_r($myimage,true));
            $extension=$myimage->getClientOriginalExtension(); 
            $image_name=time()."_adminimg.".$extension; 
            $upload=$myimage->move($folder,$image_name); 
            $mydata['image']=$image_name; 
        }
        else
        { $mydata['image']=$request->oldimage;  }


        $data=DB::table('admins')->where('id',$request->id)->update($mydata);
        //print_r($data); die;
         return redirect()->back()->with("success","Your profile is update successfully !");


    }

    //Show the profile of admin
    public function showprofile($id)
    {
        Log::debug(":: Show Profile :: ".print_r($id,true));
        // echo "asd";die();
        $data=DB::table('admins')->where('Id',$id)->first();
        Log::debug(":: Admin data :: ".print_r($data,true));
        return view('adminpanel.adminprofile')->with(compact('data')); 
    }



}