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
	
	function getCost($date = null)
	{
		$days_passed = $this->start_date->diffInDays($date);
		
		$cost = 0.00;
		
		if($this->type === '伞型'){
			$cost = $this->initial_cap / ($this->meta->杠杆配比 + 1) * $this->meta->杠杆配比 * ($this->meta->银行托管费率 + $this->meta->信托通道费率 + $this->meta->优先资金成本) / 100 * ($days_passed + 1) / 365;
		}
		
		return round($cost, 2);
	}
	
	function getMetaAttribute($value)
	{
		return json_decode($value);
	}
	
	function setMetaAttribute($value)
	{
		$this->attributes['meta'] = json_encode($value, JSON_UNESCAPED_UNICODE);
	}
	
}