<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}
if($core->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
	masterRedirect("/404");

$clean = array();
$clean['user'] = filter_input(INPUT_POST,"user",FILTER_SANITIZE_STRING);
$clean['activated'] = filter_input(INPUT_POST,"activate",FILTER_SANITIZE_STRING);

if(empty($clean['user'])||empty($clean['activated']))
	masterDie($language['emptyFields']);

$sql = "SELECT * FROM `user` WHERE `user`='{$clean['user']}'";

if($core->IDByField('user','user',$clean['user'])==1)
	masterDie($language['userNotExists']);

$q = mysql_query($sql);
if(!mysql_num_rows($q))
	masterDie($language['userNotExists']);

if($clean['activated']=='yes')
	$act = 'no';
else
	$act = 'yes';

mysql_query("UPDATE `user` SET `activated`='{$act}',`activation_code`=NULL WHERE `user`='{$clean['user']}' LIMIT 1");
masterDie("good");

/*File: save.php*/
/*Date: 26.04.2011*/