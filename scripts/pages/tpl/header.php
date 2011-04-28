<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
	<meta name="keywords" content="Drawing pad" />
	<meta name="description" content="Draw something, save it or send it to your friends and have fun." />
	<meta name="author" content="Copyright 2011 (c) Duricu Gheorghe Adrian IF" />
	<meta name="Generator" content="Spark Sketch v0.1"/>

	<meta name="rating" content="general" />
	<meta name="revisit-after" content="7 days" />
	<meta name="robots" content="all,follow" />
	<meta name="language" content="romanian, RO" />
	<meta name="distribution" content="global" />
	<meta name="publisher" content="duricu.ro"/>

	<script src="/style/js/jq.js" type="text/javascript"></script>
	<script src="/style/js/ui.js" type="text/javascript"></script>
<?
	if($core->pageType()=='sketch'||$core->pageType()=='sketch2')
		require_once("sketch_h1.php");
?>
	<script src="/style/js/tipsy.js" type="text/javascript"></script>
	<script src="/style/js/main.js" type="text/javascript"></script>
<?
	if($core->pageType()=='sketch')
		require_once("sketch_h2.php");
	if($core->pageType()=='sketch2')
		require_once("sketch_h3.php");
?>

	<link rel="shortcut icon" href="/style/images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="/style/style.css" />
	<link rel="stylesheet" type="text/css" href="/style/ui/ui.css" />
	<link rel="stylesheet" type="text/css" href="/style/tipsy.css" />
