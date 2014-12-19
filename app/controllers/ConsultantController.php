<?php

class ConsultantController extends BaseController {
	
	protected $consultant;
			
	public function serveWeixin()
	{
		$wx = new Weixin();
	}
	
	public function signup()
	{
		$weixin_qy = new WeixinQY();
		if(!Session::get('weixin.user_id')){
			$weixin_user_info = $weixin_qy->oauth_get_user_info();
			Session::set('weixin.user_id', $weixin_user_info->UserId);
		}

		if(Input::method() === 'POST')
		{
			$this->consultant = new Consultant();
			$this->consultant->fill(Input::all());
			$this->consultant->open_id = Session::get('weixin.user_id');
			$this->consultant->save();
			
			Session::set('user.id', $this->consultant->id);
			Session::set('user.type', 'consultant');
			
			return Redirect::to('register-client');
		}
		
		return View::make('consultant/signup');
	}
	
	public function registerClient()
	{
		
		if(Session::get('user.id') && Session::get('user.type') === 'consultant')
		{
			$this->consultant = Consultant::find(Session::get('user.id'));
		}
		
		if(Input::method() === 'POST')
		{
			$product = new Product();
			$product->name = Input::get('name');
			$product->type = Input::get('type');
			$product->metas = json_encode(Input::get('metas'), JSON_UNESCAPED_UNICODE);
			$product->consultant()->associate($this->consultant);
			$product->save();
			
			$client = new Client();
			$client->name = Input::get('name');
			$client->open_id = md5(rand(0, 1E6));
			$client->save();
			$client->products()->save($product);
			
			$weixin = new Weixin();
			
			
			$client->consultants()->save($this->consultant);
			
			return Redirect::to('make-report/' . $product->id);
		}
		return View::make('consultant/register-client');
	}
	
	public function makeReport(Product $product = null)
	{
//		Session::set('user.id', 1);
//		Session::set('user.type', 'consultant');
		
		if(Session::get('user.id') && Session::get('user.type') === 'consultant'){
			$this->consultant = Consultant::find(Session::get('user.id'));
		}
		
		if(is_null($this->consultant)){
			return 'error: consultant not logged in';
		}
		
		if(is_null($product)){
			$products = $this->consultant->products;
		}
		
		if(Input::method() === 'POST'){
			$quote = new Quote();
			$quote->fill(Input::all());
			$quote->product()->associate($product);
			$quote->save();
			return Redirect::to('make-report');
		}
		
		return View::make('consultant/make-report', compact('products', 'product'));
	}
	
}