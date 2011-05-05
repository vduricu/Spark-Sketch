<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}

$clean = array();
$clean['lang'] = filter_input(INPUT_POST,"lang",FILTER_SANITIZE_STRING);
$clean['timezone'] = filter_input(INPUT_POST,"timezone",FILTER_SANITIZE_STRING);

if(empty($clean['lang'])||empty($clean['timezone'])){
	$_SESSION['error'] = $language['emptyFields'];
	masterRedirect("/settings");
}

mysql_query("UPDATE `config` SET `value`='{$clean['lang']}' WHERE `name`='default_language'");
mysql_query("UPDATE `config` SET `value`='{$clean['timezone']}' WHERE `name`='timezone'");

if(mysql_error()){
	$_SESSION['error'] = "SQL";
	masterRedirect("/settings");
}

masterRedirect("/settings");
break;

/*File: gsettings.php*/
/*Date: 26.04.2011*/