<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title><?=$core->pageTitle()?> / <?=$core->getConfig("site_name")?></title>
	<? require_once("tpl/header.php");?>
</head>
<body>
<? if(!isset($_SESSION['sk_user']))
	require_once("tpl/menu_unreg.php");
else
	require_once("tpl/menu_logged.php");
?>