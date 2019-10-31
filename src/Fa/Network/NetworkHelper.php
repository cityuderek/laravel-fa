<?php 

namespace Fa\Network;

use Illuminate\Support\Str;
use Carbon\Carbon;
// use Fa\Database\DbHelper;
// use Fa\Helpers\FaHelper;
// use Fa\Helpers\DateTimeHelper;
use Fa\Helpers\StrHelper;

class NetworkHelper {

	public static function test(){
		$arr = array();
		$url = "https://fishapple.com:443/fa-tools/text-tool?a=1&b=2";

		$current = url()->current();
		$full = url()->full();
		varDump(url(), 'url');
		// varDump(url()->full(), 'full');
		// varDump(url()->previous(), 'previous');
		// logd("current=$current");
		// logd("full=$full");
		$arr['current'] = url()->current();
		$arr['full'] = url()->full();
		$arr['previous'] = url()->previous();

		$arr['profile1'] = url('user/profile');
		$arr['profile2'] = url('user/profile', [1]);

		$arr['URL'] = URL::to('/');
		$arr['app_path'] = app_path();

		varDump(URL::to('/'), 'URL');


		return $arr;
	}

	public static function chkConnByDomain($host, $port = 80, $timeoutS = 1){ 
		$tmpErrReport = error_reporting();
		error_reporting(0);
		$tB = microtime(true); 
		$fP = fSockOpen($host, $port, $errno, $errstr, $timeoutS); 
		error_reporting($tmpErrReport);
		if (!$fP) { return -1; } 
		$tA = microtime(true); 

		return round((($tA - $tB) * 1000), 0)." ms"; 
	}

	public static function chkConnByUrl($url, $timeoutS = 1){ 
		$i = strpos($url, "//");
		$s = $i ? substr($url, $i + 2) : $url;

		$i = strpos($s, "/");
		$s = $i ? substr($s, 0, $i) : $s;
		// echo "url1=$url; s=$s<br>";

		$i = strpos($s, ":");
		if($i){
			$domain = substr($s, 0, $i);
			$port = substr($s, $i + 1);

		}else{
			$domain = $s;
			$port = 80;
		}

		// echo "url2=$url; domain=$domain; port=$port<br>";
		return chkConnByDomain($domain, $port, $timeoutS);
	}
}