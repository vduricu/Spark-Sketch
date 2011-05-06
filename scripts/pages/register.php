<?php

if(count($_POST)==0)
	masterRedirect("/");

if(isset($_SESSION['sk_user'])){
	masterRedirect("/");
}

/*
   username: $("#r-username").val(),
   password: $("#r-password").val(),
   confirm: $("#r-confirm").val(),
   email: $("#r-email").val(),
   firstname: $("#r-firstname").val(),
   lastname: $("#r-lastname").val(),
*/

$clean = array();
$clean['username'] = filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING);
$clean['password'] = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);
$clean['confirm'] = filter_input(INPUT_POST,"confirm",FILTER_SANITIZE_STRING);
$clean['email'] = filter_var(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL);
$clean['firstname'] = filter_input(INPUT_POST,"firstname",FILTER_SANITIZE_STRING);
$clean['lastname'] = filter_input(INPUT_POST,"lastname",FILTER_SANITIZE_STRING);

if(empty($clean['username'])||empty($clean['password'])||empty($clean['confirm'])||empty($clean['email'])||empty($clean['firstname'])||empty($clean['lastname']))
	masterDie("error|{$language['emptyFields']}");

if(strlen($clean['password'])<5)
	masterDie("error|{$language['usernameToShort']}");

foreach($resUName as $uname)
	if($uname == $clean['username'])
		masterDie("error|{$language['resUsername']}");

if($clean['password']!=$clean['confirm'])
	masterDie("error|{$language['passwordNotMatch']}");

if(strlen($clean['password'])<6)
	masterDie("error|{$language['passwordToShort']}");

$clean['password'] = $core->createPassword($clean['password']);

if(!$clean['email'])
	masterDie("error|{$language['emailNotValid']}");

if(isset($_POST['ajax'])){
	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}'");
	if(mysql_num_rows($q))
		masterDie("error|{$language['userExists']}");

	$q = mysql_query("SELECT * FROM `user` WHERE `email`='{$clean['email']}'");
	if(mysql_num_rows($q))
		masterDie("error|{$language['emailExists']}");

	$clean['date'] = date("Y-m-d H:i:s");

	$code = sha1("{$clean['confirm']}|{$clean['date']}|{$clean['email']}|".uniqid());
	mysql_query("INSERT INTO `user` (`id`,`user`,`password`,`rank`,`email`,`firstname`,`lastname`,`creationDate`,`activated`,`activation_code`) VALUES (NULL,'{$clean['username']}','{$clean['password']}','user','{$clean['email']}','{$clean['firstname']}','{$clean['lastname']}','{$clean['date']}','no','{$code}');");

	@mail($clean['email'],$language['activationTitle'],sprintf($language['activationCode'],$code),"FROM: Sketch Daemon<daemon@sparksketch.ro>");

	echo "good|{$language['registered']}";

}else{
	masterRedirect("/");
}

/*File: login.php*/
/*Date: 25.04.2011*/