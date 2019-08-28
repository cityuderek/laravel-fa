<?php 

namespace Fa\Http;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Fa\Helpers\FaHelper;
use Fa\Helpers\StrHelper;

class ReqHelper {
	public static $data = array();

	public static function getAppName($defVal = "") {
		return self::getData('app_name', $defVal);
	}

	public static function getReqId($defVal = -1) {
		return self::getData('req_id', $defVal);
	}

	public static function getData($key, $defVal = NULL) {
		return getFromArr(self::$data, $defVal, $key);
	}

	public static function setData($key, $val) {
		self::$data[$key] = $val;
	}

	public static function queryStr(Request $request) {
		$url = $request->url();
		$fullUrl = $request->fullUrl();
		
		return substr($fullUrl, strlen($url) + 1);
	}

	public static function getCfCtry(Request $request) {
		$val = $request->header('cf-ipcountry');
		// val is null in localhost
		if (config('app.env') == 'local'){
			$val = "HK";
		}
		
		return $val;
	}

	public static function getCfCity(Request $request) {
		$val = $request->header('cf-ray');
		// val is null in localhost
		if (config('app.env') == 'local'){
			$val = "4d0feef119db3377-HKG";
		}

		if($val && strlen($val) > 3){
			return StrHelper::getRight($val, 3);
		}
		
		return "";
	}

	public static function isPathStartsWith(Request $request, $str) {
		$path = $request->path();
		return StrHelper::startsWith($path, $str);
	}

	public static function getHeaderArr(Request $request) {
		$arr1 = $request->headers->all();
		//varDump($arr1, "arr1");
		$arr = array();
		foreach($arr1 as $key => $arr2){
			//varDump($key, "key");
			$cnt = count($arr2);
			if($cnt == 1){
				$arr[$key] = $arr2[0];

			}else if($cnt == 0){
				$arr[$key] = NULL;

			}else{
				$arr[$key] = "MANY_VALUES; " . $arr2[0];
			}
		}

		return $arr;
	}
}