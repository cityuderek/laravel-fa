<?php
namespace App\Fa\Http;

class FaApiRc extends \App\Fa\Model\BasicEnum{
	// FA 0000 to 1999
	const SUCCESS = "0000";
	const ERROR = "1000";
	const FAIL = "1001";
	const INV_PARAM = "1002";
	const WRONG_URL = "1003";
	const UNK_ERROR = "9999";

	public static $ioc = NULL;

	// public static function test($i = 0){
 //        // logd("i=$i, get_class=" . get_class() . ", get_called_class()=" . get_called_class());
	// 	if(self::$ioc && get_called_class() != self::$ioc && $i < 3){
	// 		return self::$ioc::test($i + 1);
	// 	}

 //        $constants = self::getConstants();
 //        return $constants;
	// }

    public static function getKey($val) {
    	// logd("get_called_class=" . get_called_class());
		return self::$ioc && get_called_class() != self::$ioc ? self::$ioc::getKey($val) : parent::getKey($val);
    }

    public static function getKeyIoc($val) {
    	// logd("get_called_class=" . get_called_class());
		return self::$ioc ? self::$ioc::getKey($val) : parent::getKey($val);
    }
}