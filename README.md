
# laravel-fa
Laravel FA framework
Version 1.1.10

# Global Functions
### String
$slug = "aaa-222-bbb-Ccc-Ddd";
$snake = "aaa_222_bbb_Ccc_Ddd";
$camel = "aaa222BbbCccDdd";
$title = "aaa 222 Bbb Ccc Ddd";

#### snake($string)
logd("snake 1=" . snake(\$slug));
logd("snake 2=" . snake(\$snake));
logd("snake 3=" . snake(\$camel));
logd("snake 4=" . snake(\$title));
output:
snake 1=aaa_222_bbb_ccc_ddd  
snake 2=aaa_222_bbb_ccc_ddd  
snake 3=aaa_222_bbb_ccc_ddd  
snake 4=aaa_222_bbb_ccc_ddd  

#### slug($string)
For URL
logd("slug 1=" . slug(\$slug));
logd("slug 2=" . slug(\$snake));
logd("slug 3=" . slug(\$camel));
logd("slug 4=" . slug(\$title));
output:
slug 1=aaa-222-bbb-ccc-ddd  
slug 2=aaa-222-bbb-ccc-ddd  
slug 3=aaa-222-bbb-ccc-ddd  
slug 4=aaa-222-bbb-ccc-ddd  

#### camel($string)
logd("camel 1=" . camel(\$slug));
logd("camel 2=" . camel(\$snake));
logd("camel 3=" . camel(\$camel));
logd("camel 4=" . camel(\$title));
output:
camel 1=aaa222BbbCccDdd  
camel 2=aaa222BbbCccDdd  
camel 3=aaa222BbbCccDdd  
camel 4=aaa222BbbCccDdd  

#### studly($string)
logd("studly 1=" . studly(\$slug));
logd("studly 2=" . studly(\$snake));
logd("studly 3=" . studly(\$camel));
logd("studly 4=" . studly(\$title));
output:
studly 1=Aaa222BbbCccDdd  
studly 2=Aaa222BbbCccDdd  
studly 3=Aaa222BbbCccDdd  
studly 4=Aaa222BbbCccDdd  

#### to_title($string)
For display
logd("to_title 1=" . to_title(\$slug));
logd("to_title 2=" . to_title(\$snake));
logd("to_title 3=" . to_title(\$camel));
logd("to_title 4=" . to_title(\$title));
output:
to_title 1=Aaa 222 Bbb Ccc Ddd  
to_title 2=Aaa 222 Bbb Ccc Ddd  
to_title 3=Aaa 222 Bbb Ccc Ddd  
to_title 4=Aaa 222 Bbb Ccc Ddd 


### Array
- gfa($_REQUEST, "default_value", "key");
Get value from array
\$_REQUEST["key"] is not set or empty, it will return "default_value";
gfa($_REQUEST, "default_value", "key1", "key2");
to get $_REQUEST["key1"]["key2"], and whatnot.

### Log
- logd("msg");
to write log in debug level

- varDump(\$obj, "title");
to var_dump(\$obj) in logger.
It supports Laravel Model, it will call $obj->toArray() for Laravel Model.

# File Helper
FileHelper::files(\$storageDiskName, \$folder, \$extFilter)
use Fa\IO\FileHelper;

\$files = FileHelper::files(\'log_dir_web\', \'\', \"log\");
varDump(\$files, 'files');

[2019-10-28 10:37:36] local.DEBUG: [test(WebFileManager:67)]	varDump; files=(type=array), count=8
- [0]=(type=string22), value=laravel-2019-09-25.log
- [1]=(type=string22), value=laravel-2019-10-08.log
- [2]=(type=string22), value=laravel-2019-10-14.log
- [3]=(type=string22), value=laravel-2019-10-17.log
- [4]=(type=string22), value=laravel-2019-10-21.log
- [5]=(type=string22), value=laravel-2019-10-24.log
- [6]=(type=string22), value=laravel-2019-10-25.log
- [7]=(type=string7), value=web.log  


# Fa Common API
### checkDatabase API (url: /api/app/chk_db)
- Add below code in routes/api.php
Route::get('app/chk_db','Api\AppApiController@checkDatabase');
Route::post('app/chk_db','Api\AppApiController@checkDatabase');

- Add below code in app/Http/Controller/Api/AppApiController.php
use Fa\Http\CmnApiHelper;

public function checkDatabase() {
    return CmnApiHelper::checkDatabase(\$request);
}

### heartbeat API (url: /api/app/heartbeat)
- Add below code in routes/api.php
Route::get(\'app/heartbeat\', \'Api\AppApiController@heartbeat');
Route::post('app/heartbeat', 'Api\AppApiController@heartbeat');

- Add below code in app/Http/Controller/Api/AppApiController.php
use Fa\Http\CmnApiHelper;

public function heartbeat(Request \$request) {
    return CmnApiHelper::heartbeat(\$request);
}
