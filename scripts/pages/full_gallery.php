<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title><?=$language['fullGallery_title']?> / Spark Sketch</title>
	<? require_once("tpl/header.php");?>
</head>
<body>
	<? require_once("tpl/menu_logged.php"); ?>
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

					echo "<td><a href=\"/gallery/{$r['filename']}\"><img src=\"/files/{$r['filename']}\" title=\"{$r['title']} - by ".$core->fieldByID("user","user",$r['userid'])."\" alt=\"image\"/></a></td>\n";

					if($i%4==3||$i==$n-1)
						echo "</tr>\n";
					$i++;
				}
			}
		?>

		</table>
	</div>
	<? require_once("tpl/footer.php"); ?>
</body>
</html>