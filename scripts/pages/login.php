<?php

if(count($_POST)==0)
	masterRedirect("/");

if(isset($_SESSION['sk_user'])){
	masterRedirect("/");
}

$clean = array();
$clean['username'] = filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING);
$clean['password'] = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);

if(empty($clean['username'])||empty($clean['password']))
	masterDie($language['emptyFields']);

$clean['password'] = $core->createPassword($clean['password']);

if(isset($_POST['ajax'])){
	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}' AND `activated`='no'");
	if(mysql_num_rows($q))
		masterDie($language['userNotActivated']);

	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}' AND `activated`='yes'");
	if(!mysql_num_rows($q))
		masterDie($language['userNotExists']);

	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}' AND `password`='{$clean['password']}' AND `activated`='yes'");
	if(!mysql_num_rows($q))
		masterDie($language['uApNotMatch']);

	echo "good";

}else{
	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}'");
	if(!mysql_num_rows($q))
		masterDie($language['userNotExists']);

	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}' AND `password`='{$clean['password']}'");
	if(!mysql_num_rows($q))
		masterDie($language['uApNotMatch']);

	$r = mysql_fetch_assoc($q);
	$_SESSION['sk_user'] = $r['id'];
	masterRedirect("/");
}

/*File: login.php*/
/*Date: 25.04.2011*/