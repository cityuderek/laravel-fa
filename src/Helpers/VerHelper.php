<?php 

namespace Fa\Helpers;

class VerHelper {
	public static function toVerNum($ver) {
		$ver = preg_replace('/^([0-9][0-9]?\.[0-9][0-9]?\.[0-9][0-9]?).*/', "$1", $ver);
		$strs = explode('.',$ver);
		if(count($strs) == 3){
			return $strs[0] * 10000 + $strs[1] * 100 + $strs[2];
		}

	    return 0;
	}

	public static function isUpdateRequired($tarVer, $ver) {
		$tarVerNum = self::toVerNum($tarVer);
		$verNum = self::toVerNum($ver);
		logd("tarVerNum=$tarVerNum, verNum=$verNum");

	    return $tarVerNum > $verNum;
	}
}