<?php
session_start();
require_once('engine/master.php');

if(!isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/"));
}

$clean = array();
$clean['type'] = filter_input(INPUT_POST,"type",FILTER_SANITIZE_STRING);

switch($clean['type']){
	case 'infoChange':
		$clean['firstname'] = filter_input(INPUT_POST,"firstname",FILTER_SANITIZE_STRING);
		$clean['lastname'] = filter_input(INPUT_POST,"lastname",FILTER_SANITIZE_STRING);
		$clean['lang'] = filter_input(INPUT_POST,"lang",FILTER_SANITIZE_STRING);
		$clean['email'] = filter_var(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL);
		$clean['id'] = $_SESSION['sk_user'];

		if(empty($clean['firstname'])||empty($clean['lastname'])||empty($clean['lang']))
			masterDie("error|".langItem("emptyFields"));
		if(empty($clean['id']))
			masterDie("error|".langItem("IDnotsent"));

		$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$clean['id']}'");
		if(mysql_error())
			masterDie("error|SQL");
		if(!mysql_num_rows($q))
			masterDie("error|".langItem("userNotExists"));
		if(!$clean['email'])
			masterDie("error|".langItem("invalidEmail"));

		mysql_query("UPDATE `user` SET `firstname`='{$clean['firstname']}',`lastname`='{$clean['lastname']}',`lang`='{$clean['lang']}' WHERE `id`='{$clean['id']}'");

		if(mysql_error())
			masterDie("error|SQL");

		if(getElementByID('user',loggedUserID(),'lang')!=$clean['lang'])
			masterDie("refresh|Success");

		masterDie("good|Success");
		break;
	case 'passChange':
		$clean['cpassword'] = filter_input(INPUT_POST,"cpassword",FILTER_SANITIZE_STRING);
		$clean['password'] = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);
		$clean['confirm'] = filter_input(INPUT_POST,"confirm",FILTER_SANITIZE_STRING);
		$clean['id'] = $_SESSION['sk_user'];

		if(empty($clean['password'])||empty($clean['confirm'])||empty($clean['cpassword']))
			masterDie("error|".langItem("emptyFields"));
		if(empty($clean['id']))
			masterDie("error|".langItem("IDnotsent"));

		if($clean['password']!=$clean['confirm'])
			masterDie("error|".langItem("passwordsNotMatch"));

		if(strlen($clean['password'])<6)
			masterDie("error|".sprintf(langItem("passwordShort"),6));

		$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$clean['id']}'");
		if(mysql_error())
			masterDie("error|SQL");
		if(!mysql_num_rows($q))
			masterDie("error|".langItem("userNotExists"));

		$cpass = $spkcore->createPassword($clean['cpassword']);

		$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$clean['id']}' AND `password`='{$cpass}'");
		if(mysql_error())
			masterDie("error|SQL");
		if(!mysql_num_rows($q))
			masterDie("error|".langItem("upNotMatch"));

		$pass = $spkcore->createPassword($clean['password']);
		mysql_query("UPDATE `user` SET `password`='{$pass}' WHERE `id`='{$clean['id']}'");

		if(mysql_error())
			masterDie("error|SQL");

		masterDie("good|Success");
		break;
	case 'deleteAccount':
		$clean['accept'] = filter_input(INPUT_POST,"accept",FILTER_SANITIZE_STRING);
		$clean['id'] = $_SESSION['sk_user'];

		if(empty($clean['accept']))
			masterDie("error|".langItem("emptyFields"));
		if(empty($clean['id']))
			masterDie("error|".langItem("IDnotsent"));

		if($clean['accept']=='false')
			masterDie("error|".langItem("deleteConfirm"));

		$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$clean['id']}'");
		if(mysql_error())
			masterDie("error|SQL");
		if(!mysql_num_rows($q))
			masterDie("error|".langItem("userNotExists"));

		if($clean['id']!=1){
			$q = mysql_query("SELECT * FROM `draws` WHERE `userid`='{$clean['id']}'");

			while($r = mysql_fetch_assoc($q)){
				unlink("files/{$r['filename']}.png");
				mysql_query("DELETE FROM `draws` WHERE `filename`='{$r['filename']}' LIMIT 1");
			}
			mysql_query("DELETE FROM `discuss` WHERE `userid`='{$clean['id']}';");
			mysql_query("DELETE FROM `user` WHERE `id`='{$clean['id']}' LIMIT 1;");
		}
		if(mysql_error())
			masterDie("error|SQL");
		unset($_SESSION['sk_user']);
		masterDie("good|Success");
		break;
	default:
		masterDie("error|".langItem("restrictedZone"));
}
//masterRedirect($spkcore->createURL("/page/gallery"));
/*File: change.php*/
/*Date: 03.07.2011*/