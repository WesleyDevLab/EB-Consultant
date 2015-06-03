<?php

class ProductQuoteController extends BaseController {

	/**
	 * 查看产品的净值报告图表
	 * @param  Product $product
	 */
	public function index(Product $product)
	{
		$chart_data = array();
		
		$query = $product->quotes()->dateAscending();
		
		if(!$this->user instanceof Consultant && (!$this->user || !$this->user->is_admin))
		{
			$query->fridayOnly();
		}
		
		$quotes = $query->get();
		
		foreach($quotes as $quote){
			$chart_data[$product->id][] = array(strtotime($quote->date) * 1000, round($quote->value, 2));
			if(in_array($product->type, array('结构化', '伞型')))
			{
				$chart_data[$product->id . '_inferior'][] = array(strtotime($quote->date) * 1000, round($quote->value_inferior, 2));
			}
		}
		
		$latest_quote_date = $product->quotes()->dateDescending()->first()->date;
		
		$sh300 = Product::firstOrCreate(array('name'=>'沪深300指数'));
		
		$query_sh300 = $sh300->quotes()->where('date', '>=', $product->start_date)->where('date', '<=', isset($latest_quote_date) ? $latest_quote_date : date('Y-m-d'))->dateAscending();
		
		if(!$this->user instanceof Consultant && (!$this->user || !$this->user->is_admin))
		{
			$query_sh300->fridayOnly();
		}
		
		$quotes_sh300 = $query_sh300->get();
		
		$chart_data['sh300'] = array();
		
		foreach($quotes_sh300 as $quote){
			$chart_data['sh300'][] = array(strtotime($quote->date) * 1000, round($quote->value, 2));
		}
		
		return View::make('product-quote/report', compact('product', 'quotes', 'chart_data'));
		
	}
	

	/**
	 * 为一产品添加，修改一条净值报告
	 *
	 * @param  Product $product
	 * @return Response
	 */
	public function create(Product $product)
	{
		if(!$this->user){
			return Redirect::to('consultant/edit');
		}
		
		$product_type = in_array($product->type, array('结构化', '管理型')) ? 'product' : 'account';
		
		return View::make('product-quote/edit', compact('product', 'product_type'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Product $product
	 * @return Response
	 */
	public function store(Product $product)
	{
		$quote = new Quote();
		return $this->update($product, $quote);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Product $product
	 * @param Quote $quote
	 * @return Response
	 */
	/**
	 * 为一产品添加，修改一条净值报告
	 */
	public function edit(Product $product, Quote $quote)
	{
		if(!$this->user){
			return Redirect::to('consultant/edit');
		}
		
		$product_type = in_array($product->type, array('结构化', '管理型')) ? 'product' : 'account';
		
		return View::make('product-quote/edit', compact('product', 'quote', 'product_type'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Product $product
	 * @param Quote $quote
	 * @return Response
	 */
	public function update(Product $product, Quote $quote)
	{
		if(Input::get('remove'))
		{
			return $this->destroy($product, $quote);
		}

		$quote->fill(Input::all());
		
		if(Input::get('cap'))
		{
			$quote->cap = Input::get('cap');
			$quote->value = Input::get('cap') / $product->initial_cap;
		}
		elseif(Input::get('value'))
		{
			$quote->value = Input::get('value');
		}
		
		if(Input::get('value_inferior'))
		{
			$quote->value_inferior = Input::get('value_inferior');
		}
		else
		{
			$quote->value_inferior = null;
		}
		
		if($product->type === '伞型')
		{
			$cap_inferior = $product->meta->劣后资金规模;
			$cap_preferred = $product->meta->劣后资金规模 * $product->meta->杠杆配比;
			$quote->value_inferior = ($quote->cap - $cap_preferred - $product->getCost($quote->date)) / $cap_inferior;
		}
		
		$quote->product()->associate($product);
		$quote->save();

		if(Input::get('continue'))
		{
			return Redirect::to('product/' . $product->id . '/quote/create');
		}
		else
		{
			return Redirect::to('product/' . $product->id . '/quote');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Product $product
	 * @param Quote $quote
	 * @return Response
	 */
	public function destroy(Product $product, Quote $quote)
	{
		$quote->delete();
		return Redirect::to('product/' . $product->id . '/quote');
	}


}
