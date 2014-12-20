<?php

class ConsultantController extends BaseController {
	
	protected $consultant;
			
	public function serveWeixin()
	{
		$wx = new Weixin();
	}
	
	protected function _weixinLogin(){
		$weixin = new WeixinQY();
		
	}

	public function signup()
	{
		$weixin = new WeixinQY();
		if(!Session::get('weixin.user_id'))
		{
			$weixin_user_info = $weixin->oauth_get_user_info();
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
		
		$weixin = new WeixinQY();
		
		if(!Session::get('weixin.user_id'))
		{
			$weixin_user_info = $weixin->oauth_get_user_info();
			Session::set('weixin.user_id', $weixin_user_info->UserId);
		}
		
		$this->consultant = Consultant::where('open_id', Session::get('weixin.user_id'))->first();
		
		if(!$this->consultant){
			return 'error: consultant not logged in';
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
			
			$weixin = new WeixinQY();
			$client->consultants()->save($this->consultant);
			
			$weixin->send_message($this->consultant->open_id, '客户 ' . $client->name . ' 登记成功，请客户在以下地址注册:' . 'http://client.ebillion.com.cn/signup?invite=' . $client->open_id);
			return Redirect::to('make-report/' . $product->id);
		}
		return View::make('consultant/register-client');
	}
	
	public function makeReport(Product $product = null)
	{
		$weixin = new WeixinQY();
		
		if(!Session::get('weixin.user_id'))
		{
			$weixin_user_info = $weixin->oauth_get_user_info();
			Session::set('weixin.user_id', $weixin_user_info->UserId);
		}
		
		$this->consultant = Consultant::where('open_id', Session::get('weixin.user_id'))->first();
		
		if(!$this->consultant){
			return 'error: consultant not logged in';
		}
		
		if(is_null($product))
		{
			$products = $this->consultant->products;
		}
		
		if(Input::method() === 'POST')
		{
			$quote = new Quote();
			$quote->fill(Input::all());
			$quote->product()->associate($product);
			$quote->save();
			return Redirect::to('make-report');
		}
		
		return View::make('consultant/make-report', compact('products', 'product'));
	}
	
}