<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


 
class ChangePasswordController extends Controller
{
    /*
     * Ensure the user is signed in to access this page
     */
    public function __construct() {
 
        $this->middleware('auth:customer');
 
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

    
    /**
     * Show the form to change the user password.
     */
    public function showChagePasswordForm(){

        $this->cart_delete_customer();
        return view('customerpanel.customer_change_password');
    }
 
    /**
     * Update the password for the admin.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updateAdminPassword(Request $request)
    {
        $this->cart_delete_customer();

        // if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
        //     // The passwords matches
        //     return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        // }

        // if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
        //     //Current password and new password are same
        //     return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        // }

        $validatedData = $request->validate([
            // 'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);


        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        $email=$request->get('email');
        $name=$request->get('name');
 $new_password=$request->get('new-password');
      Log::debug(" email ".print_r($email,true));     

        //echo "your change password message is sent";

 Mail::send('customerpanel.customer_change_password_message',['new_password' =>$new_password,'email' => $email,'name'=>$name], function($message) {
           $message->to(Auth::user()->email)->subject('Change Password');          
            });
     return redirect()->back()->with("success","Password changed successfully!");
 
    }


     public function cart_delete_customer()
    {
        $cart_delete=DB::table('cart_slot_request')->where('request_customer_id',Auth::guard('customer')->user()->id)->delete();
    }
   
}