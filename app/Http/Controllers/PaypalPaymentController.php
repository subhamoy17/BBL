<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use URL;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Auth;

use App\Customer;
use App\Notifications\PackagePurchaseNotification;
use Carbon\Carbon;

use PayPal\Exception\PayPalConnectionException;

use Illuminate\Support\Facades\Mail;

class PaypalPaymentController extends Controller
{

//configure paypal here
private $_api_context;
public function __construct()
    {
/** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
}

public function payWithpaypal(Request $request)
    {

    	$package_name=$request->slots_name;
    	$slots_number=$request->slots_number;
    	$package_id=$request->slot_id;
    	$purchases_date=substr($request->purchases_date,0,10);
    	$package_validity_date=substr($request->package_validity_date,0,10);
    	$customer_id=$request->customer_id;
    	$package_amount=$request->amount;
        

        Session::put('package_name', $package_name);
        Session::put('slots_number', $slots_number);
        Session::put('package_id', $package_id);
        Session::put('purchases_date', $purchases_date);
        Session::put('package_validity_date', $package_validity_date);
        Session::put('customer_id', $customer_id);
        Session::put('package_amount', $package_amount);

        $purchases_history_data['slot_id']=$package_id;
        $purchases_history_data['customer_id']=$customer_id;
        $purchases_history_data['purchases_date']=$purchases_date;
        $purchases_history_data['package_validity_date']=$package_validity_date;
        $purchases_history_data['payment_options']='Paypal';
        $purchases_history_data['slots_name']=$package_name;
        $purchases_history_data['slots_number']=$slots_number;
        $purchases_history_data['slots_price']=$package_amount;

        

$payer = new Payer();
        $payer->setPaymentMethod('paypal');

$item_1 = new Item();
$item_1->setName($package_name) /** item name **/
            ->setCurrency('GBP')
            ->setQuantity(1)
            ->setPrice($package_amount); /** unit price **/
$item_list = new ItemList();
        $item_list->setItems(array($item_1));
$amount = new Amount();
        $amount->setCurrency('GBP')
            ->setTotal($package_amount);
$transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');
$redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('customer/status')) /** Specify return URL **/
            ->setCancelUrl(URL::to('customer/status'));
$payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
            
        // dd($payment->create($this->_api_context));exit; 
        try {
 Log::debug(":: try :: ".print_r($payment,true));
$payment->create($this->_api_context);

 // Log::debug(":: _api_context :: ".print_r($this->_api_context,true));
 //echo $this->_api_context;

//Log::debug(":: before paypal return data :: ".print_r($payment,true));

} 
catch (PayPalConnectionException $ex) {

        //Log::debug(":: 1st catche :: ".print_r($ex->getData(),true));

    //var_dump(json_decode($ex->getData()));
        //exit(1);
    
if (\Config::get('app.debug')) {
\Session::put('failed_paypalpay', 'Connection timeout');
    $paypal_history_data['status']='Connection timeout';
    $paypal_history_data['payment_mode']='Paypal'; 

    $purchases_history_data['active_package']=0;
    $purchases_history_data['package_remaining']=0;

    $purchases_history=DB::table('purchases_history')->insert($purchases_history_data);
    $paypal_history_data['purchase_history_id']=DB::getPdo()->lastInsertId();
    $payment_history=DB::table('payment_history')->insert($paypal_history_data);

    return Redirect::to('customer/paypalpaymentsuccess');
} else {

\Session::put('failed_paypalpay', 'Some error occur, sorry for inconvenient');
    $paypal_history_data['status']='Inconvenient error';
    $paypal_history_data['payment_mode']='Paypal'; 

    $purchases_history_data['active_package']=0;
    $purchases_history_data['package_remaining']=0;

    $purchases_history=DB::table('purchases_history')->insert($purchases_history_data);
    $paypal_history_data['purchase_history_id']=DB::getPdo()->lastInsertId();
    $payment_history=DB::table('payment_history')->insert($paypal_history_data);


    $customer_details=Customer::find($customer_id);

    $notifydata['package_name'] =$package_name;
    $notifydata['slots_number'] =$slots_number;
    $notifydata['package_validity'] =$package_validity_date;
    $notifydata['package_purchase_date'] =$purchases_date;
    $notifydata['package_amount'] =$package_amount;
    $notifydata['payment_id'] =' ';
    $notifydata['payment_mode'] ='Paypal';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Payment Failed';

    //Log::debug(" paypal Inconvenient error notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    return Redirect::to('customer/paypalpaymentsuccess');
}
}
foreach ($payment->getLinks() as $link) {
if ($link->getRel() == 'approval_url') {
$redirect_url = $link->getHref();
                break;
}
}
/** add payment ID to session **/
Session::put('paypal_payment_id', $payment->getId());
        

if (isset($redirect_url)) {
/** redirect to paypal **/
            return Redirect::away($redirect_url);
}
\Session::put('failed_paypalpay', 'Unknown error occurred');
    $paypal_history_data['status']='Unknown error';
    $paypal_history_data['payment_mode']='Paypal'; 

