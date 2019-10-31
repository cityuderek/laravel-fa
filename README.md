# laravel-fa
Laravel FA framework
Version 1.1.3

# Global Functions
- gfa($_REQUEST, "default_value", "key");
Get value from array
\$_REQUEST["key"] is not set or empty, it will return "default_value";
gfa($_REQUEST, "default_value", "key1", "key2");
to get $_REQUEST["key1"]["key2"], and whatnot

- logd("msg");
to write log in debug level

- varDump($obj, "title");
to var_dump($obj) in logger.
It supports Laravel Model, it will call $obj->toArray() for Laravel Model.

# File Helper
use Fa\IO\FileHelper;

$files = FileHelper::files('log_dir_web', '', "log");
varDump($files, 'files');

[2019-10-28 10:37:36] local.DEBUG: [test(WebFileManager:67)]	varDump; files=(type=array), count=8
- [0]=(type=string22), value=laravel-2019-09-25.log
- [1]=(type=string22), value=laravel-2019-10-08.log
- [2]=(type=string22), value=laravel-2019-10-14.log
- [3]=(type=string22), value=laravel-2019-10-17.log
- [4]=(type=string22), value=laravel-2019-10-21.log
- [5]=(type=string22), value=laravel-2019-10-24.log
- [6]=(type=string22), value=laravel-2019-10-25.log
- [7]=(type=string7), value=web.log  