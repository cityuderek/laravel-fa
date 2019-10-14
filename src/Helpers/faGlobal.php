<?php

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
        $obj = ((isset($params[0])) ? $params[0] : "");
        $title = ((isset($params[1])) ? $params[1] : "");
        $callerOffset = ((isset($params[2])) ? $params[2] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::varDump", array($obj, $title, $callerOffset));
    }
}

if(!function_exists('varDumpToJStr')){
    function varDumpToJStr(){
        $params = func_get_args();
        $obj = ((isset($params[0])) ? $params[0] : "");
        $title = ((isset($params[1])) ? $params[1] : "");
        $callerOffset = ((isset($params[2])) ? $params[2] : 0) + 1;
        call_user_func_array("\Fa\Log\Flog::varDumpToJStr", array($obj, $title, $callerOffset));
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