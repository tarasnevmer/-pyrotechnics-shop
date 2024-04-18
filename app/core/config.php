<?php 

define('WEBSITE_TITLE', "Pyrotehnic");

define('DB_TYPE','mysql');
define('DB_NAME','webstore');
define('DB_USER','root');
define('DB_PASS','');
define('DB_HOST','localhost');

define('ADMIN_PASSWORD_1', 'store123');
define('ADMIN_USER_1', 'admin1');

define('ADMIN_PASSWORD_2', 'admin');
define('ADMIN_USER_2', 'admin');

define('PROTOCAL','http');


$path = str_replace("\\", "/",PROTOCAL ."://" . $_SERVER['SERVER_NAME'] . __DIR__  . "/");
$path = str_replace($_SERVER['DOCUMENT_ROOT'], "", $path);

define('ROOT', str_replace("app/core", "public", $path));
define('ASSETS', str_replace("app/core", "public/assets", $path));


define('DEBUG',true);
