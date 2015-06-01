<?php

class Quote extends Eloquent {
	
	protected $fillable = array('date', 'value', 'value_inferior', 'cap', 'comments', 'data');
			
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
	
	function scopeFridayOnly($query)
	{
		return $query->whereRaw('DAYOFWEEK(`date`) = 6');
	}
	
	function scopeDateDescending($query)
	{
		return $query->orderBy('date', 'DESC');
	}

}