<?php 

namespace Fa\database;

use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Fa\database\DBHelper;
// use Fa\Helpers\FaHelper;
// use Fa\Helpers\DateTimeHelper;
// use Fa\Helpers\StrHelper;

class DBHelper {

	public static function addSelectRaw($q, $rawSql){
		$q->addSelect(DB::raw($rawSql));
	}

	public static function map_array($map) {
		$arr = [];
		foreach($map as $key => $value){
			$arr[] = $value;
		}

		return $arr;
	}

	public static function rowsToArray($rows) {
		return collect($rows)->map(function($x){ return (array) $x; })->toArray();
	}

	public static function sum($objs, $fieldName = 'cnt') {
		$sum = 0;

		$rows = collect($objs)->map(function($x){ return (array) $x; })->toArray(); 
		foreach($rows as $i => $row){
			$sum += getFromArr($row, 0, $fieldName);
		}

		return $sum;
	}

	public static function sltNWhere(&$q, $fieldName, $val){
		if($val){
			$q->addSelect($fieldName);
			if($val !== true){
				$q->where($fieldName, $val);
			}
		}
	}

	public static function sltNWhereNGroupBy(&$q, $fieldName, $val){
		if($val){
			$q
				->addSelect($fieldName)
				->groupBy($fieldName);
			if($val !== true){
				$q->where($fieldName, $val);
			}
		}
	}

	public static function sltNGroupBy(&$q, $fieldName){
		$q
			->addSelect($fieldName)
			->groupBy($fieldName);
	}

	// public static function sltNWhere(&$q, &$fields, $fieldName, $val){
	// 	if($val){
	// 		$fields[] = $fieldName;
	// 		if($val !== true){
	// 			$q->where($fieldName, $val);
	// 		}
	// 	}
	// }

	// public static function sltNGroupBy(&$q, &$fields, $fieldName){
	// 	$fields[] = $fieldName;
	// 	$q->groupBy($fieldName);
	// }

	public static function whereToday(&$q, $field){
		$q->whereDate($field, Carbon::today()->toDateString());
	}

	public static function whereDateCond(&$q, $field, $startDayOffset, $days){
		$q
			->whereDate($field, '>', Carbon::today()->addDays(-($startDayOffset + $days))->toDateString())
			->whereDate($field, '<=', Carbon::today()->addDays(-$startDayOffset)->toDateString());
	}

	public static function groupBys(&$q, $arr){
		foreach($arr as $i => $val){
			$q->groupBy($val);
		}
	}

	public static function subquery($q, $alias = 't1') {
		return DB::table( DB::raw("({$q->toSql()}) $alias") )
		    ->mergeBindings($q);
	}
}