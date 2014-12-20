<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateSH500Quote extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'update:sh300';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '更新沪深300指数';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$result = file_get_contents('http://hq.sinajs.cn/list=sh000300');
		
		$matches = null;
		preg_match('/"(.*)"/', $result, $matches);
		
		$data = explode(',', $matches[0]);
		
		$mapped = array(
			'lastClose'=>$data[1],
			'open'=>$data[2],
			'new'=>$data[3],
			'high'=>$data[4],
			'low'=>$data[5],
			'vol'=>$data[8],
			'amount'=>$data[9],
			'date'=>$data[30],
			'time'=>$data[31]
		);
		
		$sh300 = Product::firstOrCreate(array('name'=>'沪深300指数', 'type'=>'参考指标'));
		
		$quote = new Quote();
		$quote->value = $mapped['new'];
		$quote->data = json_encode($mapped);
		$quote->date = $mapped['date'];
		$quote->product()->associate($sh300);
		$quote->save();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
//			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
//			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
