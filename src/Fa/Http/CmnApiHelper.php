<?php 
namespace Fa\Http;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Fa\Helpers\FaHelper;
use Fa\Http\ApiHelper;
use Fa\Http\FaApiRc;
use Fa\Database\DbHelper;


class CmnApiHelper {
	public static function heartbeat(Request $request) {
		$resp = ApiHelper::successRespByData(date("Y-m-d H:i:s"));
        // FatApiRespLogHelper::addApiRespLog($resp);
        
	    return $resp;
	}

    public static function checkDatabase(Request $request) {
    	if(DbHelper::checkConn()){
			$resp = ApiHelper::successResp();

    	}else{
			$resp = ApiHelper::failResp("Fail", FaApiRc::FAIL);

    	}

		return $resp;
    }
}