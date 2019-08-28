<?php 

namespace App\Fa\Helpers;
/*
use App\Fa\Helpers\StrHelper;
*/

class StrHelper {
	public static function test() {
		$arr = array();
		$str = "aabbccddeeff";
		$str2 = "aabbccddeeffaabbccddeeffaabbccddeeff";
		$arr['str'] = $str;
		$arr['getLeftByKey_def_f'] = StrHelper::getLeftByKey($str, "b");
		$arr['getLeftByKey_def_r'] = StrHelper::getLeftByKey($str, "b", true, true);
		$arr['getLeftByKey_defF_r'] = StrHelper::getLeftByKey($str, "bbb", false);
		$arr['getRightByKey_def_f'] = StrHelper::getRightByKey($str, "b");
		$arr['getRightByKey_def_r'] = StrHelper::getRightByKey($str, "b", true, true);
		$arr['getRight_2'] = StrHelper::getRight("abcdef", 2);
		$arr['getRight_M2'] = StrHelper::getRight("abcdef", -2);
		$arr['getLeft_2'] = StrHelper::getLeft("abcdef", 2);
		$arr['getLeft_M2'] = StrHelper::getLeft("abcdef", -2);
		$arr['getRight_20'] = StrHelper::getRight("abcdef", 20);
		$arr['getRight_M20'] = StrHelper::getRight("abcdef", -20);
		$arr['getLeft_20'] = StrHelper::getLeft("abcdef", 20);
		$arr['getLeft_M20'] = StrHelper::getLeft("abcdef", -20);
		$arr['smry_short'] = StrHelper::smry($str, "smry_short");
		$arr['smry_long'] = StrHelper::smry($str2, "smry_long");
		$arr['limitLen1_5'] = StrHelper::limitLen($str2, 5);
		$arr['limitLen2_0'] = StrHelper::limitLen(NULL, 5);
		$arr['limitLen3_3'] = StrHelper::limitLen("abc", 5);

		// return $arr;
		return true;
	}

	public static function append($str1, $str2, $delimiter = ', ') {
		if(!$str2) return $str1;
		if(!$str1) return $str2;

		return $str1 . $delimiter . $str2;
	}

	public static function smry($str, $title = "str", $maxLen = 20) {
		if($str === NULL){
			return $title . "(null)";
		}
		if(!$str){
			return $title . "(0)";
		}

		$len = strlen($str);
		if($len > $maxLen){
			$short = substr($str, 0, $maxLen) . "...";

		}else{
			$short = $str;
		}

		return $title . "($len): $short";
	}

	public static function getLeft($str, $len) {
		if($len < 0){
			$i = strlen($str) + $len;
			if($i > 0){
		    	return substr($str, 0, strlen($str) + $len);
		    }
		    return "";
		}

	    return substr($str, 0, $len);
	}

	public static function getRight($str, $len) {
		if($len < 0){
			$i = strlen($str) + $len;
			if($i > 0){
	    		return substr($str, $len);
		    }
		    return "";
		}

	    // return substr($str, strlen($str) - $len);
	    return substr($str, -$len);
	}

	public static function getMidByKey($str, $key1, $key2, $isDefOrg = true) {
		$i = strrpos($str, $key1);
		if($i === false){
			return $isDefOrg ? $str : "";
		}
		$i += strlen($key1);
		$j = strrpos($str, $key2, $i);
		if($j === false){
			return $isDefOrg ? $str : "";
		}

	    return substr($str, $i, $j - $i);
	}

	public static function getLeftByKey($str, $key, $isDefOrg = true, $isReverse = false) {

		$i = $isReverse ? strrpos($str, $key) : strpos($str, $key);
		if($i === false){
			return $isDefOrg ? $str : "";
		}

	    return substr($str, 0, $i);
	}

	public static function getRightByKey($str, $key, $isDefOrg = true, $isReverse = false) {

		$i = $isReverse ? strrpos($str, $key) : strpos($str, $key);
		if($i === false){
			return $isDefOrg ? $str : "";
		}

	    return substr($str, $i + strlen($key));
	}

	public static function keep(
		$str, 
		$isUpper = true, 
		$isLower = true, 
		$isNumberic = true, 
		$isSpace = false, 
		$isHyphen = false, 
		$isUnderscore = false) {
	   // $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		$patt = '';
		if($isUpper){
			$patt .= 'A-Z';
		}
		if($isLower){
			$patt .= 'a-z';
		}
		if($isNumberic){
			$patt .= '0-9';
		}
		if($isHyphen){
			$patt .= '\-';
		}
		if($isSpace){
			$patt .= ' ';
		}
		if($isUnderscore){
			$patt .= '_';
		}

	   return preg_replace('/[^' . $patt . ']/', '', $str);
	}

	//// replace
	static function filterNewLine($str){
		return str_replace("\n", "", str_replace("\r\n", "", $str));
	}

	////
	public static function generateRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
	}

	public static function avoidNull($str){
		return $str ? $str : "";
	}

	public static function contains($haystack, $needle){
		return strpos($haystack, $needle) !== false;
	}

	public static function notContains($haystack, $needle){
		return strpos($haystack, $needle) === false;
	}

	public static function startsWith($haystack, $needle)
	{
	     $length = strlen($needle);
	     return (substr($haystack, 0, $length) === $needle);
	}

	public static function limitLen($str, $n)
	{
	     return substr($str, 0, $n);
	}

	public static function endsWith($haystack, $needle)
	{
	    $length = strlen($needle);
	    if ($length == 0) {
	        return true;
	    }

	    return (substr($haystack, -$length) === $needle);
	}
}