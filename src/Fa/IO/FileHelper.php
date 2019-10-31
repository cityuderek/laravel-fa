<?php 

namespace Fa\IO;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Fa\Helpers\FaHelper;

class FileHelper {

	public static function filesByDirInfo($dirInfo) {
		return self::files($dirInfo['disk'], $dirInfo['path'], $dirInfo['ext']);
	}

	public static function files($disk, $path = '', $ext = '') {
		logd("disk=$disk, path=$path, ext=$ext");
		$files = Storage::disk($disk)->files($path);
		if($ext){
			$files = self::filterFilesByExt($files, $ext);
		}

	    return $files;
	}

	public static function filterFilesByExt($files, $ext) {
		$pattern = '/.*\.' . $ext . '/';
		$files = array_values(preg_grep($pattern, $files));

	    return $files;
	}

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