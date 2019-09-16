<?php 
namespace Fa\Helpers;

use Session;
use Auth;
// use Carbon\Carbon;

class FaHelper {
	public static function test() {
		$arr = array();
		
		return $arr;
		// return true;
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

	//// Session
	public static function getSessionData($key, $defVal = NULL) {
		return Session::get($key, $defVal);
	}

	public static function setSessionData($key, $value) {
		Session::put($key, $value);
	}

	//// Request
	public static function getReqData($key, $defVal = NULL) {
		return ReqHelper::getData($key, $defVal);
	}

	public static function setReqData($key, $value) {
		ReqHelper::setData($key, $value);
	}

	//// User
	public static function getCurrUserName() {
		return Auth::user()->name;
	}
}