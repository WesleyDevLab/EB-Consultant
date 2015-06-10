<?php

class Quote extends Eloquent {
	
	protected $fillable = array('date', 'value', 'value_inferior', 'cap', 'comments', 'data');
			
	public function product()
	{
		return $this->belongsTo('Product');
	}
	
	public function getDates() {
		$columns = parent::getDates();
		$columns[] = 'date';
		return $columns;
	}
	
	public function scopeDateAscending($query)
	{
		return $query->orderBy('date', 'ASC');
	}
	
	public function scopeFridayOnly($query)
	{
		return $query->whereRaw('DAYOFWEEK(`date`) = 6');
	}
	
	public function scopeDateDescending($query)
	{
		return $query->orderBy('date', 'DESC');
	}

}