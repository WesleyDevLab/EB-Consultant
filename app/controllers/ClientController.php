<?php

class ClientController extends BaseController {
	
	protected $client;

	public function serveWeixin()
	{
		$weixin = new Weixin('client');
		if(Input::get('echostr')){
			$weixin->verify();
		}
	}
	
	public function updateMenu()
	{
		$weixin = new Weixin('client');
		$menu_config = ConfigModel::firstOrCreate(array('key' => 'wx_client_menu'));
		
		if(!$menu_config->value){
			$menu = $weixin->getMenu();
			$menu_config->value = json_encode($menu->menu, JSON_UNESCAPED_UNICODE);
			$menu_config->save();
			return $menu_config->value;
		}
		
		$menu = json_decode($menu_config->value);
		$weixin->removeMenu();
		$result = $weixin->createMenu($menu);
		return json_encode($result) . "\n" . json_encode($weixin->getMenu(), JSON_UNESCAPED_UNICODE);
	}
	
	/**
	 * 查看产品的净值报告图表
	 */
	public function viewReport()
	{
		
		if(!Session::get('weixin.open_id')){
			$weixin = new Weixin('client');
			$weixin->getOAuthInfo();
		}
		
		$user = User::where('open_id', Session::get('weixin.open_id'))->first();
		$user && $this->client = $user->loggable;
		
		$client = $this->client;
		
		if($this->client)
		{
			$product = $this->client->products()->first();
			$chartData = array();

			foreach($product->quotes()->dateAscending()->get() as $quote){
				$chartData[$product->id][] = array(strtotime($quote->date) * 1000, round($quote->value, 2));
				if($product->type === '结构化')
				{
					$chartData[$product->id . '_inferior'][] = array(strtotime($quote->date) * 1000, round($quote->value_inferior, 2));
				}
			}
			
			$latest_quote_date = $product->quotes()->dateDescending()->first()->date;
			
		}
		
		$sh300 = Product::where('name', '沪深300指数')->first();
		
		$quotes = $sh300 ? $sh300->quotes()->where('date', '>=', isset($product) ? $product->start_date : date('Y-m-d', strtotime('-180 days')))->where('date', '<=', isset($latest_quote_date) ? $latest_quote_date : date('Y-m-d'))->dateAscending()->get() : array();
		
		$chartData['sh300'] = array();
		foreach($quotes as $quote){
			$chartData['sh300'][] = array(strtotime($quote->date) * 1000, round($quote->value, 2));
		}
		
		$is_guest = false;
		
		return View::make('client/view-report', compact('product', 'client', 'chartData', 'is_guest'));
	}
	
}