    $purchases_history_data['active_package']=0;
    $purchases_history_data['package_remaining']=0;

    $purchases_history=DB::table('purchases_history')->insert($purchases_history_data);
    $paypal_history_data['purchase_history_id']=DB::getPdo()->lastInsertId();
    $payment_history=DB::table('payment_history')->insert($paypal_history_data);

    $customer_details=Customer::find($customer_id);


    $notifydata['package_name'] =$package_name;
    $notifydata['slots_number'] =$slots_number;
    $notifydata['package_validity'] =$package_validity_date;
    $notifydata['package_purchase_date'] =$purchases_date;
    $notifydata['package_amount'] =$package_amount;
    $notifydata['payment_id'] =' ';
    $notifydata['payment_mode'] ='Paypal';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Payment Failed';

    //Log::debug(" paypal payment Failed For Unknown Error notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    return Redirect::to('customer/paypalpaymentsuccess');       
}

public function getPaymentStatus()
    {


        $package_name=Session('package_name');
        $slots_number=Session('slots_number');
        $package_id=Session('package_id');
        $purchases_date=Session('purchases_date');
        $package_validity_date=Session('package_validity_date');
        $customer_id=Session('customer_id');
        $package_amount=Session('package_amount');   

        $purchases_history_data['slot_id']=$package_id;
        $purchases_history_data['customer_id']=$customer_id;
        $purchases_history_data['purchases_date']=$purchases_date;
        $purchases_history_data['package_validity_date']=$package_validity_date;
        $purchases_history_data['payment_options']='Paypal';
        $purchases_history_data['slots_name']=$package_name;
        $purchases_history_data['slots_number']=$slots_number;
        $purchases_history_data['slots_price']=$package_amount;



        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
/** clear the session payment ID **/
        

    if (empty(Input::get('PayerID')) || empty(Input::get('token'))) { 

    $paypal_history_data['status']='Cancelled';
    $paypal_history_data['payment_mode']='Paypal'; 

    $purchases_history_data['active_package']=0;
    $purchases_history_data['package_remaining']=0;

    $purchases_history=DB::table('purchases_history')->insert($purchases_history_data);

    $paypal_history_data['purchase_history_id']=DB::getPdo()->lastInsertId();

    $payment_history=DB::table('payment_history')->insert($paypal_history_data);

    //Log::debug(":: before session value :: ".print_r($package_amount,true));

    $customer_details=Customer::find($customer_id);


    $notifydata['package_name'] =$package_name;
    $notifydata['slots_number'] =$slots_number;
    $notifydata['package_validity'] =$package_validity_date;
    $notifydata['package_purchase_date'] =$purchases_date;
    $notifydata['package_amount'] =$package_amount;
    $notifydata['payment_id'] =' ';
    $notifydata['payment_mode'] ='Paypal';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Payment Cancelled';

    //Log::debug(" paypal payment Cancelled notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    Session::forget('package_amount');
    Session::forget('slots_number');
    Session::forget('package_id');
    Session::forget('purchases_date');
    Session::forget('package_validity_date');
    Session::forget('customer_id');
    Session::forget('package_amount');

\Session::put('failed_paypalpay', 'Payment Cancelled by the customer');

       return Redirect::to('customer/paypalpaymentsuccess');
}

        Session::forget('paypal_payment_id');
		$payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
/**Execute the payment **/
        
//try{
$result = $payment->execute($execution, $this->_api_context);


if ($result->getState() == 'approved') {

	
	$amout=$result->getTransactions();
	$transaction_details=$amout[0]->getAmount();

	$paypal_history_data['payment_id']=$payment_id;
	//$paypal_history_data['payer_id']=Input::get('PayerID');
	$paypal_history_data['status']='Success';
	$paypal_history_data['amount']=$transaction_details->total;
	$paypal_history_data['payment_mode']='Paypal';
	$paypal_history_data['currency']=$transaction_details->currency;

	//Log::debug(":: paypal return data :: ".print_r($paypal_history_data,true));

    $purchases_history_data['active_package']=1;
    $purchases_history_data['package_remaining']=$slots_number;


    $purchases_history=DB::table('purchases_history')->insert($purchases_history_data);

    $paypal_history_data['purchase_history_id']=DB::getPdo()->lastInsertId();

    $payment_history=DB::table('payment_history')->insert($paypal_history_data);

    //Log::debug(":: before session value :: ".print_r($package_amount,true));

    $remaining_session_request_now=Carbon::now()->toDateString();

    $sum_slots = DB::table('purchases_history')
      ->select('active_package','package_remaining','customer_id')
      ->where('customer_id',$customer_id)
      ->where('active_package',1 )
      ->where('package_remaining','>=',0)
      ->where('package_validity_date','>=',$remaining_session_request_now)
      ->sum('package_remaining');

      $sum_extra_slots = DB::table('purchases_history')
    ->select('active_package','package_remaining','extra_package_remaining','customer_id')
    ->where('customer_id',$customer_id)
    ->where('active_package',1)
    ->where('extra_package_remaining','>=',0)
    ->sum('extra_package_remaining');

    $sum_slots=$sum_slots+$sum_extra_slots;

      session(['sum_slots' => $sum_slots]);


    $customer_details=Customer::find($customer_id);


    $notifydata['package_name'] =$package_name;
    $notifydata['slots_number'] =$slots_number;
    $notifydata['package_validity'] =$package_validity_date;
    $notifydata['package_purchase_date'] =$purchases_date;
    $notifydata['package_amount'] =$package_amount;
    $notifydata['payment_id'] =$payment_id;
    $notifydata['payment_mode'] ='Paypal';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Payment Success';

    //Log::debug(" paypal payment success notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    Session::forget('package_amount');
    Session::forget('slots_number');
    Session::forget('package_id');
    Session::forget('purchases_date');
    Session::forget('package_validity_date');
    Session::forget('customer_id');
    Session::forget('package_amount');


\Session::put('success_paypalpay', 'Payment success');
\Session::put('payment_id', $payment_id);
    return Redirect::to('customer/paypalpaymentsuccess');
}


    $amout=$result->getTransactions();
    $transaction_details=$amout[0]->getAmount();

    $paypal_history_data['payment_id']=$payment_id;
    //$paypal_history_data['payer_id']=Input::get('PayerID');
    $paypal_history_data['status']='Failed';
    $paypal_history_data['amount']=$transaction_details->total;
    $paypal_history_data['payment_mode']='Paypal';
    $paypal_history_data['currency']=$transaction_details->currency;

    //Log::debug(":: paypal return data :: ".print_r($paypal_history_data,true));

    $purchases_history_data['active_package']=0;
    $purchases_history_data['package_remaining']=0;

    $purchases_history=DB::table('purchases_history')->insert($purchases_history_data);

    $paypal_history_data['purchase_history_id']=DB::getPdo()->lastInsertId();

    $payment_history=DB::table('payment_history')->insert($paypal_history_data);

    //Log::debug(":: before session value :: ".print_r($package_amount,true));

    $customer_details=Customer::find($customer_id);


    $notifydata['package_name'] =$package_name;
    $notifydata['slots_number'] =$slots_number;
    $notifydata['package_validity'] =$package_validity_date;
    $notifydata['package_purchase_date'] =$purchases_date;
    $notifydata['package_amount'] =$package_amount;
    $notifydata['payment_id'] =$payment_id;
    $notifydata['payment_mode'] ='Paypal';
    $notifydata['url'] = '/customer/purchase_history';
    $notifydata['customer_name']=$customer_details->name;
    $notifydata['customer_email']=$customer_details->email;
    $notifydata['customer_phone']=$customer_details->ph_no;
    $notifydata['status']='Payment Failed';

    //Log::debug(" paypal payment failed notification ".print_r($notifydata,true));

    $customer_details->notify(new PackagePurchaseNotification($notifydata));

    Session::forget('package_amount');
    Session::forget('slots_number');
    Session::forget('package_id');
    Session::forget('purchases_date');
    Session::forget('package_validity_date');
    Session::forget('customer_id');
    Session::forget('package_amount');

\Session::put('failed_paypalpay', 'Payment failed');
        return Redirect::to('customer/paypalpaymentsuccess');
}

