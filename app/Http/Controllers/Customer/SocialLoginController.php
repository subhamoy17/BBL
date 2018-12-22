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
use Illuminate\Support\Facades\Validator;
use App\Notifications\PlanPurchasedNotification;
use Carbon\Carbon;

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
        //Log::debug("socialite calling" . print_r($provider,true));
        return Socialite::driver($provider)->redirect();
    }

     public function handleProviderCallback($provider)
    {

        
        DB::beginTransaction();
        try
        {
        $user_social_signin = Socialite::driver($provider)->user();

        //Log::debug("socialite sign in" . print_r($user_social_signin,true));

        
        $user_social_account=DB::table('social_accounts')
        ->where('provider_id',$user_social_signin->id)
        ->first(); 

        $old_customer_data = Customer::where('email',$user_social_signin->email)
        ->first();   
        
        if($old_customer_data && $user_social_account)
        {

        Auth::guard('customer')->login($old_customer_data,true);
            
        //Log::debug("old_customer_data" . print_r($old_customer_data,true));
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

            //Log::debug("new_customer_data" . print_r($customer_social_data,true));

            return redirect()->route('customer-register')
            ->with('email',$customer_social_data['email'])
            ->with('name',$customer_social_data['name'])
            ->with('provider_id',$customer_social_data['provider_id'])
            ->with('provider_name',$customer_social_data['provider_name']);

            DB::commit();
        }
        
        }
         catch(\Exception $e) {

        //Log::debug("anything wrong");

         DB::rollback();
         return redirect()->route('bbldb');
        
       }


    }




   public function showPurchaseLoginForm($id)
    {
      try{
        $plan_id=\Crypt::decrypt($id);
        //Log::debug(":: login :: ".$plan_id);

        \Session::put('plan_id',$plan_id);
        return view('customerpanel.normal_login');
      }
      catch(\Exception $e) {
        return abort(400);
      }
    }


    public function customer_purchase_login_success(Request $request)

    {
       //Log::debug("customer_purchase_login_success" . print_r($request->all(),true));
      DB::beginTransaction();
      try
      {

      $email=$request->email;
      $password=$request->password;
      $plan_id=$request->plan_id;

      $product_details=DB::table('products')
      ->join('training_type','products.training_type_id','training_type.id')
      ->join('payment_type','products.payment_type_id','payment_type.id')
      ->select('products.id as product_id','training_type.id as training_id')
      ->whereNull('products.deleted_at')
      ->where('products.total_price','>',0)
      ->where('products.status',1)
      ->where('products.id',$plan_id)
      ->first();

     Log::debug("customer_purchase_login_success" . print_r($product_details,true));


      $data['email']=$request->email;
      $data['password']=$request->password;

      $plan_id=\Crypt::encrypt($plan_id);

      $check_customer=DB::table('customers')->where('email',$email)->first();

      if(Auth::guard('customer')->attempt($data))
        {
          
          if($product_details->training_id==1)
          {
            return redirect()->route('pt_plan_purchase',['plan_id'=>$plan_id]);
          }
          elseif($product_details->training_id==2)
          {
            return redirect()->route('bootcamp_plan_purchase',['plan_id'=>$plan_id]);
          } 
        }
      elseif($request->has('name') && $request->has('ph_no'))
        {
          
          $validator=Validator::make($request->all(), [
              'email' => 'required|email|max:255|unique:customers',
              'password'=>'required|min:6',
              'name'=>'required|min:4',
              'ph_no'=>'required|min:10|numeric|unique:customers',
          ]);

          if($validator->fails())
          {
            return back()->withErrors($validator)->withInput();
          }
          else
          {
            DB::table('customers')->insert(['name' => $request->name,
            'email' => $request->email,
            'ph_no'=>$request->ph_no,
            'password' => \Hash::make($request->password),
            'confirmation_code' =>NULL,
            'confirmed' =>1,]);

            if(Auth::guard('customer')->attempt($data))
            {

              $package_details=DB::table('products')
              ->join('training_type','training_type.id','products.training_type_id')
              ->join('payment_type','payment_type.id','products.payment_type_id')
              ->select('training_type.training_name as product_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.id as product_id',(DB::raw('products.validity_value * products.validity_duration  as validity')),'products.total_price as total_price','products.price_session_or_month as price_session_or_month','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration','training_type.id as training_id')
              ->whereNull('products.deleted_at')
              ->where('products.id',9)->first();

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

                $customer_details=Customer::find(Auth::guard('customer')->user()->id);

                $order_data['order_validity_date']=$product_validity;          
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
                }
              }
              if($package_details->training_id==1)
              {
                DB::commit();
                return redirect()->route('pt_plan_purchase',['plan_id'=>$plan_id]);
              }
              elseif($package_details->training_id==2)
              {
                DB::commit();
                return redirect()->route('bootcamp_plan_purchase',['plan_id'=>$plan_id]);
              }
            }
          }
        }
        elseif(empty($check_customer))
        {
          // Log::debug("anything right ");
          return back()->withErrors(['email_not_here'=>'This email is not registered. Please filled up all credentials.'])->withInput();
        }
        else
        {
          return back()->withErrors(['email'=>'These credentials do not match our records.'])->withInput();
        }
    }
    catch(\Exception $e) {
      DB::rollback();
      return abort(400);
  }
      
}

 
    
}
