<div class="footer">
	<div class="left notice">2011 <span>&copy;</span> <?=$language['footerNotice']?></div>
	<div class="right version"><?=$language['version']?>: <?=SK_VERSION?></div>
</div>
<?php
if(isset($_SESSION['sk_user']))
	if($core->fieldByID("user","rank",$_SESSION['sk_user'])=="admin")
		require_once("menu_admin.php");
?>
</body>
</html>