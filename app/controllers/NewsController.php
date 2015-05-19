<?php

class NewsController extends BaseController {
	
	public function serveWeixin()
	{
		$weixin = new Weixin('news');
		if(Input::get('echostr')){
			$weixin->verify();
		}
	}
	
	/**
	 * 查看投顾列表
	 */
	public function viewConsultant($consultant = null)
	{
		if(is_null($consultant))
		{
			$consultants = Consultant::all();
			return View::make('consultant/list', compact('consultants'));
		}
		else
		{
			return View::make('consultant/signup', compact('consultant'));
		}
	}

	/**
	 * 查看一个私募的产品列表或所有产品
	 */
	public function viewProduct($consultant = null)
	{
		$query = Product::query();
		
		if(isset($consultant))
		{
			$query->where('consultant_id', $consultant->id);
		}
		
		$products = $query->get();
		
		return View::make('product/list', compact('products'));
	}
	
	/**
	 * 查看产品的净值报告图表
	 */
	public function viewReport($product)
	{
		
		$is_guest = true;
		
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
		
		return View::make('client/view-report', compact('product', 'chartData', 'consultant', 'is_guest'));
	}
	
}