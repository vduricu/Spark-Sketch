<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}
if($core->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
	masterRedirect("/404");

$clean = array();
$clean['user'] = filter_input(INPUT_POST,"user",FILTER_SANITIZE_STRING);

if(empty($clean['user']))
	masterDie($language['userNotExists']);

$sql = "SELECT * FROM `user` WHERE `user`='{$clean['user']}'";

if($core->IDByField('user','user',$clean['user'])==1)
	masterDie($language['userNotExists']);

$q = mysql_query($sql);
if(!mysql_num_rows($q))
	masterDie($language['userNotExists']);

$clean['id'] = $core->IDByField("user","user",$clean['user']);
$q = mysql_query("SELECT * FROM `draws` WHERE `userid`='{$clean['id']}'");
if(mysql_num_rows($q))
	while($r = mysql_fetch_assoc($q)){
		unlink("../files/{$r['filename']}.png");
		mysql_query("DELETE FROM `draws` WHERE `filename`='{$r['filename']}' LIMIT 1");
	}

mysql_query("DELETE FROM `user` WHERE `user`='{$clean['user']}' LIMIT 1");
masterDie("good");

/*File: save.php*/
/*Date: 26.04.2011*/