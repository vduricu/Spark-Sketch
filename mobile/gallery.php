<div class="content gallery">
	<?php
		$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$this->core->getUrl(1)}'");
		if(!mysql_num_rows($q))
			masterRedirect($this->core->createURL("/page/gallery"));
		$r = mysql_fetch_assoc($q);

		$path = getConfig('path');
		$image = "{$path}/files.php?id={$r['filename']}";
		$extra = "";
		if($r['type']=='extended'){
			if($r['bkgcolor']=='none')
				$extra="style=\"background: #dfdfdf url('{$path}/extra/style/images/bkg.png');\"";
			else
				$image .= "&extended=1";
		}

		$next_img = false;$prev_img = false;

		$ql = mysql_query("SELECT `filename` FROM `draws` WHERE `modificationdate`>'{$r['modificationdate']}' ORDER by `modificationdate` ASC LIMIT 1;");
		if(mysql_num_rows($ql)){
			$rl = mysql_fetch_row($ql);
			$next_img = $rl[0];
		}

		$ql = mysql_query("SELECT `filename` FROM `draws` WHERE `modificationdate`<'{$r['modificationdate']}' ORDER by `modificationdate` DESC LIMIT 1;");
		if(mysql_num_rows($ql)){
			$rl = mysql_fetch_row($ql);
			$prev_img = $rl[0];
		}

		?>
	<table class="mtable">
		<tr>
			<td colspan="2"><a href="<?php __($image)?>"><img src="<?php __($image)?>" alt="image" width="100%" <?php __($extra)?>/></a></td>
		</tr>
		<tr>
			<th><?php ___("canvasTitle")?>:</th>
			<td><?php __($r['title'])?></td>
		</tr>
		<tr>
			<th><?php ___("username")?>:</th>
			<td><?php __(getElementByID("user",$r['userid'],"user"))?></td>
		</tr>
		<tr>
			<th><?php ___("download")?>:</th>
			<td><a href="<?php __("{$image}&dl=".rand(1,10000))?>" class="no-text dl" title="<?php ___("download")?>"><?php ___("download")?></a></td>
		</tr>
	</table>
	<table>
		<tr>
			<?php if($next_img){?>
			<td><a href="<?php $spkcore->createURL("/gallery/{$next_img}",true);?>" class="back">&nbsp;</a></td>
			<?php }?>
			<?php if($prev_img){?>
			<td><a href="<?php $spkcore->createURL("/gallery/{$prev_img}",true);?>" class="next">&nbsp;</a></td>
			<?php }?>
		</tr>
	</table>
</div>