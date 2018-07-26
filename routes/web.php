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

//update mot//

Route::get('moteditshow/{id}','TrainerController@moteditshow');
Route::post('motedit','TrainerController@motedit')->name('motedit');

//delete//
Route::get('motdelete/{id}', 'TrainerController@motdelete');




});







/*Route::get('add-slot', 'TrainerController@showslot')->name('addslot');
Route::get('add-slot-record', 'TrainerController@addslot')->name('addslotrecord');
Route::POST('store-slot-record', 'TrainerController@insertslot')->name('storeslots');*/

/// route for goto admin panel after login

/// route for customer login                            
Route::GET('bbl-customer-0518','Customer\LoginController@showLoginForm')->name('customerpanel.frontlogin_registration');
Route::POST('bbl-customer-0518','Customer\LoginController@login');

/// route for customer logout 
Route::POST('customer/logout', 'Customer\LoginController@logout')->name('customerpanel.logout');






/// route for admin reset password 
Route::GET('customer-password/reset','Customer\ForgotPasswordController@showLinkRequestForm')->name('customerpanel.password.request');
Route::POST('customer-password/email','Customer\ForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');

Route::POST('customer-password/reset','Customer\ResetPasswordController@reset');
Route::GET('customer-password/reset/{token}','Customer\ResetPasswordController@showResetForm')->name('customerpanel.password.reset');

    Route::get('cutomer_registration', 'Customer\RegisterController@showRegistrationForm')->name('customer-register');

    Route::post('register', 'Customer\RegisterController@showForm')->name('customer-register-success');

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
Route::get('approveCustomer', 'TrainerController@approve_customer_request')->name('approveCustomer');
Route::get('approvePastCustomer', 'TrainerController@approve_past_customer_request')->name('approvePastCustomer');
Route::get('allCustomers', 'TrainerController@all_customers')->name('allCustomers');



//fronted work here//
Route::prefix('customer')->group(function () {

Route::get('bbl','FrontController@bbl')->name('bbl');


Route::get('about','FrontController@about')->name('about');



Route::get('details','FrontController@details')->name('details');
Route::get('history','FrontController@history')->name('history');

Route::get('frontlogin','FrontController@frontlogin')->name('frontlogin');

Route::get('pricing','FrontController@frontprice')->name('customer.pricing');

Route::get('services','FrontController@services')->name('services');

//slots payment//
Route::get('purchase_form/{id}','FrontController@purchase_form')->name('purchase_form');
Route::POST('purchaseinsert','FrontController@purchaseinsert')->name('customer.purchaseinsert');

//customer profile//
Route::get('profile/{id}','FrontController@customer_profile')->name('profile');

//edit profile//
Route::get('editprofile/{id}', 'FrontController@customer_showupdateform')->name('customer.editprofile');
Route::POST('updateprofile','FrontController@updateprofile')->name('customer.profileupdate');


Route::get('purchase_history','FrontController@purchases_history')->name('customer_purchases_history');



Route::get('booking_slot/{id}','FrontController@booking_slot')->name('booking_slot');
Route::POST('slotinsert','FrontController@slotinsert')->name('customer.slotinsert');




Route::get('booking_history','FrontController@booking_history')->name('booking_history');

Route::get('show_purchase_history','FrontController@show_purchase_history')->name('show_purchase_history');



Route::get('my_mot','FrontController@my_mot')->name('my_mot');




Route::get('contact','FrontController@customer_contact')->name('customer_contact');
Route::get('customer_contact_insert','FrontController@customer_contact_insert')->name('customer_contact_insert');



});





Route::get('bbl','FrontSimpleController@bbl')->name('bbl');

Route::get('about','FrontSimpleController@about')->name('about');


Route::get('details','FrontSimpleController@details')->name('details');
Route::get('history','FrontSimpleController@history')->name('history');

Route::get('frontlogin','FrontSimpleController@frontlogin')->name('frontlogin');

Route::get('pricing','FrontSimpleController@frontprice')->name('pricing');

Route::get('services','FrontSimpleController@services')->name('services');

Route::get('testimonial','FrontSimpleController@testimonial')->name('testimonial');

Route::get('gym_gallery','FrontSimpleController@gym_gallery');





//insert function for contacts//
Route::get('front_contact','FrontSimpleController@front_contact');
Route::post('front_contact_insert','FrontSimpleController@front_contact_insert')->name('front_contact_insert');

//














