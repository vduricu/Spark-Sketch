<?php

//We start the session before anything else.
session_start();

//We set the error reporting directive to report all errors or to not report anything
error_reporting(E_ALL | E_STRICT);
//error_reporting(0);

//We set the default timezone for our script
date_default_timezone_set("Europe/Bucharest");

//We define the website address.
define("SPARK_SITE","sketch.spark-projekt.net");

//Do not change anything beyond this point
define("SK_CODENAME","Tristan Tzara");
define("SK_VMAJOR",0);
define("SK_VMINOR",1);
define("SK_VBUILD",4);
define("SK_VERSION",SK_VMAJOR.'.'.SK_VMINOR.'.'.SK_VBUILD.'-'.strtolower(str_replace(" ","_",SK_CODENAME)));

/**
 * Generates the error page.
 *
 * @param int $errno
 * @param string $errmsg
 * @param string $errfile
 * @param int $errline
 * @return void
 */
function spkError($errno, $errmsg, $errfile, $errline){
	ob_clean();
	ob_end_clean();
	require_once("../scripts/spkError.php");
	die();
}

/**
 * Redirects the page to a different page.
 *
 * @param string $location
 * @return void
 */
function masterRedirect($location){
	ob_clean();
	ob_end_clean();
	header("Location: {$location}");
	die();
}

/**
 * Ends the current script.
 *
 * @param string $message
 * @return
 */
function masterDie($message=''){
	echo $message;
	ob_end_flush();
	die();
}

//We attach the spkError function to the error handler of PHP
set_error_handler("spkError",E_ALL);

//We start the output buffer
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