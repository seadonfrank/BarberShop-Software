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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::get('opt_out_customer/{id}', 'HomeController@opt_out_customer');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::resource('customer', 'CustomerController');

Route::resource('product', 'ProductController');

Route::resource('service', 'ServiceController');

Route::resource('booking', 'BookingController');

Route::get('process', 'BookingController@getProcess');

Route::post('process/{id}', 'BookingController@postProcess');

Route::get('events', 'BookingController@events');

Route::get('availability/{user_id}/{customer_id}/{date_time}/{duration}', 'BookingController@availability');

Route::put('set_reminder/{customer_id}', 'CustomerController@set_reminder');