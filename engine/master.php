<?php
ob_start();
error_reporting(E_ALL | E_STRICT);

define("SPK_BASEDIR",str_replace("\\","/",dirname(__FILE__).'/'));
ini_set('include_path', SPK_BASEDIR.PATH_SEPARATOR.ini_get('include_path'));

//We set the error reporting directive to report all errors or to not report anything
//error_reporting(0);

require_once("config.php");

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
	ob_start();
	ob_clean();
	ob_end_clean();
	require_once("spkError.php");
	die();
}

/**
 * Redirects the page to a different page.
 *
 * @param string $location
 * @return void
 */
function masterRedirect($location){
	ob_start();
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
	ob_start();
	echo $message;
	ob_end_flush();
	die();
}

//We attach the spkError function to the error handler of PHP
set_error_handler("spkError",E_ALL);

require_once("core/spk_lang.php");
require_once("core/spk_core.php");
require_once("core/xtend.class.php");

$spklang = new SPK_Lang(SK_DEFAULTLANGUAGE);

$_SQL = @mysql_connect(SDB_HOSTNAME,SDB_USERNAME,SDB_PASSWORD) or FALSE;
if(!$_SQL)
	trigger_error($spklang->langItem('dbConnectionError'));

$dbs = mysql_select_db(SDB_DATABASE,$_SQL);
if(!$dbs)
	trigger_error($spklang->langItem('dbDatabaseSelectError'));

$spkcore = new SPK_Core();

date_default_timezone_set($spkcore->getConfig('timezone'));

require_once("core/alias.function.php");

if(logged())
	$spklang->loadUserLang($spkcore->userinfo(loggedUserID(),'lang'));

//$plugins = unserialize($spkcore->getConfig('plugins'));
//if(count($plugins)>0){
//	foreach($plugins as $plugin)
//		if(file_exists(SPK_BASEDIR."plugins/{$plugin}/"))
//			require_once("plugins/{$plugin}/index.php");
//}
/*File: master.php*/
/*Date: 21.05.2011*/