public function common_diet_plan_pay(Request $request)
{

  $diet_plan_id=$request->diet_plan_id;
  $diet_plan_details=DB::table('common_diet_plan')->where('id',$diet_plan_id)->first();      

  Session::put('plan_id', $diet_plan_id);
  Session::put('plan_name', $diet_plan_details->diet_plan_name);
  Session::put('plan_price', $diet_plan_details->price);

  $payment_history_data['plan_id']=$diet_plan_id;
  $payment_history_data['plan_name']=$diet_plan_details->diet_plan_name;
  $payment_history_data['plan_price']=$diet_plan_details->price;
  $payment_history_data['plan_purchase_by']=Auth::guard('customer')->user()->id;
  $payment_history_data['purchase_date']=Carbon::now()->toDateString();
        

  $payer = new Payer();
          $payer->setPaymentMethod('paypal');

  $item_1 = new Item();
  $item_1->setName($diet_plan_details->diet_plan_name) /** item name **/
              ->setCurrency('GBP')
              ->setQuantity(1)
              ->setPrice($diet_plan_details->price); /** unit price **/
  $item_list = new ItemList();
          $item_list->setItems(array($item_1));
  $amount = new Amount();
          $amount->setCurrency('GBP')
              ->setTotal($diet_plan_details->price);
  $transaction = new Transaction();
          $transaction->setAmount($amount)
              ->setItemList($item_list)
              ->setDescription('Your transaction description');
  $redirect_urls = new RedirectUrls();
          $redirect_urls->setReturnUrl(URL::to('customer/diet-plan-pay-status')) /** Specify return URL **/
              ->setCancelUrl(URL::to('customer/diet-plan-pay-status'));
  $payment = new Payment();
          $payment->setIntent('Sale')
              ->setPayer($payer)
              ->setRedirectUrls($redirect_urls)
              ->setTransactions(array($transaction));
          
          try {
   //Log::debug(":: try :: ".print_r($payment,true));
  $payment->create($this->_api_context);

  } 
  catch (PayPalConnectionException $ex) {

  if (\Config::get('app.debug')) {
  \Session::put('failed_paypalpay', 'Connection timeout');
    $payment_history_data['status']='Connection timeout';

    $purchases_history=DB::table('common_diet_plan_purchases_history')->insert($payment_history_data);

    Session::forget('plan_id');
    Session::forget('plan_name');
    Session::forget('plan_price');

    return Redirect::to('customer/common-diet-plan-paymentsuccess');
  } else {

  \Session::put('failed_paypalpay', 'Some error occur, sorry for inconvenient');
    $payment_history_data['status']='Inconvenient error';
    $purchases_history=DB::table('common_diet_plan_purchases_history')->insert($payment_history_data);

    Session::forget('plan_id');
    Session::forget('plan_name');
    Session::forget('plan_price');

    return Redirect::to('customer/common-diet-plan-paymentsuccess');
  }
  }
  foreach ($payment->getLinks() as $link) {
  if ($link->getRel() == 'approval_url') {
  $redirect_url = $link->getHref();
                  break;
  }
  }
  /** add payment ID to session **/
  Session::put('paypal_payment_id', $payment->getId());
          

  if (isset($redirect_url)) {
  /** redirect to paypal **/
    return Redirect::away($redirect_url);
  }
  \Session::put('failed_paypalpay', 'Unknown error occurred');
  $payment_history_data['status']='Unknown error';
  $purchases_history=DB::table('common_diet_plan_purchases_history')->insert($payment_history_data);

  Session::forget('plan_id');
  Session::forget('plan_name');
  Session::forget('plan_price');
     
  return Redirect::to('customer/common-diet-plan-paymentsuccess');       
}

