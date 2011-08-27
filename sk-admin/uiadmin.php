<?php

session_start();
require_once('../engine/master.php');
if(!logged())
	masterRedirect($spkcore->createURL("/404"));
if(loggedUserRank()!='admin'&&loggedUserRank()!='moderator')
	masterRedirect($spkcore->createURL("/404"));

$zona = filter_input(INPUT_GET,"zona",FILTER_SANITIZE_STRING);

switch($zona){
	case 'user':
		$user = filter_input(INPUT_GET,"user",FILTER_SANITIZE_STRING);
		$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$user}'");
		if(!mysql_num_rows($q))
			masterDie("Nu exista utilizatorul cerut!");
		$r = mysql_fetch_assoc($q);
		require_once('pagini/ui/userdata.php');
		break;
	case 'draws':
		$page = filter_input(INPUT_GET,"item",FILTER_SANITIZE_STRING);
		$draw = filter_input(INPUT_GET,"draw",FILTER_SANITIZE_STRING);

		$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$draw}'");
		if(!mysql_num_rows($q))
			masterDie("Nu exista desenul cerut!");

		$r = mysql_fetch_assoc($q);
		require_once("pagini/ui/draw_{$page}.php");

		break;

	case 'discuss':
		$page = filter_input(INPUT_GET,"item",FILTER_SANITIZE_STRING);
		$id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);

		$q = mysql_query("SELECT * FROM `discuss` WHERE `id`='{$id}'");
		if(!mysql_num_rows($q))
			masterDie("Nu exista mesajul cerut!");

		$r = mysql_fetch_assoc($q);
		require_once("pagini/ui/discuss_{$page}.php");

		break;

}
