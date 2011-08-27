<?php
session_start();
require_once('engine/master.php');

if(!isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/"));
}

$clean = array();
$clean['filename'] = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);

if(empty($clean['filename']))
	masterDie(langItem("noFilename"));

$sql = "SELECT * FROM `draws` WHERE `filename`='{$clean['filename']}'";

if(getElementByID('user',$_SESSION['sk_user'],'rank')!='admin'&&getElementByID('user',$_SESSION['sk_user'],'rank')!='moderator')
	$sql .= " AND `userid`='{$_SESSION['sk_user']}'";

$q = mysql_query($sql);
if(!mysql_num_rows($q))
	masterDie(langItem("imageNotExists"));

$drawid = getIDByElement('draws','filename',$clean['filename']);
@mysql_query("DELETE FROM `discuss` WHERE `drawid`='{$drawid}'");
mysql_query("DELETE FROM `draws` WHERE `filename`='{$clean['filename']}' LIMIT 1");
unlink("files/{$clean['filename']}.png");
masterRedirect($spkcore->createURL("/page/gallery"));
/*File: delete.php*/
/*Date: 02.07.2011*/