<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontSimpleController@index')->name('bbldb');

Route::get('/alertifydemo', function () {
    return view('alertifyjquery');
});


Route::POST('update-trainer-first-changepassword','TrainerFirstChangePasswordController@updateTrainerPassword')->name('trainer.firstchangepassword.update');

Auth::routes();

////the group function used to create all link as prefix is trainer
Route::group ( [
  'prefix' => 'trainer'
], function () {
//// goto trainer home panel
Route::get('home', 'TrainerController@index')->name('home');

// for show own profile of trainer
Route::get('showprofile', 'TrainerController@showprofile')->name('showprofile');

// for show own profile of trainer
Route::get('editprofile', 'TrainerController@showupdateform');
Route::POST('updateprofile','TrainerController@updateprofile')->name('trainer.profileupdate');

/// route for admin change password 

Route::GET('changepassword','TrainerChangePasswordController@showChagePasswordForm')->name('trainer.changepassword');
Route::POST('update-changepassword','TrainerChangePasswordController@updateTrainerPassword')->name('trainer.changepassword.update');


// for add slot
Route::get('add-slot', 'TrainerController@showslot')->name('addslot');
Route::get('add-slot-record', 'TrainerController@addslot')->name('addslotrecord');
Route::POST('store-slot-record', 'TrainerController@insertslot')->name('storeslots');
//for showing trainer details
Route::get('trainerlist','TrainerController@showlist')->name('trainerlist');



//for adding the trainer details into the databa


Route::get('addtrainer','TrainerController@addtrainer')->name('addtrainer');
//for
Route::POST('inserttrainer','TrainerController@inserttrainer')->name('inserttrainer');


Route::get('trainerdelete/{id}', 'TrainerController@trainerdelete');

Route::get('edittrainer/{id}', 'TrainerController@showtrainerseditform');
Route::POST('updatetrain', 'TrainerController@traineredit')->name('updatetrain');



Route::POST('editslots', 'TrainerController@slotsedit')->name('editslots');


// for edit slot
Route::get('editslots/{id}', 'TrainerController@showslotseditform');
Route::POST('editslots', 'TrainerController@slotsedit')->name('editslots');

// for delete slot
Route::get('deleteslots/{id}', 'TrainerController@slotsdelete');


//view exercise type //
Route::get('gymType','TrainerController@gym_showlist')->name('gymType');
//view exercise type  delete//
Route::get('gymdelete/{id}', 'TrainerController@gymdelete');

//view exercise type  insert//
Route::get('add_exercise_trainer','TrainerController@add_exercise_trainer')->name('add_exercise_trainer');
Route::post('exerciseUserInsert', 'TrainerController@exercise_user_insert')->name('exercise_insert');

//view exercise type  update//
Route::get('editexercise/{id}', 'TrainerController@show_edit_exercise_form');
 Route::POST('updateexercise', 'TrainerController@update_exercise')->name('updateexercise');


//for showing contact details
Route::get('contactlist','TrainerController@contactlist')->name('contactlist');

//for showing contact details
Route::get('feedbacklist','TrainerController@feedbacklist')->name('feedbacklist');

//testimonial backend insert

Route::get('testimonialshow','TrainerController@testimonialshow')->name('testimonialshow');
Route::post('testimonialinsert','TrainerController@testimonialinsert')->name('testimonial_insert');

//testimonial backend show//
Route::get('testimonial_view','TrainerController@testimonial_view')->name('testimonial_view');


Route::get('testimonialedit/{id}','TrainerController@testimonialedit')->name('testimonialedit');
Route::post('testimonialupdate','TrainerController@testimonialupdate')->name('testimonialupdate');


Route::get('testimonialdelete/{id}', 'TrainerController@testimonialdelete');


Route::get('mot_show','TrainerController@mot_show')->name('mot_show');

//insert mot//
Route::get('motinsertshow','TrainerController@motinsertshow')->name('motinsertshow_page');



Route::get('motinsertshowauto','TrainerController@motinsertshowauto')->name('searchajax');

Route::get('customersearch','TrainerController@customersearch')->name('customersearch');

Route::post('motinsert','TrainerController@motinsert')->name('motinsert');



Route::get('mot_customer_request', 'TrainerController@mot_customer_request')->name('mot_customer_request');


//update mot//

Route::get('moteditshow/{id}','TrainerController@moteditshow');
Route::post('motedit','TrainerController@motedit')->name('motedit');

//delete//
Route::get('motdelete/{id}', 'TrainerController@motdelete');

//Add session//
Route::get('add_session','TrainerController@add_session')->name('add_session');

Route::get('slot_time','TrainerController@slot_times')->name('slot_time');

Route::POST('trainer_slotinsert','TrainerController@trainer_slotinsert')->name('trainer_slotinsert');
Route::get('add_customer','TrainerController@add_customer_session')->name('add_customer');

//Add Coupon//
Route::get('searchslots','TrainerController@searchslots')->name('searchslots');
Route::get('add_coupon','TrainerController@add_coupon')->name('add_coupon');
Route::POST('coupon_insert','TrainerController@coupon_insert')->name('coupon_insert');
Route::get('our_coupon_list','TrainerController@our_coupon_list')->name('our_coupon_list');
Route::get('our_coupon_edit_view/{id}','TrainerController@our_coupon_edit_view')->name('our_coupon_edit_view');
Route::POST('coupon_edit_insert','TrainerController@coupon_edit_insert')->name('coupon_edit_insert');
Route::get('coupon_delete/{id}', 'TrainerController@coupon_delete')->name('coupon_delete');
Route::post('duplicatecoupon','TrainerController@duplicatecoupon')->name('duplicatecoupon');
Route::post('duplicatecoupon_edit','TrainerController@duplicatecoupon_edit')->name('duplicatecoupon_edit');
Route::post('checkdiscount_price','TrainerController@checkdiscount_price')->name('checkdiscount_price');
Route::post('checkdiscount_price_edit','TrainerController@checkdiscount_price_edit')->name('checkdiscount_price_edit');

// end coupon

Route::get('diet-plan-purchases-history','TrainerController@diet_plan_purchases')->name('diet_plan_purchases');


//show our client//
Route::get('our_trainer_list','TrainerController@our_client_show')->name('our_trainer_list');

//insert our client//

Route::get('our_trainer_insert_view','TrainerController@client_insert_view')->name('client_insert_view');
Route::post('client_insert','TrainerController@client_insert')->name('client_insert');

//update our_client
Route::get('our_trainer_edit_view/{id}','TrainerController@client_edit_view')->name('client_edit_view');
Route::post('client_update','TrainerController@client_update')->name('client_update');


//delete//
Route::get('client_delete/{id}', 'TrainerController@client_delete');

Route::get('payment_history_backend','TrainerController@payment_history_backend')->name('payment_history');


Route::get('payment_history_backend_request', 'TrainerController@payment_history_backend_request')->name('payment_history_backend_request');

Route::get('order_history_backend_request', 'TrainerController@order_history_backend_request')->name('order_history_backend_request');

Route::get('trainer_active_deactive', 'TrainerController@trainer_active_deactive')->name('trainer_active_deactive');


Route::post('cheeckexercisecategory', 'TrainerController@cheeck_exercise_category');
Route::post('cheeckexercisecategory_edit', 'TrainerController@cheeckexercisecategory_edit');
Route::post('cheecktestimonialname', 'TrainerController@cheecktestimonialname');
Route::post('cheecktestimonialname_edit', 'TrainerController@cheecktestimonialname_edit');

Route::get('allCustomers', 'TrainerController@all_customers')->name('allCustomers');

// @totan 071018

Route::get('admin_get_slot_time', 'TrainerController@booking_slot_times')->name('admin_get_slot_time');
Route::get('admin_get_current_slot_time', 'TrainerController@admin_get_current_slot_time')->name('admin_get_current_slot_time');
Route::get('admin_get_slot_trainer', 'TrainerController@admin_get_slot_trainer')->name('admin_get_slot_trainer');

Route::get('check_customer_session', 'TrainerController@check_customer_session')->name('check_customer_session');

Route::get('slot_insert_to_cart_trainer', 'TrainerController@slot_insert_to_cart_trainer')->name('slot_insert_to_cart_trainer');

Route::get('cart_data_delete_trainer', 'TrainerController@cart_data_delete_trainer')->name('cart_data_delete_trainer');

Route::get('admin_get_current_time', 'TrainerController@admin_get_current_time')->name('admin_get_current_time');
Route::get('admin_get_time', 'TrainerController@admin_get_time')->name('admin_get_time');


Route::get('add-bootcamp-plan', 'TrainerController@bootcamp_plan')->name('bootcamp_plan');

Route::post('insert-bootcamp-plan', 'TrainerController@insert_bootcamp_plan')->name('insert_bootcamp_plan');
Route::get('bootcamp-plan', 'TrainerController@bootcamp_plan_list')->name('bootcamp_plan_list');
Route::get('edit-bootcamp-plan/{id}', 'TrainerController@bootcamp_plan_edit_view')->name('bootcamp_plan_edit');
Route::post('bootcamp_plan_edit_insert', 'TrainerController@bootcamp_plan_edit_insert')->name('bootcamp_plan_edit_insert');
Route::get('bootcamp_plan_delete/{id}', 'TrainerController@bootcamp_plan_delete')->name('bootcamp_plan_delete');

Route::get('bootcamp-plan-schedule', 'TrainerController@bootcamp_plan_schedule')->name('bootcamp_plan_schedule');
Route::get('bootcamp-schedule-cancelled', 'TrainerController@bootcamp_schedule_cancelled_admin');

Route::get('bootcamp-schedule-cancelled2', 'TrainerController@bootcamp_schedule_cancelled_admin2');

Route::post('checked_bootcampdate','TrainerController@checked_bootcampdate')->name('checked_bootcampdate');
Route::get('bootcamp-schedule-booking-cancelled/{slug}', 'TrainerController@bootcamp_booking_individual_cancelled')->name('bootcamp_booking_individual_cancelled');
Route::get('individual_bootcamp_cancele', 'TrainerController@individual_bootcamp_cancele');

Route::get('edit-bootcamp-plan-schedule/{id}', 'TrainerController@bootcamp_schedule_edit_view')->name('bootcamp_schedule_edit_view');

Route::get('delete-bootcamp-plan-schedule/{id}', 'TrainerController@bootcamp_schedule_delete')->name('bootcamp_schedule_delete');

Route::post('update-bootcamp-plan-schedules','TrainerController@update_bootcamp_plan_schedules')->name('update_bootcamp_plan_schedules');
Route::post('bootcamp-plan-final-delete','TrainerController@bootcamp_plan_final_delete')->name('bootcamp_plan_final_delete');



////// For common diet plan list//////

Route::get('common-diet-plan', 'TrainerController@common_diet_plan')->name('common_diet_plan');

// Add new diet plan
Route::get('add-common-diet-plan','TrainerController@add_common_diet_plan')->name('add_common_diet_plan');
Route::post('insert-common-diet-plan', 'TrainerController@insert_common_diet_plan')->name('insert_common_diet_plan');


//Update diet plan
Route::get('edit-common-diet-plan/{id}', 'TrainerController@edit_common_diet_plan');
Route::post('update-diet-plan', 'TrainerController@update_common_diet_plan')->name('update_common_diet_plan');

//Delete diet plan
Route::get('delete-common-diet-plan/{id}', 'TrainerController@delete_common_diet_plan')->name('delete_common_diet_plan');

Route::post('checkDietPlan_duplicate', 'TrainerController@checkDietPlan_duplicate');
Route::post('check_editDietPlan_duplicate', 'TrainerController@check_editDietPlan_duplicate');

Route::get('add-product', 'TrainerController@add_product')->name('add_product');
Route::post('insert-product', 'TrainerController@insert_product')->name('insert_product');

Route::get('edit-product/{slug}', 'TrainerController@edit_product')->name('edit_product');
Route::post('update-product', 'TrainerController@update_product')->name('update_product');
Route::get('all-products', 'TrainerController@view_product')->name('view_product');
Route::get('product-delete/{id}', 'TrainerController@product_delete');
Route::get('purchased-history', 'TrainerController@order_history')->name('order_history');

Route::get('purchased-history', 'TrainerController@order_history')->name('order_history');

Route::get('active-order/{slug}', 'TrainerController@active_order_by_admin')->name('active_order_by_admin');

Route::post('active-order-success', 'TrainerController@active_order_success')->name('active_order_success');

Route::get('deactive-order/{slug}', 'TrainerController@deactive_order_by_admin')->name('deactive_order_by_admin');

Route::post('deactive-order-success', 'TrainerController@deactive_order_success')->name('deactive_order_success');

});



