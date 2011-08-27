<?php ob_end_clean();?>
<!DOCTYPE html>
<html lang="ro-RO">
<head>
	<title><?php ___("404pageTitle")?></title>
	<link href="<?php themePath();?>/style/404.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="text">
		HTTP 404 Error!<br />
		<?php ___("404pageTitle")?>
	</div>
</body>
</html>
<?php masterDie();?>