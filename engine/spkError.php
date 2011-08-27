<?php
ob_clean();
ob_start();?>
<html>
	<head>
		<? /*<title>Error: [<?=$errno?>] <?=$errmsg?> # Encore (by Spark)</title>*/ ?>
		<? /*<title>Error: [<?=$errline?>] <?=$errfile?> # Encore (by Spark)</title>*/ ?>
		<title>Error: [<?=$errno?>] <?=$errmsg?> # Encore (by Spark)</title>
		<style type="text/css">
body{
	background-color: #ffffff;
	font-family: Tahoma, Verdana, Arial, sans-serif;
	font-size: 9pt;
}
.error{
	background-color: #fefedd;
	width: 500px;
	margin: 150px auto;
	border: 1px solid #dc0000;
}
.title{
	font-weight: bold;
	font-size: 11pt;
	color: #dc0000;
	padding: 5px;
	border-bottom: 1px solid #787878;
}
.text{
	padding: 5px;
}
		</style>
	</head>
	<body>
		<div class="error">
			<div class="title">Error: <span style="color: #000000">[<?=$errno?>]</span> <span style="font-style: italic;font-weight: normal; color: #000000"><?=$errmsg?></span></div>
			<div class="text">
				<strong>File:</strong> <?=$errfile;?><br />
				<strong>Line:</strong> <?=$errline;?><br />
			</div>
		</div>
	</body>
</html>
<?php ob_end_flush();?>