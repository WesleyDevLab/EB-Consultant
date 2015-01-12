<?php

class Consultant extends Eloquent {
	
	protected $fillable = array('name', 'type', 'meta', 'open_id');
			
	function clients()
	{
		return $this->belongsToMany('Client');
	}
	
	function products()
	{
		return $this->hasMany('Product');
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