<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}

$clean = array();
$clean['type'] = filter_input(INPUT_POST,"type",FILTER_SANITIZE_STRING);

switch($clean['type']){
	case 'infoChange':
		$clean['firstname'] = filter_input(INPUT_POST,"firstname",FILTER_SANITIZE_STRING);
		$clean['lastname'] = filter_input(INPUT_POST,"lastname",FILTER_SANITIZE_STRING);
		$clean['lang'] = filter_input(INPUT_POST,"lang",FILTER_SANITIZE_STRING);
		$clean['id'] = $_SESSION['sk_user'];

		if(empty($clean['firstname'])||empty($clean['lastname'])||empty($clean['lang']))
			masterDie("error|{$language['emptyFields']}");
		if(empty($clean['id']))
			masterDie("error|{$language['idEmpty']}");

		$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$clean['id']}'");
		if(mysql_error())
			masterDie("error|SQL");
		if(!mysql_num_rows($q))
			masterDie("error|{$language['userNotExists']}");

		mysql_query("UPDATE `user` SET `firstname`='{$clean['firstname']}',`lastname`='{$clean['lastname']}',`lang`='{$clean['lang']}' WHERE `id`='{$clean['id']}'");

		if(mysql_error())
			masterDie("error|SQL");

		if($lang!=$clean['lang'])
			masterDie("refresh|{$language['changeGood']}");

		masterDie("good|{$language['changeGood']}");
		break;
	case 'passChange':
		$clean['cpassword'] = filter_input(INPUT_POST,"cpassword",FILTER_SANITIZE_STRING);
		$clean['password'] = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);
		$clean['confirm'] = filter_input(INPUT_POST,"confirm",FILTER_SANITIZE_STRING);
		$clean['id'] = $_SESSION['sk_user'];

		if(empty($clean['password'])||empty($clean['confirm'])||empty($clean['cpassword']))
			masterDie("error|{$language['emptyFields']}");
		if(empty($clean['id']))
			masterDie("error|{$language['idEmpty']}");

		if($clean['password']!=$clean['confirm'])
			masterDie("error|{$language['passwordNotMatch']}");

		if(strlen($clean['password'])<6)
			masterDie("error|{$language['passwordToShort']}");

		$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$clean['id']}'");
		if(mysql_error())
			masterDie("error|SQL");
		if(!mysql_num_rows($q))
			masterDie("error|{$language['userNotExists']}");

		$cpass = $core->createPassword($clean['cpassword']);

		$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$clean['id']}' AND `password`='{$cpass}'");
		if(mysql_error())
			masterDie("error|SQL");
		if(!mysql_num_rows($q))
			masterDie("error|{$language['uApNotMatch']}");

		$pass = $core->createPassword($clean['password']);
		mysql_query("UPDATE `user` SET `password`='{$pass}' WHERE `id`='{$clean['id']}'");

		if(mysql_error())
			masterDie("error|SQL");

		masterDie("good|{$language['changeGood']}");
		break;
	case 'deleteAccount':
		$clean['accept'] = filter_input(INPUT_POST,"accept",FILTER_SANITIZE_STRING);
		$clean['id'] = $_SESSION['sk_user'];


		if(empty($clean['accept']))
			masterDie("error|{$language['emptyFields']}");
		if(empty($clean['id']))
			masterDie("error|{$language['idEmpty']}");

		if($clean['accept']=='false')
			masterDie("error|{$language['accNotChecked']}");

		$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$clean['id']}'");
		if(mysql_error())
			masterDie("error|SQL");
		if(!mysql_num_rows($q))
			masterDie("error|{$language['userNotExists']}");

		if($clean['id']!=1){
			$q = mysql_query("SELECT * FROM `draws` WHERE `userid`='{$clean['id']}'");
			if(mysql_num_rows($q))
				while($r = mysql_fetch_assoc($q)){
					unlink("../files/{$r['filename']}.png");
					mysql_query("DELETE FROM `draws` WHERE `filename`='{$r['filename']}' LIMIT 1");
				}
			mysql_query("DELETE FROM `user` WHERE `id`='{$clean['id']}' LIMIT 1;");
		}
		if(mysql_error())
			masterDie("error|SQL");
		unset($_SESSION['sk_user']);
		masterDie("good|{$language['changeGood']}");
		break;
	default:
		masterDie("error|{$language['restrictedArea']}");
}

/*if(empty($clean['filename']))
	masterDie($language['fileEmpty']);

$sql = "SELECT * FROM `draws` WHERE `filename`='{$clean['filename']}'";

if($core->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
	$sql .= " AND `userid`='{$_SESSION['sk_user']}'";

$q = mysql_query();
if(!mysql_num_rows($q))
	masterDie($language['imageNotExists']);

mysql_query("DELETE FROM `draws` WHERE `filename`='{$clean['filename']}' LIMIT 1");
unlink("../files/{$clean['filename']}.png");*/

/*File: save.php*/
/*Date: 26.04.2011*/