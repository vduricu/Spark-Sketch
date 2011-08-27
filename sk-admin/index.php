<?php
session_start();
require_once('../engine/master.php');
if(!logged())
	masterRedirect($spkcore->createURL("/404"));
if(loggedUserRank()!='admin'&&loggedUserRank()!='moderator')
	masterRedirect($spkcore->createURL("/404"));

$pagina = 'dashboard';

if(isset($_GET['zona'])){
	if(isset($_GET['pagina']))
		$pagina = filter_input(INPUT_GET,"zona",FILTER_SANITIZE_STRING).'/'.filter_input(INPUT_GET,"pagina",FILTER_SANITIZE_STRING);
	else
		$pagina = filter_input(INPUT_GET,"zona",FILTER_SANITIZE_STRING).'/index';
}else{
	if(isset($_GET['pagina']))
		$pagina = filter_input(INPUT_GET,"pagina",FILTER_SANITIZE_STRING);
}
if(!file_exists("pagini/{$pagina}.php"))
	masterRedirect($spkcore->createURL("/404"));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title>Administrare Spark Sketch</title>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />

	<script src="../template/style/js/jquery.js" type="text/javascript"></script>
	<script src="style/jquery.dataTables.js" type="text/javascript"></script>
	<script src="../template/style/js/effui.js" type="text/javascript"></script>
	<script src="../template/style/js/facebox.js" type="text/javascript"></script>

	<script src="style/main.js" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="../template/style/facebox.css" />
	<link rel="stylesheet" type="text/css" href="../template/style/font/stylesheet.css" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />

	</head>
<body>
	<div class="header">
		<div class="left logo no-text">spark sketch</div>
		<div class="right menu">
			<ul>
				<li><a href="./">Dashboard</a></li>
				<li><a href="./?zona=desene">Desene</a></li>
				<li><a href="./?zona=discutii">Discutii</a></li>
				<?php if(loggedUserRank()=='admin'){?>
				<li><a href="./?zona=utilizatori">Utilizatori</a></li>
				<?php }?>
				<li class="last"><a href="../">Iesire</a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<?php
		require_once("pagini/{$pagina}.php");
	?>
	<div class="footer">
		<div class="left notice">Spark <span style="font-family: verdana">&copy;</span> 2011. All rights reserved.</div>
		<div class="right version">Version: <?php __($spkcore->version())?></div>
	</div>
</body>
</html>
<?php
ob_end_flush();
?>