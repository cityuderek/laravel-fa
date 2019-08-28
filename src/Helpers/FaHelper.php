<?php 
namespace App\Fa\Helpers;

class FaHelper {

	//// Array
	public static function is2dArr($obj){
		return is_array($obj) && count($obj) != count($obj, 1);
	}


	//// Map
	public static function mapToArray($map) {
		$arr = [];
		foreach($map as $key => $value){
			$arr[] = $value;
		}

		return $arr;
		// return collect($map)->map(function($x){ return (array) $x; })->toArray();
	}
}