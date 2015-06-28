<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{	
//		$files = File::files(storage_path('imports/义珊'));
//		
//		foreach($files as $file)
//		{
//			$data = new PHPExcelReader\SpreadsheetReader($file);
//
//			if(strpos($data->val(3, 'A'), '日期'))
//			{
//				$date = $data->val(3, 'A');
//			}
//			elseif(strpos($data->val(3, 'B'), '日期'))
//			{
//				$date = $data->val(3, 'B');
//			}
//			else
//			{
//				$date = 'N/A';
//			}
//			
//			if(strpos($data->val(3, 'L'), '净值'))
//			{
//				$value = $data->val(3, 'L');
//			}
//			elseif(strpos($data->val(3, 'M'), '净值'))
//			{
//				$value = $data->val(3, 'M');
//			}
//			elseif(strpos($data->val(3, 'H'), '净值'))
//			{
//				$value = $data->val(3, 'H');
//			}
//			else
//			{
//				$value = 'N/A';
//			}
//			
////			echo $date . "\t" . $value . "\n";
//			
//			$date = explode('：', $date)[1];
//			$value = explode('：', $value)[1];
//			
//			$quote = new Quote();
//			
//			$quote->fill(array(
//				'date'=>$date,
//				'value'=>$value
//			));
//			
//			$product = Product::find(5);
//			
//			$quote->product()->associate($product);
//			
//			$quote->save();
//			
//		}
		
		return View::make('hello');
	}

}
