<?php
session_start();

//include only that one, rest required files will be included from it
include "engine/master.php";
$item = filter_input(INPUT_GET,"m",FILTER_SANITIZE_STRING);
if(empty($item))
	masterDie(langItem("itemNotExists"));

//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
/*if(!file_exists("qrtemp/{$item}.png")){

	QRcode::png("http://{$_SERVER['HTTP_HOST']}".$spkcore->createURL("/gallery/{$item}"), "qrtemp/{$item}.png", 'H',2,2);
}*/

include "qr/phpqrcode.php";
QRcode::png("http://{$_SERVER['HTTP_HOST']}".$spkcore->createURL("/gallery/{$item}"));