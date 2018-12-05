<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\Enquiry;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DateTime;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Auth;
use Session;
use App\Customer;
use App\Notifications\PackagePurchaseNotification;

class BankPaymentController extends Controller
{


  public function __construct()
{
  $this->middleware('auth:customer');
}

public function bank_payment_success(Request $request)
{
  Log::debug(" data bank_payment_success ".print_r($request->all(),true));
  $coupon_code=$request->coupon_code;
  $coupon_id=$request->coupon_id;
  Log::debug(" $coupon_id ".print_r($coupon_id,true));
  Log::debug(" $coupon_code ".print_r($coupon_code,true));
  DB::beginTransaction();
  try{

if($coupon_id)
{

  $bank_data['customer_id']=$request->customer_id;
  $bank_data['slot_id']=$request->slot_id;
  $bank_data['purchases_date']=$request->purchases_date;
  $bank_data['package_validity_date']=$request->package_validity_date;
  $bank_data['payment_options']='Bank Transfer';
  $bank_data['slots_name']=$request->slots_name;
  $bank_data['slots_number']=$request->slots_number;
  $bank_data['slots_price']=$request->slots_price;
  $bank_data['active_package']=0;
  $bank_data['package_remaining']=0;


  $insert_bank_data=DB::table('purchases_history')->insert($bank_data);

   $purchase_history_id = DB::getPdo()->lastInsertId();
  $data['purchase_history_id'] = $purchase_history_id;
  if($request->package_image!='')
  {
    $myimage=$request->package_image;
    $folder="backend/bankpay_images/"; 
    $extension=$myimage->getClientOriginalExtension(); 
    $image_name=time()."_bankdocimg.".$extension; 
    $upload=$myimage->move($folder,$image_name); 
    $data['image']=$image_name;
  } 

  $data['payment_id']='BBL'.time();
  $data['currency']=Null;
  $data['amount']=$request->slots_price;
  $data['payment_mode']='Bank Transfer';
  $data['description']=$request->package_description;
  $data['status']='Inprogress';
  $bank_data=DB::table('payment_history')->insert($data);

// DB::table('slots_discount_coupon')->where('id',$coupon_id)->update(['is_active'=>0]);

   if ($insert_bank_data && $bank_data)
  {
    Session::put('success_bank_pay', 'Your payment is success using bank transfer');
    Session::put('bank_payment_id',$data['payment_id']);

    $customer_details=Customer::find($request->customer_id);


    $notifydata['package_name'] =$request->slots_name;
    $notifydata['slots_number'] =$request->slots_number;
    $notifydata['package_validity'] =substr($request->package_validity_date,0,10);
    $notifydata['package_purchase_date'] =substr($request->purchases_date,0,10);
    $notifydata['package_amount'] =$request->slots_price;
    $notifydata['payment_id'] =$data['payment_id'];
    $notifydata['payment_mode'] ='Bank Transfer';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Payment Success';

    Log::debug(" paypal Inconvenient error notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    DB::commit();
    return redirect()->route('bankpaymentcomplete'); 
  }
  else
  {
    Session::put('failed_bank_pay', 'Your bank transfer payment is failed');

    $customer_details=Customer::find($request->customer_id);


    $notifydata['package_name'] =$request->slots_name;
    $notifydata['slots_number'] =$request->slots_number;
    $notifydata['package_validity'] =substr($request->package_validity_date,0,10);
    $notifydata['package_purchase_date'] =substr($request->purchases_date,0,10);
    $notifydata['package_amount'] =$request->slots_price;
    $notifydata['payment_id'] =$data['payment_id'];
    $notifydata['payment_mode'] ='Bank Transfer';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Payment Failed';

    Log::debug(" paypal Inconvenient error notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    DB::commit();
    return redirect()->route('bankpaymentcomplete'); 
  }
}
else
{
  $bank_data['customer_id']=$request->customer_id;
  $bank_data['slot_id']=$request->slot_id;
  $bank_data['purchases_date']=$request->purchases_date;
  $bank_data['package_validity_date']=$request->package_validity_date;
  $bank_data['payment_options']='Bank Transfer';
  $bank_data['slots_name']=$request->slots_name;
  $bank_data['slots_number']=$request->slots_number;
  $bank_data['slots_price']=$request->slots_price;
  $bank_data['active_package']=0;
  $bank_data['package_remaining']=0;


  $insert_bank_data=DB::table('purchases_history')->insert($bank_data);

   $purchase_history_id = DB::getPdo()->lastInsertId();
  $data['purchase_history_id'] = $purchase_history_id;
  if($request->package_image!='')
  {
    $myimage=$request->package_image;
    $folder="backend/bankpay_images/"; 
    $extension=$myimage->getClientOriginalExtension(); 
    $image_name=time()."_bankdocimg.".$extension; 
    $upload=$myimage->move($folder,$image_name); 
    $data['image']=$image_name;
  } 

  $data['payment_id']='BBL'.time();
  $data['currency']=Null;
  $data['amount']=$request->slots_price;
  $data['payment_mode']='Bank Transfer';
  $data['description']=$request->package_description;
  $data['status']='Inprogress';
  $bank_data=DB::table('payment_history')->insert($data);

   if ($insert_bank_data && $bank_data)
  {
    Session::put('success_bank_pay', 'Your payment is success using bank transfer');
    Session::put('bank_payment_id',$data['payment_id']);

    $customer_details=Customer::find($request->customer_id);


    $notifydata['package_name'] =$request->slots_name;
    $notifydata['slots_number'] =$request->slots_number;
    $notifydata['package_validity'] =substr($request->package_validity_date,0,10);
    $notifydata['package_purchase_date'] =substr($request->purchases_date,0,10);
    $notifydata['package_amount'] =$request->slots_price;
    $notifydata['payment_id'] =$data['payment_id'];
    $notifydata['payment_mode'] ='Bank Transfer';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Payment Success';

    Log::debug(" paypal Inconvenient error notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    DB::commit();
    return redirect()->route('bankpaymentcomplete'); 
  }
  else
  {
    Session::put('failed_bank_pay', 'Your bank transfer payment is failed');

    $customer_details=Customer::find($request->customer_id);


    $notifydata['package_name'] =$request->slots_name;
    $notifydata['slots_number'] =$request->slots_number;
    $notifydata['package_validity'] =substr($request->package_validity_date,0,10);
    $notifydata['package_purchase_date'] =substr($request->purchases_date,0,10);
    $notifydata['package_amount'] =$request->slots_price;
    $notifydata['payment_id'] =$data['payment_id'];
    $notifydata['payment_mode'] ='Bank Transfer';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Payment Failed';

    Log::debug(" paypal Inconvenient error notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    DB::commit();
    return redirect()->route('bankpaymentcomplete'); 
  }
}

 

 

}
catch(\Exception $e) {
      DB::rollback();
      return abort(400);
  }

  
}

public function bank_payment_complete()
{
  return view('customerpanel.payment-success');
}


public function bootcamp_bank_payment_success(Request $request)
{
  //Log::debug(":: bootcamp_onlinepayment :: ".print_r($request->all(),true));
  
  DB::beginTransaction();
   try{
  $package_details=DB::table('products')
  ->join('training_type','training_type.id','products.training_type_id')
  ->join('payment_type','payment_type.id','products.payment_type_id')
  ->select('training_type.training_name as product_name','payment_type.payment_type_name as payment_type_name','products.total_sessions as total_sessions','products.id as product_id','products.id as product_id',(DB::raw('products.validity_value * products.validity_duration  as validity')),'products.total_price as total_price','products.price_session_or_month as price_session_or_month','products.validity_value as validity_value','products.validity_duration as validity_duration','products.contract as contract','products.notice_period_value as notice_period_value','products.notice_period_duration as notice_period_duration')
  ->where('products.id',$request->product_id)->first();

  $payment_history_data['payment_id']='BBL'.time();
  $payment_history_data['amount']=$package_details->total_price;
  $payment_history_data['payment_mode']='Bank Transfer';
  $payment_history_data['status']='Inprogress';

  if($request->package_image!='')
  {
    $myimage=$request->package_image;
    $folder="backend/bankpay_images/"; 
    $extension=$myimage->getClientOriginalExtension(); 
    $image_name=time()."_bankdocimg.".$extension; 
    $upload=$myimage->move($folder,$image_name); 
    $payment_history_data['image']=$image_name;
  } 
  $payment_history_data['description']=$request->package_description;


  $payment_history=DB::table('payment_history')->insert($payment_history_data);
  $order_data['payment_id']=DB::getPdo()->lastInsertId();
  $order_data['customer_id']=Auth::guard('customer')->user()->id;
  $order_data['product_id']=$request->product_id;
  $order_data['training_type']=$package_details->product_name;
  $order_data['payment_type']=$package_details->payment_type_name;
  $order_data['order_purchase_date']=Carbon::now()->toDateString();
  if($package_details->validity!='')
  {
    $order_data['order_validity_date']=Carbon::now()->addDay($package_details->validity);
  }
  
  $order_data['payment_option']='Bank Transfer';
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

  $order_history=DB::table('order_details')->insert($order_data);

  \Session::put('success_bootcamp_bank', 'Payment success');
  \Session::put('payment_id', $payment_history_data['payment_id']);
  DB::commit();
    return redirect('customer/bootcampbankpaymentcomplete');
   }
   catch(\Exception $e) {
     DB::rollback();
       return abort(400);
   }

}

public function bootcamp_bank_payment_complete()
{
  return view('customerpanel.payment-success');
}


}