<?php

class ClientController extends BaseController {
	
	protected $client;

	public function serveWeixin()
	{
		$weixin = new Weixin();
		if(Input::get('echostr')){
			$weixin->verify();
		}
	}
	
	public function updateMenu()
	{
		$weixin = new Weixin();
		$menu_config = ConfigModel::firstOrCreate(array('key' => 'wx_client_menu'));
		
		if(!$menu_config->value){
			$menu = $weixin->get_menu();
			$menu_config->value = json_encode($menu, JSON_UNESCAPED_UNICODE);
			$menu_config->save();
			return $menu_config->value;
		}
		
		$menu = json_decode($menu_config->value);
		$weixin->remove_menu();
		$result = $weixin->create_menu($menu);
		return json_encode($result) . "\n" . json_encode($weixin->get_menu(), JSON_UNESCAPED_UNICODE);
	}
	
	public function viewReport()
	{
		$this->client = Client::where('open_id', Input::get('hash'))->first();
		
		if(!$this->client){
			return 'error: client not existed';
		}
		
		$product = $this->client->products()->first();
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
