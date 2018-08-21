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

  $data['payment_id']='BANK'.time();
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
    $notifydata['package_validity'] =$request->package_validity_date;
    $notifydata['package_purchase_date'] =$request->purchases_date;
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
    return redirect()->route('bankpaymentcomplete'); 
  }
  else
  {
    Session::put('failed_bank_pay', 'Your bank transfer payment is failed');

    $customer_details=Customer::find($request->customer_id);


    $notifydata['package_name'] =$request->slots_name;
    $notifydata['slots_number'] =$request->slots_number;
    $notifydata['package_validity'] =$request->package_validity_date;
    $notifydata['package_purchase_date'] =$request->purchases_date;
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


    return redirect()->route('bankpaymentcomplete'); 
  }

  
}

public function bank_payment_complete()
{
  return view('customerpanel.payment-success');
}

}