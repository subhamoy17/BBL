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


 
class TrainerFirstChangePasswordController extends Controller
{
    
 
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
        
        $password = bcrypt($request->get('new-password'));
        $email=$request->get('email');

        $trainer_password_update=DB::table('users')->where('email',$email)
            ->update(['password' => $password]);


        $trainer_details=DB::table('users')->where('email',$email)->first();

        Log::debug ( " :: trainer_details :: " . print_r ( $trainer_details, true ) );

        if(($trainer_details->login_attempt==1)  && $trainer_details->master_trainer==2)
        {
            $trainer_details_update=DB::table('users')->where('email',$email)
            ->update(['login_attempt' => 2]);   
        }


    
       return redirect()->route('login')->with("fisr_change_password_success","Password changed successfully! Now you can log in using your new password");
 
 
    }

   
}