<?php
session_start();
require_once('engine/master.php');

if(isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/404"));
}

if(!isset($_GET['u'])){
	masterRedirect($spkcore->createURL("/"));
}

$user = filter_input(INPUT_GET,"u",FILTER_SANITIZE_STRING);
$_SESSION['invitedby'] = getIDByElement("user","user",$user);
if(!is_numeric($_SESSION['invitedby']))
	unset($_SESSION['invitedby']);

/*
print_r($_SESSION);
print_r($user);
masterDie();
   */

masterRedirect($spkcore->createURL("/page/register"));

/*File: invitation.php*/
/*Date: 07.07.2011*/