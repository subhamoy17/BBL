<?php 

// setup all configuration of paypal
return
[

	'client_id'=>env('PAYPAL_CLIENT_ID',''), //paypal client id
	'secret'=>env('PAYPAL_SECRET',''), //paypal client secret
	'settings'=> array(

			'paypal_mode' => env('PAYPAL_MODE',''),
			'http.ConnectionTimeOut'=>30, /// timeout in 30 seconds
			'log.LogEnabled'=>true,			// show the result in log
			'log.FileName'=>storage_path().'/logs/paypal.log', // log file create
			'log.LogLevel'=>'ERROR',

		),

];