<?php

class Product extends Eloquent {
	
	protected $fillable = array('name', 'type', 'metas');
			
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
	
}