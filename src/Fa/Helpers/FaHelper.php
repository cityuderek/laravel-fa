<?php 
namespace Fa\Helpers;

class FaHelper {
	//// System
	public static function isProd(){
		$env = config("app.env");

		return $env == "prod" || $env == "production";
	}

	public static function isUat(){
		return config("app.env") == "uat" ;
	}

	public static function isDebug(){
		return config("app.env") == "debug" ;
	}

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