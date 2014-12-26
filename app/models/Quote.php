<?php

class Quote extends Eloquent {
	
	protected $fillable = array('date', 'value', 'cap', 'comments', 'data');
			
	function product()
	{
		return $this->belongsTo('Product');
	}
	
	function getDates() {
		$columns = parent::getDates();
		$columns[] = 'date';
		return $columns;
	}
	
	function scopeDateAscending($query)
	{
		return $query->orderBy('date', 'ASC');
	}
	
	function scopeDateDescending($query)
	{
		return $query->orderBy('date', 'DESC');
	}

}