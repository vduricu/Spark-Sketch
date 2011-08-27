<?php
session_start();

require_once('engine/master.php');

$spkcore->appendClass("isMobile");

/**
 * Used to connect to the language class.
 *
 * @var isMobile $isMobile
 */
$isMobile = $spkcore->getClass('isMobile');
if($isMobile->isMobile()){
	$spkcore->appendClass("mobile");
	$mobile = $spkcore->getClass("mobile");
	require_once('mobile/default.php');
}else{
	$spkcore->appendClass("template");
	require_once('template/default.php');
}

ob_end_flush();
/*File: index.php*/
/*Date: 16.06.2011*/
