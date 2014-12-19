<?php

class Client extends Eloquent {
	
	protected $fillable = array('name', 'comments', 'open_id');
			
	function consultants()
	{
		return $this->belongsToMany('Consultant');
	}
	
	function products(){
		return $this->belongsToMany('Product');
	}
	
}
