<?php 

namespace Fa\Network;

use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
// use Fa\Database\DbHelper;
// use Fa\Helpers\FaHelper;
// use Fa\Helpers\DateTimeHelper;
use Fa\Helpers\StrHelper;
use Illuminate\Support\Facades\URL;

class UrlHelper {

	public static function test(){
		$arr = array();
		$url = "https//fa-web.tvbroaming.com:5443/api/app/tt?a=2&b=3";

		// $current = url()->current();
		// $full = url()->full();
		// varDump(url(), 'url');
		// varDump(url()->full(), 'full');
		// varDump(url()->previous(), 'previous');
		// logd("current=$current");
		// logd("full=$full");

		// $arr['URL'] = URL::to('/');
        // $arr["url"] = [
        // 	"HTTP_HOST" => $_SERVER["HTTP_HOST"],
        // 	"REQUEST_URI" => $_SERVER["REQUEST_URI"],
        // 	"HTTPS" => $_SERVER["HTTPS"],
        // 	"scheme" => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http"),
        // 	"SERVER_NAME" => $_SERVER["SERVER_NAME"],
        // 	"REQUEST_METHOD" => $_SERVER["REQUEST_METHOD"],
        // 	"SERVER_ADDR" => $_SERVER["SERVER_ADDR"],
        // 	"SERVER_PORT" => $_SERVER["SERVER_PORT"],
        // 	"REQUEST_TIME" => $_SERVER["REQUEST_TIME"]
        // ];
        // $arr["_SERVER"] = $_SERVER;
        $arr["urlInfo1"] = self::getUrlInfo();
        $arr["urlInfo2"] = self::getUrlInfo($url);
        $arr["urlInfo3"] = self::getUrlInfo("https//fa-web.tvbroaming.com:5443/api/app/tt");
        $arr["urlInfo4"] = self::getUrlInfo("https//fa-web.tvbroaming.com");
        $arr["urlInfo5"] = self::getUrlInfo("fa-web.tvbroaming.com");
        $arr["getPathN_0"] = self::getPathN(0);
        $arr["getPathN_1"] = self::getPathN(1);
        $arr["getPathN_2"] = self::getPathN(2);
        $arr["getPathN_3"] = self::getPathN(3);
        $arr["getPathN_4"] = self::getPathN(4);
        $arr["getPathN_-1"] = self::getPathN(-1);
        $arr["getPathN_-2"] = self::getPathN(-2);
        $arr["getPathN_-3"] = self::getPathN(-3);
        $arr["getPathN_-4"] = self::getPathN(-4);
        $arr["getPathN2_0"] = self::getPathN(0, $url);
        $arr["getPathN2_1"] = self::getPathN(1, $url);
        $arr["getPathN2_2"] = self::getPathN(2, $url);
        $arr["getPathN2_3"] = self::getPathN(3, $url);
        $arr["getPathN2_4"] = self::getPathN(4, $url);
        $arr["getPathN2_-1"] = self::getPathN(-1, $url);
        $arr["getPathN2_-2"] = self::getPathN(-2, $url);
        $arr["getPathN2_-3"] = self::getPathN(-3, $url);
        $arr["getPathN2_-4"] = self::getPathN(-4, $url);

		// varDump(URL::to('/'), 'URL');

		return $arr;
	}

	public static function getPathN(){
		$args = func_get_args();
		$argCnt = count($args);
		$n = $args[0];
		if($argCnt == 2){
			$full_url = $args[1];
			$sTmp1 = StrHelper::getRightByKey($full_url, '//');
			$sTmp2 = StrHelper::getLeftByKey($sTmp1, '?');
			$sTmp3 = StrHelper::getRightByKey($sTmp2, '/', false);

		}else if($argCnt == 1){
			$redirectUrl = $_SERVER["REDIRECT_URL"];
			$sTmp3 = substr($redirectUrl, 1);
			// logd("redirectUrl=$redirectUrl; sTmp3=$sTmp3");

		}else{

			return "";
		}

        $paths = $sTmp3 ? explode('/', $sTmp3) : [];
        // varDump($paths, 'paths');
        if($n >= 0){
        	return gfa($paths, '', $n);
        }

        $i = count($paths) + $n;
        return $i >= 0 ? $paths[$i] : "";
	}

	public static function getUrlInfo(){
		$args = func_get_args();
		$argCnt = count($args);
		$paths = [];
		$query_strings = [];
		if($argCnt == 0){
			$scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");		// https
			// $httpHost = $_SERVER["HTTP_HOST"]; 	// "fa-web.tvbroaming.com:5443"
			$serverName = $_SERVER["SERVER_NAME"];		// fa-web.tvbroaming.com
			$port = $_SERVER["SERVER_PORT"];			// 5443
			$redirectUrl = $_SERVER["REDIRECT_URL"];	// "/api/app/tt"
            $queryString  = $_SERVER["QUERY_STRING"];	// "a=2&b=3"

			$url = $scheme . '//' . $serverName . (($scheme == "http" && $port == 80) || ($scheme == "https" && $port == 443) ? "" : ':' . $port) . $redirectUrl;
			$full_url = $url . ($queryString ? '?' . $queryString : '');

		}else if($argCnt == 1){
			$full_url = $args[0];

			$scheme = StrHelper::getLeftByKey($full_url, '//', false);
			if(!$scheme){
				$scheme = "http";
			}

			$sTmp1 = StrHelper::getRightByKey($full_url, '//');
			$sTmp2 = StrHelper::getLeftByKey($sTmp1, '?');
			$queryString = StrHelper::getRightByKey($sTmp1, '?', false);

			$domainNPort = StrHelper::getLeftByKey($sTmp2, '/');
			$sTmp3 = StrHelper::getRightByKey($sTmp2, '/', false);
			$redirectUrl = $sTmp3 ? '/' . $sTmp3 : "";

			$serverName = StrHelper::getLeftByKey($domainNPort, ':');
			$port = StrHelper::getRightByKey($domainNPort, ':', false);
			if(!$port){
				$port = $scheme == "http" ? 80 : 443;
			}

			$url = $scheme . '//' . $serverName . (($scheme == "http" && $port == 80) || ($scheme == "https" && $port == 443) ? "" : ':' . $port) . $redirectUrl;

		}else{
			return NULL;
		}

        $paths = $redirectUrl ? explode('/', substr($redirectUrl, 1)) : [];
		parse_str($queryString, $query_strings);
		return [
			"full_url" => $full_url,
			"url" => $url,
			"scheme" => $scheme,
			"domain" => $serverName,
			"port" => $port,
			"path" => $redirectUrl,
			"query_string" => $queryString,
			"paths" => $paths,
			"query_strings" => $query_strings,
		];
	}

	public static function getDomainFromUrl($url){
		$i = strpos($url, "//");
		$s = $i ? substr($url, $i + 2) : $url;

		$i = strpos($s, "/");
		$s = $i ? substr($s, 0, $i) : $s;

		$i = strpos($s, ":");
		$s = $i ? substr($s, 0, $i) : $s;

		return $s;
	}
}