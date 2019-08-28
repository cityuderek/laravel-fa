<?php
namespace Fa\Log;

use Storage;

defined('LOG_FILE_NAME') or define('LOG_FILE_NAME', '../storage/logs/laravel.log');

class Flog {

	public static function test(){
		self::str("aaa");
		self::str(null, "nnn");
		self::str("", "eee");
		self::str("bbb", "title");
		self::strSmry("aaa");
		self::strSmry(null, "nnn");
		self::strSmry("", "eee");
		self::strSmry("bbb", "title");
		self::strSmry("aaadfdsfasdfasdfasdfsadfasdf", "title");

		$path = 'app/tsv/crsVids.tsv';
		self::file($path);
		self::file($path, 'crsVids');
		self::file("", 'eee');
	}

	public static function str(){
    	$args = func_get_args();
    	$cnt = count($args);
		if($cnt == 0){
			self::d(1, "Invalid param cnt; cnt=$cnt");
		}

		$str = NULL;
		$title = "str";
		if($cnt == 1){
			$str = $args[0];

		}else{
			$str = $args[0];
			$title = $args[1];
		}

		if($str == NULL){
			self::d(1, $title . " is null");

		}else{
			self::d(1, $title . "(" . strlen($str) . ")=" . $str);
		}
	}

	public static function strSmry(){
    	$args = func_get_args();
    	$cnt = count($args);
		if($cnt == 0){
			self::d(1, "Invalid param cnt; cnt=$cnt");
		}

		$str = NULL;
		$title = "str";
		if($cnt == 1){
			$str = $args[0];

		}else{
			$str = $args[0];
			$title = $args[1];
		}

		if($str == NULL){
			self::d(1, $title . " is null");

		}else{
			$len = strlen($str);
			$smry = $len > 20 ? substr($str, 0, 20) . "..." : $str;
			self::d(1, $title . "(" . $len . ")=" . $smry);
		}
	}

	public static function file(){
    	$args = func_get_args();
    	$cnt = count($args);
		if($cnt == 0){
			self::d(1, "Invalid param cnt; cnt=$cnt");
		}

		$path = "";
		$title = "file";
		if($cnt == 1){
			$path = $args[0];

		}else{
			$path = $args[0];
			$title = $args[1];
		}

		$exists = Storage::exists($path);
		if(!$path){
			self::d(1, $title . " (path is empty)");

		}else{
			self::d(1, $title . " (path=$path)=" . ($exists ? "exists" : "notExists"));
		}
	}

	protected static function getJConfigVal($key){
		if($key == "logLevel") return 'DEBUG';

		return NULL;
	}

	public static function b(){
    	$args = func_get_args();
    	$cnt = count($args);
		$title = "";
		$b = false;
		if($cnt <= 2){
			if($cnt == 1){
				$b = $args[0] ? true : false;

			}else{
				$b = $args[0] ? true : false;
				$title = $args[1];
			}
			self::d(1, $title . "=" . ($b ? "T" : "F"));

		}else{
			self::d(1, "Invalid param cnt; cnt=$cnt");
		}
	}

	//// logger
	/*
	file		1
	line		1
	function	2
	*/
	protected static function getCallerInfo($offset = 0){
		try {
			//var_dump(debug_backtrace());
			$debug_backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3 + $offset);
			$line = "";
			$file = "";
			$fnName = "";
			if(isset($debug_backtrace[1 + $offset])){
				$arr = $debug_backtrace[1 + $offset];
				$line = $arr["line"];
				$file = str_replace(dirname(__FILE__), "", $arr["file"]);
				$file = str_replace(".php", "", basename($file));
			}
			if(isset($debug_backtrace[2 + $offset])){
				$arr = $debug_backtrace[2 + $offset];
				// $file = str_replace(dirname(__FILE__), "", $arr["file"]);
				// $file = str_replace(".php", "", basename($file));
				$fnName = $arr["function"];
				
			}else{
				$fnName = "";
			}
			return $fnName . "(" . $file . ($line ? ":" . $line : "") . ")";

		} catch (\Exception $e) {
		}

