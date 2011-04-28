<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}

$clean = array();
$clean['name'] = filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING);
$clean['type'] = filter_input(INPUT_POST,"type",FILTER_SANITIZE_STRING);
$clean['bkcolor'] = filter_input(INPUT_POST,"background",FILTER_SANITIZE_STRING);
$clean['width'] = filter_input(INPUT_POST,"width",FILTER_SANITIZE_NUMBER_INT);
$clean['height'] = filter_input(INPUT_POST,"height",FILTER_SANITIZE_NUMBER_INT);
$clean['data'] = filter_input(INPUT_POST,"data",FILTER_SANITIZE_STRING);

if(empty($clean['data']))
	masterDie($language['imageEmpty']);
if(empty($clean['name']))
	masterDie($language['nameEmpty']);

if(empty($clean['width'])||empty($clean['height']))
	masterDie($language['sizeEmpty']);

$data = base64_decode(substr($clean['data'],strpos($clean['data'],",")+1));
$img_uri = imagecreatefromstring($data);

if($clean['type']=='new'){
	$img = imagecreatetruecolor($clean['width'],$clean['height']);
	$background = $core->colorGen($clean['bkcolor'],$img);
	imagefill($img,0,0,$background);

	$zName = $core->randomName(12);
	$file = "../files/{$zName}.png";
	while(file_exists($file)){
		$zName = $core->randomName(12);
		$file = "files/{$zName}.png";
	}
	$core->imagecopymerge_alpha($img, $img_uri, 0, 0, 0, 0, $clean['width'], $clean['width'], 100);

	$curdate = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO `draws` (`id`,`userid`,`title`,`filename`,`creationdate`,`modificationdate`) VALUES (NULL,'{$_SESSION['sk_user']}','{$clean['name']}','{$zName}','{$curdate}','{$curdate}');");
	echo "good|".$zName.'|';
}else{
	$clean['imgId'] = filter_input(INPUT_POST,"imgid",FILTER_SANITIZE_NUMBER_INT);
	$q = mysql_query("SELECT * FROM `draws` WHERE `id`='{$clean['imgId']}'");
	if(!mysql_num_rows($q))
		masterDie($language['imageNotExists']);
	$img = $img_uri;
	$file = "files/{$r['filename']}.png";

	//$curdate = date("Y-m-d H:i:s");
	//mysql_query("UPDATE `draws`");
}

imagepng($img,$file);
if(isset($background)) imagecolordeallocate($img,$background);
imagedestroy($img_uri);
imagedestroy($img);
echo $language['imageSaved'];
//unlink("../tmp/{$clean['name']}.png");

/*File: save.php*/
/*Date: 26.04.2011*/