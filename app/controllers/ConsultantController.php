<?php

class ConsultantController extends BaseController {
	
	protected $consultant;
			
	public function serveWeixin()
	{
		$wx = new WeixinQY();
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
		
		if(Input::method() === 'POST')
		{
			if(empty($this->consultant))
			{
				$this->consultant = new Consultant();
				$this->consultant->open_id = Session::get('weixin.user_id');
			}
			
			$this->consultant->name = Input::get('name');
			$this->consultant->type = Input::get('type');
			$this->consultant->meta = Input::get('meta');
			
			$this->consultant->save();
			
			if(empty($this->consultant))
			{
				return Redirect::to('register-client');
			}
		}
		
		return View::make('consultant/signup', array('consultant'=>$this->consultant));
	}
	
	public function viewConsultant($consultant = null)
	{
		$weixin = new WeixinQY();
		if(!Session::get('weixin.user_id'))
		{
			$weixin_user_info = $weixin->oauth_get_user_info();
			Session::set('weixin.user_id', $weixin_user_info->UserId);
		}
		
		$this->consultant = Consultant::where('open_id', Session::get('weixin.user_id'))->first();
		
		$administrators = json_decode(ConfigModel::where('key', 'administrators')->first()->value);
		
		if(!$this->consultant || !in_array($this->consultant->open_id, $administrators))
		{
			return;
		}
		
		if(is_null($consultant))
		{
			$consultants = Consultant::all();
			return View::make('consultant/list', compact('consultants'));
		}
		
		else
		{
			if(Input::method() === 'POST')
			{
				$consultant->name = Input::get('name');
				$consultant->type = Input::get('type');
				$consultant->meta = Input::get('meta');

				$consultant->save();

				return Redirect::to('view-consultant');
			}
			
			return View::make('consultant/signup', compact('consultant'));
		}
	}
	
	public function viewClient($product = null)
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
			
			if(Input::get('action') === 'remove' && isset($product))
			{
				$clients = $product->clients();
				
				$product->clients()->detach();
				$product->delete();
				
				foreach($clients as $client)
				{
					$client->delete();
				}
				
				return Redirect::to('view-client');
			}
			
			if(is_null($product))
			{
				$product = new Product();
			}
			
			$product->name = Input::get('name');
			$product->type = Input::get('type');
			$product->meta = Input::get('meta');
			$product->initial_cap = $product->type === '单账户' ? Input::get('meta.起始资金规模') : Input::get('meta.劣后资金规模') * (1 + Input::get('meta.杠杆配比'));
			$product->start_date = Input::get('start_date');
			$product->consultant()->associate($this->consultant);
			$product->save();
			
			if(count($product->quotes) === 0)
			{
				$product->quotes()->create(array(
					'date'=>$product->start_date,
					'value'=>1,
					'cap'=>$product->initial_cap
				));
			}
			
			if(count($product->clients) === 0)
			{
				$client = new Client();
				$client->name = Input::get('name');
				$client->open_id = md5(rand(0, 1E6));
				$client->save();
				$client->products()->save($product);
				$client->consultants()->save($this->consultant);
				$weixin = new WeixinQY();
				$weixin->send_message($this->consultant->open_id, '客户 ' . $client->name . ' 登记成功，请客户在微信点击以下地址绑定：' . 'http://client.ebillion.com.cn/view-report?hash=' . $client->open_id . '，并关注“翊弼私募产品统计平台”微信公众账号。');
			}
			
			return Redirect::to('make-report/' . $product->id);
		}
		
		if(is_null($product) && strpos(Route::getCurrentRoute()->getPath(), 'view-client') !== false)
		{
			$products = $this->consultant->products;
			return View::make('consultant/register-client', compact('products'));
		}
		else
		{
			return View::make('consultant/register-client', compact('product'));
		}
		
	}
	
	public function makeReport(Product $product = null, Quote $quote = null)
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
			if(Input::get('remove'))
			{
				$quote->delete();
				return Redirect::to('make-report/' . $product->id);
			}
			
			is_null($quote) && $quote = new Quote();
			
			$quote->fill(Input::all());
			$quote->cap = Input::get('cap');
			$quote->value = Input::get('cap') / $product->initial_cap;
			$quote->product()->associate($product);
			$quote->save();
			
			if(!Input::get('continue'))
			{
				return Redirect::to('make-report');
			}
			else
			{
				return Redirect::to('make-report/' . $product->id);
			}
			
		}
		
		return View::make('consultant/make-report', compact('products', 'product', 'quote'));
	}
	
	public function viewReport($product)
	{
		$weixin = new WeixinQY();

		if(!Session::get('weixin.user_id'))
		{
			$weixin_user_info = $weixin->oauth_get_user_info();
			Session::set('weixin.user_id', $weixin_user_info->UserId);
		}

		$consultant = $this->consultant = Consultant::where('open_id', Session::get('weixin.user_id'))->first();
		
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
		
		return View::make('client/view-report', compact('product', 'chartData', 'consultant'));
	}
	
}