		return "UNK";
	}

	public static function varDump(){
		$logLevel = self::getJConfigVal("logLevel");
		if($logLevel != 'DEBUG'){
			return;
		}
		
    	$args = func_get_args();
    	$mthOffset = 0;
    	$title = "";
    	$obj = NULL;
    	$outputType = 0;

    	$cnt = count($args);
    	if($cnt <= 4){
			if($cnt == 1){
				$title = "obj";
				$obj = $args[0];

			}else if($cnt == 2){
				$obj = $args[0];
				$title = $args[1];

			}else if($cnt== 3){
				$mthOffset = $args[0];
				$obj = $args[1];
				$title = $args[2];

			}else if(count($args) == 4){
				$mthOffset = $args[0];
				$obj = $args[1];
				$title = $args[2];
				$outputType = $args[3];
			}
			$msg = "varDump; " . self::getVarDumpString($title, $obj);

		}else{
			$msg = "Invalid param count; " . count($args);

		}
		self::logMsg("[D]", self::getCallerInfo($mthOffset), $msg, $outputType);
	}

	public static function getVarDumpString($title, $obj, $level = 0){
		$prefix = str_repeat("- ", $level);
		
		//$str = "$title=";
		$str = $title ? $title . "=" : "";
		if(is_null($obj)){
			$str .= "NULL";
		}else{
			$t = gettype ($obj);
			$c = $t == "object" ? get_class($obj) : $t;
			
			$objInfo = "type=" . $t;
			if(!empty($c) && $c != $t){
				$objInfo .= ", class=" . $c;
			}
			if($t == "string"){
				$objInfo .= strlen($obj);
			}

			// logd("000 t=$t, c=$c");
			if ($obj instanceof \Illuminate\Database\Eloquent\Model) {
			   $obj = $obj->toArray();
			}

			$isHandled = $t == "string" || $t == "double" || $t == "integer" || $t == "float" || $t == "boolean";
			if($isHandled){
				if($t == "boolean"){
					$str .= "($objInfo), value=" . ($obj ? "T" : "F");
				}else{
					$str .= "($objInfo), value=" . $obj;
				}
			}else if($t == "array" || $t == "object"){
				$isHandled = true;
				$cnt = 0;
				$sTmp = "";
				foreach ($obj as $i => $obj2){
					$sTmp .= "\r\n" . self::getVarDumpString("[$i]", $obj2, $level + 1);
					$cnt++;
				}
				$str .= "($objInfo), count=" . $cnt . $sTmp;
			}
		}
		
		return $prefix . $str;
	}

	public static function d(){
		$logLevel = self::getJConfigVal("logLevel");
		if($logLevel != 'DEBUG'){
			return;
		}
		
    	$args = func_get_args();
    	$msg = "";
    	$flag = 0;
    	$argsCnt = count($args);
		if($argsCnt == 1){
			$msg = $args[0];

		}else if(count($args) == 2){
			$msg = $args[0];
			$flag = $args[1];

		}else{
			$msg = "Invalid param count; " . count($args);
		}
		$mthOffset = $flag % 100;
		$outputType = intval($flag / 100);
		self::logMsg("[D]", self::getCallerInfo($mthOffset), $msg, $outputType);
	}

	public static function i(){
		$logLevel = self::getJConfigVal("logLevel");
		if($logLevel != 'DEBUG' && $logLevel != 'INFO'){
			return;
		}

    	$args = func_get_args();
    	$msg = "";
    	$flag = 0;
    	$argsCnt = count($args);
		if($argsCnt == 1){
			$msg = $args[0];

		}else if(count($args) == 2){
			$msg = $args[0];
			$flag = $args[1];

		}else{
			$msg = "Invalid param count; " . count($args);
		}
		$mthOffset = $flag % 100;
		$outputType = intval($flag / 100);
		self::logMsg("[I]", self::getCallerInfo($mthOffset), $msg, $outputType);
	}

	public static function w(){
		$logLevel = self::getJConfigVal("logLevel");
		if($logLevel != 'DEBUG' && $logLevel != 'INFO' && $logLevel != 'WARN'){
			return;
		}

    	$args = func_get_args();
    	$msg = "";
    	$flag = 0;
    	$argsCnt = count($args);
		if($argsCnt == 1){
			$msg = $args[0];

		}else if(count($args) == 2){
			$msg = $args[0];
			$flag = $args[1];

		}else{
			$msg = "Invalid param count; " . count($args);
		}
		$mthOffset = $flag % 100;
		$outputType = intval($flag / 100);
		self::logMsg("[W]", self::getCallerInfo($mthOffset), $msg, $outputType);
	}

	public static function e(){
		$logLevel = self::getJConfigVal("logLevel");
		if($logLevel != 'DEBUG' && $logLevel != 'INFO' && $logLevel != 'WARN' && $logLevel != 'ERROR'){
			return;
		}

    	$args = func_get_args();
    	$msg = "";
    	$flag = 0;
    	$argsCnt = count($args);
		if($argsCnt == 1){
			$msg = $args[0];

		}else if(count($args) == 2){
			$msg = $args[0];
			$flag = $args[1];

		}else{
			$msg = "Invalid param count; " . count($args);
		}
		$mthOffset = $flag % 100;
		$outputType = intval($flag / 100);
		self::logMsg("[E]", self::getCallerInfo($mthOffset), $msg, $outputType);
	}

	protected static function showObjDet($title, $obj){
		$logLevel = self::getJConfigVal("logLevel");
		if($logLevel != 'DEBUG'){
			return;
		}
		
		$msg = "$title=" . getObjDet($obj);
		self::logMsg("[D]", self::getCallerInfo(), "showObjDet", $msg, 0);
	}

	protected static function getObjDet($obj){
		if($obj === NULL) return "NULL";

		$t = gettype ($obj);
		if($t != "object"){
			return self::getVarDumpString("", $obj);
		}

		$c = get_class($obj);
		$meths = get_class_methods($obj);
		$vars = get_object_vars ($obj);
		$str = "class=$c; methodCnt=" . count($meths) . ", varCnt=" . count($vars) . "\r\n";
		if($meths){
			foreach($meths as $i => $meth){
				$str .= "Method: $meth\r\n";
			}
		}
		if($vars){
			foreach($vars as $name => $val){
				$str .= "Var: $name\r\n";
			}
		}

		return $str;
	}

	protected static function logMsg($debugLevel, $callerInfo, $msg, $outputType){
		defined('LOG_FILE_NAME') or define('LOG_FILE_NAME', 'log.txt');
		if($outputType == 1 || $outputType == 2){
			$str = str_replace("\r\n", "<br>\r\n", $msg) . 
				"<br>\r\n";
			echo $str;
		}
		
		if($outputType == 0 || $outputType == 2){
			$str = date("Y-m-d h:i:s") . 
				"\t" . $debugLevel . 
				"\t" . (!empty($callerInfo) ? "[" . $callerInfo . "]" : "") . 
				// "\t" . (!empty($tag) ? "[" . $tag . "]" : "") . 
				"\t" . $msg . 
				"\r\n";
			//file_put_contents(.'log.txt', $str , FILE_APPEND | LOCK_EX);
			$filepath = (defined('JPATH_BASE') ? JPATH_BASE . DS : "") . LOG_FILE_NAME;
			file_put_contents($filepath, $str , FILE_APPEND | LOCK_EX);
		}
	}
}