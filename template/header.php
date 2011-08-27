<!DOCTYPE html>
<html lang="ro-RO">
<head>
	<title><?php __($spkcore->getClass('template')->pageTitle())?> / <?php __($spkcore->getConfig('title'))?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="<?php __($spkcore->getConfig('keywords'))?>" />
	<meta name="description" content="<?php __($spkcore->getConfig('description'))?>" />
	<meta name="author" content="Copyright 2011 (c) Duricu Valentin" />
	<meta name="Generator" content="Spark Sketch v<?php __($spkcore->version('number'))?>"/>

	<meta name="rating" content="general" />
	<meta name="robots" content="all,follow" />

	<script src="<?php themePath();?>/style/js/jquery.js" type="text/javascript"></script>
	<script src="<?php themePath();?>/style/js/jquery.hoverIntent.js" type="text/javascript"></script>
	<script src="<?php themePath();?>/style/js/effui.js" type="text/javascript"></script>
	<link href="<?php themePath();?>/style/style.css" rel="stylesheet" type="text/css" />

	<script src="<?php themePath();?>/style/js/facebox.js" type="text/javascript"></script>
	<script src="<?php themePath();?>/style/js/jquery.tipsy.js" type="text/javascript"></script>
	<script src="<?php themePath();?>/style/js/main.js" type="text/javascript"></script>

	<link href="<?php themePath();?>/style/jquery.tipsy.css" rel="stylesheet" type="text/css" />
	<link href="<?php themePath();?>/style/facebox.css" rel="stylesheet" type="text/css" />

	<link rel="shortcut icon" href="<?php themePath();?>/style/images/favicon.ico" type="image/x-icon" />

	<?php if($spkcore->getClass('template')->pageType()=='sgallery'){
	$path = getConfig('path');
	$filename = $spkcore->getUrl(1);
	$image = "{$path}/files.php?id={$filename}";

	$bkgcolor = getElementByField("draws","filename",$filename,'bkgcolor');
	if(getElementByField("draws","filename",$filename,'type')=='extended')
		if($bkgcolor!='none')
			$image .= "&extended=1";
		?>
	<link rel="image_src" href="http://<?php __($_SERVER['HTTP_HOST'])?><?php __($image)?>" / >
	<?php }?>
	<?php extra_header();?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-9095982-5']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<?php
if(isset($_SESSION['registerSuccess'])){?>
<script type="text/javascript">
jQuery.facebox('<?php ___("registerSucces")?>');
</script>
<?php
	unset($_SESSION['registerSuccess']);
}
?>
	<div class="wrapper">