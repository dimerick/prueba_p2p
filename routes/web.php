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

Route::get('/', 'PaymentController@index');
Route::get('/home', 'PaymentController@index')->name('home');
Route::get('payment-response/{id}', 'PaymentController@paymentResponse');

#Route::get('create-request', 'PaymentController@createRequest');
Route::post('payments/{id}', 'PaymentController@updateStatus');
Route::resource('payments', 'PaymentController');
Auth::routes();


