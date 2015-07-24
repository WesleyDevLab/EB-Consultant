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
		
		if(!$this->user || (!$this->user->loggable instanceof Consultant && !$this->user->is_admin))
		{
			$query->fridayOnly($product->start_date);
		}
		
		$quotes = $query->get();
		
		foreach($quotes as $quote){
			$chart_data[$product->id][] = array(strtotime($quote->date) * 1000, round($quote->value_total ? $quote->value_total : $quote->value, 2));
			if(in_array($product->type, array('结构化', '伞型')))
			{
				$chart_data[$product->id . '_inferior'][] = array(strtotime($quote->date) * 1000, round($quote->value_inferior, 2));
			}
		}
		
		$latest_quote_date = $product->quotes()->dateDescending()->first()->date;
		
		$sh300 = Product::firstOrCreate(array('name'=>'沪深300指数'));
		
		$query_sh300 = $sh300->quotes()->where('date', '>=', $product->start_date)->where('date', '<=', isset($latest_quote_date) ? $latest_quote_date : date('Y-m-d'))->dateAscending();
		
		if(!$this->user || (!$this->user->loggable instanceof Consultant && !$this->user->is_admin))
		{
			$query_sh300->fridayOnly($product->start_date);
		}
		
		$quotes_sh300 = $query_sh300->get();
		
		$chart_data['sh300'] = array();
		
		foreach($quotes_sh300 as $quote){
			$chart_data['sh300'][] = array(strtotime($quote->date) * 1000, round($quote->value, 2));
		}
		
		return View::make('product-quote/report', compact('product', 'quotes', 'chart_data'));
		
	}
	
	/**
	 * 将产品的净值和对应的对照指标导出一张Excel表格
	 * @param Product $product
	 */
	public function dump(Product $product)
	{
		$sheet_data = array();
		
		$query = $product->quotes()->dateAscending();
		
		if(!$this->user instanceof Consultant && (!$this->user || !$this->user->is_admin))
		{
			$query->fridayOnly($product->start_date);
		}
		
		$quotes = $query->get();
		
		$sh300 = Product::firstOrCreate(array('name'=>'沪深300指数'));
		$query_sh300 = $sh300->quotes()->where('date', '>=', $product->start_date)->dateAscending();
		$quotes_sh300 = $query_sh300->get();
		
		foreach($quotes as $quote)
		{
			$row = array('日期'=>$quote->date->format('Y/m/d'), '单位净值'=>$quote->value);
			
			$row['单位净值盈亏'] = $quote->value - 1;
			
			if(in_array($product->type, array('结构化', '伞型')))
			{
				$row['劣后净值'] = $quote->value_inferior;
				$row['劣后净值盈亏'] = $quote->value_inferior ? $quote->value_inferior - 1 : null;
			}
			
			$quote_300 = $quotes_sh300->filter(function($quote_300) use ($quote)
			{
				return $quote_300->date->eq($quote->date);
			})
			->first();
			
			if($quote_300)
			{
				$row['沪深300指数'] = $quote_300->value;
				$row['沪深300涨幅'] = ($row['沪深300指数'] - $quotes_sh300->first()->value) / $quotes_sh300->first()->value;
			}
			
			$sheet_data[] = $row;
		}
		
		Excel::create($product->name . '净值报表', function($excel) use ($sheet_data)
		{
			$excel->sheet('净值报表', function($sheet) use ($sheet_data)
			{
				$sheet->setColumnFormat(array(
					'A'=>'yyyy-mm-dd',
					'C'=>'0.00%',
					'E'=>'0.00%',
					'G'=>'0.00%'
				));
				
				$sheet->fromArray($sheet_data);
			});
		})
		->export();
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
		
		if(!$quote->date)
		{
			return;
		}
		
		if(Input::get('value'))
		{
			$quote->value_for_reference = false;
		}
		
		if(Input::get('value_inferior'))
		{
			$quote->value_inferior_for_reference = false;
		}
		
		if(Input::get('cap'))
		{
			$quote->cap_for_reference = false;
		}
		
		$quote->product()->associate($product);
		$quote->fillCapValue();
		
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
