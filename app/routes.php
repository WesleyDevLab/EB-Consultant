<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::any('/dev', 'DevController@index');

Route::model('product', 'Product');
Route::model('client', 'Client');

Route::group(array('domain' => 'consultant.ebillion.com.cn'), function()
{
	Route::any('/wx', 'ConsultantController@serveWexin');
	Route::any('/signup', 'ConsultantController@signup');
	Route::any('/register-client', 'ConsultantController@registerClient');
	Route::any('/make-report/{product?}', 'ConsultantController@makeReport');
});

Route::group(array('domain' => 'client.ebillion.com.cn'), function()
{
	Route::any('/wx', 'ClientController@serveWeixin');
	Route::any('/view-report/{client?}', 'ClientController@viewReport');
});

