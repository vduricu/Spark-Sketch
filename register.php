<?php
session_start();
require_once('engine/master.php');

if(getConfig('registration')=='closed')
	masterRedirect($spkcore->createURL("/404"));
if(getConfig('registration')=='beta')
	if(mysql_num_rows(mysql_query("SELECT * FROM `user`"))>=MAX_BETA)
		masterRedirect($spkcore->createURL("/404"));

if(count($_POST)==0)
	masterRedirect($spkcore->createURL("/404"));

if(isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/404"));
}

$clean = array();
$clean['username'] = filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING);
$clean['password'] = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);
$clean['confirm'] = filter_input(INPUT_POST,"confirm",FILTER_SANITIZE_STRING);
$clean['email'] = filter_var(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL);
$clean['firstname'] = filter_input(INPUT_POST,"firstname",FILTER_SANITIZE_STRING);
$clean['lastname'] = filter_input(INPUT_POST,"lastname",FILTER_SANITIZE_STRING);

if(empty($clean['username'])||empty($clean['password'])||empty($clean['confirm'])||empty($clean['email'])||empty($clean['firstname'])||empty($clean['lastname']))
	masterDie("error|".langItem("emptyFields"));

if(strlen($clean['username'])<5)
	masterDie("error|".sprintf(langItem("usernameShort"),5));

if(strlen($clean['username'])>30)
	masterDie("error|".sprintf(langItem("usernameTooLong"),30));

$resUName = array(
	'thg2oo6',
	'admin',
	'valentin.duricu',
	'spark',
	'sketch',
	'thg2006',
	'vduricu',
	'administrator',
	'skadmin',
	'user',
	'username',
	'password',
	'email',
	'utilizator',
	'parola',
	'demo',
	'demonstratie',
	'demouser'
);

foreach($resUName as $uname)
	if($uname == $clean['username'])
		masterDie("error|".langItem("reservedUser"));

if($clean['password']!=$clean['confirm'])
	masterDie("error|".langItem("passwordsNotMatch"));

if(strlen($clean['password'])<6)
	masterDie("error|".sprintf(langItem("passwordShort"),6));

if(is_numeric($clean['username'])||is_numeric($clean['username'][0]))
	masterDie("error|".langItem("badUsername"));

$clean['password'] = $spkcore->createPassword($clean['password']);

if(!$clean['email'])
	masterDie("error|".langItem("invalidEmail"));

if(isset($_POST['ajax'])){
	$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$clean['username']}'");
	if(mysql_num_rows($q))
		masterDie("error|".langItem("userExists"));

	$q = mysql_query("SELECT * FROM `user` WHERE `email`='{$clean['email']}'");
	if(mysql_num_rows($q))
		masterDie("error|".langItem("emailExists"));

	$clean['date'] = date("Y-m-d H:i:s");

	$lang = SK_DEFAULTLANGUAGE;

	$code = sha1("{$clean['confirm']}|{$clean['date']}|{$clean['email']}|".uniqid());

	$invitedby['table'] = '';
	$invitedby['data'] = '';

	if(isset($_SESSION['invitedby'])){
		$invitedby['table'] = ',`invitedby`';
		$invitedby['data'] = ",'{$_SESSION['invitedby']}'";
	}

	mysql_query("INSERT INTO `user` (`id`,`user`,`password`,`rank`,`email`,`firstname`,`lastname`,`lang`,`creationDate`,`activated`,`activation_code` {$invitedby['table']}) VALUES (NULL,'{$clean['username']}','{$clean['password']}','user','{$clean['email']}','{$clean['firstname']}','{$clean['lastname']}','{$lang}','{$clean['date']}','no','{$code}' {$invitedby['data']});");

	if(mysql_errno())
		masterDie("error|SQl");

	$site = $_SERVER['HTTP_HOST'];
	@mail($clean['email'],langItem("emailSubject"),sprintf(langItem("emailMsg"),$clean['username'],$site,$code),"FROM: Sketch Daemon<sketch@duricu.ro>");

	$_SESSION['registerSuccess'] = true;
	echo "good";
	if(isset($_SESSION['invitedby'])){
		unset($_SESSION['invitedby']);
	}

}else{
	masterRedirect($spkcore->createURL("/"));
}

/*File: login.php*/
/*Date: 16.06.2011*/