<?php 

namespace App\Fa\IO;

use Carbon\Carbon;
use App\Fa\Helpers\FaHelper;

class FileHelper {
	public static function failResp($msg = "UNK", $rc = -1, $disp_msg = "", $data = NULL) {
		$resp = array(
			"rs" => "FAIL",
			"rc" => $rc,
			"msg" => $msg,
			"disp_msg" => $disp_msg,
		);
		if($data){
			$resp['data'] = $data;
		}

	    return $resp;
	}
}