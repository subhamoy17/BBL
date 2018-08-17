<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

use Socialite;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'customer/bbl';

        public function showRegistrationForm()
  {
      $customer_social_data1['email']=Session::get( 'email' );
      $customer_social_data1['name']=Session::get( 'name' );
      $customer_social_data1['provider_id']=Session::get( 'provider_id' );
      $customer_social_data1['provider_name']=Session::get( 'provider_name' );

      return view('customerpanel.frontregistration')->with(compact('customer_social_data1'));
  }



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
   


public function showForm(Request $request)

{
    Log::debug("Customer Register ".print_r($request->all(),true));
    $validator=Validator::make($request->all(), [
              
              'ph_no' => 'numeric|unique:customers',
              'email' => 'required|email|max:255|unique:customers',
              'password' => 'required|min:6|confirmed',

          ]);

          if($validator->fails())
          {
            Log::debug(" Validator ".print_r($validator->errors(),true));
            return redirect()->back()->withErrors($validator)
                          ->withInput();
          }

       //generate confirmation code
        $confirmation_code = str_random(30);
        $customers = $this->create($request->all(),$confirmation_code);
       
       // for social login 
        if($request->provider_id && $request->provider_name)
        {
          $social_account_data['provider_id']=$request->provider_id;
          $social_account_data['provider_name']=$request->provider_name;
          $social_account_data['customers_id']=DB::getPdo()->lastInsertId();

          
          $customer_data['confirmed']=1;
          $customer_data['confirmation_code']=NULL;

          $savedata=Customer::where('id',$social_account_data['customers_id'])->update($customer_data);

          Log::debug("Customer Register ".print_r($savedata,true));

          $customer_social_account = DB::table('social_accounts')->insert($social_account_data);
        }


        if($customers && $request->provider_id && $request->provider_name)
        {
            Mail::send('emails.socialenquirycustomermail',['email' =>$request->email,'name' =>$request->name],function($message) {
            $message->to(Input::get('email'));   
            });
            Log::debug("Request_allllllll ".print_r($request->all(),true));

            Auth::guard('customer')->login($customers,true);
            return redirect('customer/bbl'); 
        }


        if($customers && !$request->provider_id && !$request->provider_name)
        {
            Mail::send('emails.enquirycustomermail',['email' =>$request->email,'password' =>$request->password,'confirmation_code' => $confirmation_code],function($message) {
            $message->to(Input::get('email'));
            });  

            return redirect('cutomer-registration')->with('confirm_message', 'A verification code has been sent to your email. Please confirm to complete the registration process!');
        }
}



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data,$confirmation_code)
    {

        return Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'ph_no'=>$data['ph_no'],
            'password' => Hash::make($data['password']),
            'confirmation_code' => $confirmation_code,
        ]);
    }


     public function confirm($confirmation_code)
    {
        if(!$confirmation_code)
        {
            return redirect('/customer-login');
        }

        $customers = Customer::whereConfirmationCode($confirmation_code)->first();

        if (!$customers)
        {
            return redirect('/customer-login');
        }

        $customers->confirmed = 1;
        $customers->confirmation_code = null;
        $customers->save();

        return redirect('/customer-login');
    }

}
