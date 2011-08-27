<?php
session_start();
require_once('engine/master.php');

if(isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/404"));
}

if(!isset($_GET['code']))
	masterRedirect($spkcore->createURL("/404"));

$clean = array();
$clean['code'] = filter_input(INPUT_GET,"code",FILTER_SANITIZE_STRING);

@header("Refresh: 5; url={$spkcore->createURL('/')}");

$q = mysql_query("SELECT * FROM `user` WHERE `activation_code`='{$clean['code']}'");
if(mysql_num_rows($q)){
	$r = mysql_fetch_assoc($q);
	mysql_query("UPDATE `user` SET `activated`='yes', `activation_code`=NULL WHERE `id`='{$r['id']}'");
	___("accountActivated");
}
else
	___("accountNE");

echo nl2br(sprintf(langItem("beRedirected"),5));
echo nl2br(sprintf(langItem("redirectNotice"),5,$spkcore->createURL("/")));
ob_end_flush();

/*File: activate.php*/
/*Date: 07.07.2011*/