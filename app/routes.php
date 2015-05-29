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

Route::get('/', 'HomeController@showWelcome');

Route::model('product', 'Product');
Route::model('quote', 'Quote');
Route::model('consultant', 'Consultant');

Route::group(array('domain' => Config::get('weixin.consultant.domain')), function()
{
	Route::any('wx', 'WeixinController@serveConsultant');
});

Route::group(array('domain' => Config::get('weixin.client.domain')), function()
{
	Route::any('wx', 'WeixinController@serveClient');
	Route::get('update-menu', 'WeixinController@updateMenu');
});

Route::group(array('domain' => Config::get('weixin.news.domain')), function()
{
	Route::any('wx', 'WeixinController@serveGuest');
	Route::get('update-menu', 'WeixinController@updateMenu');
});

Route::post('product/{product}/quote/{quote}', 'ProductQuoteController@update');

Route::resource('product', 'ProductController');
Route::resource('consultant', 'ConsultantController');
Route::resource('product.quote', 'ProductQuoteController', array('except'=>array('show')));
