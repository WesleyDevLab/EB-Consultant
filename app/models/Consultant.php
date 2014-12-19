<?php

class Consultant extends Eloquent {
	
	protected $fillable = array('name', 'description', 'open_id');
			
	function clients()
	{
		return $this->belongsToMany('Client');
	}
	
	function products()
	{
		return $this->hasMany('Product');
	}
	
}