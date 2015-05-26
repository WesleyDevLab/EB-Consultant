<?php

class ProductController extends BaseController {

	/**
	 * Display a listing of the product.
	 *
	 * @return Response
	 */
	public function index()
	{
		$query = Product::query();
		
		if(Input::query('consultant_id'))
		{
			$query->where('consultant_id', Input::query('consultant_id'));
		}
		
		if($this->user && $this->user->loggable instanceof Consultant)
		{
			$query->where('consultant_id', $this->user->loggable->id);
		}
		
		$products = $query->get();
		
		$mp = $this->weixin->account;
		$user = $this->user;
		
		return View::make('product/list', compact('products', 'mp', 'user'));
	}


	/**
	 * Show the form for creating a new product.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('product/edit');
	}


	/**
	 * Store a newly created product in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$product = new Product();
		return $this->update($product);
	}


	/**
	 * Display the specified product.
	 *
	 * @param  Product $product
	 * @return Response
	 */
	public function show(Product $product)
	{
		$mp = $this->weixin->account;;
		return View::make('product/edit', compact('product', 'mp'));
	}


	/**
	 * Show the form for editing the specified product.
	 *
	 * @param  Product $product
	 * @return Response
	 */
	public function edit(Product $product)
	{
		return View::make('product/edit', compact('product'));
	}


	/**
	 * Update the specified product in storage.
	 *
	 * @param  Product $product
	 * @return Response
	 */
	public function update(Product $product)
	{
		if(Input::get('action') === 'remove')
		{
			return $this->destroy($product);
		}

		if($product->exists && $product->consultant->id !== $this->user->id && !$this->user->is_admin)
		{
			throw new Exception('没有权限更新此产品', 403);
		}
		
		$product->name = Input::get('name');
		$product->type = Input::get('type');
		$product->meta = Input::get('meta');
		$product->initial_cap = $product->type === '单账户' ? Input::get('meta.起始资金规模') : Input::get('meta.劣后资金规模') * (1 + Input::get('meta.杠杆配比'));
		$product->start_date = Input::get('start_date');
		
		if(!$product->consultant && $this->user->loggable instanceof Consultant)
		{
			$product->consultant()->associate($this->user->loggable);
		}
		
		$product->save();

		if(count($product->quotes) === 0)
		{
			$product->quotes()->create(array(
				'date'=>$product->start_date,
				'value'=>1,
				'cap'=>$product->initial_cap
			));
		}

		if(count($product->clients) === 0 && in_array($product->type, array('单账户', '伞型') ))
		{
			$client = Client::firstOrCreate(array('name'=>Input::get('name')));
			
			$client->products()->save($product);
			
			if($this->user->loggable instanceof Consultant)
			{
				$client->consultants()->save($this->user->loggable);
			}

			$client_user = new User();
			
			$client_user->fill(array(
				'name'=>Input::get('name'),
				'open_id'=>'rand-' . md5(rand(0, 1E6))
			));

			$client_user->loggable()->associate($client);
			$client_user->save();

			$this->weixin->send_message($this->user->open_id, '客户 ' . $client->name . ' 登记成功，请客户在微信点击以下地址绑定：' . 'http://client.ebillion.com.cn/product/' . $product->id . '/quote?hash=' . $client_user->open_id . '，并关注“翊弼私募产品统计平台”微信公众账号。');
		}
		
		return Redirect::to('product');
	}


	/**
	 * Remove the specified product from storage.
	 *
	 * @param  Product $product
	 * @return Response
	 */
	public function destroy($product)
	{
		if($product->consultant->id !== $this->user->id && !$this->user->is_admin)
		{
			throw new Exception('没有权限删除此产品', 403);
		}
		
		$clients = $product->clients();

		$product->clients()->detach();
		$product->delete();

		foreach($clients as $client)
		{
			$client->consultants()->detach();
			$client->delete();
		}

		return Redirect::to('product');
	}
	
}
