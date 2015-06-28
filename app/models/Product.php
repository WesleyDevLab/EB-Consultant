<?php

class Product extends Eloquent {
	
	protected $fillable = array('name', 'type', 'meta', 'initial_cap', 'start_date');
	
	public function getDates() {
		$columns = parent::getDates();
		$columns[] = 'start_date';
		return $columns;
	}
	
	public function clients()
	{
		return $this->belongsToMany('Client');
	}
	
	public function consultant()
	{
		return $this->belongsTo('Consultant');
	}
	
	public function quotes()
	{
		return $this->hasMany('Quote');
	}
	
	public function getCost($date = null)
	{
		$days_passed = $this->start_date->diffInDays($date);
		
		$annual_cost = 0.00;
		
		if(isset($this->meta->杠杆配比))
		{
			// 优先资金
			$initial_cap_preferred = $this->initial_cap / ($this->meta->杠杆配比 + 1) * $this->meta->杠杆配比;
		}
		
		if($this->type === '管理型')
		{
			$annual_cost = $this->initial_cap * ($this->meta->基金管理费 + $this->meta->投顾管理费 + $this->meta->托管费) / 100;
		}
		
		elseif($this->type === '伞型'){
			$annual_cost = $initial_cap_preferred * ($this->meta->银行托管费率 + $this->meta->信托通道费率 + $this->meta->优先资金成本) / 100;
		}
		
		elseif($this->type === '结构化'){
			$annual_cost = $initial_cap_preferred * $this->meta->优先资金成本 / 100
					+ $this->initial_cap * ($this->meta->产品管理费 + $this->meta->投顾管理费 + $this->meta->托管费) / 100;
		}
		
		return round($annual_cost * $days_passed / 365, 2);
	}
	
	public function getMetaAttribute($value)
	{
		return json_decode($value);
	}
	
	public function setMetaAttribute($value)
	{
		$this->attributes['meta'] = json_encode($value, JSON_UNESCAPED_UNICODE);
	}
	
	public function getCategoryAttribute($category = null)
	{
		if(!is_null($category))
		{
			return $category;
		}
		
		return in_array($this->type, array('管理型', '结构化')) ? 'product' : 'account';
	}
	
	public function scopeOfCategory($query, $category = null)
	{
		return $query->whereIn('type', $category === 'product' ? array('管理型', '结构化') : array('单账户', '伞型'));
	}
	
}