<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("DEBUG",1);
define("MAINTENANCE", 0);
define("MAINTENANCEIP", "172.17.40.1731");
define("GONE", 0);
define("GONE_URL", "");
define("ROOT", dirname(__DIR__));
define("WWW", ROOT.'/public');
define("APP", ROOT.'/app');
define("CORE", ROOT.'/vendor/james.rus52/phpfrm/src');
define("LIBS", ROOT.'/vendor/james.rus52/phpfrm/src/libs');
define("CACHE", ROOT.'/tmp/cache');
define("CONF", ROOT.'/config');
define("LOGS", ROOT.'/logs');
define("WIDGETS", APP.'/widgets');
define("LAYOUT", 'default');
define("APPCLASSBASE", 'app');

$proto = (isset($_SERVER['HTTPS']) ? "https" : "http" );
$app_path = "{$proto}://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";

$app_path = preg_replace("/[^\/]+$/", "", $app_path);
$app_path = str_replace('/public/', '', $app_path);
define("BASEURL", $app_path);
define("ADMIN", BASEURL.'/admin');

require_once ROOT.'/vendor/autoload.php';
