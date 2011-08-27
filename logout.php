<?php
session_start();
require_once('engine/master.php');

if(!isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/"));
}

unset($_SESSION['sk_user']);
masterRedirect($spkcore->createURL("/"));

/*File: logout.php*/
/*Date: 25.04.2011*/