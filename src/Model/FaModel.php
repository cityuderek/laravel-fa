<?php
namespace Fa\Model;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Fa\Log\Flog;
// web

class FaModel extends Model
{

    public static function createIfNotExistsA($akey){
		$instance = (new static);
    	$primaryKey = $instance->primaryKey;
    	
        $tmp = $instance->where($primaryKey, $akey);
		if($tmp->exists()){
			// logd("get $primaryKey=$akey");
			return null;
		}
    	
        $tmp = $instance->withTrashed()->where($primaryKey, $akey);
		if($tmp->exists()){
			// logd("restore $primaryKey=$akey");
			return null;
		}

    	// logd("create $primaryKey=$akey");
		$obj = $instance->create([$primaryKey => $akey]);

        return $obj;
    }

    public static function firstOrCreateA($akey){
		$instance = (new static);
    	$primaryKey = $instance->primaryKey;
    	
        $tmp = $instance->where($primaryKey, $akey);
		if($tmp->exists()){
			// logd("get $primaryKey=$akey");
			return $tmp->first();
		}
    	
        $tmp = $instance->withTrashed()->where($primaryKey, $akey);
		if($tmp->exists()){
			// logd("restore $primaryKey=$akey");
			$tmp->restore();
			return $instance->where($primaryKey, $akey)->first();
		}

    	// logd("create $primaryKey=$akey");
		$obj = $instance->create([$primaryKey => $akey]);

        return $obj;
    }

    public static function restoreA($akey){
    	$primaryKey = (new static)->primaryKey;
    	// logd("$primaryKey=$akey");
        return self::withTrashed()->where($primaryKey, $akey)->restore();
    }

    public static function existsA($akey){
    	$primaryKey = (new static)->primaryKey;
    	// logd("$primaryKey=$akey");
        return self::where($primaryKey, $akey)->exists();
    }

	public static function insertA($akey) {
    	$primaryKey = (new static)->primaryKey;
    	// logd("$primaryKey=$akey");
		$obj = self::insert([$primaryKey => $akey]);

		return $obj;
	}

	public static function createA($akey) {
		$instance = (new static);
    	$primaryKey = $instance->primaryKey;
    	// logd("$primaryKey=$akey");
		$obj = $instance->create([$primaryKey => $akey]);

		return $obj;
	}

	public static function deleteA($akey) {
    	$primaryKey = (new static)->primaryKey;
    	// logd("$primaryKey=$akey");
		return self::where($primaryKey, $akey)->delete();
	}

	public static function isDeletedA($akey) {
    	$primaryKey = (new static)->primaryKey;
    	// logd("$primaryKey=$akey");
		return self::withTrashed()->where($primaryKey, $akey)->whereNotNull('deleted_at')->exists();
	}

	public static function getA($akey) {
    	$primaryKey = (new static)->primaryKey;
    	// logd("$primaryKey=$akey");
        $tmp = self::where($primaryKey, $akey);
		// logd("count=" . $tmp->count());
		// Log::debug(__METHOD__ . "; items=" . count($items));
		// if(!count($items)) return NULL;
		if($tmp->count() == 0) return NULL;
		$obj = $tmp->first();
		return $obj;
	}
}
