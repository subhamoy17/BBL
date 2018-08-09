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
    	$purchases_date=$request->purchases_date;
    	$package_validity_date=$request->package_validity_date;
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
$payment->create($this->_api_context);

//Log::debug(":: before paypal return data :: ".print_r($payment,true));

} catch (\PayPal\Exception\PPConnectionException $ex) {
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

    Log::debug(":: before session value :: ".print_r($package_amount,true));

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

	Log::debug(":: paypal return data :: ".print_r($paypal_history_data,true));

    $purchases_history_data['active_package']=1;
    $purchases_history_data['package_remaining']=$slots_number;


    $purchases_history=DB::table('purchases_history')->insert($purchases_history_data);

    $paypal_history_data['purchase_history_id']=DB::getPdo()->lastInsertId();

    $payment_history=DB::table('payment_history')->insert($paypal_history_data);

    Log::debug(":: before session value :: ".print_r($package_amount,true));

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

    Log::debug(":: paypal return data :: ".print_r($paypal_history_data,true));

    $purchases_history_data['active_package']=0;
    $purchases_history_data['package_remaining']=0;

    $purchases_history=DB::table('purchases_history')->insert($purchases_history_data);

    $paypal_history_data['purchase_history_id']=DB::getPdo()->lastInsertId();

    $payment_history=DB::table('payment_history')->insert($paypal_history_data);

    Log::debug(":: before session value :: ".print_r($package_amount,true));

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




}