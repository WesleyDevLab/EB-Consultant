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

Route::model('product', 'Product');
Route::model('quote', 'Quote');
Route::model('client', 'Client');
Route::model('consultant', 'Consultant');

Route::group(array('domain' => 'consultant.ebillion.com.cn'), function()
{
	Route::any('wx', 'ConsultantController@serveWeixin');
	Route::any('signup', 'ConsultantController@signup');
	Route::any('view-consultant/{consultant?}', 'ConsultantController@viewConsultant');
	Route::any('view-client/{product?}', 'ConsultantController@viewClient');
	Route::any('register-client', 'ConsultantController@viewClient');
	Route::any('make-report/{product?}/{quote?}', 'ConsultantController@makeReport');
	Route::any('view-report/{product}', 'ConsultantController@viewReport');
});

Route::group(array('domain' => 'client.ebillion.com.cn'), function()
{
	Route::any('wx', 'ClientController@serveWeixin');
	Route::any('signup', 'ClientController@signup');
	Route::any('view-report', 'ClientController@viewReport');
	Route::any('update-menu', 'ClientController@updateMenu');
});

Route::group(array('domain' => 'news.ebillion.com.cn'), function()
{
	Route::any('wx', 'NewsController@serveWeixin');
	Route::get('consultant', 'NewsController@viewConsultant');
	Route::get('product', 'NewsController@viewProduct');
	Route::get('report/{product}', 'NewsController@viewReport');
});

