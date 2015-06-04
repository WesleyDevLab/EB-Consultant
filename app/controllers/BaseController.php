<?php

class BaseController extends Controller {

	protected $weixin;
	protected $user;

	function __construct()
	{
		// initialize weixin library
		switch(Input::server('HTTP_HOST'))
		{
			case Config::get('weixin.consultant.domain'):
				$this->weixin = new WeixinQY('consultant');
				break;
			
			case Config::get('weixin.client.domain'):
				$this->weixin = new Weixin('client');
				break;
			
			case Config::get('weixin.news.domain'):
				$this->weixin = new Weixin('news');
				break;
			
			default:
				throw new Exception('Input host name error.');
		}
		
		// user authentication
		if($this->weixin->account !== 'news' && strpos(Input::server('HTTP_USER_AGENT'), 'MicroMessenger') !== false)
		{
			
			if(Session::get('user_id'))
			{
				$this->user = User::find(Session::get('user_id'));
				if(!$this->user)
				{
					Session::flush();
				}
			}
			else
			{
				if(!Session::get('weixin.open_id'))
				{
					// write weixin.open_id to Session
					if($this->weixin->account === 'consultant')
					{
						$this->weixin->oauth_get_user_info();
					}
					elseif($this->weixin->account === 'client')
					{
						$this->weixin->getOAuthInfo();
					}
				}
				
				$this->user = User::where('open_id', Session::get('weixin.open_id'))->first();

				if($this->user)
				{
					Session::set('user_id', $this->user->id);
				}
				elseif($this->weixin->account === 'consultant' && !in_array(Route::currentRouteName(), array('consultant.create', 'consultant.store')))
				{
					header('Location: ' . url('consultant/create'));
					exit;
				}
			}
		}
		
		$administrators = json_decode(ConfigModel::where('key', 'administrators')->first()->value);
		
		if($this->user)
		{
			$this->user->is_admin = in_array($this->user->open_id, $administrators);
		}
		
		View::share('weixin', $this->weixin);
		View::share('user', $this->user);
	}


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
