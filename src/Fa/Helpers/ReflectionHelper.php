<?php 

namespace Fa\Helpers;

class ReflectionHelper {

	public static function getClassSimpleName($obj) {
	    return (new \ReflectionClass($obj))->getShortName();
	}
}