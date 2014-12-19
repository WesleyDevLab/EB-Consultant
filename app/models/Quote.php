<?php

class Quote extends Eloquent {
	
	protected $fillable = array('date', 'value', 'comments');
			
	function product()
	{
		return $this->belongsTo('Product');
	}
	
	function getDates() {
		$columns = parent::getDates();
		$columns[] = 'date';
		return $columns;
	}
	
}