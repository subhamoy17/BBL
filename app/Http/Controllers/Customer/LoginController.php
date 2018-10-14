<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */



    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'customer/mybooking';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout');
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        
        return view('customerpanel.frontlogin_registration');
    }


public function login(Request $request)
    {
      Log::debug("yiyik login ".print_r($request->all(),true));
      
        // $request->request->add(['email' => $request->user]);
      
      $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if($this->guard('customer')->attempt(

            $this->credentials($request), $request->has('remember')))
            {
              Log::debug ( " :: login before confirm :: " );
              if($this->guard('customer')->user()->confirmed==0)
              {
                Log::debug ( " :: not confirm :: " );
                
                $this->guard()->logout();
                $request->session()->invalidate();
                return redirect()->back()->with('email_verification_errors','You need to confirm your account, please check your mail for the verification link.');
              }
             
              else {
                 
                return $this->sendLoginResponse($request);

              }
            }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {

   
  $cart_delete=DB::table('cart_slot_request')->where('request_customer_id',Auth::guard('customer')->user()->id)->delete();
       Log::debug("customer logout");
        $this->guard()->logout();
        $request->session()->invalidate();
         return redirect()->route('customerpanel.frontlogin_registration');
         // return redirect('customer/bbl');
        
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


    


    
}
