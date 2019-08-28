<?php 

namespace App\Fa\database;

use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FaDBReportHelper extends DBHelper{

	protected static function getDataArrAvg($arr, $n) {
		// varDump($arr, 'arr');
		foreach($arr as $i => $data){
			$avg = $arr[$i]['cnt'] / $n;
			if($avg >= 10){
				$avg = round($avg, 0);
				
			}else{
				$avg = round($avg, 1);
			}
			$arr[$i]['cnt'] = $avg;
		}
		return $arr;
	}

	protected static function addRowsToTbl(&$tbl, $groups, $cellName, $rows) {
		if(is_object($rows)){
			$rows = self::rowsToArray($rows);
		}

		foreach($rows as $key => $row){
			self::addRowToTbl($tbl, $groups, $cellName, $row);
		}
	}

	protected static function addRowToTbl(&$tbl, $groups, $cellName, $row) {
		// varDump($groups, 'groups');
		// varDump($row, 'row');

		$rowKey = "";
		foreach($groups as $key => $value){
			$rowKey .= "__{$key}_{$value}";
		}
		foreach($row as $key => $value){
			if($key != 'cnt'){
				$rowKey .= "__{$key}_{$value}";
			}
		}

		if(!isset($tbl[$rowKey])){
			$tbl[$rowKey] = array_merge($groups, $row);
			unset($tbl[$rowKey]['cnt']);
		}
		$tbl[$rowKey][$cellName] = $row['cnt'];

		return $tbl;
	}

	protected static function addCntToTbl(&$tbl, $groups, $cellName, $cnt) {
		// varDump($groups, 'groups');
		// varDump($row, 'row');

		$rowKey = "";
		foreach($groups as $key => $value){
			$rowKey .= "__{$key}_{$value}";
		}

		if(!isset($tbl[$rowKey])){
			$tbl[$rowKey] = $groups;
		}
		$tbl[$rowKey][$cellName] = $cnt;

		return $tbl;
	}

	protected static function toTbl($tbl) {
		$rows = [];
		$valKeys = [];
	//	logd('tbl=' . count($tbl));
		// varDump($tbl, 'tbl');
		foreach($tbl as $key => $val){
			$valKeys[] = $key;
		}
		// varDump($valKeys, 'valKeys');
		$cells = [];
		foreach($tbl as $valKey => $group){
			foreach($group as $i => $cell){
				$cellKey = "";
				foreach($cell as $key => $val){
					if($key != 'cnt'){
						$cellKey .= '__' . $key;
					}
				}
				$cell['tmpCellKey'] = $cellKey;
				$cell['tmpValKey'] = $valKey;
				$cells[] = $cell;
			}
		}
		// varDump($cells, 'cells');

		$newTbl = [];
		foreach($cells as $i => $cell){
			$cellKey = $cell['tmpCellKey'];
			$valKey = $cell['tmpValKey'];
			unset($cell['tmpCellKey']);
			unset($cell['tmpValKey']);

			if(!isset($newTbl[$cellKey])){
				$newTbl[$cellKey] = $cell;
				unset($newTbl[$cellKey]['cnt']);
			}
			//$newTbl[$cellKey][$valKey] = $cell['cnt'];
		}

		return $newTbl;

	}
}