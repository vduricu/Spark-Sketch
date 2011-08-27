<?php
session_start();
require_once('engine/master.php');


if(isset($_POST['ajax'])):

$clean = array();
$clean['type'] = filter_input(INPUT_POST,"type",FILTER_SANITIZE_STRING);

if($clean['type']!='demo')
	if(!isset($_SESSION['sk_user'])){
		masterRedirect($spkcore->createURL("/"));
	}

$clean['name'] = filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING);
$clean['bkcolor'] = filter_input(INPUT_POST,"background",FILTER_SANITIZE_STRING);
$clean['width'] = filter_input(INPUT_POST,"width",FILTER_SANITIZE_NUMBER_INT);
$clean['height'] = filter_input(INPUT_POST,"height",FILTER_SANITIZE_NUMBER_INT);
$clean['data'] = filter_input(INPUT_POST,"data",FILTER_SANITIZE_STRING);

if(empty($clean['data']))
	masterDie("error|".langItem("imageNotSent"));
if(empty($clean['name']))
	masterDie("error|".langItem("imageNoTitle"));

if(empty($clean['width'])||empty($clean['height']))
	masterDie("error|".langItem("imageSize"));

$data = base64_decode(substr($clean['data'],strpos($clean['data'],",")+1));
$img_uri = imagecreatefromstring($data);

$zName = '';

if($clean['type']=='new'){
	$img = imagecreatetruecolor($clean['width'],$clean['height']);
	$background = $spkcore->colorGen($clean['bkcolor'],$img);
	imagefill($img,0,0,$background);

	$zName = $spkcore->randomName(12);
	$file = "files/{$zName}.png";
	while(file_exists($file)){
		$zName = $spkcore->randomName(12);
		$file = "files/{$zName}.png";
	}
	$spkcore->imagecopymerge_alpha($img, $img_uri, 0, 0, 0, 0, $clean['width'], $clean['width'], 100);

	$curdate = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO `draws` (`id`,`userid`,`title`,`filename`,`creationdate`,`modificationdate`) VALUES (NULL,'{$_SESSION['sk_user']}','{$clean['name']}','{$zName}','{$curdate}','{$curdate}');");
	echo "good|".$zName;
}elseif($clean['type']=='edit'){
	$zName = $clean['filename'] = filter_input(INPUT_POST,"filename",FILTER_SANITIZE_STRING);
	$userid = loggedUserID();
	$sql = "SELECT * FROM `draws` WHERE `filename`='{$clean['filename']}'";

	if(loggedUserRank()!='admin'&&loggedUserRank()!='moderator')
		$sql .= "AND `userid`='{$userid}'";

	$q = mysql_query($sql);

	if(!mysql_num_rows($q))
		masterDie("error|".langItem("imageNotExists"));

	$file = "files/{$clean['filename']}.png";

	$img = imagecreatetruecolor($clean['width'],$clean['height']);
	$background = $spkcore->colorGen($clean['bkcolor'],$img);
	imagefill($img,0,0,$background);

	$spkcore->imagecopymerge_alpha($img, $img_uri, 0, 0, 0, 0, $clean['width'], $clean['width'], 100);
	$curdate = date("Y-m-d H:i:s");

	mysql_query("UPDATE `draws` SET `title`='{$clean['name']}', `modificationdate`='{$curdate}' WHERE `filename`='{$clean['filename']}';");

	echo "good|".$clean['filename'];
	//$curdate = date("Y-m-d H:i:s");
	//mysql_query("UPDATE `draws`");
}elseif($clean['type']=='demo'){
	$img = imagecreatetruecolor($clean['width'],$clean['height']);
	$background = $spkcore->colorGen($clean['bkcolor'],$img);
	imagefill($img,0,0,$background);

	$zName = $spkcore->randomName(12);
	$file = "files/{$zName}.png";
	while(file_exists($file)){
		$zName = $spkcore->randomName(12);
		$file = "files/{$zName}.png";
	}
	$spkcore->imagecopymerge_alpha($img, $img_uri, 0, 0, 0, 0, $clean['width'], $clean['width'], 100);

	$curdate = date("Y-m-d H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];

	$status = getConfig('demo_save');
	mysql_query("INSERT INTO `draws` (`id`,`userid`,`title`,`filename`,`creationdate`,`modificationdate`,`status`,`ip`) VALUES (NULL,'0','{$clean['name']}','{$zName}','{$curdate}','{$curdate}','{$status}','{$ip}');");
	echo "good|".$zName;
}

imagepng($img,$file);
if(isset($background)) imagecolordeallocate($img,$background);
imagedestroy($img_uri);
imagedestroy($img);

$spkcore->createThumbnail($zName);
//echo $language['imageSaved'];
//unlink("../tmp/{$clean['name']}.png");

endif;

/*File: save.php*/
/*Date: 02.07.2011*/