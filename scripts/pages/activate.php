<?php

if(isset($_SESSION['sk_user'])){
	masterRedirect("/");
}

$code = end($core->url);
$q = mysql_query("SELECT * FROM `user` WHERE `activation_code`='{$code}'");
if(mysql_num_rows($q)){
	$r = mysql_fetch_assoc($q);
	mysql_query("UPDATE `user` SET `activated`='yes', `activation_code`=NULL WHERE `id`='{$r['id']}'");
	echo $language['accountActivated'];
}
else
	echo $language['activationNExists'];

echo nl2br(sprintf($language['redirectIn'],5));
echo nl2br(sprintf($language['redirectNotice'],5,"/"));
ob_end_flush();

header("Refresh: 5; url=/");
die();


/*File: login.php*/
/*Date: 25.04.2011*/