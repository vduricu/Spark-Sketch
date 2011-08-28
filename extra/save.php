<?php
session_start();
require_once('../engine/master.php');

if(!isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/"));
}

if(isset($_POST['ajax'])):

$clean = array();
$clean['type'] = filter_input(INPUT_POST,"type",FILTER_SANITIZE_STRING);
$clean['name'] = filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING);
$clean['bkcolor'] = filter_input(INPUT_POST,"background",FILTER_SANITIZE_STRING);
$clean['width'] = filter_input(INPUT_POST,"width",FILTER_SANITIZE_NUMBER_INT);
$clean['height'] = filter_input(INPUT_POST,"height",FILTER_SANITIZE_NUMBER_INT);
$clean['data'] = filter_input(INPUT_POST,"data",FILTER_SANITIZE_STRING);

if(empty($clean['data']))
	masterDie("error|".langItem("imageNotSent"));

if(empty($clean['bkcolor']))
	masterDie("error|".langItem("emptyFields"));

if(empty($clean['name']))
	masterDie("error|".langItem("imageNoTitle"));

if(empty($clean['width'])||empty($clean['height']))
	masterDie("error|".langItem("imageSize"));

$data = base64_decode(substr($clean['data'],strpos($clean['data'],",")+1));
$zName = '';

if($clean['type']=='new'){
	$zName = $spkcore->randomName(12);
	$file = "../files/{$zName}.png";
	while(file_exists($file)){
		$zName = $spkcore->randomName(12);
		$file = "../files/{$zName}.png";
	}

	if($clean['bkcolor']=='transparent')
		$clean['bkcolor'] = "none";

	$curdate = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO `draws` (`id`,`userid`,`title`,`filename`,`creationdate`,`modificationdate`,`type`,`width`,`height`,`bkgcolor`) VALUES (NULL,'{$_SESSION['sk_user']}','{$clean['name']}','{$zName}','{$curdate}','{$curdate}','extended','{$clean['width']}','{$clean['height']}','{$clean['bkcolor']}');");
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

	$file = "../files/{$clean['filename']}.png";
	$curdate = date("Y-m-d H:i:s");

	if($clean['bkcolor']=='transparent')
		$clean['bkcolor'] = "none";

	mysql_query("UPDATE `draws` SET `title`='{$clean['name']}', `modificationdate`='{$curdate}', `bkgcolor`='{$clean['bkcolor']}' WHERE `filename`='{$clean['filename']}';");
	echo "good|".$clean['filename'];
}

file_put_contents($file,$data);

$img = imagecreatefromstring($data);
$width = $clean['width'];
$height = $clean['height'];

if($clean['bkcolor']=='axis'){
	$img_t = imagecreatefrompng('axis.png');

	$img_temp = imagecreatetruecolor($width, $height);
	$background = $spkcore->colorGen("#ffffff",$img_temp);
	imagefill($img_temp,0,0,$background);

	$spkcore->imagecopymerge_alpha($img_temp, $img_t, 0, 0, 1250-$width/2, 1250-$height/2, $width, $height, 100);
	$spkcore->imagecopymerge_alpha($img_temp, $img, 0, 0, 0, 0, $width, $height, 100);

	$img = $img_temp;
	imagepng($img_temp,"../temp/{$zName}.png");
	//imagedestroy($img_t);
}elseif($clean['bkcolor']!='none'){
	$img_temp = imagecreatetruecolor($width,$height);

	$background = $spkcore->colorGen($clean['bkcolor'],$img_temp);
	imagefill($img_temp,0,0,$background);
	$spkcore->imagecopymerge_alpha($img_temp, $img, 0, 0, 0, 0, $width, $height, 100);

	imagepng($img_temp,"../temp/{$zName}.png");
	if(isset($background)) imagecolordeallocate($img_temp,$background);

	$img = $img_temp;
}else{
	imagealphablending($img,true);
	imagesavealpha($img,true);
}

$thumbWidth = 200;

// calculate thumbnail size
if($width > $height){
	$new_width = $thumbWidth;
	$new_height = floor($height * ($thumbWidth / $width ));
}else{
	$thumbWidth = 136;
	$new_width = floor($width * ($thumbWidth / $height ));
	$new_height = $thumbWidth;
}

// create a new temporary image
$tmp_img = imagecreatetruecolor($new_width, $new_height);

ImageAlphaBlending($tmp_img,false);
ImageSaveAlpha($tmp_img,true);

// copy and resize old image into new image
imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

// save thumbnail into a file
imagepng($tmp_img,"../thumb/{$zName}.png");

if(isset($img_temp))
	imagedestroy($img_temp);
else
	imagedestroy($img);

endif;

/*File: save.php*/
/*Date: 02.07.2011*/