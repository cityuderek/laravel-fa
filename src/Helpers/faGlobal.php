<?php

//// Log
function logd(){
    $params = func_get_args();
    $param1 = ((isset($params[0])) ? $params[0] : "");
    $param2 = ((isset($params[1])) ? $params[1] : 0) + 1;
    call_user_func_array("\App\Fa\Log\Flog::d", array($param1, $param2));
}

function logi(){
    $params = func_get_args();
    $param1 = ((isset($params[0])) ? $params[0] : "");
    $param2 = ((isset($params[1])) ? $params[1] : 0) + 1;
    call_user_func_array("\App\Fa\Log\Flog::i", array($param1, $param2));
}

function logw(){
    $params = func_get_args();
    $param1 = ((isset($params[0])) ? $params[0] : "");
    $param2 = ((isset($params[1])) ? $params[1] : 0) + 1;
    call_user_func_array("\App\Fa\Log\Flog::w", array($param1, $param2));
}

function loge(){
    $params = func_get_args();
    $param1 = ((isset($params[0])) ? $params[0] : "");
    $param2 = ((isset($params[1])) ? $params[1] : 0) + 1;
    call_user_func_array("\App\Fa\Log\Flog::e", array($param1, $param2));
}

function logMsg(){
    $params = func_get_args();
    $param1 = strtoupper($params[0]);
    $param2 = ((isset($params[1])) ? $params[1] : "");
    $param3 = ((isset($params[2])) ? $params[2] : 0) + 1;
    if($param1 == "D"){
        call_user_func_array("\App\Fa\Log\Flog::d", array($param2, $param3));
        
    }else if($param1 == "W"){
        call_user_func_array("\App\Fa\Log\Flog::w", array($param2, $param3));
        
    }else if($param1 == "E"){
        call_user_func_array("\App\Fa\Log\Flog::e", array($param2, $param3));
        
    }else if($param1 == "I"){
        call_user_func_array("\App\Fa\Log\Flog::i", array($param2, $param3));
    }
}

function varDump(){
    call_user_func_array("\App\Fa\Log\Flog::varDump", array_merge([1], func_get_args()));
}

// function showModel(){
//     $params = func_get_args();
//     $param1 = $params[0];
//     $param2 = $params[1];
//     if($param1 !== NULL){
//         $param1 = $param1->toArray();
//     }
//     call_user_func_array("\App\Fa\Log\Flog::varDump", array(1, $param1, $param2));
// }

function reqId(){
    // return call_user_func("\App\Fa\Http\ReqHelper::getData");
    return call_user_func_array("\App\Fa\Http\ReqHelper::getData", array('req_id'));
}

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
function ifnull($obj, $def){
    return $obj === NULL ? $def : $obj;
}

//// String
function upFirstChar($str) {
    return $str ? strtoupper($str[0]) . substr($str, 1) : '';
}

function appendStr($str1, $str2, $delimiter = ', ') {
    if(!$str2) return $str1;
    if(!$str1) return $str2;

    return $str1 . $delimiter . $str2;
}

function strMaxLen($str, $n) {
    return substr($str, 0, $n);
    // if(strlen($str1 )
    // return $str1 . $delimiter . $str2;
}

//// Datetime
function dtm2dt($dtm) {
    return $dtm && $dtm != '0001-01-01 00:00:00' ? date("Y-m-d", strtotime($dtm)) : "";
}

function dtm2tm($dtm) {
    return $dtm && $dtm != '0001-01-01 00:00:00' ? date("H:m:s", strtotime($dtm)) : "";
}

//// Boolean

function b2s($b, $sTrue = "T", $sFalse = "F"){
    return $b ? $sTrue : $sFalse;
}

function v2b($val){
    return $val ? TRUE : FALSE;
}

function isTrueVal($val){
    if(!$val) return false;
    return $val === true || strtolower($val) === "true" || $val === "on";
}

// function bToStr($b, $sTrue = "T", $sFalse = "F"){
//     return $b ? $sTrue : $sFalse;
// }

// function toB($val){
//     return $val ? true : false;
// }

//// Array
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