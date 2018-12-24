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
use App\Notifications\PlanPurchasedNotification;
use Carbon\Carbon;

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

      DB::beginTransaction();
      try{
      
      $validator=Validator::make($request->all(), [
              
              'ph_no' => 'numeric|unique:customers',
              'email' => 'required|email|max:255|unique:customers',
              'password' => 'required|min:6|confirmed',

          ]);

      if($validator->fails())
      {
        //Log::debug(" Validator ".print_r($validator->errors(),true));
        return redirect()->back()->withErrors($validator)
                      ->withInput();
      }

     //generate confirmation code
      $confirmation_code = str_random(30);
      $customers = $this->create($request->all(),$confirmation_code);
     
      $customers_id=DB::getPdo()->lastInsertId();
     // for social login 
      if($request->provider_id && $request->provider_name)
      {
        $social_account_data['provider_id']=$request->provider_id;
        $social_account_data['provider_name']=$request->provider_name;
        $social_account_data['customers_id']=DB::getPdo()->lastInsertId();

        $customer_data['confirmed']=1;
        $customer_data['confirmation_code']=NULL;

        $savedata=Customer::where('id',$social_account_data['customers_id'])->update($customer_data);

        $customer_social_account = DB::table('social_accounts')->insert($social_account_data);
      }


      if($customers && $request->provider_id && $request->provider_name)
      {
                  //Log::debug("Request_allllllll ".print_r($request->all(),true));

        Auth::guard('customer')->login($customers,true);
        
        $package_details=DB::table('products')
        ->join('training_type','training_type.id','products.training_type_id')
        ->join('payment_type','payment_type.id','products.payment_type_id')
        ->select('training_type.training_name as product_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.id as product_id',(DB::raw('products.validity_value * products.validity_duration  as validity')),'products.total_price as total_price','products.price_session_or_month as price_session_or_month','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration')
        ->whereNull('products.deleted_at')
        ->where('products.id',7)->first();

        if($package_details)

        {

        if($package_details->validity!='')
        {
          $product_validity=Carbon::now()->addDay($package_details->validity);
        }
        else{
          $product_validity='2099-12-30';
        }

        if($product_validity>Carbon::now()->toDateString())
        {
        
          $payment_history_data['amount']=$package_details->total_price;
          $payment_history_data['status']='Success';

          $order_data['customer_id']=Auth::guard('customer')->user()->id;
          $order_data['product_id']=$package_details->product_id;
          $order_data['training_type']=$package_details->product_name;
          $order_data['payment_type']=$package_details->payment_type_name;
          $order_data['order_purchase_date']=Carbon::now()->toDateString();

          if($package_details->validity!='')
          {
            $order_data['order_validity_date']=Carbon::now()->addDay($package_details->validity);
          }
          else{
            $order_data['order_validity_date']='2099-12-30';
          }
            
          $order_data['payment_option']='';
          $order_data['status']=1;
          $order_data['no_of_sessions']=$package_details->total_sessions;
          $order_data['remaining_sessions']=$package_details->total_sessions;
          $order_data['price_session_or_month']=$package_details->price_session_or_month;
          $order_data['total_price']=$package_details->total_price;
          $order_data['validity_value']=$package_details->validity_value;
          $order_data['validity_duration']=$package_details->validity_duration;
          $order_data['contract']=$package_details->contract;
          $order_data['notice_period_value']=$package_details->notice_period_value;
          $order_data['notice_period_duration']=$package_details->notice_period_duration;
          $order_data['free_product']=1;

          $payment_history=DB::table('payment_history')->insert($payment_history_data);

          $order_data['payment_id']=DB::getPdo()->lastInsertId();

          $order_history=DB::table('order_details')->insert($order_data);

          $customer_details=Customer::find(Auth::guard('customer')->user()->id);

          $notifydata['product_name'] =$package_details->product_name;
          $notifydata['no_of_sessions'] =$package_details->total_sessions;
          $notifydata['product_validity'] =$order_data['order_validity_date'];
          $notifydata['product_purchase_date'] =$order_data['order_purchase_date'];
          $notifydata['product_amount'] =$package_details->total_price;
          $notifydata['order_id'] ='';
          $notifydata['payment_mode'] ='';
          $notifydata['url'] = '/customer/freebootcamp';
          $notifydata['customer_name']=$customer_details->name;
          $notifydata['customer_email']=$customer_details->email;
          $notifydata['customer_phone']=$customer_details->ph_no;
          $notifydata['status']='Get free bootcamp trial';

          $customer_details->notify(new PlanPurchasedNotification($notifydata));

          Mail::send('emails.socialenquirycustomermail',['email' =>$request->email,'name' =>$request->name],function($message) {
        $message->to(Input::get('email'))->subject('Successfully Register');   
        });

        DB::commit();

        return redirect('customer/free-sessions'); 
        }

        }
        else
        {

          Mail::send('emails.socialenquirycustomermail',['email' =>$request->email,'name' =>$request->name],function($message) {
          $message->to(Input::get('email'))->subject('Successfully Register');   
          });

          DB::commit();
          return redirect('customer/free-sessions'); 
        }
        }


        if($customers && !$request->provider_id && !$request->provider_name)
        { 

          $package_details=DB::table('products')
        ->join('training_type','training_type.id','products.training_type_id')
        ->join('payment_type','payment_type.id','products.payment_type_id')
        ->select('training_type.training_name as product_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.id as product_id',(DB::raw('products.validity_value * products.validity_duration  as validity')),'products.total_price as total_price','products.price_session_or_month as price_session_or_month','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration')
        ->whereNull('products.deleted_at')
        ->where('products.id',7)->first();

        Log::debug("package_details ".print_r($package_details,true));
        if($package_details)

        {
        if($package_details->validity!='')
        {
          $product_validity=Carbon::now()->addDay($package_details->validity);
        }
        else{
          $product_validity='2099-12-30';
        }

        if($product_validity>Carbon::now()->toDateString())        {

          $payment_history_data['amount']=$package_details->total_price;
          $payment_history_data['status']='Success';

          $order_data['customer_id']=$customers_id;
          $order_data['product_id']=$package_details->product_id;
          $order_data['training_type']=$package_details->product_name;
          $order_data['payment_type']=$package_details->payment_type_name;
          $order_data['order_purchase_date']=Carbon::now()->toDateString();

          if($package_details->validity!='')
          {
            $order_data['order_validity_date']=Carbon::now()->addDay($package_details->validity);
          }
          else{
            $order_data['order_validity_date']='2099-12-30';
          }
            
          $order_data['payment_option']='';
          $order_data['status']=1;
          $order_data['no_of_sessions']=$package_details->total_sessions;
          $order_data['remaining_sessions']=$package_details->total_sessions;
          $order_data['price_session_or_month']=$package_details->price_session_or_month;
          $order_data['total_price']=$package_details->total_price;
          $order_data['validity_value']=$package_details->validity_value;
          $order_data['validity_duration']=$package_details->validity_duration;
          $order_data['contract']=$package_details->contract;
          $order_data['notice_period_value']=$package_details->notice_period_value;
          $order_data['notice_period_duration']=$package_details->notice_period_duration;
          $order_data['free_product']=1;

          $payment_history=DB::table('payment_history')->insert($payment_history_data);

          $order_data['payment_id']=DB::getPdo()->lastInsertId();

          $order_history=DB::table('order_details')->insert($order_data);

          $customer_details=Customer::find($customers_id);

          $notifydata['product_name'] =$package_details->product_name;
          $notifydata['no_of_sessions'] =$package_details->total_sessions;
          $notifydata['product_validity'] =$order_data['order_validity_date'];
          $notifydata['product_purchase_date'] =$order_data['order_purchase_date'];
          $notifydata['product_amount'] =$package_details->total_price;
          $notifydata['order_id'] ='';
          $notifydata['payment_mode'] ='';
          $notifydata['url'] = '/customer/freebootcamp';
          $notifydata['customer_name']=$customer_details->name;
          $notifydata['customer_email']=$customer_details->email;
          $notifydata['customer_phone']=$customer_details->ph_no;
          $notifydata['status']='Get free bootcamp trial';

          $customer_details->notify(new PlanPurchasedNotification($notifydata));


          Mail::send('emails.enquirycustomermail',['email' =>$request->email,'password' =>$request->password,'confirmation_code' => $confirmation_code],function($message) {
            $message->to(Input::get('email'))->subject('Successfully Register');
            }); 

        DB::commit();
        return redirect('customer-registration')->with('confirm_message', 'A verification code has been sent to your email. Please confirm to complete the registration process!');

        }

      }
        else
        {
  
          Mail::send('emails.enquirycustomermail',['email' =>$request->email,'password' =>$request->password,'confirmation_code' => $confirmation_code],function($message) {
              $message->to(Input::get('email'))->subject('Successfully Register');
              }); 

          DB::commit();
          return redirect('customer-registration')->with('confirm_message', 'A verification code has been sent to your email. Please confirm to complete the registration process!');
        }
      }
      }
       catch(\Exception $e) {
        DB::rollback();
       return abort(400);
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
