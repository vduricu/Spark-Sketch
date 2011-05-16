<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}
?>
<? require_once("tpl/top.php"); ?>
<div class="content imageGallery">
	<table>
	<?
		$q = mysql_query("SELECT * FROM `draws` ORDER by `creationdate` DESC");
		if(!mysql_num_rows($q))
			echo "<tr><td colspan=\"4\">{$language['noPhotos']}</td></tr>";
		else{
			$n = mysql_num_rows($q);
			$i = 0;
			while($r = mysql_fetch_assoc($q)){
				if($i%4==0)
					echo "<tr>\n";
				$image = $core->createURL("/files/{$r['filename']}");
				echo "<td onClick=\"showGAdmin('#photos','{$r['filename']}','{$r['title']}','{$language['confirm']}')\"><img src=\"{$image}\" title=\"{$r['title']} - by ".$core->fieldByID("user","user",$r['userid'])."\" alt=\"image\"/></td>\n";

				if($i%4==3||$i==$n-1)
					echo "</tr>\n";
				$i++;
			}
		}
	?>

	</table>
</div>
<div id="boxes">
	<div id="photos" class="window">
		<h3></h3>
		<ul>
			<li id="view"><img src="/style/admin/view.png" alt="view"/><br /><?=$language['view']?></li>
			<li id="delete"><img src="/style/admin/delete.png" alt="delete"/><br /><?=$language['delete']?></li>
		</ul>
	</div>
	<div id="mask"></div>
</div>
<div id="modalMsg"></div>
	<? require_once("tpl/footer.php"); ?>