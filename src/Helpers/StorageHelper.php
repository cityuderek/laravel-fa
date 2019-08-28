<?php 

namespace App\Fa\Helpers;

use Storage;
use Carbon\Carbon;
use App\Fa\Helpers\FaHelper;
use App\Fa\Log\Flog;

class StorageHelper {
	public static function get($path, $defCtt = NULL) {
		if(Storage::exists($path)){
			$ctt = Storage::get($path);

			return $ctt;
		}
		logw("file not exist; path=$path");

		return $defCtt;
	}
}