/*Route::get('add-slot', 'TrainerController@showslot')->name('addslot');
Route::get('add-slot-record', 'TrainerController@addslot')->name('addslotrecord');
Route::POST('store-slot-record', 'TrainerController@insertslot')->name('storeslots');*/



//// For Social Login
Route::get('auth/{provider}/login', 'Customer\SocialLoginController@redirectToProvider')->name('social-auth-login');
Route::get('auth/{provider}/callback', 'Customer\SocialLoginController@handleProviderCallback');


/// route for goto admin panel after login


/// route for customer login                            
Route::GET('customer-login','Customer\LoginController@showLoginForm')->name('customerpanel.frontlogin_registration');
Route::POST('customer-login','Customer\LoginController@login');

/// route for customer logout 
Route::POST('customer/logout', 'Customer\LoginController@logout')->name('customerpanel.logout');


/// route for customer reset password 
Route::GET('customer-password/reset','Customer\ForgotPasswordController@showLinkRequestForm')->name('customerpanel.password.request');
Route::POST('customer-password/email','Customer\ForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');

Route::POST('customer-password/reset','Customer\ResetPasswordController@reset');
Route::GET('customer-password/reset/{token}','Customer\ResetPasswordController@showResetForm')->name('customerpanel.password.reset');

    Route::get('customer-registration', 'Customer\RegisterController@showRegistrationForm')->name('customer-register');

    Route::post('register', 'Customer\RegisterController@showForm')->name('customer-register-success');
    Route::get('register/verify/{confirmationCode}','Customer\RegisterController@confirm')->name('verify-user');

