<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite; // socialite namespace

use App\Customer;

use Illuminate\Support\Facades\DB;

class SocialLoginController extends Controller
{
    //Where to redirect vendor after login.
    protected $redirectTo = '/customer/free-sessions';
     /**
     * Redirect the user to the facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        Log::debug("socialite calling" . print_r($provider,true));
        return Socialite::driver($provider)->redirect();
    }

     public function handleProviderCallback($provider)
    {

        
        DB::beginTransaction();
        try
        {
        $user_social_signin = Socialite::driver($provider)->user();

        Log::debug("socialite sign in" . print_r($user_social_signin,true));

        
        $user_social_account=DB::table('social_accounts')
        ->where('provider_id',$user_social_signin->id)
        ->first(); 

        $old_customer_data = Customer::where('email',$user_social_signin->email)
        ->first();   
        
        if($old_customer_data && $user_social_account)
        {

        Auth::guard('customer')->login($old_customer_data,true);
            
        Log::debug("old_customer_data" . print_r($old_customer_data,true));
        DB::commit();
        return redirect('customer/free-sessions');    
        }
        elseif($old_customer_data && $old_customer_data->confirmed==1)
        {

        $social_account_data['customers_id']=$old_customer_data->id;
        $social_account_data['provider_id']=$user_social_signin->id;
        $social_account_data['provider_name']=$provider;

        $customer_social_account = DB::table('social_accounts')->insert($social_account_data);


        if($customer_social_account)
        {
        DB::commit();
        Auth::guard('customer')->login($old_customer_data,true);
        return redirect('customer/free-sessions');

        }

        }
        elseif($old_customer_data && $old_customer_data->confirmed==0)
        {
            $social_account_data['customers_id']=$old_customer_data->id;
            $social_account_data['provider_id']=$user_social_signin->id;
            $social_account_data['provider_name']=$provider;

            $customer_social_account = DB::table('social_accounts')->insert($social_account_data);

            $customer_data['confirmed']=1;
            $customer_data['confirmation_code']=NULL;

            $savedata=Customer::where('id',$old_customer_data->id)->update($customer_data);

            DB::commit();
            Auth::guard('customer')->login($old_customer_data,true);
            return redirect('customer/free-sessions');

        }
        else
        {
            $customer_social_data['email']=$user_social_signin->email;
            $customer_social_data['name']=$user_social_signin->name;
            $customer_social_data['provider_id']=$user_social_signin->id;
            $customer_social_data['provider_name']=$provider;

            Log::debug("new_customer_data" . print_r($customer_social_data,true));

            return redirect()->route('customer-register')
            ->with('email',$customer_social_data['email'])
            ->with('name',$customer_social_data['name'])
            ->with('provider_id',$customer_social_data['provider_id'])
            ->with('provider_name',$customer_social_data['provider_name']);

            DB::commit();
        }
        
        }
         catch(\Exception $e) {

        Log::debug("anything wrong");

         DB::rollback();
         return redirect()->route('bbldb');
        
       }


    }

 
    
}
