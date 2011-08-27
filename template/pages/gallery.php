<?php
appendFooter('
<script src="'.getConfig('path').'/template/style/js/captify.js" type="text/javascript"></script>
<script type="text/javascript">
//$("#content img").tipsy({fade: true,gravity: $.fn.tipsy.autoNS});
$(\'#content img\').captify({
		// all of these options are... optional
		// ---
		// speed of the mouseover effect
		speedOver: \'normal\',
		// speed of the mouseout effect
		speedOut: \'normal\',
		// how long to delay the hiding of the caption after mouseout (ms)
		hideDelay: 500,
		// \'fade\', \'slide\', \'always-on\'
		animation: \'slide\',
		// text/html to be placed at the beginning of every caption
		prefix: \'\',
		// opacity of the caption on mouse over
		opacity: \'0.7\',
		// the name of the CSS class to apply to the caption box
		className: \'caption-bottom\',
		// position of the caption (top or bottom)
		position: \'bottom\',
		// caption span % of the image
		spanWidth: \'100%\'
	});
</script>');
?>
<div class="right" id="content">
	<h1 class="title"><?php ___("galleryTitle")?></h1>
	<div class="content">
		<table>
		<?php
		$q = mysql_query("SELECT * FROM `draws` WHERE `status`='approved' ORDER by `modificationdate` DESC");
		if(!mysql_num_rows($q))
			echo "<tr><td colspan=\"4\">".langItem('noPhotos')."</td></tr>";
		else{
			$n = mysql_num_rows($q);
			$i = 0;
			while($r = mysql_fetch_assoc($q)){
				if($i%4==0)
					echo "<tr>\n";
				$url = $this->core->createURL("/gallery/{$r['filename']}");
				$path = $this->core->getConfig('path');
				$image = "{$path}/files.php?id={$r['filename']}&thumb=1";

				echo "<td style=\"width: 23%; padding:1%;\"><a href=\"{$url}\"><img src=\"{$image}\" title=\"{$r['title']} - by ".getElementByID("user",$r['userid'],"user")."\" alt=\"image\" style=\"width: 100%;border:1px solid #000000\"/></a></td>\n";

				if($i%4==3||$i==$n-1){
					switch(($i+1)%4){
						case 1: echo "<td colspan=\"3\">&nbsp;</td>";break;
						case 2: echo "<td colspan=\"2\">&nbsp;</td>";break;
						case 3: echo "<td colspan=\"1\">&nbsp;</td>";break;
					}
					echo "</tr>\n";
				}

				$i++;
			}
		}
		?>

		</table>
	</div>
</div>

