# laravel-fa
Laravel FA framework

Version 1.1.3

- gfa($_REQUEST, "default_value", "key");
Get value from array
$_REQUEST["key"] is not set or empty, it will return "default_value";

gfa($_REQUEST, "default_value", "key1", "key2");
to get $_REQUEST["key1"]["key2"], and whatnot

- logd("msg");
to write log in debug level

- varDump($obj, "title");
to var_dump($obj) in logger.
It supports Laravel Model, it will call $obj->toArray() for Laravel Model.