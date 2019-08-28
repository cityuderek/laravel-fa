<?php 

namespace Fa\Helpers;

use Storage;
use Carbon\Carbon;
use Fa\Helpers\FaHelper;
use Fa\Log\Flog;

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