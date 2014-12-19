<?php

class ConsultantController extends BaseController {
	
	protected $consultant;
			
	public function serveWeixin()
	{
		
	}
	
	public function signup()
	{
		if(Input::method() === 'POST')
		{
			$this->consultant = Consultant::create(Input::all());
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
			$client->save();
			$client->products()->save($product);
			
			$client->consultants()->save($this->consultant);
			
			return Redirect::to('make-report/' . $product->id);
		}
		return View::make('consultant/register-client');
	}
	
	public function makeReport(Product $product = null)
	{
		Session::set('user.id', 1);
		Session::set('user.type', 'consultant');
		
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