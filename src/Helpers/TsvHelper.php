<?php 

namespace App\Fa\Helpers;

use Storage;
use App\Fa\Log\Flog;
use App\Fa\Helpers\FaHelper;
use App\Fa\Helpers\StrHelper;
use App\Fa\Helpers\StorageHelper;

class TsvHelper {

	public static function loadTsvFromFile($path, $hasHeader = true, $expColCnt = 0){
		$tbl = array();
		$path = StrHelper::contains($path, '/') ? $path : 'static/tsv/' . $path;
		$ctt = StorageHelper::get($path);
		$hdrs = "";
		// Flog::file($path, "path");
		// logd("ctt=" . strlen($ctt));
		if(!$ctt){
			logw("ctt is empty; path=$path");
		}

		$lines = preg_split("/\r\n|\n|\r/", $ctt);
		$i = 0;
		if($hasHeader){
			if(count($lines) < 2) return $tbl;
			$line = $lines[0];
			$hdrs = explode("\t", $line);
			$colCnt = count($hdrs);
			$i++;
			if($expColCnt != 0 && $expColCnt != $colCnt){
				return $tbl;
			}
		}
		
		for(; $i < count($lines); $i++){
			$line = $lines[$i];
			if(!$line) break;
			$strs = explode("\t", $line);
			$colCnt = count($strs);
			if($expColCnt == 0 || $expColCnt == $colCnt){
				if($hasHeader){
					$strs2 = array();
					foreach($strs as $j => $val){
						$strs2[$hdrs[$j]] = $val;
					}
					$tbl[] = $strs2;
					
				}else{
					$tbl[] = $strs;
				}
			}
		}

		return $tbl;
	}
}