<?php

//// Boolean
if(!function_exists('b2s')){
    function b2s($b, $sTrue = "T", $sFalse = "F"){
        return $b ? $sTrue : $sFalse;
    }
}

if(!function_exists('is_true')){
    function is_true($val){
        if(!$val) return false;
        $valLc = strtolower($val);
        return $val === true || $valLc === "true" || $valLc === "on";
    }
}

//// String

if(!function_exists('append_str')){
    function append_str($str1, $str2, $delimiter = ', ') {
        if(!$str2) return $str1;
        if(!$str1) return $str2;

        return $str1 . $delimiter . $str2;
    }
}

if(!function_exists('lower')){
    function lower($str) {
        return mb_strtolower($str, 'UTF-8');
    }
}

if(!function_exists('snake')){
    function snake($str) {
        $str = str_replace(["-", " "], "_", $str);
        return strtolower(preg_replace(
        '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', '_', $str));

        //// Laravel
        // $str = preg_replace('/\s+/u', '', ucwords($str));
        // $str = lower(preg_replace('/(.)(?=[A-Z])/u', '$1_', $str));
        // // return $str;
        // return str_replace(['__', '-_'], '_', $str);
    }
}

if(!function_exists('slug')){
    function slug($str) {
        $str = str_replace(["_", " "], "-", $str);
        return strtolower(preg_replace(
        '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', '-', $str));
    }
}

if(!function_exists('camel')){
    function camel($str) {
        return lcfirst(studly($str));
    }
}

if(!function_exists('studly')){
    function studly($str) {
        $str = ucwords(str_replace(['-', '_'], ' ', $str));

        return str_replace(' ', '', $str);
    }
}

if(!function_exists('to_title')){
    function to_title($str) {
        $str = slug($str);
        return ucwords(str_replace('-', ' ', $str));
    }
}

//// Array
if(!function_exists('getFromArr')){
    function getFromArr(){
        $params = func_get_args();
        $arr = $params[0];
        $defaultValue = $params[1];
        $n = count($params) - 2;

        for($i = 2; $i < count($params); $i++){
            $key = $params[$i];
            // if(!$key){
            //  return $arr;
            // }
            if(isset($arr[$key])){
                $arr = $arr[$key];

            }else{
                return $defaultValue;

            }
        }

        return $arr;
    }
}

if(!function_exists('gfa')){
    function gfa(){
        $params = func_get_args();
        $arr = $params[0];
        $defaultValue = $params[1];
        $n = count($params) - 2;

        for($i = 2; $i < count($params); $i++){
            $key = $params[$i];
            // if(!$key){
            //  return $arr;
            // }
            if(isset($arr[$key])){
                $arr = $arr[$key];

            }else{
                return $defaultValue;

            }
        }

        return $arr;
    }
}

if(!function_exists('keys2karr')){
    function keys2karr($arr, $keyField = ""){
        $arr2 = [];
        foreach ($arr as $i=>$key){
            $arr2[$key] = [];
            if($keyField){
                $arr2[$keyField] = $key;
            }
        }
        return $arr2;
    }
}

//// Object
if(!function_exists('ifnull')){
    function ifnull($obj, $def){
        return $obj === NULL ? $def : $obj;
    }

}
if(!function_exists('nempty')){
    function nempty($obj){
        return !nempty($obj);
    }
}

//// Datetime
if(!function_exists('dtm2dt')){
    function dtm2dt($dtm) {
        return $dtm && $dtm != '0001-01-01 00:00:00' ? date("Y-m-d", strtotime($dtm)) : "";
    }
}

if(!function_exists('dtm2tm')){
    function dtm2tm($dtm) {
        return $dtm && $dtm != '0001-01-01 00:00:00' ? date("H:m:s", strtotime($dtm)) : "";
    }
}

//// Log
if(!function_exists('logd')){
    function logd(){
        $params = func_get_args();
        $msg = ((isset($params[0])) ? $params[0] : "");
        $callerOffset = ((isset($params[1])) ? $params[1] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::d", array($msg, $callerOffset));
    }
}

if(!function_exists('logi')){
    function logi(){
        $params = func_get_args();
        $msg = ((isset($params[0])) ? $params[0] : "");
        $callerOffset = ((isset($params[1])) ? $params[1] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::i", array($msg, $callerOffset));
    }
}

if(!function_exists('logw')){
    function logw(){
        $params = func_get_args();
        $msg = ((isset($params[0])) ? $params[0] : "");
        $callerOffset = ((isset($params[1])) ? $params[1] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::w", array($msg, $callerOffset));
    }
}

if(!function_exists('loge')){
    function loge(){
        $params = func_get_args();
        $msg = ((isset($params[0])) ? $params[0] : "");
        $callerOffset = ((isset($params[1])) ? $params[1] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::e", array($msg, $callerOffset));
    }
}

if(!function_exists('logMsg')){
    function logMsg(){
        $params = func_get_args();
        $logLevel = strtoupper($params[0]);
        $msg = ((isset($params[1])) ? $params[1] : "");
        $callerOffset = ((isset($params[2])) ? $params[2] : 0) + 1;
        if($logLevel == "D"){
            call_user_func_array("\Fa\Log\Flog::d", array($msg, $callerOffset));
            
        }else if($logLevel == "W"){
            call_user_func_array("\Fa\Log\Flog::w", array($msg, $callerOffset));
            
        }else if($logLevel == "E"){
            call_user_func_array("\Fa\Log\Flog::e", array($msg, $callerOffset));
            
        }else if($logLevel == "I"){
            call_user_func_array("\Fa\Log\Flog::i", array($msg, $callerOffset));
        }
    }
}

if(!function_exists('varDump')){
    function varDump(){
        $params = func_get_args();
        $obj = (isset($params[0]) ? $params[0] : "");
        $title = (isset($params[1]) ? $params[1] : "");
        $callerOffset = (isset($params[2]) ? $params[2] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::varDump", array($obj, $title, $callerOffset));
    }
}

if(!function_exists('varDumpToJStr')){
    function varDumpToJStr(){
        $params = func_get_args();
        $obj = (isset($params[0]) ? $params[0] : "");
        $title = (isset($params[1]) ? $params[1] : "");
        $callerOffset = (isset($params[2]) ? $params[2] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::varDumpToJStr", array($obj, $title, $callerOffset));
    }
}

if(!function_exists('reqId')){
    function reqId(){
        // return call_user_func("\Fa\Http\ReqHelper::getData");
        return call_user_func_array("\Fa\Http\ReqHelper::getData", array('req_id'));
    }
}

//// HTML
if(!function_exists('debugMsg')){
    function debugMsg(){
        $args = func_get_args();
        $cnt = count($args);
        if($cnt == 1){
            $val = $args[0];
            echo "<!-- $val -->";

        }else{
            $key = $args[0];
            $val = $args[1];
            echo "<!-- $key=$val -->";
        }
    }
}