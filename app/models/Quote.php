<?php

class Quote extends Eloquent {
	
	protected $fillable = array('date', 'value', 'value_inferior', 'cap', 'comments', 'data', 'value_for_reference', 'value_inferior_for_reference', 'cap_for_reference', 'divended', 'value_total');
	
	public function product()
	{
		return $this->belongsTo('Product');
	}
	
	public function getDates()
	{
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

	/**
	 * 
	 * Fill capital or net value by each other,
	 * caculate inferior net value for some products and accounts,
	 * and caculate total value for accounts that have been dividended
	 */
	public function fillCapValue()
	{
		$product = $this->product;
		
		// cap is reliable
		if($this->cap && !$this->cap_for_reference && !$this->value)
		{
			$this->value = $this->cap / $product->initial_cap;
			$this->value_for_reference = true;
		}
		
		// value is reliable
		if($this->value && !$this->value_for_reference && !$this->cap)
		{
			$this->cap = $product->initial_cap * $this->value;
			$this->cap_for_reference = true;
		}
		
		// inferior value required
		if(in_array($product->type, array('伞型', '结构化')) && (!$this->value_inferior || $this->value_inferior_for_reference))
		{
			if(empty($product->meta->劣后资金规模) || empty($product->meta->杠杆配比))
			{
				return $this;
			}
			
			$cap_inferior = $product->meta->劣后资金规模;
			$cap_preferred = $product->meta->劣后资金规模 * $product->meta->杠杆配比;
			$this->value_inferior = ($this->cap - $cap_preferred - $product->getCost($this->date)) / $cap_inferior;
			$this->value_inferior_for_reference = true;
		}
		
		$total_dividend = $product->quotes()->where('date', '<', $this->date)->get()->reduce(function($total_dividend, $quote)
		{
			return $quote->dividend ? $total_dividend + $quote->dividend : $total_dividend;
		}
		, 0);
		
		$total_dividend += $this->dividend;
		
		$this->value_total = ($this->cap + $total_dividend) / $product->initial_cap;
		
		return $this;
	}
	
}