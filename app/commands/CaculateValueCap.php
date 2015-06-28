<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CaculateValueCap extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'caculate:value-cap';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Caculate product history value or cap if not valid according to their cap or value.';

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
		if($this->option('product') === 'all')
		{
			$products = Product::where('type', '!=', '参考指标')->get();
		}
		else
		{
			$products = Product::where('name', $this->option('product-name'))->get();
		}
		
		if(empty($products))
		{
			$this->error('Product ' . $this->option('product') . ' not found.');
			return;
		}
		
		foreach($products as $product)
		{
			foreach($product->quotes as $quote)
			{
				$quote->fillCapValue();
				$quote->save();
			}
			
			$this->info($product->name . ' 处理完成');
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			
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
			array('product', 'p', InputOption::VALUE_REQUIRED, 'Product name.', null),
		);
	}

}
