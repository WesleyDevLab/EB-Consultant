<?php

class WeixinController extends BaseController {
	
	public function serveGuest()
	{
		if(Input::get('echostr')){
			$this->weixin->verify();
		}
	}
	
	public function serveClient()
	{
		if(Input::get('echostr')){
			$this->weixin->verify();
		}
	}
	
	public function serveConsultant()
	{
		if(Input::get('echostr')){
			$this->weixin->verify();
		}
	}
	
	public function updateClientMenu()
	{
		$menu_config = ConfigModel::firstOrCreate(array('key' => 'wx_client_menu'));
		
		if(!$menu_config->value){
			$menu = $this->weixin->getMenu();
			$menu_config->value = json_encode($menu->menu, JSON_UNESCAPED_UNICODE);
			$menu_config->save();
			return $menu_config->value;
		}
		
		$menu = json_decode($menu_config->value);
		$this->weixin->removeMenu();
		$result = $this->weixin->createMenu($menu);
		return json_encode($result) . "\n" . json_encode($this->weixin->getMenu(), JSON_UNESCAPED_UNICODE);
	}
	
}