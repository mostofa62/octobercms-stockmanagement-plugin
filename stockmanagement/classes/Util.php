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


	public static function item_unit($index=null){
		$data= [			
			1=>'pcs(pieces)', //PIECES
			//weight
			2=>'oz(ounces)',
			3=>'g(grams)',//Grams
			4=>'kg(kilogram)', //KiloGram
			5=>'lb(pound)', //POUND
			6=>'T(ton)', //TON
			//lenght
			7=>'m(meter)',//METER
			8=>'cm(centimeter)', //Centimeter
			9=>'in(inches)',//INCH
			10=>'ft(feet)',
			11=>'yd(yard)',
			//liquid
			12=>'mL(milliliters)',
			13=>'L(liter)',
			14=>'gal(gallon)',
			//extra
			15=>'pt(pint)',
			16=>'qt(quart)',
			//big
			17=>'pack',
			18=>'bundle',
			19=>'roll',

		];
		return isset($index)?$data[$index]:$data;
	}

	
}