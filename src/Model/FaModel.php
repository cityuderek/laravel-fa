<?php
namespace Fa\Model;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Fa\Log\Flog;
// web

class FaModel extends Model
{
	protected $akeyName = '';

    public static function createIfNotExistsA($akey){
		$instance = (new static);
    	$akeyName = $instance->akeyName;
    	
        $tmp = $instance->where($akeyName, $akey);
		if($tmp->exists()){
			// logd("get $akeyName=$akey");
			return null;
		}
    	
        $tmp = $instance->withTrashed()->where($akeyName, $akey);
		if($tmp->exists()){
			// logd("restore $akeyName=$akey");
			return null;
		}

    	// logd("create $akeyName=$akey");
		$obj = $instance->create([$akeyName => $akey]);

        return $obj;
    }

    public static function firstOrCreateA($akey){
		$instance = (new static);
    	$akeyName = $instance->akeyName;
    	
        $tmp = $instance->where($akeyName, $akey);
		if($tmp->exists()){
			// logd("get $akeyName=$akey");
			return $tmp->first();
		}
    	
        $tmp = $instance->withTrashed()->where($akeyName, $akey);
		if($tmp->exists()){
			// logd("restore $akeyName=$akey");
			$tmp->restore();
			return $instance->where($akeyName, $akey)->first();
		}

    	// logd("create $akeyName=$akey");
		$obj = $instance->create([$akeyName => $akey]);

        return $obj;
    }

    public static function restoreA($akey){
    	$akeyName = (new static)->akeyName;
    	// logd("$akeyName=$akey");
        return self::withTrashed()->where($akeyName, $akey)->restore();
    }

    public static function existsA($akey){
    	$akeyName = (new static)->akeyName;
    	// logd("$akeyName=$akey");
        return self::where($akeyName, $akey)->exists();
    }

	public static function insertA($akey) {
    	$akeyName = (new static)->akeyName;
    	// logd("$akeyName=$akey");
		$obj = self::insert([$akeyName => $akey]);

		return $obj;
	}

	public static function createA($akey) {
		$instance = (new static);
    	$akeyName = $instance->akeyName;
    	// logd("$akeyName=$akey");
		$obj = $instance->create([$akeyName => $akey]);

		return $obj;
	}

	public static function deleteA($akey) {
    	$akeyName = (new static)->akeyName;
    	// logd("$akeyName=$akey");
		return self::where($akeyName, $akey)->delete();
	}

	public static function isDeletedA($akey) {
    	$akeyName = (new static)->akeyName;
    	// logd("$akeyName=$akey");
		return self::withTrashed()->where($akeyName, $akey)->whereNotNull('deleted_at')->exists();
	}

	public static function getA($akey) {
    	$akeyName = (new static)->akeyName;
    	// logd("$akeyName=$akey");
        $tmp = self::where($akeyName, $akey);
		// logd("count=" . $tmp->count());
		// Log::debug(__METHOD__ . "; items=" . count($items));
		// if(!count($items)) return NULL;
		if($tmp->count() == 0) return NULL;
		$obj = $tmp->first();
		return $obj;
	}
}
