<?php

session_start();
require_once('../engine/master.php');
if(!logged())
	masterRedirect($spkcore->createURL("/404"));

if(!isset($_POST['sentForm'])){
	$image = filter_input(INPUT_GET,"photo",FILTER_SANITIZE_STRING);

	if(empty($image))
		masterDie(langItem("emptyFields"));

	require_once('pagini/ui/report.php');
	masterDie();
}
$image = filter_input(INPUT_POST,"image",FILTER_SANITIZE_STRING);
$reason = filter_input(INPUT_POST,"reason",FILTER_SANITIZE_STRING);
$userid = loggedUserID();
$data = date("Y-m-d H:i:s");

if(empty($image)||empty($reason)||empty($userid))
	masterDie("error|".langItem("emptyFields"));

$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$image}'");

if(!mysql_num_rows($q))
	masterDie("error|".langItem("imageNotExists"));

mysql_query("UPDATE `draws` SET `status`='reported',`reason`='{$reason}',`reportData`='{$data}',`reportedby`='{$userid}' WHERE `filename`='{$image}'");

if(mysql_error())
	masterDie("error|SQL");

masterDie("good|".langItem("imageReported"));

