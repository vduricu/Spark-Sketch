<div class="header">
	<div class="left logo no-text">spark sketch</div>
	<div class="right menu">
		<ul>
			<li><a href="/"><?=$language['menuDraw']?></a></li>
			<li><a href="/mygallery"><?=$language['menuGallery']?></a></li>
<?
if($core->fieldByID('user','rank',$_SESSION['sk_user'])=='admin')
	require_once("menu_admin.php");
?>
			<li><a href="/account"><?=$language['menuAccount']?></a></li>
			<li class="last"><a href="/logout"><?=$language['menuLogout']?></a></li>
		</ul>
	</div>
	<div class="clear"></div>
</div>