<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}

$clean = array();
$clean['filename'] = filter_input(INPUT_POST,"filename",FILTER_SANITIZE_STRING);

if(empty($clean['filename']))
	masterDie($language['fileEmpty']);

$sql = "SELECT * FROM `draws` WHERE `filename`='{$clean['filename']}'";

if($core->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
	$sql .= " AND `userid`='{$_SESSION['sk_user']}'";

$q = mysql_query($sql);
if(!mysql_num_rows($q))
	masterDie($language['imageNotExists']);

mysql_query("DELETE FROM `draws` WHERE `filename`='{$clean['filename']}' LIMIT 1");
unlink("../files/{$clean['filename']}.png");

/*File: save.php*/
/*Date: 26.04.2011*/