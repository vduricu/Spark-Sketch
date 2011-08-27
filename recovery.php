<?php
session_start();
require_once('engine/master.php');

if(isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/404"));
}

if(count($_POST)==0)
	masterRedirect($spkcore->createURL("/404"));

$clean = array();
$clean['username'] = filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING);
$clean['email'] = filter_var(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL);

if(empty($clean['email'])||empty($clean['username']))
	masterDie(langItem("emptyFields"));

if(!$clean['email'])
	masterDie(langItem("invalidEmail"));

if(isset($_POST['ajax'])){
	$q = mysql_query("SELECT * FROM `user` WHERE `email`='{$clean['email']}' AND `user`='{$clean['username']}'");
	if(!mysql_num_rows($q))
		masterDie(langItem("emailNotExists"));

	$r = mysql_fetch_assoc($q);
	if($r['id']==1||$r['id']==0)
		masterDie(langItem("emailNotExists"));

	echo "good";

}else{
	$q = mysql_query("SELECT * FROM `user` WHERE `email`='{$clean['email']}' AND `user`='{$clean['username']}'");
	if(!mysql_num_rows($q))
		masterDie(langItem("emailNotExists"));

	$r = mysql_fetch_assoc($q);
	if($r['id']==1||$r['id']==0)
		masterDie(langItem("emailNotExists"));

	@header("Refresh: 5; url={$spkcore->createURL('/')}");
	$pass = $spkcore->randomName(6);
	$newPass = $spkcore->createPassword($pass);
	mysql_query("UPDATE `user` SET `password`='{$newPass}' WHERE `email`='{$clean['email']}'");

	@mail($clean['email'],langItem("recEmailSubject"),sprintf(langItem("recEmailMsg"),$clean['username'],$pass),"FROM: Sketch Daemon<sketch@duricu.ro>");

	___("newPassSent");
	echo nl2br(sprintf(langItem("beRedirected"),5));
	echo nl2br(sprintf(langItem("redirectNotice"),5,$spkcore->createURL("/")));

}

/*File: login.php*/
/*Date: 16.06.2011*/