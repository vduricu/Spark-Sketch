<? require_once("tpl/top.php");?>
<div class="content imageGallery">
	<table>
	<?
		$q = mysql_query("SELECT * FROM `draws` ORDER by `modificationdate` DESC");
		if(!mysql_num_rows($q))
			echo "<tr><td colspan=\"4\">{$language['noPhotos']}</td></tr>";
		else{
			$n = mysql_num_rows($q);
			$i = 0;
			while($r = mysql_fetch_assoc($q)){
				if($i%4==0)
					echo "<tr>\n";
				$url = $core->createURL("/gallery/{$r['filename']}");
				$image = $core->createURL("/files/{$r['filename']}");
				echo "<td><a href=\"{$url}\"><img src=\"{$image}\" title=\"{$r['title']} - by ".$core->fieldByID("user","user",$r['userid'])."\" alt=\"image\"/></a></td>\n";

				if($i%4==3||$i==$n-1)
					echo "</tr>\n";
				$i++;
			}
		}
	?>

	</table>
</div>
<? require_once("tpl/footer.php"); ?>