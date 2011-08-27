<?php
session_start();
require_once('../engine/master.php');
ob_end_clean();

if(!isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/"));
}

$tool = filter_input(INPUT_GET,"item",FILTER_SANITIZE_STRING);

if(!isset($tool))
	masterDie(langItem("itemNotExists"));
else
	require_once("proper/{$tool}.php");
