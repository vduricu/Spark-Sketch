<div class="content adminContent">
	<div class="aSMenu">
		<a href="./?zona=discutii&pagina=lista">Lista Mesaje Acceptate <span>(<?php __(howMany("discuss","status","approved"))?>)</span></a>&nbsp;
		|&nbsp;<a href="./?zona=discutii&pagina=waiting">Mesaje in asteptare <span>(<?php __(howMany("discuss","status","waiting"))?>)</span></a>&nbsp;
		|&nbsp;<a href="./?zona=discutii&pagina=spam" class="current">Mesaje spam <span>(<?php __(howMany("discuss","status","spam"))?>)</span></a>&nbsp;
		|&nbsp;<a href="./?zona=discutii&pagina=deleted">Mesaje sterse <span>(<?php __(howMany("discuss","status","deleted"))?>)</span></a>
	</div>
	<form action="admin.php?zona=discuss&pagina=mdelete" method="POST">
	<table border="1" class="table_data" id="discuss">
		<thead>
			<tr>
				<th style="width: 3%">&nbsp;</th>
				<th style="width: 15%;">Utilizator</th>
				<th style="width: 15%;">Desen</th>
				<th style="width: 37%;">Mesaj</th>
				<th style="width: 20%;">Data Creare</th>
				<th style="width: 10%;">Actiune<br /><span class="info">Stare</span></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$q=mysql_query("SELECT * FROM `discuss` WHERE `status`='spam' ORDER by `data` DESC");
		$i=0;
		while($r=mysql_fetch_assoc($q)){
			$trClass = "";
			if($i%2) $trClass = " class=\"v\"";
			$i=1-$i;
			//date("d F Y, H:i:s",strtotime($r['modificationdate']))
		?>
			<tr <?php __($trClass)?>>
				<td style="width: 3%; text-align: right;vertical-align: middle"><input type="checkbox" name="item[]" value="<?php __($r['id'])?>" /></td>
				<td style="width: 15%;"><?php __($spkcore->userinfo($r['userid'],'user'))?></td>
				<td style="width: 15%;"><a href="<?php __(getConfig('path')."/files.php?id=".getElementByID('draws',$r['drawid'],'filename'))?>" target="_blank" rel="facebox"><?php __(getElementByID('draws',$r['drawid'],'filename'))?></a></td>
				<td style="width: 37%;"><?php __(nl2br($r['text']))?></td>
				<td style="width: 20%; text-align: center;"><?php __($r['data'])?></td>
				<td style="width: 10%;text-align: center;clear: both;">
					<span class="status"><?php __($r['status'])?></span><br />
					<input type="button" class="ui-admin ui-approve" title="Aproba" value="&nbsp;" onClick="approveMsg('<?php __($r['id'])?>')"/>
					<input type="button" class="ui-admin ui-delete" title="Sterge" value="&nbsp;" onClick="msgConfirmDelete('<?php __($r['id'])?>')"/>
				</td>
			</tr>
			<?php }?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7" style="text-align: right">
				<select name="action">
					<option value="">&nbsp;</option>
					<option value="mapprove">Aproba</option>
					<option value="mdelete">Sterge</option>
				</select>
				<input type="submit" class="button" value="Executa"/>
				</td>
			</tr>
		</tfoot>
	</table>
	</form>
</div>
