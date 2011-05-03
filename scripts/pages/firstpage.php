<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title><?=$language['firstPage_title']?> / Spark Sketch</title>
	<? require_once("tpl/header.php");?>
</head>
<body>
	<? require_once("tpl/menu_unreg.php"); ?>
	<div class="content">
		<div class="box">
			<div class="title"><img src="/style/images/bnew.png" alt="new"/> <?=$language['somethingnew_title']?></div>
			<div class="text">
				<?=$language['somethingnew_text']?>
			</div>
		</div>
		<div class="box">
			<div class="title"><img src="/style/images/bshare.png" alt="share"/> <?=$language['shareit_title']?></div>
			<div class="text">
				<?=$language['shareit_text']?>
			</div>
		</div>
		<div class="box">
			<div class="title"><img src="/style/images/beq.png" alt="equation"/> <?=$language['equation_title']?></div>
			<div class="text">
				<?=$language['equation_text']?>
			</div>
		</div>
		</div>
		<div class="clear"></div>
	</div>
	<? require_once("tpl/footer.php"); ?>
</body>
</html>