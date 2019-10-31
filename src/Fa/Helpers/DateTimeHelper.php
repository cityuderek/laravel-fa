<?php 

namespace Fa\Helpers;

class DateTimeHelper {

	public static function nowPeriodTs($interval){
		return self::roundByPeriod(time(), $interval);
	}

	public static function nowPeriodStr($interval){
		$period = self::roundByPeriod(time(), $interval);
		return self::tsToDateTimeString($period);
	}

	public static function roundByPeriod($ts, $interval) {
        return $ts - ($ts % $interval);
	}
	
	public static function tsToDateTimeString($ts, $format = "Y-m-d H:i:s") {
        return date("Y-m-d H:i:s", $ts);
	}

	public static function tsDetailString($ts, $format = "Y-m-d H:i:s") {
        return $ts . "(" . date("Y-m-d H:i:s", $ts) . ")";
	}
}