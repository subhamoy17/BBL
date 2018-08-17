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
Route::get('home/{id}', 'TrainerController@showprofile');

// for show own profile of trainer
Route::get('editprofile/{id}', 'TrainerController@showupdateform');
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
Route::post('motinsert','TrainerController@motinsert')->name('motinsert');



Route::get('mot_customer_request', 'TrainerController@mot_customer_request')->name('mot_customer_request');









//update mot//

Route::get('moteditshow/{id}','TrainerController@moteditshow');
Route::post('motedit','TrainerController@motedit')->name('motedit');

//delete//
Route::get('motdelete/{id}', 'TrainerController@motdelete');


//show our client//
Route::get('our_trainer_list','TrainerController@our_client_show')->name('our_trainer_list');

//insert our client//

Route::get('client_insert_view','TrainerController@client_insert_view')->name('client_insert_view');
Route::post('client_insert','TrainerController@client_insert')->name('client_insert');

//update our_client
Route::get('client_edit_view/{id}','TrainerController@client_edit_view')->name('client_edit_view');
Route::post('client_update','TrainerController@client_update')->name('client_update');




//delete//
Route::get('client_delete/{id}', 'TrainerController@client_delete');

Route::get('payment_history_backend','TrainerController@payment_history_backend')->name('payment_history');


Route::get('payment_history_backend_request', 'TrainerController@payment_history_backend_request')->name('payment_history_backend_request');





Route::get('trainer_active_deactive', 'TrainerController@trainer_active_deactive')->name('trainer_active_deactive');



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

    Route::get('cutomer-registration', 'Customer\RegisterController@showRegistrationForm')->name('customer-register');

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

Route::get('futurePendingRequestlist/{id}','TrainerController@future_pending_showlist');


Route::get('approvePendingRequest', 'TrainerController@approve_pending_request')->name('approvePendingRequest');


Route::get('approveCustomer', 'TrainerController@approve_customer_request')->name('approveCustomer');
// Route::get('approvePastCustomer', 'TrainerController@approve_past_customer_request')->name('approvePastCustomer');
Route::get('allCustomers', 'TrainerController@all_customers')->name('allCustomers');










//fronted work here//
Route::prefix('customer')->group(function () {

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

//customer profile//
Route::get('profile/{id}','FrontController@customer_profile')->name('profile');

//edit profile//
Route::get('editprofile/{id}', 'FrontController@customer_showupdateform')->name('customer.editprofile');
Route::POST('updateprofile','FrontController@updateprofile')->name('customer.profileupdate');


Route::get('purchase_history','FrontController@purchases_history')->name('customer_purchases_history');



Route::get('booking_slot/{id}','FrontController@booking_slot')->name('booking_slot');
Route::get('booking_slot_time','FrontController@booking_slot_times')->name('get_slot_time');




Route::POST('slotinsert','FrontController@slotinsert')->name('customer.slotinsert');




Route::get('mybooking','FrontController@booking_history')->name('booking_history');


Route::get('show_purchase_history','FrontController@show_purchase_history')->name('show_purchase_history');



Route::get('my_mot','FrontController@my_mot')->name('my_mot');




Route::get('contact-us','FrontController@customer_contact')->name('contact-us');
Route::get('customer_contact_insert','FrontController@customer_contact_insert')->name('customer_contact_insert');



});





Route::get('bbl','FrontSimpleController@bbl')->name('bbl');

Route::get('about-us','FrontSimpleController@about')->name('about-us');


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














