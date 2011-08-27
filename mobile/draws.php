<div class="content draws">
	<ul>
		<?php
		$items = $mobile->items*($mobile->pagination-1);
		$sql = "SELECT * FROM `draws` WHERE `status`='approved' ORDER by `modificationdate` DESC LIMIT {$items},{$mobile->items}";

		$q = mysql_query($sql);
		$n = mysql_num_rows(mysql_query("SELECT * FROM `draws` WHERE `status`='approved' ORDER by `modificationdate` DESC"));
		$maxi = intVal($n/$mobile->items);
		if($n%$mobile->items)
			$maxi++;

		if(!$n){?>
		<li><?php ___('noPhotos')?></li>
		<?php }else{
			while($r=mysql_fetch_assoc($q)){
				$url = $spkcore->createURL("/gallery/{$r['filename']}");
				$path = $spkcore->getConfig('path');
				$image = "{$path}/files.php?id={$r['filename']}&thumb=1";
				?>
		<li><a href="<?php __($url)?>"><img src="<?php __($image)?>" alt="draw" width="100%" /></a><br /><?php __($r['title'])?></li>
		<?php }
		}?>

	</ul>
	<p class="clear"></p>
	<table>
		<tr>
			<?php if($mobile->pagination>1){?>
			<td><a href="<?php $spkcore->createURL('/draws/'.($mobile->pagination-1),true)?>" class="back">&nbsp;</a></td>
			<?php }?>
			<?php if($n>$items && $mobile->pagination < $maxi){?>
			<td><a href="<?php $spkcore->createURL('/draws/'.($mobile->pagination+1),true)?>" class="next">&nbsp;</a></td>
			<?php }?>
		</tr>
	</table>
</div>