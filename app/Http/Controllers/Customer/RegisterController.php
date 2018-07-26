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

      return view('customerpanel.frontregistration');
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
        $customer = $this->create($request->all(),$confirmation_code);


if($customer)
{
   Mail::send('emails.enquirycustomermail',['email' =>$request->email,'password' =>$request->password],function($message) {
    $message->to(Input::get('email'));
});  
}


  return redirect('cutomer_registration')->with('confirm_message', 'A verification code has been sent to your email. Please confirm to complete the registration process!');


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

}