public function getCommonDietPlanPaymentStatus()
{

  $plan_id=Session('plan_id');
  $plan_name=Session('plan_name');
  $plan_price=Session('plan_price');

  $purchases_history_data['plan_id']=$plan_id;
  $purchases_history_data['plan_name']=$plan_name;
  $purchases_history_data['plan_price']=$plan_price;
  $purchases_history_data['plan_purchase_by']=Auth::guard('customer')->user()->id;
  $purchases_history_data['purchase_date']=Carbon::now()->toDateString();
  
  /** Get the payment ID before session clear **/
  $payment_id = Session::get('paypal_payment_id');
/** clear the session payment ID **/
        

  if (empty(Input::get('PayerID')) || empty(Input::get('token'))) { 

  $purchases_history_data['status']='Cancelled by customer';
  
  \Session::put('failed_paypalpay', 'Payment Cancelled by the customer');

  $purchases_history_data=DB::table('common_diet_plan_purchases_history')->insert($purchases_history_data);

  Mail::send('emails.common_diet_plan_mail',['email' =>Auth::guard('customer')->user()->email,'name' =>Auth::guard('customer')->user()->name,'status' =>'Cancelled by customer'],function($message) {
            $message->to(Auth::guard('customer')->user()->email)->subject('Diet Plan Payment');   
            });

  Session::forget('plan_id');
  Session::forget('plan_name');
  Session::forget('plan_price');

  return Redirect::to('customer/common-diet-plan-paymentsuccess');
  }

  Session::forget('paypal_payment_id');
  $payment = Payment::get($payment_id, $this->_api_context);
  $execution = new PaymentExecution();
  $execution->setPayerId(Input::get('PayerID'));
/**Execute the payment **/
        
//try{
$result = $payment->execute($execution, $this->_api_context);


if ($result->getState() == 'approved') {

  
  $amout=$result->getTransactions();
  $transaction_details=$amout[0]->getAmount();

  $purchases_history_data['payment_reference_id']=$payment_id;
  $purchases_history_data['status']='Payment success';

  //Log::debug(":: paypal return data :: ".print_r($paypal_history_data,true));

  \Session::put('success_paypalpay', 'Payment success');
  \Session::put('payment_id', $payment_id);

  $purchases_history_data=DB::table('common_diet_plan_purchases_history')->insert($purchases_history_data);

  $diet_plan_details=DB::table('common_diet_plan')->where('id',$plan_id)->first();

  Session::forget('plan_id');
  Session::forget('plan_name');
  Session::forget('plan_price');

  return Redirect::to('customer/common-diet-plan-paymentsuccess');
}


  $amout=$result->getTransactions();
  $transaction_details=$amout[0]->getAmount();

  $purchases_history_data['payment_reference_id']=$payment_id;
  //$paypal_history_data['payer_id']=Input::get('PayerID');
  $purchases_history_data['status']='Payment failed';

  //Log::debug(":: paypal return data :: ".print_r($paypal_history_data,true));

  \Session::put('failed_paypalpay', 'Payment failed');
  $purchases_history_data=DB::table('common_diet_plan_purchases_history')->insert($purchases_history_data);

  Session::forget('plan_id');
  Session::forget('plan_name');
  Session::forget('plan_price');

  return Redirect::to('customer/common-diet-plan-paymentsuccess');
}




}