//customer changes password//
Route::GET('customerpanel/home/customer-changepassword','Customer\ChangePasswordController@showChagePasswordForm')->name('customer.changepassword');

Route::POST('customerpanel/home/customer-changepassword','Customer\ChangePasswordController@updateAdminPassword')->name('customer.changepassword.update');






/// route for admin profile edit and update 
Route::GET('adminpanel/home/editprofile/{id}','Admin\ProfileUpdateController@showupdateform');
Route::POST('adminpanel/home/updateprofile','Admin\ProfileUpdateController@updateprofile')->name('admin.profileupdate');
/// route for admin profile view
Route::GET('adminpanel/home/{id}','Admin\ProfileUpdateController@showprofile');
///for showing customer details
Route::get('pastRequestlist/{id}','TrainerController@pastshowlist');
Route::get('futureRequestlist/{id}','TrainerController@futureshowlist');

Route::get('canelledlist','TrainerController@cancelledshowlist');

Route::get('futurePendingRequestlist/{id}','TrainerController@future_pending_showlist');


Route::get('approvePendingRequest', 'TrainerController@approve_pending_request')->name('approvePendingRequest');


Route::get('approveCustomer', 'TrainerController@approve_customer_request')->name('approveCustomer');
// Route::get('approvePastCustomer', 'TrainerController@approve_past_customer_request')->name('approvePastCustomer');











