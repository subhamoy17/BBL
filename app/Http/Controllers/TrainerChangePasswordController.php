<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\mail;
use Illuminate\Support\Facades\DB;


 
class TrainerChangePasswordController extends Controller
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
     * Show the form to change the admin password.
     */
    public function showChagePasswordForm(){
        return view('trainer.change_password');
    }
 
    /**
     * Update the password for the admin.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updateTrainerPassword(Request $request)
    {
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
            'new-password' => 'required|string|min:6|confirmed'
        ]);
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        $email=$request->get('email');


        $name=$request->get('name');
        $new_password=$request->get('new-password');
        Log::debug(" email ".print_r($email,true));
        Mail::send('trainer.change_password_message',['new_password' =>$new_password,'email' => $email,'name'=>$name], function($message) {
           $message->to(Auth::user()->email);          
            });
       return redirect()->back()->with("success","Password changed successfully!");
 
 
    }

   
}