<?php

class Product extends Eloquent {
	
	protected $fillable = array('name', 'type', 'meta', 'initial_cap', 'start_date');
			
	function getDates() {
		$columns = parent::getDates();
		$columns[] = 'start_date';
		return $columns;
	}
	
	function clients()
	{
		return $this->belongsToMany('Client');
	}
	
	function consultant()
	{
		return $this->belongsTo('Consultant');
	}
	
	function quotes()
	{
		return $this->hasMany('Quote');
	}
	
	function getCost()
	{
		$meta = json_decode($this->meta);
		
		$days_passed = $this->start_date->diffInDays();
		
		$cost = 0.00;
		
		if($this->type === '伞型'){
			$cost = $this->initial_cap / ($meta->杠杆配比 + 1) * $meta->杠杆配比 * ($meta->银行托管费率 + $meta->信托通道费率 + $meta->优先资金成本) / 100 * ($days_passed + 1) / 365;
		}
		
		return round($cost, 2);
	}
	
}