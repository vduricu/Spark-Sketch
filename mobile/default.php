<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html lang="ro-RO">
<head>
	<title><?php __($mobile->getTitle())?> / Mobile / <?php __($spkcore->getConfig('title'))?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="<?php __($spkcore->getConfig('keywords'))?>" />
	<meta name="description" content="<?php __($spkcore->getConfig('description'))?>" />
	<meta name="author" content="Copyright 2011 (c) Duricu Valentin" />
	<meta name="Generator" content="Spark Sketch v<?php __($spkcore->version('number'))?>"/>
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />

	<meta name="rating" content="general" />
	<meta name="robots" content="all,follow" />

	<script src="<?php themePath();?>/style/js/jquery.js" type="text/javascript"></script>
	<link href="<?php __(getConfig('path'));?>/mobile/style/style.css" rel="stylesheet" type="text/css" />

	<link rel="shortcut icon" href="<?php themePath();?>/style/images/favicon.ico" type="image/x-icon" />
	<script type="text/javascript">
		//$("body").css({width: window.innerWidth});
		$("body").animate({width: window.innerWidth});
		$(window).resize(function(){
			//$("body").css({width: window.innerWidth});
			$("body").animate({width: window.innerWidth});
		});
	</script>
</head>
<body>
	<div class="top">
		<div class="left logo"><a href="<?php __($spkcore->getConfig('path'));?>/"><span class="no-text spark">Spark</span></a></div>
		<div class="right menu">
			<ul>
				<li><a href="<?php __($spkcore->getConfig('path'));?>/"><?php ___("homeMenu")?></a></li>
				<li><a href="<?php $spkcore->createURL('/draws/1',true)?>"><?php ___("galleryMenu")?></a></li>
				<?php /*<li><a href="<?php $spkcore->createURL('/faq',true)?>">FAQ</a></li>*/?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<?php $mobile->content();?>
</body>
</html>