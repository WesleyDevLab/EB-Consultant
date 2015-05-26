<?php

class ProductQuoteController extends BaseController {

	/**
	 * 查看产品的净值报告图表
	 * @param  Product $product
	 */
	public function index(Product $product)
	{
		$chart_data = array();
		
		foreach($product->quotes()->dateAscending()->get() as $quote){
			$chart_data[$product->id][] = array(strtotime($quote->date) * 1000, round($quote->value, 2));
			if($product->type === '结构化')
			{
				$chart_data[$product->id . '_inferior'][] = array(strtotime($quote->date) * 1000, round($quote->value_inferior, 2));
			}
		}
		
		$latest_quote_date = $product->quotes()->dateDescending()->first()->date;
		
		$sh300 = Product::where('name', '沪深300指数')->first();
		$quotes = $sh300 ? $sh300->quotes()->where('date', '>=', $product->start_date)->where('date', '<=', isset($latest_quote_date) ? $latest_quote_date : date('Y-m-d'))->dateAscending()->get() : array();
		$chart_data['sh300'] = array();
		foreach($quotes as $quote){
			$chart_data['sh300'][] = array(strtotime($quote->date) * 1000, round($quote->value, 2));
		}
		
		$mp = $this->weixin->account;
		
		return View::make('product-quote/report', compact('product', 'chart_data', 'mp'));
		
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
		
		return View::make('product-quote/edit', compact('product'));
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
		
		return View::make('product-quote/edit', compact('product', 'quote'));
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
		$quote->cap = Input::get('cap');
		$quote->value = Input::get('cap') / $product->initial_cap;
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
