<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}

$clean = array();
$clean['lang'] = filter_input(INPUT_POST,"lang",FILTER_SANITIZE_STRING);
$clean['timezone'] = filter_input(INPUT_POST,"timezone",FILTER_SANITIZE_STRING);
$clean['site_name'] = filter_input(INPUT_POST,"siteName",FILTER_SANITIZE_STRING);

if(empty($clean['lang'])||empty($clean['timezone'])){
	$_SESSION['error'] = $language['emptyFields'];
	masterRedirect($core->createURL("/settings"));
}

mysql_query("UPDATE `config` SET `value`='{$clean['lang']}' WHERE `name`='default_language'");
mysql_query("UPDATE `config` SET `value`='{$clean['timezone']}' WHERE `name`='timezone'");
mysql_query("UPDATE `config` SET `value`='{$clean['site_name']}' WHERE `name`='site_name'");

if(mysql_error()){
	$_SESSION['error'] = "SQL";
	masterRedirect($core->createURL("/settings"));
}

masterRedirect($core->createURL("/settings"));
break;

/*File: gsettings.php*/
/*Date: 26.04.2011*/