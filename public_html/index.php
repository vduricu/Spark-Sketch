<?php

session_start();
error_reporting(E_ALL | E_STRICT);
//error_reporting(0);
date_default_timezone_set("Europe/Bucharest");

define("SPARK_SITE","sketch.spark-projekt.net");
define("SK_CODENAME","Tristan Tzara");
define("SK_VMAJOR",0);
define("SK_VMINOR",1);
define("SK_VBUILD",3);
define("SK_VERSION",SK_VMAJOR.'.'.SK_VMINOR.'.'.SK_VBUILD.'-'.strtolower(str_replace(" ","_",SK_CODENAME)));

function spkError($errno, $errmsg, $errfile, $errline){
	ob_clean();
	ob_end_clean();
	require_once("../scripts/spkError.php");
	die();
}
function masterRedirect($location){
	ob_clean();
	ob_end_clean();
	header("Location: {$location}");
	die();
}
function masterDie($message=''){
	echo $message;
	ob_end_flush();
	die();
}
set_error_handler("spkError",E_ALL);

ob_start();

require_once("../scripts/config.php");
require_once("../scripts/core.php");

@mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD) or trigger_error("I cannot make a connection with the database server!");
mysql_select_db(DB_DATABASE) or trigger_error("I cannot use the requested database!");

$core = new UCore();

$lang = $core->language();
require_once("../scripts/lang/{$lang}.php");

$page = $core->getPage();
require_once("../scripts/pages/{$page}.php");

ob_end_flush();
/*File: index.php*/
/*Date: 25.04.2011*/