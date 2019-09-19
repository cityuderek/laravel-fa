<?php

//// Log
if(!function_exists('logd')){
    function logd(){
        $params = func_get_args();
        $param1 = ((isset($params[0])) ? $params[0] : "");
        $param2 = ((isset($params[1])) ? $params[1] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::d", array($param1, $param2));
    }
}

if(!function_exists('logi')){
    function logi(){
        $params = func_get_args();
        $param1 = ((isset($params[0])) ? $params[0] : "");
        $param2 = ((isset($params[1])) ? $params[1] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::i", array($param1, $param2));
    }
}

if(!function_exists('logw')){
    function logw(){
        $params = func_get_args();
        $param1 = ((isset($params[0])) ? $params[0] : "");
        $param2 = ((isset($params[1])) ? $params[1] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::w", array($param1, $param2));
    }
}

if(!function_exists('loge')){
    function loge(){
        $params = func_get_args();
        $param1 = ((isset($params[0])) ? $params[0] : "");
        $param2 = ((isset($params[1])) ? $params[1] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::e", array($param1, $param2));
    }
}

if(!function_exists('logMsg')){
    function logMsg(){
        $params = func_get_args();
        $param1 = strtoupper($params[0]);
        $param2 = ((isset($params[1])) ? $params[1] : "");
        $param3 = ((isset($params[2])) ? $params[2] : 0) + 1;
        if($param1 == "D"){
            call_user_func_array("\Fa\Log\Flog::d", array($param2, $param3));
            
        }else if($param1 == "W"){
            call_user_func_array("\Fa\Log\Flog::w", array($param2, $param3));
            
        }else if($param1 == "E"){
            call_user_func_array("\Fa\Log\Flog::e", array($param2, $param3));
            
        }else if($param1 == "I"){
            call_user_func_array("\Fa\Log\Flog::i", array($param2, $param3));
        }
    }
}

if(!function_exists('varDump')){
    function varDump(){
        call_user_func_array("\Fa\Log\Flog::varDump", array_merge([1], func_get_args()));
    }
}

if(!function_exists('reqId')){
    function reqId(){
        // return call_user_func("\Fa\Http\ReqHelper::getData");
        return call_user_func_array("\Fa\Http\ReqHelper::getData", array('req_id'));
    }
}

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

    //// Object
}

if(!function_exists('ifnull')){
    function ifnull($obj, $def){
        return $obj === NULL ? $def : $obj;
    }

    //// String
}

if(!function_exists('upFirstChar')){
    function upFirstChar($str) {
        return $str ? strtoupper($str[0]) . substr($str, 1) : '';
    }
}

if(!function_exists('appendStr')){
    function appendStr($str1, $str2, $delimiter = ', ') {
        if(!$str2) return $str1;
        if(!$str1) return $str2;

        return $str1 . $delimiter . $str2;
    }
}

if(!function_exists('strMaxLen')){
    function strMaxLen($str, $n) {
        return substr($str, 0, $n);
        // if(strlen($str1 )
        // return $str1 . $delimiter . $str2;
    }
}

if(!function_exists('dtm2dt')){
    //// Datetime
    function dtm2dt($dtm) {
        return $dtm && $dtm != '0001-01-01 00:00:00' ? date("Y-m-d", strtotime($dtm)) : "";
    }
}

if(!function_exists('dtm2tm')){
    function dtm2tm($dtm) {
        return $dtm && $dtm != '0001-01-01 00:00:00' ? date("H:m:s", strtotime($dtm)) : "";
    }
}

    //// Boolean
if(!function_exists('b2s')){
    function b2s($b, $sTrue = "T", $sFalse = "F"){
        return $b ? $sTrue : $sFalse;
    }
}

// if(!function_exists('o2b')){
//     function o2b($val){
//         return $val ? TRUE : FALSE;
//     }
// }

if(!function_exists('isTrue')){
    function isTrue($val){
        if(!$val) return false;
        return $val === true || strtolower($val) === "true" || $val === "on";
    }
}

    // function bToStr($b, $sTrue = "T", $sFalse = "F"){
    //     return $b ? $sTrue : $sFalse;
    // }

    // function toB($val){
    //     return $val ? true : false;
    // }

    //// Array

if(!function_exists('getFromArr')){
    function getFromArr($arr, $defaultValue, $key1, $key2 = ""){
        if(empty($arr)) return $defaultValue;
        if(empty($key1)) return $defaultValue;
        if(!isset($arr[$key1])) return $defaultValue;
        if(empty($key2)){
            return $arr[$key1];
        }
        if(!isset($arr[$key1][$key2])) return $defaultValue;
        return $arr[$key1][$key2];
    }
}