<?php

class ConsultantController extends BaseController {
	
	protected $consultant;
			
	public function serveWeixin()
	{
		$wx = new Weixin();
		if(Input::get('echostr')){
			$wx->verify();
		}
	}
	
	public function signup()
	{
		$weixin = new WeixinQY();
		if(!Session::get('weixin.user_id'))
		{
			$weixin_user_info = $weixin->oauth_get_user_info();
			Session::set('weixin.user_id', $weixin_user_info->UserId);
		}
		
		$this->consultant = Consultant::where('open_id', Session::get('weixin.user_id'))->first();
		
		if(Input::method() === 'POST' && !$this->consultant)
		{
			$this->consultant = new Consultant();
			$this->consultant->name = Input::get('name');
			$this->consultant->type = Input::get('type');
			$this->consultant->meta = json_encode(Input::get('meta'), JSON_UNESCAPED_UNICODE);
			$this->consultant->open_id = Session::get('weixin.user_id');
			$this->consultant->save();
			
			return Redirect::to('register-client');
		}
		
		return View::make('consultant/signup', array('consultant'=>$this->consultant));
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
			return Redirect::to('signup');
		}
		
		if(Input::method() === 'POST')
		{
			$product = new Product();
			$product->name = Input::get('name');
			$product->type = Input::get('type');
			$product->meta = json_encode(Input::get('meta'), JSON_UNESCAPED_UNICODE);
			$product->initial_cap = $product->type === '单账户' ? Input::get('meta.起始资金规模') : Input::get('meta.劣后资金规模') * (1 + Input::get('meta.杠杆配比'));
			$product->start_date = Input::get('start_date');
			$product->consultant()->associate($this->consultant);
			$product->save();
			
			$product->quotes()->create(array(
				'date'=>$product->start_date,
				'value'=>1,
				'cap'=>$product->initial_cap
			));
			
			$client = new Client();
			$client->name = Input::get('name');
			$client->open_id = md5(rand(0, 1E6));
			$client->save();
			$client->products()->save($product);
			
			$weixin = new WeixinQY();
			$client->consultants()->save($this->consultant);
			
			$weixin->send_message($this->consultant->open_id, '客户 ' . $client->name . ' 登记成功，请客户在以下地址查看净值：' . 'http://client.ebillion.com.cn/view-report?hash=' . $client->open_id . '。客户端公众服务号即将上线，敬请期待。');
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
			return Redirect::to('signup');
		}
		
		if(is_null($product))
		{
			$products = $this->consultant->products;
		}
		
		if(Input::method() === 'POST')
		{
			$quote = new Quote();
			$quote->fill(Input::all());
			$quote->cap = Input::get('cap');
			$quote->value = Input::get('cap') / $product->initial_cap;
			$quote->product()->associate($product);
			$quote->save();
			
			if(!Input::get('continue')){
				return Redirect::to('make-report');
			}
			
		}
		
		return View::make('consultant/make-report', compact('products', 'product'));
	}
	
	public function viewReport($product)
	{
		
		$chartData = array();
		
		foreach($product->quotes()->dateAscending()->get() as $quote){
			$chartData[$product->id][] = array(strtotime($quote->date) * 1000, round($quote->value, 2));
		}
		
		$sh300 = Product::where('name', '沪深300指数')->first();
		$quotes = $sh300 ? $sh300->quotes()->where('date', '>=', $product->start_date)->dateAscending()->get() : array();
		$chartData['sh300'] = array();
		foreach($quotes as $quote){
			$chartData['sh300'][] = array(strtotime($quote->date) * 1000, round($quote->value, 2));
		}
		
		return View::make('client/view-report', compact('product', 'chartData'));
	}
	
}