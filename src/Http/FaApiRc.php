<?php
namespace Fa\Http;

class FaApiRc extends \Fa\Model\BasicEnum{
	// FA 0000 to 1999
	const SUCCESS = "0000";
	const ERROR = "1000";
	const FAIL = "1001";
	const INV_PARAM = "1002";
	const WRONG_URL = "1003";
	const UNK_ERROR = "9999";

	// public static function test($i = 0){
 //        // logd("i=$i, get_class=" . get_class() . ", get_called_class()=" . get_called_class());
	// 	if(self::$ioc && get_called_class() != self::$ioc && $i < 3){
	// 		return self::$ioc::test($i + 1);
	// 	}

 //        $constants = self::getConstants();
 //        return $constants;
	// }

    public static function getKey($val) {
    	// App\Fw\Http\FwApiRc
    	// return "";
        $faApiRc = resolve('Fa\Http\FaApiRc');
        return get_called_class() != get_class($faApiRc) ? $faApiRc::getKey($val) : parent::getKey($val);
    }
}