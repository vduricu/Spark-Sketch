<?php

if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}

unset($_SESSION['sk_user']);
masterRedirect("/");

/*File: logout.php*/
/*Date: 25.04.2011*/