//fronted work here//

  Route::group (['prefix' => 'customer'], function () {

Route::get('bbl','FrontController@bbl')->name('bbl');


Route::get('about-us','FrontController@about')->name('about-us');

Route::get('exercise','FrontController@exercise')->name('exercise');
Route::get('testimonial','FrontController@cust_testimonial')->name('cust_testimonial');

Route::get('details','FrontController@details')->name('details');
Route::get('history','FrontController@history')->name('history');

Route::get('frontlogin','FrontController@frontlogin')->name('frontlogin');

Route::get('pricing','FrontController@frontprice')->name('customer.pricing');

Route::get('services','FrontController@services')->name('services');

//slots payment//
Route::get('purchase_form/{id}','FrontController@purchase_form')->name('purchase_form');
Route::POST('package_purchase','FrontController@purchase_payment_mode')->name('customer.package_purchase');
Route::post('paypalpayment','PaypalPaymentController@payWithpaypal');
Route::get('status','PaypalPaymentController@getPaymentStatus');
Route::get('paypalpaymentsuccess','FrontController@paypal_payment_success');
Route::post('bankpaymentsuccess','BankPaymentController@bank_payment_success');
Route::get('bankpaymentcomplete','BankPaymentController@bank_payment_complete')->name('bankpaymentcomplete');

// Front Coupon
Route::get('cus_couponsearch','FrontController@couponchecking')->name('cus_couponsearch');
Route::post('valid_coupon','FrontController@validcoupon')->name('valid_coupon');
//customer profile//

Route::get('profile','FrontController@customer_profile')->name('profile');

//edit profile//
Route::get('editprofile', 'FrontController@customer_showupdateform')->name('customer.editprofile');
Route::POST('updateprofile','FrontController@updateprofile')->name('customer.profileupdate');

Route::get('purchase_history','FrontController@purchases_history')->name('customer_purchases_history');

Route::get('my-diet-plan','FrontController@common_diet_plan_history')->name('customer_diet_plan');

Route::get('purchased-history','FrontController@my_order_history')->name('my_order_history');

Route::get('booking_slot','FrontController@booking_slot')->name('booking_slot');
Route::get('get_slot_time','FrontController@get_slot_time')->name('get_slot_time');
Route::get('get_current_slot_time','FrontController@get_current_slot_time')->name('get_current_slot_time');

Route::get('get_slot_trainer','FrontController@get_slot_trainer')->name('get_slot_trainer');



Route::POST('slotinsert','FrontController@slotinsert')->name('customer.slotinsert');
Route::get('customer_session_delete/{id}', 'FrontController@session_delete')->name('customer_session_delete');



Route::get('mybooking','FrontController@booking_history')->name('booking_history');


Route::get('free-sessions','FrontController@free_sessions');



Route::get('show_purchase_history','FrontController@show_purchase_history')->name('show_purchase_history');



Route::get('my_mot','FrontController@my_mot')->name('my_mot');


Route::get('contact-us','FrontController@customer_contact')->name('contact-us');
Route::get('customer_contact_insert','FrontController@customer_contact_insert')->name('customer_contact_insert');

Route::get('slot_insert_to_cart','FrontController@slot_insert_to_cart')->name('slot_insert_to_cart');

Route::get('cart_data_delete','FrontController@cart_data_delete')->name('cart_data_delete');


Route::get('booking-bootcamp','FrontController@booking_bootcamp');
Route::get('get_bootcamp_time','FrontController@get_bootcamp_time')->name('get_bootcamp_time');
Route::post('bootcamp-booking','FrontController@bootcamp_booking_customer')->name('bootcamp_booking_customer');
Route::get('bootcamp-booking-cancele-customer/{slug}','FrontController@bootcamp_booking_cancele_customer')->name('bootcamp_booking_cancele_customer');




Route::post('diet-plan-purchase','FrontController@common_diet_plan_purchase');
Route::post('common-diet-plan-pay','PaypalPaymentController@common_diet_plan_pay');
Route::get('diet-plan-pay-status','PaypalPaymentController@getCommonDietPlanPaymentStatus');
Route::get('common-diet-plan-paymentsuccess','FrontController@common_diet_plan_paymentsuccess');

Route::get('bootcamp-plan-purchase/{slug}','FrontController@bootcamp_plan_purchase')->name('bootcamp_plan_purchase');
Route::post('bootcamp-plan-purchase','FrontController@bootcamp_purchase_payment_mode')->name('bootcamp_product_purchase_request');

Route::post('bootcamp-stripe-payment','FrontController@bootcamp_strip_payment')->name('bootcamp_strip_payment');
Route::get('bootcampstripepaymentsuccess','FrontController@bootcampstripepaymentsuccess');
Route::post('bootcamp_bankpaymentsuccess','BankPaymentController@bootcamp_bank_payment_success');
Route::get('bootcampbankpaymentcomplete','BankPaymentController@bootcamp_bank_payment_complete');

Route::get('personal-training-plan-purchase/{slug}','FrontController@pt_plan_purchase')->name('pt_plan_purchase');

Route::post('personal-training-plan-purchase','FrontController@pt_purchase_payment_mode')->name('pt_product_purchase_request');
Route::post('pt-stripe-payment','FrontController@pt_strip_payment')->name('pt_strip_payment');
Route::get('ptstripepaymentsuccess','FrontController@ptstripepaymentsuccess');
Route::post('personal_training_bankpaymentsuccess','BankPaymentController@pt_bank_payment_success');
Route::get('personaltrainingbankpaymentcomplete','BankPaymentController@pt_bank_payment_complete');
});





