<?php 
namespace Fa\Http;

use Carbon\Carbon;
use Fa\Helpers\FaHelper;
use Fa\Http;


class ApiHelper {

	public static function failResp($msg = "UNK", $rc = "9999", $disp_msg = "", $data = NULL) {
		$resp = array(
			"rc" => $rc,
			"rc_name" => FaApiRc::getkey($rc),
			"msg" => $msg,
			"disp_msg" => $disp_msg,
		);
		if($data){
			$resp['data'] = $data;
		}

	    return $resp;
	}

	public static function failRespByFaEx($faEx) {
		return self::failResp($faEx->msg, $faEx->rc, $faEx->disp_msg, $faEx->data);
	}

	public static function successResp($msg = "", $rc = "0000", $disp_msg = "", $data = NULL) {
		$resp = array(
			"rc" => $rc,
			"rc_name" => FaApiRc::getkey($rc),
			"msg" => $msg,
			"disp_msg" => $disp_msg,
		);
		if($data){
			$resp['data'] = $data;
		}

	    return $resp;
	}

	public static function successRespByData($data) {
		return self::successResp("", "0000", "", $data);
	}
}