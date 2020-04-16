<?php namespace Arkylus\Stockmanagement\Classes;


class Util
{
	
	public static function op_type($index=null){
		
		$data= [
			1=>'arkylus.stockmanagement::lang.util.op_in',
			2=>'arkylus.stockmanagement::lang.util.op_out',
		];
		return isset($index)?$data[$index]:$data;		
	}

	
}