<?php
session_start();
require_once('engine/master.php');

if(isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/404"));
}
if(isset($_SESSION['invitedby'])){
	unset($_SESSION['invitedby']);
}

if(count($_POST)==0)
	masterRedirect($spkcore->createURL("/404"));

$clean = array();
$clean['username'] = filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING);
$clean['password'] = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);

if(empty($clean['username'])||empty($clean['password']))
	masterDie(langItem("emptyFields"));

$clean['password'] = $spkcore->createPassword($clean['password']);

if(isset($_POST['ajax'])){
	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}'");
	if(!mysql_num_rows($q))
		masterDie(langItem("userNotExists"));

	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}' AND `activated`='no'");
	if(mysql_num_rows($q))
		masterDie(langItem("userNotActivated"));

	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}' AND `password`='{$clean['password']}' AND `activated`='yes'");
	if(!mysql_num_rows($q))
		masterDie(langItem("upNotMatch"));

	echo "good";

}else{
	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}'");
	if(!mysql_num_rows($q))
		masterDie(langItem("userNotExists"));

	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}' AND `password`='{$clean['password']}'");
	if(!mysql_num_rows($q))
		masterDie(langItem("upNotMatch"));

	$r = mysql_fetch_row($q);
	$_SESSION['sk_user'] = $r[0];
	masterRedirect($spkcore->createURL('/'));
}

/*File: login.php*/
/*Date: 16.06.2011*/