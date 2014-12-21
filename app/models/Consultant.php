<?php

class Consultant extends Eloquent {
	
	protected $fillable = array('name', 'meta', 'open_id');
			
	function clients()
	{
		return $this->belongsToMany('Client');
	}
	
	function products()
	{
		return $this->hasMany('Product');
	}
	
}