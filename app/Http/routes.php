<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index');

Route::get('/', array('before' => 'auth', 'uses' => 'BookingController@index'));

Route::get('opt_out_customer/{id}', 'HomeController@opt_out_customer');

Route::group(['middleware' => 'auth'], function()
{
    Route::get('setting', 'HomeController@getSetting');

    Route::post('setting/{id}', 'HomeController@postSetting');
});

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
    Route::resource('user', 'UserController');

    Route::resource('product', 'ProductController');

    Route::resource('service', 'ServiceController');
});

Route::resource('customer', 'CustomerController');

Route::resource('booking', 'BookingController');

Route::post('booking/{id}/cancel', 'BookingController@cancel');

Route::get('process', 'BookingController@getProcess');

Route::post('process/{id}', 'BookingController@postProcess');

Route::get('events', 'BookingController@events');

Route::get('availability/{user_id}/{customer_id}/{date_time}/{duration}', 'BookingController@availability');

Route::get('stylist_availability/{date_time}/{user_id?}', 'BookingController@stylist_availability');

Route::put('set_reminder/{customer_id}', 'CustomerController@set_reminder');