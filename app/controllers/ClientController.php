<?php

class ClientController extends BaseController {
	
	protected $client;

	public function serveWeixin()
	{
		
	}
	
	public function viewReport(Client $client = null)
	{
//		if(!is_null($client))
//		{
//			$this->client = $client;
//		}
		
		$products = $this->client->products;
		$chartData = array();
		
		foreach($products as $product){
			foreach($product->quotes as $quote){
				$chartData[$product->id][] = array(strtotime($quote->date) * 1000, round($quote->value, 2));
			}
		}
		
		return View::make('client/view-report', compact('products', 'chartData'));
	}
	
}
