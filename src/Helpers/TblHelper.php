<?php 

namespace App\Fa\Helpers;

// use App\Fa\Log\Flog;
use App\Fa\Helpers\FaHelper;
use App\Fa\Helpers\StrHelper;

class TblHelper {

	// TODO
	public static function append(&$tblItems1, $tblItems2, $extraCols = NULL, $rmCols = NULL){
		self::chgCols($tblItems2, $extraCols, $rmCols);
		// varDump($extraCols, 'extraCols');
		// varDump($rmCols, 'rmCols');
		// varDump($tblItems2, 'tblItems2');
		// varDump($rmCols, 'rmCols');
		// varDump($tblItems2, 'tblItems2');
		$tblItems1 = array_merge($tblItems1, $tblItems2);

		return $tblItems1;
	}

	public static function chgCols(&$tblItems, $extraCols = NULL, $rmCols = NULL){
		self::rmCols($tblItems, $rmCols);
		self::addCols($tblItems, $extraCols);
	}

	public static function addCols(&$tblItems, $extraCols = NULL){
		if($extraCols){
			foreach($tblItems as $i=>$data){
				if(is_array($data)){
					if(self::isTblItem($data)){
						self::addColsForTblData($tblItems[$i]['data'], $extraCols);

					}else{
						self::addCols($tblItems[$i], $extraCols);
					}
				}
			}
		}

		return $tblItems;
	}

	public static function rmCols(&$tblItems, $rmCols = []){
		if($rmCols){
			// logd('rmCols=' . count($rmCols));
			foreach($tblItems as $i=>$data){
				if(is_array($data)){
					if(self::isTblItem($data)){
						self::rmColsForTblData($tblItems[$i]['data'], $rmCols);

					}else{
						self::rmCols($tblItems[$i], $rmCols);
					}
				}

			}
		}

		return $tblItems;
	}

	public static function isTblItem($data){
		return isset($data['obj']) && $data['obj'] == 'TblItem';
	}

	public static function getTblItem($data, $extraCols = NULL, $newColName = 'cnt', $orgColName = 'cnt'){
		self::addColsForTblData($data, $extraCols);
		return array(
			'obj' => 'TblItem', 
			'data' => $data, 
			'newColName' => $newColName, 
			'orgColName' => $orgColName, 
		);
	}

	public static function render($tblItems){
		$map = array();
		foreach($tblItems as $i=>$tblItem){
			$data = $tblItem['data'];
			if(count($data)){
				$orgColName = $tblItem['orgColName'];
				$newColName = $tblItem['newColName'];
				// varDump($tblItem, 'render_tblItem');
				// varDump($data, 'render_data');

				self::addTblItemToMap($map, $data, $orgColName, $newColName);
			}
		}

		//// map to tbl
		// varDump($map, 'map');
		$tbl = FaHelper::mapToArray($map);
		// varDump($tbl, 'tbl');

		return $tbl;
	}

	//// Private ///////////////////////////////////////////////////////////////
	protected static function addColsForTblData(&$tblData, $extraCols){
		if(!count($tblData) || !count($extraCols)) return;

		if(FaHelper::is2dArr($tblData)){
			foreach($tblData as $i => $arr){
				foreach($extraCols as $key => $val){
					$tblData[$i][$key] = $val;
				}
			}

		}else{
			foreach($extraCols as $key => $val){
				$tblData[$key] = $val;
			}
		}
	}

	protected static function rmColsForTblData(&$tblData, $rmCols){
		if(!count($tblData) || !count($rmCols)) return;

		if(FaHelper::is2dArr($tblData)){
			foreach($rmCols as $i => $arr){
				foreach($rmCols as $key => $val){
					unset($tblData[$i][$val]);
				}
			}

		}else{
			foreach($rmCols as $key => $val){
				unset($tblData[$val]);
			}
		}
	}

	protected static function addTblItemToMap(&$map, $data, $orgColName, $newColName){
		// varDump($data, 'data');
		if(FaHelper::is2dArr($data)){
			foreach($data as $i=>$data2){
				self::addTblItemToMap($map, $data2, $orgColName, $newColName);
			}

		}else{
			$val = getFromArr($data, 0, $orgColName);
			$key = self::getKey($data, $orgColName);
			if(!isset($data[$orgColName])){
				// logd("key=$key, orgColName=$orgColName, newColName=$newColName");
				// varDump($data, 'data');
			}
			// logd("key=$key, orgColName=$orgColName, existCol=" . b2s(isset($map[$key])));
			if(isset($map[$key])){
				$map[$key][$newColName] = $val;

			}else{
				if($orgColName != $newColName){
					$data[$newColName] = $val;
					unset($data[$orgColName]);
				}
				$map[$key] = $data;
			}
		}

	}

	protected static function getKey($arr1, $exceptVal){
		$id = "";
		foreach($arr1 as $key=>$val){
			if($key != $exceptVal){
				$id .= "__" . $val;
			}
		}

		return $id;
	}

	// protected static function getKey($arr1, $arr2, $exceptVal){
	// 	$id = "";
	// 	foreach($arr1 as $key=>$val){
	// 		if($key != $exceptVal){
	// 			$id .= "__" . $val;
	// 		}
	// 	}
	// 	foreach($arr2 as $key=>$val){
	// 		if($key != $exceptVal){
	// 			$id .= "__" . $val;
	// 		}
	// 	}

	// 	return $id;
	// }
}