Route::get('bbl','FrontSimpleController@bbl')->name('bbl');

Route::get('about-us','FrontSimpleController@about')->name('about-us');


Route::get('gym-training','FrontSimpleController@gym_training')->name('gym_training');
Route::get('diet-plan','FrontSimpleController@diet_plans')->name('diet_plans');
Route::get('bootcamp-training','FrontSimpleController@bootcamp_training')->name('bootcamp_training');
Route::get('personal-instructor','FrontSimpleController@personal_instructor')->name('personal_instructor');




Route::get('details','FrontSimpleController@details')->name('details');
Route::get('history','FrontSimpleController@history')->name('history');

Route::get('frontlogin','FrontSimpleController@frontlogin')->name('frontlogin');

Route::get('pricing','FrontSimpleController@frontprice')->name('pricing');

Route::get('services','FrontSimpleController@services')->name('services');

Route::get('testimonial','FrontSimpleController@testimonial')->name('testimonial');

Route::get('exercise','FrontSimpleController@gym_gallery')->name('exercise');





//insert function for contacts//
Route::get('contact-us','FrontSimpleController@front_contact')->name('contact-us');
Route::post('front_contact_insert','FrontSimpleController@front_contact_insert')->name('front_contact_insert');

//



//Live Server cache, route, view clear
//Clear Cache facade value:
Route::get('/cache-clear', function() {
  $exitCode = Artisan::call('cache:clear');
  return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
  $exitCode = Artisan::call('optimize');
  return '<h1>Reoptimized class loader</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
  $exitCode = Artisan::call('route:clear');
  return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
  $exitCode = Artisan::call('view:clear');
  return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
  $exitCode = Artisan::call('config:cache');
  return '<h1>Clear Config cleared</h1>';
});
//Clear Config cache:
Route::get('/queue-worker', function() {
  $exitCode = Artisan::call('queue:work');
  return '<h1>Started Queue Worker</h1>';
});
Route::get('/queue-flush', function() {
  $exitCode = Artisan::call('queue:flush');
  return '<h1>Started Queue Worker</h1>';
});
Route::get('info', function () {
    return phpversion();
});














